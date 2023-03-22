<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CaseAgenda extends Model
{

    use HasFactory;
    protected $table="case_agenda";
    protected $fillable = [
        'date_jour',
        'libelle_jour',
        'heure_debut',
        'heure_fin',
        'type_jour_id',
    ];
    public function type_jour() {
        return $this->belongsTo(TypeJour::class, 'type_jour_id', 'id');
    }
    public function reservations() {
        return $this->belongsToMany(Reservation::class,'reservation_case_agenda');
    }
}
