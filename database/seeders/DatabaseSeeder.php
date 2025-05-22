<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Comment;
use App\Models\Artikel;
use App\Models\ArtikelView;
use App\Models\Category;
use Faker\Factory as Faker;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
         $faker = \Faker\Factory::create();

        $users = User::pluck('id')->toArray();
        $categories = Category::pluck('id')->toArray();

        foreach (range(1, 20) as $i) {
            $title = $faker->sentence(6);
            Artikel::create([
                'user_id' => $faker->randomElement($users),
                'category_id' => $faker->randomElement($categories),
                'title' => $title,
                'slug' => Str::slug($title) . '-' . Str::random(5),
                'excerpt' => $faker->paragraph(),
                'content' => $faker->paragraphs(5, true),
                'image' => $faker->imageUrl(800, 600, 'news', true),
                'status' => $faker->randomElement(['draft', 'published', 'review', 'archived']),
                'view_count' => $faker->numberBetween(0, 1000),
                'published_at' => $faker->dateTimeBetween('-1 year', 'now'),
                'is_featured' => $faker->boolean(20),
            ]);
        }
    }
}
