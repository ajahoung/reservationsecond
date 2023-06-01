<?php

namespace Database\Seeders;

use App\Models\Gestionnaire;
use App\Models\User;
use Illuminate\Database\Seeder;

class GestionnaireTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $gestionnaires = [
            [
                'address' => 'Bruxelles, Ixelles',
                'user_id' => 3,
            ],
        ];
        foreach ($gestionnaires as $key => $value) {
            $gestionnaire = Gestionnaire::create($value);
        }
    }
}
