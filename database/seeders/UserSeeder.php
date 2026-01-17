<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Admin user
        \App\Models\User::create([
            'name' => 'Admin User',
            'email' => 'admin@school.com',
            'password' => bcrypt('password'),
            'role' => 'admin',
            'assigned_class_id' => null,
        ]);

        // Teacher users
        \App\Models\User::create([
            'name' => 'Teacher John',
            'email' => 'teacher@school.com',
            'password' => bcrypt('password'),
            'role' => 'teacher',
            'assigned_class_id' => null,
        ]);

        // Homeroom teacher for Grade 10 PPLG
        \App\Models\User::create([
            'name' => 'Homeroom Teacher PPLG',
            'email' => 'homeroom.pplg@school.com',
            'password' => bcrypt('password'),
            'role' => 'homeroom_teacher',
            'assigned_class_id' => 1, // Grade 10 PPLG
        ]);

        // Homeroom teacher for Grade 10 DKV
        \App\Models\User::create([
            'name' => 'Homeroom Teacher DKV',
            'email' => 'homeroom.dkv@school.com',
            'password' => bcrypt('password'),
            'role' => 'homeroom_teacher',
            'assigned_class_id' => 4, // Grade 10 DKV
        ]);
    }
}
