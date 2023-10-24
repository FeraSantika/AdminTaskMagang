<?php

namespace Database\Seeders;

use App\Models\DataUser;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('data_user')->insert([
            'User_id' => 6,
                'User_name' => 'Tika',
                'User_email' => 'Tika@gmail.com',
                'User_password' => Hash::make('password123'),
                'User_gender' => 'female',
                'User_photo' => 'tika.jpg',
                'Role_id' => 1,
                'User_token' => 'user_token_123',
        ]);
    }
}
