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
            'email' => 'superadmin@diandidaktika.sch.id',
            'password' => Hash::make('admin123'),
            'role' => 'superadmin',
        ]);

        User::create([
            'name' => 'Admin Biasa',
            'email' => 'admin@diandidaktika.sch.id',
            'password' => Hash::make('admin123'),
            'role' => 'admin',
        ]);

        User::create([
            'name' => 'Orang Tua',
            'email' => 'ortu@diandidaktika.sch.id',
            'password' => Hash::make('admin123'),
            'role' => 'ortu',
        ]);
    }
}
