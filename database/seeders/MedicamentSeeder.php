<?php

namespace Database\Seeders;

use App\Models\Medicament;
use Illuminate\Database\Seeder;

class MedicamentSeeder extends Seeder
{
    public function run(): void
    {
        $medicaments = [
            ['code' => 'PARA500', 'nom' => 'Paracétamol 500mg'],
            ['code' => 'AMOX500', 'nom' => 'Amoxicilline 500mg'],
            ['code' => 'IBU400', 'nom' => 'Ibuprofène 400mg'],
            ['code' => 'DOLA1000', 'nom' => 'Doliprane 1000mg'],
            ['code' => 'SPASFON', 'nom' => 'Spasfon'],
            ['code' => 'AUGM', 'nom' => 'Augmentin'],
            ['code' => 'VENTO', 'nom' => 'Ventoline'],
            ['code' => 'CLAM', 'nom' => 'Clamoxyl'],
        ];

        foreach ($medicaments as $med) {
            Medicament::create($med);
        }
    }
}
