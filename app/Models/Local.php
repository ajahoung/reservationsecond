<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Local extends Model
{
    use HasFactory;
    protected $table="local";
    protected $fillable = [
        'libelle',
    ];
    public function group_locals() {
        return $this->belongsToMany(GroupLocal::class);
    }
    public function reservation() {
        return $this->hasMany(Reservation::class, 'reservation', 'id');
    }
}
