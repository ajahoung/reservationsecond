<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TypeSalle extends Model
{
    protected $table="type_salle";
    use HasFactory;
    protected $fillable = [
        'type',
    ];
    public function group_local() {
        return $this->hasMany(GroupLocal::class, 'type_salle_id', 'id');
    }
}
