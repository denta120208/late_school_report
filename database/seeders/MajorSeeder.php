<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MajorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $majors = [
            [
                'code' => 'PPLG',
                'name' => 'Pengembangan Perangkat Lunak dan Gim',
                'teacher_name' => 'Pak Budi Santoso', // Ganti dengan nama guru PPLG
                'whatsapp_number' => '081234567890', // Ganti dengan nomor WA guru PPLG
                'description' => 'Jurusan yang mempelajari pengembangan software dan game',
                'is_active' => true,
            ],
            [
                'code' => 'TKJ',
                'name' => 'Teknik Komputer dan Jaringan',
                'teacher_name' => 'Pak Ahmad Hidayat', // Ganti dengan nama guru TKJ
                'whatsapp_number' => '081234567891', // Ganti dengan nomor WA guru TKJ
                'description' => 'Jurusan yang mempelajari jaringan komputer dan infrastruktur IT',
                'is_active' => true,
            ],
            [
                'code' => 'DKV',
                'name' => 'Desain Komunikasi Visual',
                'teacher_name' => 'Bu Siti Nurhaliza', // Ganti dengan nama guru DKV
                'whatsapp_number' => '081234567892', // Ganti dengan nomor WA guru DKV
                'description' => 'Jurusan yang mempelajari desain grafis dan multimedia',
                'is_active' => true,
            ],
            [
                'code' => 'RPL',
                'name' => 'Rekayasa Perangkat Lunak',
                'teacher_name' => 'Pak Dedi Mulyadi', // Ganti dengan nama guru RPL
                'whatsapp_number' => '081234567893', // Ganti dengan nomor WA guru RPL
                'description' => 'Jurusan yang mempelajari rekayasa software',
                'is_active' => true,
            ],
            [
                'code' => 'MM',
                'name' => 'Multimedia',
                'teacher_name' => 'Bu Rina Wati', // Ganti dengan nama guru MM
                'whatsapp_number' => '081234567894', // Ganti dengan nomor WA guru MM
                'description' => 'Jurusan yang mempelajari multimedia dan broadcasting',
                'is_active' => true,
            ],
        ];

        foreach ($majors as $major) {
            \App\Models\Major::create($major);
        }

        $this->command->info('Data jurusan berhasil dibuat!');
        $this->command->warn('PENTING: Silakan update nama guru dan nomor WhatsApp sesuai dengan data aktual di sekolah Anda.');
    }
}
