<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TypeJour extends Model
{
    protected $table="type_jour";
    use HasFactory;
    protected $fillable = [
        'type',
    ];
    public function group_local() {
        return $this->hasMany(GroupLocal::class, 'type_jour_id', 'id');
    }
}
