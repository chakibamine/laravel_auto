<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Reg extends Model
{
    use HasFactory;

    protected $table = 'reg';
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'date_reg',
        'price',
        'motif',
        'nom_du_payeur',
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
        'date_reg' => 'datetime',
        'date_insertion' => 'datetime',
        'price' => 'float',
        'dossier_id' => 'integer'
    ];

    /**
     * Get the dossier that owns the registration
     */
    public function dossier(): BelongsTo
    {
        return $this->belongsTo(Dossier::class);
    }
}