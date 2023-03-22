<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Gestionnaire extends User
{
    protected $table="gestionnaire";
    use HasFactory;
    protected $fillable = [
        'user_id',
        'address',
        ];
    public function account() {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
