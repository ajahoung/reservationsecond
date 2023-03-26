<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GroupLocal extends Model
{
    use HasFactory;
    protected $table="group_local";
    protected $fillable = [
        'libelle',
        'type_jour_id',
        'type_salle_id'
    ];

    public function locals() {
        return $this->belongsToMany(Local::class);
    }
    public function gestionnaires() {
        return $this->belongsToMany(Gestionnaire::class);
    }
    public function typejours() {
        return $this->belongsTo(TypeJour::class, 'type_jour_id', 'id');
    }
    public function typesalle() {
        return $this->belongsTo(TypeSalle::class, 'type_salle_id', 'id');
    }
}
