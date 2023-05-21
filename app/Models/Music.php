<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Music extends Model
{
    use HasFactory;

    protected $fillable = [
        'music_name',
        'music_artist',
        'music_src',
    ];

    public function scheduledSegments()
    {
        return $this->hasMany(ScheduledSegment::class);
    }
}
