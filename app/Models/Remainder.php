<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Remainder extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'date',
        'type',
        'description',
    ];

    // Optionally, specify the table if not plural of model name
    // protected $table = 'remainders';
} 