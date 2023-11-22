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
        \App\Models\User::create([
            'name' => 'Super User',
            'email' => 'superuser@gmail.com',
            'password' => Hash::make('password'),
            'role'=>"superuser",
            'is_approved'=>true,
        ]);

         \App\Models\User::factory(20)->create([
             "role"=>"consultant"
         ]);

        \App\Models\User::factory(100)->create([
            "role"=>"client"
        ]);


    }
}
