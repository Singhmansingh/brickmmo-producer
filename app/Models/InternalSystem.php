<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InternalSystem extends Model
{
    use HasFactory;

    protected $fillable = [
        "system_name",
        "request_api_url",
        "system_icon",
    ];

    public function segments()
    {
        return $this->hasMany(Segment::class);
    }
}
