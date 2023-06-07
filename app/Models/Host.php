<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Host extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'gtts_name',
        'personality',
        'bio',
        'profile_pic',
    ];
}
