<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reglement extends Model
{
    use HasFactory;

    protected $table = 'reg';

    protected $fillable = [
        'dossier_id',
        'total_price',
        'date_reg',
        'date_insertion',
        'insert_user'
    ];

    protected $dates = [
        'date_reg',
        'date_insertion'
    ];

    public function dossier()
    {
        return $this->belongsTo(Dossier::class, 'dossier_id');
    }
} 