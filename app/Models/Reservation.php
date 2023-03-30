<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    const PENDING="PENDING";
    const ACCEPTED="ACCEPTED";
    const DENIED="DENIED";
    protected $table="reservation";
    use HasFactory;
    protected $fillable = [
        'personnel_id',
        'local_id',
        'user_id',
        'agenda_id',
        'periode_id',
        'start',
        'end',
        'libelle',
        'status',
        'date_reservation',
        'contegent',
        'group_local_id',
        'parent_id'
    ];
    public function local() {
        return $this->belongsTo(Local::class, 'local_id', 'id');
    }
    public function local_group() {
        return $this->belongsTo(GroupLocal::class, 'group_local_id', 'id');
    }
    public function periode() {
        return $this->belongsTo(Periode::class, 'periode_id', 'id');
    }
    public function agenda() {
        return $this->belongsToMany(CaseAgenda::class,'reservation_case_agenda');
    }
    public function user() {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
