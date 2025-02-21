<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Exam extends Model
{
    use HasFactory;

    protected $table = 'exams';
    protected $guarded = [];
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'date_exam',
        'type_exam',
        'n_serie',
        'resultat',
        'dossier_id',
        'insert_user'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'date_exam' => 'datetime',
        'resultat' => 'string'
    ];

    /**
     * Get the dossier that owns the exam
     */
    public function dossier(): BelongsTo
    {
        return $this->belongsTo(Dossier::class);
    }
}