<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class RolesAndPermissionsSeeder extends Seeder
{
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Clear tables to avoid duplicates
        $this->truncateTables();

        // create permissions
        Permission::create(['name' => 'manage appointments']);
        Permission::create(['name' => 'conduct consultations']);
        Permission::create(['name' => 'manage prestations']);
        Permission::create(['name' => 'request appointments']);

        // create roles and assign created permissions
        $rolePatient = Role::create(['name' => 'patient']);
        $rolePatient->givePermissionTo('request appointments');

        $roleMedecin = Role::create(['name' => 'medecin']);
        $roleMedecin->givePermissionTo('conduct consultations');

        $roleSecretaire = Role::create(['name' => 'secretaire']);
        $roleSecretaire->givePermissionTo('manage appointments');

        $roleResponsable = Role::create(['name' => 'responsable_prestation']);
        $roleResponsable->givePermissionTo('manage prestations');

        // Create default users for testing
        $admin = User::create([
            'name' => 'Admin Secrétaire',
            'email' => 'secretaire@clinique.com',
            'password' => Hash::make('password'),
        ]);
        $admin->assignRole($roleSecretaire);

        $doctor = User::create([
            'name' => 'Dr. House',
            'email' => 'house@clinique.com',
            'password' => Hash::make('password'),
        ]);
        $doctor->assignRole($roleMedecin);
        \App\Models\Medecin::create([
            'user_id' => $doctor->id,
            'specialite' => 'généraliste',
        ]);

        $doctor2 = User::create([
            'name' => 'Dr. Watson',
            'email' => 'watson@clinique.com',
            'password' => Hash::make('password'),
        ]);
        $doctor2->assignRole($roleMedecin);
        \App\Models\Medecin::create([
            'user_id' => $doctor2->id,
            'specialite' => 'dentiste',
        ]);

        $doctor3 = User::create([
            'name' => 'Dr. Strange',
            'email' => 'strange@clinique.com',
            'password' => Hash::make('password'),
        ]);
        $doctor3->assignRole($roleMedecin);
        \App\Models\Medecin::create([
            'user_id' => $doctor3->id,
            'specialite' => 'ophtalmologie',
        ]);

        $manager = User::create([
            'name' => 'Responsable Prestations',
            'email' => 'responsable@clinique.com',
            'password' => Hash::make('password'),
        ]);
        $manager->assignRole($roleResponsable);
    }

    protected function truncateTables()
    {
        $tables = [
            'role_has_permissions',
            'model_has_roles',
            'model_has_permissions',
            'roles',
            'permissions',
            'medecins',
            'users'
        ];

        if (DB::getDriverName() === 'sqlite') {
            DB::statement('PRAGMA foreign_keys = OFF');
            foreach ($tables as $table) {
                DB::table($table)->truncate();
            }
            DB::statement('PRAGMA foreign_keys = ON');
        } elseif (DB::getDriverName() === 'pgsql') {
            foreach ($tables as $table) {
                DB::statement("TRUNCATE TABLE $table RESTART IDENTITY CASCADE");
            }
        } else {
            Schema::disableForeignKeyConstraints();
            foreach ($tables as $table) {
                DB::table($table)->truncate();
            }
            Schema::enableForeignKeyConstraints();
        }
    }
}
