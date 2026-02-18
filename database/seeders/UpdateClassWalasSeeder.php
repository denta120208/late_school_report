<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UpdateClassWalasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Update nomor WhatsApp wali kelas untuk setiap kelas
        // Sesuaikan dengan data kelas yang ada di database Anda
        
        $classWalasData = [
            // Format: 'Nama Kelas' => ['walas_name' => 'Nama Wali Kelas', 'walas_whatsapp' => 'Nomor WA']
            // Sesuaikan dengan data kelas yang ada di database
            
            'Grade 10 PPLG' => ['walas_name' => 'Pak Budi Santoso', 'walas_whatsapp' => '081234567890'],
            'Grade 11 PPLG' => ['walas_name' => 'Bu Ani Rahmawati', 'walas_whatsapp' => '081234567891'],
            'Grade 12 PPLG' => ['walas_name' => 'Pak Joko Widodo', 'walas_whatsapp' => '081234567892'],
            'Grade 10 DKV' => ['walas_name' => 'Bu Siti Nurhaliza', 'walas_whatsapp' => '081234567893'],
            'Grade 11 DKV' => ['walas_name' => 'Pak Dedi Mulyadi', 'walas_whatsapp' => '081234567894'],
            'Grade 12 DKV' => ['walas_name' => 'Bu Rina Wati', 'walas_whatsapp' => '081234567895'],
            
            // Tambahkan kelas lainnya sesuai kebutuhan
        ];

        foreach ($classWalasData as $className => $data) {
            $class = \App\Models\SchoolClass::where('name', $className)->first();
            
            if ($class) {
                $class->update([
                    'walas_name' => $data['walas_name'],
                    'walas_whatsapp' => $data['walas_whatsapp'],
                ]);
                $this->command->info("✓ Updated: {$className} - {$data['walas_name']}");
            } else {
                $this->command->warn("✗ Class not found: {$className}");
            }
        }

        $this->command->info("\n📱 Nomor WhatsApp wali kelas berhasil diupdate!");
        $this->command->warn("\n⚠️  PENTING: Silakan sesuaikan nama kelas, nama wali kelas, dan nomor WhatsApp dengan data aktual sekolah Anda.");
        $this->command->warn("Edit file: database/seeders/UpdateClassWalasSeeder.php");
    }
}
