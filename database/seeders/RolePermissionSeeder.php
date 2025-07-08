<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Wallet;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = [
            'manage categories',
            'manage tools',
            'manage projects',
            'manage project tools',
            'manage wallets',
            'manage applicants',

            'apply job',
            'topup wallet',
            'withdraw wallet',
        ];

        foreach($permissions as $permission){
            Permission::firstOrCreate([
                'name' => $permission
            ]);
        }

        $clientRole = Role::firstOrCreate([
            'name' => 'project_client'
        ]);

        $clientPermissions = [
            'manage projects',
            'manage project tools',
            'manage applicants',
            'topup wallet',
            'withdraw wallet',
        ];

        $clientRole->syncPermissions($clientPermissions);

        $freelanceRole = Role::firstOrCreate([
            'name' => 'project_freelancer'
        ]);

        $freelancePermissions = [
            'apply job',
            'withdraw wallet',
        ];

        $freelanceRole->syncPermissions($freelancePermissions);
        
        $superAdminRole = Role::firstOrCreate([
            'name' => 'super_admin'
        ]);

        $user = User::create([
            'name' => 'Super Admin',
            'email' => 'super@admin.com',
            'occupation' => 'Owner',
            'connect' => 9999,
            'avatar' => 'images/default-avatar.png',
            'password' => bcrypt('password'),
        ]);

        $user->assignRole($superAdminRole);

        $wallet = new Wallet([
            'balance' => 0
        ]);

        $user->wallet()->save($wallet);

    }
}
