<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UpdateWalasWhatsAppSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Update nomor WhatsApp untuk user walas/homeroom_teacher
        // Contoh: Update user dengan role walas atau homeroom_teacher
        
        \App\Models\User::where('role', 'walas')
            ->orWhere('role', 'homeroom_teacher')
            ->update([
                'whatsapp_number' => '081234567890' // Ganti dengan nomor WhatsApp yang sesuai
            ]);
        
        $this->command->info('Nomor WhatsApp wali kelas berhasil diupdate!');
        $this->command->warn('PENTING: Silakan update nomor WhatsApp di database sesuai dengan nomor aktual wali kelas.');
    }
}
