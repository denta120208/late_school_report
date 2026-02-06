<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Exception;

class WhatsAppService
{
    protected $apiKey;
    protected $deviceKey;
    protected $baseUrl;

    public function __construct()
    {
        $this->apiKey = config('services.wapisender.api_key');
        $this->deviceKey = config('services.wapisender.device_key');
        $this->baseUrl = config('services.wapisender.base_url', 'https://wapisender.id');
    }

    /**
     * Kirim notifikasi WhatsApp ke orang tua siswa ketika telat
     */
    public function sendLateNotificationToParent($lateAttendance)
    {
        if (!$this->apiKey) {
            \Log::warning('WAPISender API key tidak ditemukan');
            return false;
        }

        $student = $lateAttendance->student;
        
        // Pastikan nomor orang tua tersedia
        if (!$student->parent_phone) {
            \Log::warning("Nomor orang tua tidak tersedia untuk siswa: {$student->name}");
            return false;
        }

        try {
            // Format nomor telepon (pastikan format 62xxx)
            $phoneNumber = $this->formatPhoneNumber($student->parent_phone);
            
            // Format pesan
            $message = $this->formatLateMessageForParent($lateAttendance);

            // Kirim pesan via WAPISender API v5
            $response = Http::timeout(30)
                ->asForm()
                ->post($this->baseUrl . '/api/v5/message/text', [
                    'api_key' => $this->apiKey,
                    'device_key' => $this->deviceKey,
                    'destination' => $phoneNumber,
                    'message' => $message,
                ]);

            if ($response->successful()) {
                \Log::info("WhatsApp berhasil dikirim ke orang tua {$student->name}: {$phoneNumber}");
                return true;
            } else {
                \Log::error('WAPISender error: ' . $response->body());
                return false;
            }

        } catch (Exception $e) {
            \Log::error('WhatsApp send error: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Kirim notifikasi WhatsApp ke banyak orang tua sekaligus (bulk)
     */
    public function sendBulkLateNotificationToParents($lateAttendances)
    {
        if (!$this->apiKey) {
            \Log::warning('WAPISender API key tidak ditemukan');
            return false;
        }

        $successCount = 0;
        $failedCount = 0;

        foreach ($lateAttendances as $lateAttendance) {
            $result = $this->sendLateNotificationToParent($lateAttendance);
            
            if ($result) {
                $successCount++;
            } else {
                $failedCount++;
            }

            // Delay sedikit untuk menghindari rate limit
            usleep(500000); // 0.5 detik
        }

        \Log::info("WhatsApp bulk send: {$successCount} berhasil, {$failedCount} gagal");

        return $successCount > 0;
    }

    /**
     * Format pesan WhatsApp untuk orang tua
     */
    private function formatLateMessageForParent($lateAttendance)
    {
        $student = $lateAttendance->student;
        $class = $lateAttendance->schoolClass;
        $reason = $lateAttendance->lateReason;
        $date = $lateAttendance->late_date->format('d F Y');
        $arrivalTime = date('H:i', strtotime($lateAttendance->arrival_time));

        // Hitung total keterlambatan bulan ini
        $totalLate = $student->getTotalLateCount();
        $status = $student->getLateStatus();

        $message = "🔔 *NOTIFIKASI KETERLAMBATAN SISWA*\n\n";
        $message .= "Yth. Orang Tua/Wali dari:\n";
        $message .= "👤 *Nama:* {$student->name}\n";
        $message .= "📌 *NIS:* {$student->student_number}\n";
        $message .= "🏫 *Kelas:* {$class->name}\n\n";
        
        $message .= "─────────────────────\n";
        $message .= "📅 *Tanggal:* {$date}\n";
        $message .= "⏰ *Jam Kedatangan:* {$arrivalTime} WIB\n";
        $message .= "📝 *Alasan:* {$reason->reason}\n";
        
        if ($lateAttendance->notes) {
            $message .= "💬 *Catatan:* {$lateAttendance->notes}\n";
        }
        
        $message .= "─────────────────────\n\n";
        
        // Tambahkan informasi total keterlambatan
        $message .= "📊 *Total Keterlambatan Bulan Ini:* {$totalLate}x\n\n";
        
        // Tambahkan peringatan jika perlu
        if ($status == 'parent_notification') {
            $message .= "⚠️ *PERHATIAN:*\n";
            $message .= "Siswa telah terlambat ≥5 kali bulan ini.\n";
            $message .= "Mohon perhatian khusus dari orang tua.\n\n";
        } elseif ($status == 'warning') {
            $message .= "⚠️ Siswa telah terlambat ≥3 kali bulan ini.\n\n";
        }
        
        $message .= "Terima kasih atas perhatian dan kerjasamanya.\n\n";
        $message .= "🏫 _Tim Piket Sekolah_\n";
        $message .= "_Pesan otomatis dari Sistem Absensi Sekolah_";

        return $message;
    }

    /**
     * Format nomor telepon ke format internasional (62xxx)
     */
    private function formatPhoneNumber($phone)
    {
        // Hapus karakter non-numeric
        $phone = preg_replace('/[^0-9]/', '', $phone);
        
        // Jika diawali 0, ganti dengan 62
        if (substr($phone, 0, 1) == '0') {
            $phone = '62' . substr($phone, 1);
        }
        
        // Jika tidak diawali 62, tambahkan 62
        if (substr($phone, 0, 2) != '62') {
            $phone = '62' . $phone;
        }
        
        return $phone;
    }

    /**
     * Test koneksi API WAPISender
     */
    public function testConnection()
    {
        try {
            if (!$this->apiKey) {
                return [
                    'success' => false,
                    'message' => 'API Key tidak ditemukan'
                ];
            }

            if (!$this->deviceKey) {
                return [
                    'success' => false,
                    'message' => 'Device Key tidak ditemukan. Silakan tambahkan WAPISENDER_DEVICE_KEY di .env'
                ];
            }

            $response = Http::timeout(10)
                ->asForm()
                ->post($this->baseUrl . '/api/v5/profile', [
                    'api_key' => $this->apiKey,
                ]);

            if ($response->successful()) {
                return [
                    'success' => true,
                    'message' => 'API WAPISender berhasil terhubung!',
                    'data' => $response->json()
                ];
            } else {
                return [
                    'success' => false,
                    'message' => 'API Key tidak valid atau terjadi kesalahan',
                    'error' => $response->body()
                ];
            }

        } catch (Exception $e) {
            return [
                'success' => false,
                'message' => $e->getMessage()
            ];
        }
    }
}
