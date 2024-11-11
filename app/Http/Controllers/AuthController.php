<?php

namespace App\Http\Controllers;

use App\Models\AuthCode;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use IPPanel\Client;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use App\Models\Setting;

class AuthController extends Controller
{
    private $apiKey = "1JT-C6gjOo9OOV5I__OznUNEdt2uS2o-cKb5hAe370s=";
    private $originator = "+983000505";
    private $loginPatternCode = "811frf160bfaayr";
    private $registerPatternCode = "811frf160bfaayr";


    public function get_remaining_time(Request $request)
    {
        $mobile = $request->input('mobile');
        $codeSentTime = session('code_sent_time');

        if ($codeSentTime) {
            $now = Carbon::now();
            $timeDifference = $now->diffInSeconds($codeSentTime);

            $remainingTime = max(0, 120 - $timeDifference);

            return response()->json(['remainingTime' => $remainingTime]);
        }

        return response()->json(['remainingTime' => 0]);
    }

    public function login_view()
    {
        // چک کردن اینکه آیا موبایل در session وجود دارد یا نه
        $mobile = session('mobile');

        if ($mobile) {
            // اگر موبایل در session باشد، کاربر را به صفحه ورود به کد هدایت کنید
            return redirect()->route('show_login_code');
        }

        return view('front.auth.login2');
    }

    public function register_view()
    {
        $terms = Setting::where('key', 'terms')->first()->value ?? '';
        // چک کردن اینکه آیا موبایل در session وجود دارد یا نه
        $mobile = session('mobile');

        if ($mobile) {
            // اگر موبایل در session باشد، کاربر را به صفحه ورود به کد هدایت کنید
            return redirect()->route('show_register_code');
        }

        return view('front.auth.register', compact('terms'));
    }

    public function send_login_code(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'mobile' => 'required|min:11|exists:users,mobile',
        ], [
            'mobile.required' => 'شماره همراه را وارد کنید',
            'mobile.min' => 'شماره همراه باید 11 رقم باشد',
            'mobile.exists' => 'کاربری با این شماره همراه یافت نشد',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $mobile = $request->input('mobile');

        // ذخیره شماره موبایل در session
        session(['mobile' => $mobile]);

        // بررسی اینکه آیا تایمر در حال اجراست
        $authCode = AuthCode::where('mobile', $mobile)->orderBy('updated_at', 'desc')->first();

        if ($authCode) {
            $now = Carbon::now();
            $timeDifference = $now->diffInSeconds($authCode->updated_at);

            if ($timeDifference < 120) {
                return redirect()->back()->withErrors(['code' => 'باید تا زمان اتمام تایمر صبر کنید.'])->withInput();
            }
        }

        $code = $this->generate_and_save_code($mobile);
        $this->send_sms($mobile, $this->loginPatternCode, $code);

        // ذخیره زمان ارسال کد در سشن
        session(['code_sent_time' => Carbon::now()]);

        return view('front.auth.login_code', compact('mobile'));
    }

    public function show_login_code()
    {
        $mobile = session('mobile'); // دریافت شماره موبایل از session

        if (!$mobile) {
            // اگر شماره موبایل در session نبود، به صفحه login هدایت نشود
            // بلکه باید بررسی کنیم که در localStorage هست یا نه
            return redirect()->route('login_page');
        }

        return view('front.auth.login_code', compact('mobile'));
    }

    public function send_register_code(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'mobile' => 'required|min:11|unique:users,mobile',
            'username' => 'required|min:3|unique:users,username',
        ], [
            'mobile.required' => 'شماره همراه را وارد کنید',
            'mobile.min' => 'شماره همراه باید 11 رقم باشد',
            'mobile.unique' => 'کاربری با این شماره همراه موجود است',
            'username.required' => 'نام کاربری را وارد کنید',
            'username.min' => 'نام کاربری باید حداقل 3 حرف باشد',
            'username.unique' => 'کاربری با این نام کاربری موجود است',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $mobile = $request->input('mobile');
        $username = $request->input('username'); // تعریف و مقداردهی متغیر username

        // بررسی اینکه آیا تایمر در حال اجراست
        $authCode = AuthCode::where('mobile', $mobile)->orderBy('updated_at', 'desc')->first();

        if ($authCode) {
            $now = Carbon::now();
            $timeDifference = $now->diffInSeconds($authCode->updated_at);

            if ($timeDifference < 120) {
                return redirect()->back()->withErrors(['code' => 'باید تا زمان اتمام تایمر صبر کنید.'])->withInput();
            }
        }

        // ذخیره شماره موبایل و نام کاربری در سشن
        session(['mobile' => $mobile]);
        session(['username' => $username]);

        $code = $this->generate_and_save_code($mobile);
        $this->send_sms($mobile, $this->registerPatternCode, $code);

        // ذخیره زمان ارسال کد در سشن
        session(['code_sent_time' => Carbon::now()]);

        // ارسال متغیرها به view
        return view('front.auth.register_code', compact('mobile', 'username'));
    }



