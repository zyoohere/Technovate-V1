<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Admin Techno',
            'email' => 'admin@technovate.co.id',
            'password' => Hash::make('admin123456'),
            'role' => 'admin',
            'status' => true,
        ]);
    }
}
