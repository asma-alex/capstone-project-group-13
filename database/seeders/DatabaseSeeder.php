<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        \App\Models\User::factory()->create([
            'name' => 'bulletn user',
            'email' => 'test@example.com',
            'password' => Hash::make('password')
        ]);

        \App\Models\User::factory(9)->create();

       $this->call([
        IdeaSeeder::class,
        CommentSeeder::class,
        LikesSeeder::class
       ]); 
    }
}
