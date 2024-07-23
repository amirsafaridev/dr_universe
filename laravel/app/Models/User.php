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
        return $this->hasMany(Follow::class,'followed_id','id');
    }

    public function followings()
    {
        return $this->hasMany(Follow::class,'user_id','id');
    }
}
