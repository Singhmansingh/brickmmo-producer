<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubSegmentType extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'sub_segment_name',
        'segment_type_id',
        'type_name',
    ];

    public function segmentType()
    {
        return $this->belongsTo(SegmentType::class);
    }

}
