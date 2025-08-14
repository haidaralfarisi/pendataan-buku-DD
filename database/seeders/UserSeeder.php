<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Super Admin',
            'nisn' => '12345',
            'password' => Hash::make('admin123'),
            'role' => 'superadmin',
            'classroom_id' => null, // Assuming 0 is a placeholder for superadmin
        ]);

        User::create([
            'name' => 'Orang Tua',
            'nisn' => '123455',
            'password' => Hash::make('admin123'),
            'role' => 'orangtua',
            'classroom_id' => null, // Assuming 0 is a placeholder for orangtua
        ]);
    }
}
