<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Dossier extends Model
{
    use HasFactory;

    protected $table = 'dossier';
    public $timestamps = false;
    protected $guarded = [];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'category',
        'price',
        'ref',
        'status',
        'resultat',
        'n_serie',
        'date_inscription',
        'date_cloture',
        'insert_user',
        'student_id'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'date_inscription' => 'datetime',
        'date_cloture' => 'datetime',
    ];

    /**
     * Get the student that owns the dossier
     */
    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class);
    }

    /**
     * Get the courses for this dossier
     */
    public function courses(): HasMany 
    {
        return $this->hasMany(Cour::class, 'dossier_id');
    }
}