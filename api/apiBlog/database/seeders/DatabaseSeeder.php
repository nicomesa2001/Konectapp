<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Category;
use App\Models\Tag;
use App\Models\Post;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        //User
        User::factory()->create([
            'email' => 'admin@admin.com',
            'password' => bcrypt('password')
        ]);

        User::factory(10)->create();

        Category::factory(50)->create();

        Tag::factory(15)->create();

        Post::factory(20)->create()->each(function($post) {
            $post->tags()->attach($this->tagsValue(rand(1,15)));
        });
    }

    protected function tagsValue($value)
    {
        $tags = [];

        for ($i=1; $i < $value; $i++){
            $tags [] = $i;
        }
        return $tags;        
    }
}