    public function show_register_code()
    {
        $mobile = session('mobile');
        $username = session('username');

        if (!$mobile || !$username) {
            return redirect()->route('auth.register'); // یا هر مسیر دیگری برای هدایت به صفحه اصلی
        }

        return view('front.auth.register_code', compact('mobile', 'username'));
    }

    public function verify_login_code(Request $request)
    {
//        dd("d");
        // اعتبارسنجی ورودی‌ها
        $validator = Validator::make($request->all(), [
            'mobile' => 'required|min:11|exists:users,mobile',
            'code' => 'required|exists:auth_codes,code',
        ], [
            'mobile.required' => 'شماره همراه را وارد کنید',
            'mobile.min' => 'شماره همراه باید 11 رقم باشد',
            'mobile.exists' => 'کاربری با این شماره همراه موجود نیست',
            'code.required' => 'کد دریافتی را وارد کنید',
            'code.exists' => 'کد وارد شده اشتباه است',
        ]);

        // اگر اعتبارسنجی شکست خورد، خطاها را به مسیر مشخص برگردانید
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $mobile = $request->input('mobile');
        $code = $request->input('code');

        // بررسی مطابقت کد
        if ($this->code_matching('mobile', $mobile, $code)) {
            $this->remove_auth_code($code);
            if ($this->login('mobile', $mobile)) {
                return redirect()->route('home_page');
            } else {
                return redirect()->route('send_login_code')
                    ->withErrors(['code' => 'ورود با مشکل مواجه شد'])
                    ->withInput();
            }
        } else {
            return redirect()->route('send_login_code')
                ->withErrors(['code' => 'کد وارد شده اشتباه است'])
                ->withInput();
        }
    }

    public function verify_reg_code(Request $request)
    {


        $validator = Validator::make($request->all(), [
            'mobile' => 'required|min:11|unique:users,mobile',
            'username' => 'required|min:3|unique:users,username',
            'code' => 'required',
        ], [
            'mobile.required' => 'شماره همراه را وارد کنید',
            'mobile.min' => 'شماره همراه باید 11 رقم باشد',
            'mobile.unique' => 'کاربری با این شماره همراه موجود است',
            'username.required' => 'نام کاربری را وارد کنید',
            'username.min' => 'نام کاربری باید حداقل 3 حرف باشد',
            'username.unique' => 'کاربری با این نام کاربری موجود است',
            'code.required' => 'کد دریافتی را وارد کنید',
            'code.exists' => 'کد وارد شده اشتباه است',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $mobile = $request->input('mobile');
        $username = $request->input('username');
        $code = $request->input('code');
        if ($this->code_matching('mobile', $mobile, $code)) {
            $this->remove_auth_code($code);
            $user = $this->register($username, $mobile);

            if ($user && $this->login('mobile', $mobile)) {
                // گرفتن تمام ادمین‌ها
                $admins = User::where('role', 'admin')->get();

                // فالو کردن تمام ادمین‌ها
                foreach ($admins as $admin) {
                    $user->followings()->attach($admin->id);
                }

                return redirect()->route('home_page');
            } else {
                return redirect()->back()
                    ->withErrors(['code' => 'ورود با مشکل مواجه شد'])
                    ->withInput();
            }

//            if ($user && $this->login('mobile', $mobile)) {
//                return redirect()->route('home_page');
//            } else {
//                return redirect()->back()
//                    ->withErrors(['code' => 'ورود با مشکل مواجه شد'])
//                    ->withInput();
//            }
        } else {
            return redirect()->back()
                ->withErrors(['code' => 'کد وارد شده اشتباه است'])
                ->withInput();
        }
        }


    public function resend_login_code(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'mobile' => 'required|min:11|exists:users,mobile',
        ], [
            'mobile.required' => 'شماره همراه را وارد کنید',
            'mobile.min' => 'شماره همراه باید 11 رقم باشد',
            'mobile.exists' => 'کاربری با این شماره همراه یافت نشد',
        ]);

        if ($validator->fails()) {
            return response()->json([
                "result" => false,
                "message" => $validator->messages()
            ]);
        }

        $mobile = $request->input('mobile');

        $authCode = AuthCode::where('mobile', $mobile)
            ->orderBy('updated_at', 'desc')
            ->first();

        if ($authCode) {
            $now = Carbon::now();
            $timeDifference = $now->diffInSeconds($authCode->updated_at);

            if ($timeDifference < 120) {
                return response()->json([
                    'result' => false,
                    'message' => 'باید تا زمان اتمام تایمر صبر کنید.'
                ]);
            }
        }

        $code = $this->generate_and_save_code($mobile);

        $this->send_sms($mobile, $this->loginPatternCode, $code);

        return response()->json([
            "result" => true,
            "message" => "کد جدید ارسال شد"
        ]);
    }

