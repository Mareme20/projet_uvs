<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Patient;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class PatientSeeder extends Seeder
{
    public function run(): void
    {
        $patientsData = [
            ['nom' => 'Diop', 'prenom' => 'Abdou', 'email' => 'abdou@example.com', 'antecedents' => ['Diabète']],
            ['nom' => 'Fall', 'prenom' => 'Fatou', 'email' => 'fatou@example.com', 'antecedents' => ['Hypertension', 'Hépatite']],
            ['nom' => 'Ndiaye', 'prenom' => 'Moussa', 'email' => 'moussa@example.com', 'antecedents' => []],
            ['nom' => 'Gueye', 'prenom' => 'Aminata', 'email' => 'ami@example.com', 'antecedents' => ['Hypertension']],
            ['nom' => 'Gomez', 'prenom' => 'Jean', 'email' => 'jean@example.com', 'antecedents' => ['Asthme']],
            ['nom' => 'Sow', 'prenom' => 'Awa', 'email' => 'awa@example.com', 'antecedents' => ['Diabète', 'Hypertension']],
        ];

        foreach ($patientsData as $data) {
            $user = User::create([
                'name' => $data['nom'],
                'email' => $data['email'],
                'password' => Hash::make('password'),
            ]);
            $user->assignRole('patient');

            Patient::create([
                'user_id' => $user->id,
                'code' => 'PAT-' . strtoupper(Str::random(6)),
                'nom' => $data['nom'],
                'prenom' => $data['prenom'],
                'antecedents' => $data['antecedents'],
            ]);
        }
    }
}
