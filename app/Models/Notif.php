<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notif extends Model
{
    protected $fillable = [
        'user_id', 'owner_id', 'action', 'desc', 'checked', 'notifiable_type', 'notifiable_id'
    ];

    public function notifiable()
    {
        return $this->morphTo();
    }

    public function owner()
    {
        return $this->belongsTo(User::class, 'owner_id');
    }
}





