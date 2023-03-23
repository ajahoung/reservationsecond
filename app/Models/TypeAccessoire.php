<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TypeAccessoire extends Model
{
    protected $table="type_accessoire";
    use HasFactory;
    protected $fillable = [
        'libelle',
        'quantite'
    ];
    public function lineAccessoire() {
        return $this->belongsTo(LineTypeAccessoire::class, 'type_accessoire_id', 'id');
    }
}
