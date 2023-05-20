<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'admin',
            'email' => 'admin@gmail.com',
            'email_verified_at' => now(),
            'password' => bcrypt('admin123'),
            'cedula' => '102548569',
            'address' => 'Calle 47 #10A',
            'phone' => '3014160258',    
            'role' => 'admin',
        ]);
       
        User::create([
            'name' => 'estilista',
            'email' => 'estilista02@gmail.com',
            'email_verified_at' => now(),
            'password' => bcrypt('estilista123'),
            'cedula' => '102548569',
            'address' => 'Calle 47 #10A',
            'phone' => '3014160258',    
            'role' => 'estilista',

        ]);
        User::create([
            'name' => 'cliente',
            'email' => 'cliente01@gmail.com',
            'email_verified_at' => now(),
            'password' => bcrypt('cliente123'),
            'cedula' => '102548569',
            'address' => 'Calle 47 #10A',
            'phone' => '3014160258',    
            'role' => 'cliente',
        ]);

        User::factory()
        ->count(50)
        ->state(['role' => 'cliente'])
        ->create();
    }
}
