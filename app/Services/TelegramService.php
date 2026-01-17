<?php

namespace App\Services;

use TelegramBot\Api\BotApi;
use TelegramBot\Api\Types\Inline\InlineKeyboardMarkup;
use Exception;

class TelegramService
{
    protected $telegram;
    protected $chatId;

    public function __construct()
    {
        $token = env('TELEGRAM_BOT_TOKEN');
        $this->chatId = env('TELEGRAM_CHAT_ID');
        
        if ($token) {
            $this->telegram = new BotApi($token);
        }
    }

    /**
     * Kirim notifikasi siswa telat ke Telegram
     */
    public function sendLateNotification($lateAttendance)
    {
        if (!$this->telegram || !$this->chatId) {
            return false;
        }

        try {
            $student = $lateAttendance->student;
            $class = $lateAttendance->schoolClass;
            $reason = $lateAttendance->lateReason;
            $recordedBy = $lateAttendance->recordedBy;

            // Format pesan
            $message = $this->formatLateMessage($lateAttendance);

            // Kirim pesan
            $this->telegram->sendMessage(
                $this->chatId,
                $message,
                'HTML'
            );

            return true;
        } catch (Exception $e) {
            \Log::error('Telegram send error: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Kirim batch notifikasi (banyak siswa sekaligus)
     */
    public function sendBatchNotification($lateAttendances)
    {
        if (!$this->telegram || !$this->chatId) {
            return false;
        }

        try {
            $message = $this->formatBatchMessage($lateAttendances);

            $this->telegram->sendMessage(
                $this->chatId,
                $message,
                'HTML'
            );

            return true;
        } catch (Exception $e) {
            \Log::error('Telegram batch send error: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Format pesan untuk 1 siswa
     */
    private function formatLateMessage($lateAttendance)
    {
        $student = $lateAttendance->student;
        $class = $lateAttendance->schoolClass;
        $reason = $lateAttendance->lateReason;
        $recordedBy = $lateAttendance->recordedBy;

        $totalLate = $student->getTotalLateCount();
        $status = $student->getLateStatus();

        $statusEmoji = '✅';
        $statusText = 'Normal';
        if ($status == 'parent_notification') {
            $statusEmoji = '🚨';
            $statusText = 'PERLU NOTIFIKASI ORANG TUA';
        } elseif ($status == 'warning') {
            $statusEmoji = '⚠️';
            $statusText = 'Peringatan';
        }

        $message = "🚨 <b>SISWA TERLAMBAT</b>\n\n";
        $message .= "👤 <b>Nama:</b> {$student->name}\n";
        $message .= "🆔 <b>NIS:</b> {$student->student_number}\n";
        $message .= "🏫 <b>Kelas:</b> {$class->name}\n\n";
        
        $message .= "📅 <b>Tanggal:</b> " . $lateAttendance->late_date->format('d F Y') . "\n";
        $message .= "⏰ <b>Jam Kedatangan:</b> " . date('H:i', strtotime($lateAttendance->arrival_time)) . " WIB\n";
        $message .= "📝 <b>Alasan:</b> {$reason->reason}\n";
        
        if ($lateAttendance->notes) {
            $message .= "💬 <b>Catatan:</b> {$lateAttendance->notes}\n";
        }
        
        $message .= "\n📊 <b>Total Telat Bulan Ini:</b> {$totalLate}x\n";
        $message .= "{$statusEmoji} <b>Status:</b> {$statusText}\n\n";
        
        $message .= "👨‍🏫 <i>Dicatat oleh: {$recordedBy->name}</i>\n";
        $message .= "━━━━━━━━━━━━━━━━━━━━━";

        return $message;
    }

    /**
     * Format pesan untuk banyak siswa (batch)
     */
    private function formatBatchMessage($lateAttendances)
    {
        $date = now()->format('l, d F Y');
        $count = count($lateAttendances);

        $message = "📋 <b>LAPORAN KETERLAMBATAN HARI INI</b>\n";
        $message .= "📅 {$date}\n";
        $message .= "👥 Total: {$count} siswa\n";
        $message .= "━━━━━━━━━━━━━━━━━━━━━\n\n";

        foreach ($lateAttendances as $index => $attendance) {
            $student = $attendance->student;
            $class = $attendance->schoolClass;
            $reason = $attendance->lateReason;
            $time = date('H:i', strtotime($attendance->arrival_time));

            $number = $index + 1;
            $message .= "<b>{$number}. {$student->name}</b>\n";
            $message .= "   🏫 {$class->name}\n";
            $message .= "   ⏰ {$time} WIB\n";
            $message .= "   📝 {$reason->reason}\n\n";
        }

        $message .= "━━━━━━━━━━━━━━━━━━━━━\n";
        $message .= "🤖 <i>Laporan otomatis dari Sistem Keterlambatan</i>";

        return $message;
    }

    /**
     * Test koneksi bot
     */
    public function testConnection()
    {
        try {
            if (!$this->telegram) {
                return ['success' => false, 'message' => 'Bot token tidak ditemukan'];
            }

            $me = $this->telegram->getMe();
            
            return [
                'success' => true,
                'message' => 'Bot berhasil terhubung!',
                'bot_name' => $me->getFirstName(),
                'bot_username' => $me->getUsername()
            ];
        } catch (Exception $e) {
            return [
                'success' => false,
                'message' => $e->getMessage()
            ];
        }
    }
}
