<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Cour extends Model
{
    use HasFactory;

    protected $table = 'cours';
    protected $guarded = [];
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'date_cours',
        'type_cours',
        'dossier_id',
        'date_insertion',
        'insert_user'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'date_cours' => 'datetime',
        'date_insertion' => 'datetime'
    ];

    /**
     * Get the dossier that owns the course
     */
    public function dossier(): BelongsTo
    {
        return $this->belongsTo(Dossier::class);
    }
}