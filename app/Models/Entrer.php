<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Entrer extends Model
{
    use HasFactory;

    protected $table = 'entres';
    protected $primaryKey = 'id';
    protected $guarded = [];
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'date_entrer',
        'motif',
        'montant',
        'date_entry',
        'insert_user'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'date_entrer' => 'date',
        'date_entry' => 'datetime',
        'montant' => 'decimal:2'
    ];
}