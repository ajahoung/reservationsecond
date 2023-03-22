<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Personnel extends Account
{
    use HasFactory;
    protected $fillable = [
        'account_id',
        'address',
        ];
    public function getAccount() {
        return $this->belongsTo(Account::class, null, 'id');
    }
}
