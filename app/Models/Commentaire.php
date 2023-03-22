<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Commentaire extends Model
{
    protected $table="commentaire";
    use HasFactory;
    protected $fillable = [
        'message',
        'reservation_id',
        'gestionnaire_id'
    ];
}
