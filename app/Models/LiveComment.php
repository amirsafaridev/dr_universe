<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LiveComment extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'live_stream_id', 'comment'];

    // ارتباط با مدل User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // ارتباط با مدل LiveStream
    public function liveStream()
    {
        return $this->belongsTo(LiveStream::class);
    }
}
