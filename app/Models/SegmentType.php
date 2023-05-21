<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SegmentType extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'type_name',
    ];

    public function segments()
    {
        return $this->hasMany(Segment::class);
    }
    
    public function subSegmentTypes()
    {
        return $this->hasMany(SubSegmentType::class);
    }

    public function segmentFields()
    {
        return $this->hasMany(SegmentField::class);
    }
    
}
