<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JourFerie extends Model
{
    protected $table="ferie_conge";
    use HasFactory;
    protected $fillable = [
        'libelle',
        'date_debut',
        'date_fin',
        'active',
    ];
}
