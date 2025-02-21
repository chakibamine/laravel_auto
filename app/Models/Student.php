<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Student extends Model
{
    use HasFactory;

    protected $table = 'students';
    
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'gender',
        'cin',
        'firstname',
        'lastname',
        'date_birth',
        'place_birth',
        'address',
        'city',
        'phone',
        'a_firstname',
        'a_lastname',
        'a_place_birth',
        'a_address',
        'reg_date',
        'insert_user',
        'image_url'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'date_birth' => 'date',
        'reg_date' => 'datetime'
    ];

    /**
     * Get the exams for the student
     */
    public function exams(): HasMany
    {
        return $this->hasMany(Exam::class);
    }

    /**
     * Get the entries (class attendance) for the student
     */
    public function entries(): HasMany
    {
        return $this->hasMany(Entrer::class);
    }

    /**
     * Get the exits (class departures) for the student
     */
    public function exits(): HasMany
    {
        return $this->hasMany(Sortie::class);
    }

    /**
     * Get the dossiers for the student
     */
    public function dossiers(): HasMany
    {
        return $this->hasMany(Dossier::class);
    }
}