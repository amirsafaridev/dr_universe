<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Story extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'type', 'file_path', 'expired_at','views'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }


    public function slides()
    {
        return $this->hasMany(StorySlide::class);
    }
}
