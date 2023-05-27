<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SegmentField extends Model
{
    use HasFactory;
        /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'field_name',
        'field_data_type',
        'field_label',
        'segment_type_id',
        'type_name',
    ];

    public function segmentType()
    {
        return $this->belongsTo(SegmentType::class);
    }

}
