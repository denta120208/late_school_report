<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ClassPasswordSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Add sample passwords to existing classes
        $classes = \App\Models\SchoolClass::all();
        
        foreach ($classes as $index => $class) {
            $class->update([
                'password' => 'class' . ($index + 1) . '2024' // e.g., class12024, class22024, etc.
            ]);
        }
    }
}
