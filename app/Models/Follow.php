<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Follow extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'followed_id'];

    public function follower()
    {
        return $this->belongsTo(User::class,'user_id','id');
    }

    public function followed()
    {
        return $this->belongsTo(User::class,'followed_id','id');
    }
}
