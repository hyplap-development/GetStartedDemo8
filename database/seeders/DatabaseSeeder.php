<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

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

        \App\Models\User::factory()->create([
            'name' => 'Hyplap',
            'email' => 'hyplap@gmail.com',
            'password' => Hash::make('Admin@123'),
            'role' => 'hyplap',
        ]);

        // add role
        \App\Models\Role::factory()->create([
            'name' => 'Hyplap',
            'slug' => 'hyplap',
        ]);
    }
}
