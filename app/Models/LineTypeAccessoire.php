<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LineTypeAccessoire extends Model
{
    protected $table="line_type_accessoire";
    use HasFactory;
    protected $fillable = [
        'type_accessoire_id',
        'reservation_id',
        'nombre',
    ];
    public function accessoire() {
        return $this->hasMany(TypeAccessoire::class);
    }
}
