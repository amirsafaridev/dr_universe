<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function comments()
    {
        return $this->morphMany(Comment::class, 'commentable')->orderBy('id','DESC');
    }

    public function two_comments()
    {
        return $this->morphMany(Comment::class, 'commentable')->orderBy('id','DESC')->limit(2);
    }

    public function likes()
    {
        return $this->morphMany(Like::class, 'likeable');
    }

    public function saves()
    {
        return $this->morphMany(Save::class, 'savable');
    }

    public function shares()
    {
        return $this->morphMany(Share::class, 'shareable');
    }

    public function notifs()
    {
        return $this->morphMany(Notif::class, 'notifiable');
    }

}
