<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Quiz extends Model
{
    protected $fillable = [
        'image_url',
        'audio',
        'result',
        'description',
    ];
} 