<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Entrer extends Model
{
    use HasFactory;

    protected $table = 'entrer';
    protected $primaryKey = 'id_entry';
    protected $guarded = [];
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id_entry',          // int
        'date_entrer',       // date
        'motif',             // varchar(70)
        'montant',           // varchar(15)
        'date_entry'         // timestamp
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'date_entrer' => 'date',
        'date_entry' => 'datetime'
    ];
}