<?php

namespace App\Models;


class User extends Account
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'account_id',
        'address',
    ];

    public function getAccount() {
        return $this->belongsTo(Account::class, null, 'id');
    }
}
