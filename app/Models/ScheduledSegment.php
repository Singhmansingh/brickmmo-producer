<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ScheduledSegment extends Model
{
    use HasFactory;

    protected $fillable = [
        'scheduled_for',
        'script_id',
        'music_id',
        'is_playing'
    ];

    public function music()
    {
        return $this->belongsTo(Music::class);
    }

    public function script()
    {
        return $this->belongsTo(Script::class);
    }

}
