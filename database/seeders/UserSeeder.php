<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = User::firstOrCreate([
            'email' => 'admin@example.com'
        ], [
            'name' => 'Admin',
            'password' => Hash::make('password'),
        ]);

        $admin->assignRole('admin');

        $kepsek = User::firstOrCreate([
            'email' => 'kepsek@example.com'
        ], [
            'name' => 'Kepala Sekolah',
            'password' => Hash::make('password'),
        ]);

        $kepsek->assignRole('kepala sekolah');
    }
}
