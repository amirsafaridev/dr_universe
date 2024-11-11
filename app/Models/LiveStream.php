<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LiveStream extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'stream_url', 'stream_key', 'status', 'live_url','comments_status'];

    // تعریف رابطه با مدل User (در صورت نیاز)
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function checkStreamUrl()
    {

       $result =  arvanCloudGetSpecifiedStream($this->stream_key);

        if ($result != '' && isset($result['player_url']) && !empty($result['player_url'])) {
            $this->live_url = $result['player_url'];
            $this->save();
            return $result['player_url'];
        }

        return redirect()->back();
    }
}
