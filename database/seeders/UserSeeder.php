<?php

namespace Database\Seeders;

use App\Models\DataUser;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        // Buat peran
        $roles = ['Admin', 'Depo', 'Distributor', 'Sales'];

        foreach ($roles as $role) {
            Role::create(['name' => $role]);
        }

        // Buat pengguna dan tetapkan peran
        $users = [
            [
                'User_name' => 'Admin_User',
                'User_email' => 'admin@example.com',
                'User_password' => Hash::make('password'),
                'User_gender' => 'Male',
                'Role_id' => Role::where('name', 'Admin')->first()->id,
                'role' => 'Admin',
            ],
            [
                'User_name' => 'Depo_User',
                'User_email' => 'depo@example.com',
                'User_password' => Hash::make('password'),
                'User_gender' => 'Female',
                'Role_id' => Role::where('name', 'Depo')->first()->id,
                'role' => 'Depo',
            ],
            [
                'User_name' => 'Distributor_User',
                'User_email' => 'distributor@example.com',
                'User_password' => Hash::make('password'),
                'User_gender' => 'Male',
                'Role_id' => Role::where('name', 'Distributor')->first()->id,
                'role' => 'Distributor',
            ],
            [
                'User_name' => 'Sales_User',
                'User_email' => 'sales@example.com',
                'User_password' => Hash::make('password'),
                'User_gender' => 'Female',
                'Role_id' => Role::where('name', 'Sales')->first()->id,
                'role' => 'Sales',
            ],
        ];

        foreach ($users as $userData) {
            $user = DataUser::create([
                'User_name' => $userData['User_name'],
                'User_email' => $userData['User_email'],
                'User_password' => $userData['User_password'],
                'User_gender' => $userData['User_gender'],
                'Role_id' => $userData['Role_id'],
            ]);

            $user->assignRole($userData['role']);
        }
    }
}
