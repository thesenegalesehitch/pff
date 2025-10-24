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

        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
//ici on appelle le seeder des profils pour etre execute
        $this->call([
        ProfileSeeder::class,
        CategorieTypeMaterielSeeder::class,
        TestUserSeeder::class,
    ]);
    }
}
