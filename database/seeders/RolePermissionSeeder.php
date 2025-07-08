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

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        $clientRole = Role::firstOrCreate(['name' => 'project_client']);
        $clientPermissions = [
            'manage projects',
            'manage project tools',
            'manage applicants',
            'topup wallet',
            'withdraw wallet',
        ];
        $clientRole->syncPermissions($clientPermissions);

        $freelanceRole = Role::firstOrCreate(['name' => 'project_freelancer']);
        $freelancePermissions = [
            'apply job',
            'withdraw wallet',
        ];
        $freelanceRole->syncPermissions($freelancePermissions);

        $superAdminRole = Role::firstOrCreate(['name' => 'super_admin']);

        // === KODE YANG DIPERBAIKI (USER) ===
        // Cari user berdasarkan email. Jika tidak ada, buat dengan data di array kedua.
        $user = User::firstOrCreate(
            ['email' => 'super@admin.com'], // Kunci unik untuk dicari
            [
                'name' => 'Super Admin',
                'occupation' => 'Owner',
                'connect' => 9999,
                'avatar' => 'images/default-avatar.png',
                'password' => bcrypt('password'), // Anda bisa menggunakan Hash::make() juga
            ]
        );

        // Berikan role ke user tersebut
        $user->assignRole($superAdminRole);

        // === KODE YANG DIPERBAIKI (WALLET) ===
        // Cari wallet berdasarkan user_id. Jika tidak ada, buat dengan data di array kedua.
        Wallet::firstOrCreate(
            ['user_id' => $user->id], // Kunci unik untuk dicari
            ['balance' => 0]          // Data yang akan dibuat jika tidak ada
        );
    }
}
