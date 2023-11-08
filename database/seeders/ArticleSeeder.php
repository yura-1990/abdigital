<?php

namespace Database\Seeders;

use App\Models\Article;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class ArticleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $files = Storage::disk('public')->files('article');

        for ($i = 0; $i < 1000; $i++) {
            $data = [];
            for($j = 0; $j < 1000; $j++) {
                $user = User::query()->inRandomOrder()->first();

                $data[] = [
                    'user_id' => $user->id,
                    'image' => fake()->randomElement($files),
                    'title' => fake()->text(50),
                    'content' => fake()->text(150),
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }

            foreach (array_chunk($data, 100) as $chunk){
                Article::query()->insert($chunk);
            }
        }


    }
}
