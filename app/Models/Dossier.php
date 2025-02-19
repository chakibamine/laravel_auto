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
    protected $guarded = [];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id',                // int
        'category',          // varchar(2)
        'price',            // int
        'ref',              // varchar(6)
        'date_inscription', // timestamp
        'insert_user',      // varchar(50)
        'student_id',       // int
        'status',           // tinyint(1)
        'resultat',         // tinyint(1)
        'n_serie',          // int
        'date_cloture'      // timestamp
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'price' => 'integer',
        'date_inscription' => 'datetime',
        'student_id' => 'integer',
        'status' => 'boolean',
        'resultat' => 'boolean',
        'n_serie' => 'integer',
        'date_cloture' => 'datetime'
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
        return $this->hasMany(Cour::class, 'id_dossier');
    }
}