<?php

namespace Database\Seeders;

use App\Models\User;
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

        User::factory()->create([
            'name' => 'Test User',
            'slug' => 'test-user',
            'avatar' => 'https://www.gravatar.com/avatar/' . md5(strtolower(trim('test@example.com'))) . '?d=mp&s=200',
            'tipo' => 'admin',
            'email' => 'test@example.com',
        ]);
    }
}
