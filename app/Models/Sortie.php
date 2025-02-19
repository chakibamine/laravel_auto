<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sortie extends Model
{
    use HasFactory;

    protected $table = 'sortie';
    protected $primaryKey = 'id_sortie';
    protected $guarded = [];
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id_sortie',         // int
        'date_sortie',       // date
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
        'date_sortie' => 'date',
        'date_entry' => 'datetime'
    ];
}