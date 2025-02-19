<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Cour extends Model
{
    use HasFactory;

    protected $table = 'cour';
    protected $guarded = [];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id',                // int
        'date_cour',        // date
        'type',             // varchar(50)
        'id_dossier',       // int
        'date_insertion'    // timestamp
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'date_cour' => 'date',
        'id_dossier' => 'integer',
        'date_insertion' => 'datetime'
    ];

    /**
     * Get the dossier that owns the course
     */
    public function dossier(): BelongsTo
    {
        return $this->belongsTo(Dossier::class, 'id_dossier');
    }
}