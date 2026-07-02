<?php

use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

return new class extends Migration
{
    public function up(): void
    {
        app(PermissionRegistrar::class)->forgetCachedPermissions();

        $permissions = [
            'manage appointments',
            'conduct consultations',
            'manage prestations',
            'request appointments',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate([
                'name' => $permission,
                'guard_name' => 'web',
            ]);
        }

        $roles = [
            'patient' => ['request appointments'],
            'medecin' => ['conduct consultations'],
            'secretaire' => ['manage appointments'],
            'responsable_prestation' => ['manage prestations'],
        ];

        foreach ($roles as $roleName => $rolePermissions) {
            $role = Role::firstOrCreate([
                'name' => $roleName,
                'guard_name' => 'web',
            ]);

            $role->syncPermissions($rolePermissions);
        }

        User::whereDoesntHave('roles')
            ->whereHas('patient')
            ->chunkById(100, function ($users) {
                foreach ($users as $user) {
                    $user->assignRole('patient');
                }
            });

        app(PermissionRegistrar::class)->forgetCachedPermissions();
    }

    public function down(): void
    {
        //
    }
};
