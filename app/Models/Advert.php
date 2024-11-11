<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Advert extends Model
{
    protected $fillable = ['user_id', 'media_path', 'media_type','post_num'];

    // ارتباط با مدل User
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

