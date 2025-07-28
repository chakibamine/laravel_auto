<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Moniteur extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'cin',
        'n_permit',
        'categorie_permit',
        'n_carte_moniteur',
        'categorie_carte_moniteur',
    ];
}
