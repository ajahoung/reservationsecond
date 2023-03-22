<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        $users = [
            [
                'address' => 'Douala, Bepanda',
                'account_id' => 4,
            ],
        ];
        foreach ($users as $key => $value) {
            $user = User::create($value);
        }
    }
}
