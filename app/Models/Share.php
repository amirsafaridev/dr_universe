<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Share extends Model
{
    use HasFactory;

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function post()
    {
        return $this->belongsTo(Post::class, "shareable_id", 'id');
    }

    public function receiver()
    {
        return $this->belongsTo(User::class, "receiver_id", 'id');
    }

}
