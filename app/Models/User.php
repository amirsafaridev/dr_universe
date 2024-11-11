<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;
use Laravel\Sanctum\HasApiTokens;
use Termwind\Components\Li;


class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = ['name', 'username', 'email', 'mobile', 'role', 'blue_tick', 'account_type'];


    // سایر متدها و ویژگی‌های مدل User

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'password' => 'hashed',
    ];

    private function user_id()
    {
        return Auth::id();
    }

    public function posts(): HasMany
    {
        return $this->hasMany(Post::class);
    }

    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }

    public function likes(): HasMany
    {
        return $this->hasMany(Like::class);
    }



    public function saves(): HasMany
    {
        return $this->hasMany(Save::class);
    }

    public function shares(): HasMany
    {
        return $this->hasMany(Share::class);
    }

    public function notifs(): HasMany
    {
        return $this->hasMany(Notif::class)->where('owner_id',$this->user_id());
    }

    public function notifs_last50(): HasMany
    {
        return $this->hasMany(Notif::class)->where('owner_id',$this->user_id())->limit(50);
    }

    public function followers()
    {
        return $this->belongsToMany(User::class, 'follows', 'followed_id', 'user_id');
    }

    public function followings()
    {
        return $this->belongsToMany(User::class, 'follows', 'user_id', 'followed_id');
    }


    public function stories()
    {
        return $this->hasMany(Story::class);
    }

    public function followedUsers()
    {
        return $this->hasMany(Follow::class, 'user_id', 'id')
            ->join('users', 'follows.followed_id', '=', 'users.id')
            ->select('users.*');
    }

// در User.php
    public function getUsernameWithBlueTickAttribute()
    {
        $blueTickHtml = $this->blue_tick ? '<img style="width: 20px !important; height : 20px !important; margin: 3px; margin-bottom: 5px;" src="' . asset('img/duo-icons_approved-1.svg') . '">' : '';
        return $blueTickHtml . ' ' .  $this->username; // تغییر ترتیب به نام کاربر و سپس تیک آبی
    }

    public function isAdmin()
    {
        // Replace this condition with your actual logic to check if the user is an admin
        return $this->role === 'admin'; // Assuming you have a 'role' column in your users table
    }
}