    public function resendRegisterCode(Request $request)
    {
        $mobile = $request->input('mobile');

        $authCode = AuthCode::where('mobile', $mobile)
            ->orderBy('updated_at', 'desc')
            ->first();

        if ($authCode) {
            $now = Carbon::now();
            $timeDifference = $now->diffInSeconds($authCode->updated_at);

            if ($timeDifference < 120) {
                return response()->json(['result' => false, 'message' => 'باید تا زمان اتمام تایمر صبر کنید.']);
            }
        }

        $code = $this->generate_and_save_code($mobile);
        $this->send_sms($mobile, $this->registerPatternCode, $code);

        return response()->json(['result' => true, 'message' => 'کد جدید ارسال شد.']);
    }




    private function generate_and_save_code($mobile)
    {
        AuthCode::where('mobile', $mobile)->delete();
        $code = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);
        AuthCode::create(['mobile' => $mobile, 'code' => $code]);
        return $code;
    }

    private function send_sms($mobile, $patternCode, $code)
    {
        $client = new Client($this->apiKey);

        try {
            $client->sendPattern($patternCode, $this->originator, $mobile, ["{otp}" => $code]);
        } catch (\Exception $e) {
            // Handle exception
            echo "Error: " . $e->getMessage();
        }
    }

    private function code_matching($type, $target, $code)
    {
        return AuthCode::where($type, $target)->where('code', $code)->exists();
    }

    private function remove_auth_code($code)
    {
        AuthCode::where('code', $code)->delete();
    }

    private function login($type, $target)
    {
        $user = User::where($type, $target)->first();
        if ($user) {
            Auth::login($user, true);
            return Auth::check();
        }
        return false;
    }

    private function register($username, $mobile)
    {
        return User::create(['username' => $username, 'mobile' => $mobile, 'account_verified' => 1]);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    }

    public function showLoginFormadmin()
    {
        return view('admin.login'); // نمای مربوط به فرم ورود
    }





    public function loginadmin(Request $request)
    {
        // اعتبارسنجی ورودی‌ها
        $credentials = $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);


        // جستجوی کاربر بر اساس شماره موبایل
        $user = User::where('username', $credentials['username'])->first();

//        $user->password = Hash::make($credentials['password']); // هش کردن پسورد
//        $user->save();

        // بررسی اینکه آیا کاربر وجود دارد و رمز عبور صحیح است
        if ($user && Hash::check($credentials['password'], $user->password))
        {
            if ($user->role === 'admin') {
                Auth::login($user); // ورود کاربر
                return redirect()->route('admin.dashboard'); // مسیر داشبورد
            }

            // در صورتی که کاربر ادمین نیست
            return back()->withErrors([
                'username' => 'شما اجازه دسترسی به این پنل را ندارید.',
            ]);
        }

        // ورود ناموفق
        return back()->withErrors([
            'username' => 'ورود ناموفق. لطفا اطلاعات را دوباره بررسی کنید.',
        ]);
    }

}
