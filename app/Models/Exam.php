<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Exam extends Model
{
    use HasFactory;

    protected $table = 'exam';
    protected $guarded = [];
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id',                // int
        'date_exam',         // date
        'type_exam',         // varchar(25)
        'resultat',          // varchar(1)
        'date_insertion',    // timestamp
        'insert_user',       // varchar(50)
        'dossier_id'        // int
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'date_exam' => 'date',
        'date_insertion' => 'datetime',
        'dossier_id' => 'integer'
    ];

    /**
     * Get the dossier that owns the exam
     */
    public function dossier(): BelongsTo
    {
        return $this->belongsTo(Dossier::class);
    }
}