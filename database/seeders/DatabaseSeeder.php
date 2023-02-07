<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        User::factory()->create([
            'name' => "Marco Castillo",
            'email' => "marco.castillo@emergys.com"
        ]);

        User::factory(99)
            ->sequence(fn($sequence) => ['name' => 'Person ' . $sequence->index + 2])
            ->create();

        foreach (range(1, 20) as $user_id) {
            Post::factory()->create(['user_id' => $user_id]);
            foreach (range(1, 20) as $user_id2) {
                User::find($user_id)->follows()->attach(User::find($user_id2));
            }
        }

        // Post::factory(40)->create();
    }
}