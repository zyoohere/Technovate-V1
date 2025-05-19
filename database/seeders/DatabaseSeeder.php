<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Comment;
use App\Models\Artikel;
use Faker\Factory as Faker;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        $faker = Faker::create();

        // Ambil semua ID user dan artikel
        $userIds = User::where('role', 'subscriber')->pluck('id')->toArray();
        $artikelIds = Artikel::pluck('id')->toArray();
        
        foreach (range(1, 100) as $i) {
            $isGuest = $faker->boolean(40);
            Comment::create([
                'user_id'    => $isGuest ? null : $faker->randomElement($userIds),
                'guest_name' => $isGuest ? $faker->name : null,
                'ip_address' => $faker->ipv4,
                'content'    => $faker->sentence(12),
                'artikel_id' => $faker->randomElement($artikelIds),
                'parent_id'  => null, // Atur kalau kamu mau nested comment
                'status'     => $faker->randomElement(['pending', 'approved', 'rejected']),
            ]);
        }
    }
}
