<?php

namespace Database\Seeders;

use App\Models\Personnel;
use App\Models\User;
use Illuminate\Database\Seeder;

class PersonnelTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $personnels = [
            [
                'address' => 'Douala, Bepanda',
                'account_id' => 1,
            ],
            [
                'address' => 'Douala, Akwa',
                'account_id' => 2,
            ],
            [
                'address' => 'Douala, Akwa',
                'account_id' => 3,
            ],
        ];
        foreach ($personnels as $key => $value) {
            $personnel = Personnel::create($value);
        }
    }
}
