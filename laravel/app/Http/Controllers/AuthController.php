<?php

namespace App\Http\Controllers;

use App\Models\PasswordReset;
use App\Models\User;
use http\Env\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use PDO;


class AuthController extends Controller
{
    public function login_view()
    {
        return view('front.auth.login2');
    }

    public function register_view()
    {
        return view('front.auth.register');
    }

    public function send_login_code(Request $request)
    
    {
        

        $mobile = $request->input('mobile');
        
        $validator = Validator::make($request->all(),
            [
                'mobile' => 'required|min:11|exists:users,mobile',
            ],
            [
                'mobile.required' => 'شماره همراه را وارد کنید',
                'mobile.min' => 'شماره همراه باید 11 رقم باشد',
                'mobile.exists' => 'کاربری با این شماره همراه یافت نشد',
            ]
        );
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        $this->remove_auth_code_by('mobile', $mobile);
        $this->create_auth_code($mobile, 'mobile');
        return view('front.auth.login_code', compact('mobile'));
    }

    public function send_register_code(Request $request)
    {
        $mobile = $request->input('mobile');
        $username = $request->input('username');
        $this->remove_auth_code_by('mobile', $mobile);
        $validator = Validator::make($request->all(),
            [
                'mobile' => 'required|min:11|unique:users,mobile',
                'username' => 'required|min:3|unique:users,username',
            ],
            [
                'mobile.required' => 'شماره همراه را وارد کنید',
                'mobile.min' => 'شماره همراه باید 11 رقم باشد',
                'mobile.unique' => 'کاربری با این شماره همراه موجود است',
                'username.required' => 'نام کاربری را وارد کنید',
                'username.min' => 'نام کاربری باید حداقل 3 حرف باشد',
                'username.unique' => 'کاربری با این نام کاربری موجود است',
            ]
        );
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        $this->create_auth_code($mobile, 'mobile');
        return view('front.auth.register_code', compact('mobile','username'));
    }

    public function verify_login_code(Request $request)
    {
        $code = $request->input('code');
        $mobile = $request->input('mobile');

        // Validate Code Exists
        $validator = Validator::make($request->all(),
            [
                'code' => 'required|exists:password_reset_tokens,token',
            ],
            [
                'code.required' => 'کد دریافتی را وارد کنید',
                'code.exists' => 'کد وارد شده اشتباه است',
            ]
        );
        if ($validator->fails()) {
            return json_encode([
                "result" => false,
                "validate" => $validator->messages()
            ]);
        }

        // Check the code belongs to mobile
        $exists = $this->code_matching('mobile', $mobile, $code);
        if ($exists > 0) {
            // Remove Code from DB
            $this->remove_auth_code($code);
            // Login User
            $login = $this->login('mobile', $mobile);
            return json_encode([
                "result" => $login
            ]);
        } else {
            return json_encode([
                "result" => false,
                "validate" => [
                    "code" => [
                        "کد وارد شده اشتباه است"
                    ]
                ]
            ]);
        }
    }

    public function verify_reg_code(Request $request)
    {
        $code = $request->input('code');
        $mobile = $request->input('mobile');
        $username = $request->input('username');

        // Validate Code Exists
        $validator = Validator::make($request->all(),
            [
                'mobile' => 'required|min:11|unique:users,mobile',
                'username' => 'required|min:3|unique:users,username',
                'code' => 'required|exists:password_reset_tokens,token',
            ],
            [
                'mobile.required' => 'شماره همراه را وارد کنید',
                'mobile.min' => 'شماره همراه باید 11 رقم باشد',
                'mobile.unique' => 'کاربری با این شماره همراه موجود است',
                'username.required' => 'نام کاربری را وارد کنید',
                'username.min' => 'نام کاربری باید حداقل 3 حرف باشد',
                'username.unique' => 'کاربری با این نام کاربری موجود است',
                'code.required' => 'کد دریافتی را وارد کنید',
                'code.exists' => 'کد وارد شده اشتباه است',
            ]
        );
        if ($validator->fails()) {
            return json_encode([
                "result" => false,
                "validate" => $validator->messages()
            ]);
        }

        // Check the code belongs to mobile
        $exists = $this->code_matching('mobile', $mobile, $code);
        if ($exists > 0) {
            // Remove Code from DB
            $this->remove_auth_code($code);
            //Register User
            $user=$this->register($username,$mobile);
            if($user) {
                // Login User
                $login = $this->login('mobile', $mobile);
                return json_encode([
                    "result" => $login
                ]);
            }else{
                return json_encode([
                    "result" => false,
                    "validate" => [
                        "code" => [
                            "ثبت نام با مشکل مواجه شد"
                        ]
                    ]
                ]);
            }
        } else {
            return json_encode([
                "result" => false,
                "validate" => [
                    "code" => [
                        "کد وارد شده اشتباه است"
                    ]
                ]
            ]);
        }
    }

    private function create_auth_code($target, $type)
    {
        $code = rand(10000, 99999);
        $code = 1111;
        $token = new PasswordReset();
        $token->token = $code;
        if ($type == "mobile") {
            $token->mobile = $target;
        }
        if ($type == "email") {
            $token->email = $target;
        }
        $token->save();
        return $code;
    }

    private function remove_auth_code_by($type, $target)
    {
        PasswordReset::where($type, $target)->delete();
    }

    private function remove_auth_code($code)
    {
        PasswordReset::where('token', $code)->delete();
    }

    private function code_matching($type, $target, $code)
    {
        return PasswordReset::where($type, $target)->where('token', $code)->count();
    }

    private function login($type, $target)
    {
        $user = User::where($type, $target)->first();
        Auth::login($user, true);
        if (Auth::check()) {
            return true;
        }
        return false;
    }

    private function register($username,$mobile){
        $user=new User();
        $user->username=$username;
        $user->mobile=$mobile;
        $user->account_verified=1;
        $user->save();
        return $user;
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
    }

}
