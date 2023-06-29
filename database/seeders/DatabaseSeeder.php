<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    { 
        //Add grupo Admin
        \App\Models\User::factory()->create([
                'name' => 'Admin User',
                'email' => 'admin@gmail.com',
                'password' => bcrypt(123456),
                'nivel' => 1,
        ]);

        //Add grupo Financeiro
        \App\Models\User::factory()->create([
            'name' => 'Financeiro',
            'email' => 'financeiro@gmail.com',
            'password' => bcrypt(123456),
            'nivel' => 2
        ]);

        //Add grupo Modelador
        \App\Models\User::factory()->create([
            'name' => 'Modelador',
            'email' => 'modelador@gmail.com',
            'password' => bcrypt(123456),
            'nivel' => 3
        ]);           
    }
}
