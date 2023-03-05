<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        
        // Create admin
        User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'email_verified_at' => now(),
            'phone' => '081382250081',
            'city' => 'Depok',
            'password' => Hash::make('123qweasd'), // 123qweasd
            'remember_token' => Str::random(10),
        ]);

        // Create dummy user data
        User::factory(10)->create();

        $this->call([
            PostSeeder::class
        ]);
    }
}
