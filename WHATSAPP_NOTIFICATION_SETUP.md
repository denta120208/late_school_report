# Setup Notifikasi WhatsApp untuk Exit Permission

## 📋 Deskripsi Fitur

Fitur ini akan mengirimkan notifikasi WhatsApp secara otomatis ke wali kelas ketika ada pengajuan izin keluar dari siswa di kelasnya.

## 🎯 Alur Kerja

1. Siswa mengisi form izin keluar (exit permission)
2. Sistem mencari wali kelas berdasarkan kelas siswa
3. Sistem mengirim notifikasi WhatsApp ke nomor wali kelas
4. Wali kelas menerima notifikasi berisi:
   - Nama siswa
   - Kelas
   - Jenis izin (Sakit/Pulang Lebih Awal/Izin Keluar)
   - Waktu keluar
   - Alasan izin
   - Link untuk approve/reject

## 🔧 Langkah-Langkah Setup

### 1. Konfigurasi API WhatsApp (WAPISender)

Edit file `.env` dan tambahkan konfigurasi berikut:

```env
WAPISENDER_API_KEY=your_api_key_here
WAPISENDER_DEVICE_KEY=your_device_key_here
WAPISENDER_BASE_URL=https://wapisender.id
```

> **Catatan:** Dapatkan API Key dan Device Key dari dashboard WAPISender Anda

### 2. Jalankan Migration

Migration sudah dijalankan otomatis yang menambahkan:
- Kolom `whatsapp_number` ke tabel `users`
- Kolom `whatsapp_sent`, `whatsapp_sent_at`, `whatsapp_recipient` ke tabel `exit_permissions`

### 3. Update Nomor WhatsApp Wali Kelas

Ada 2 cara untuk menambahkan nomor WhatsApp wali kelas:

#### Cara 1: Manual via Database/Admin Panel
Update langsung di tabel `users` untuk setiap wali kelas:
```sql
UPDATE users 
SET whatsapp_number = '081234567890' 
WHERE id = 1 AND role IN ('walas', 'homeroom_teacher');
```

#### Cara 2: Via Seeder (Development)
Jalankan seeder untuk update semua wali kelas:
```bash
php artisan db:seed --class=UpdateWalasWhatsAppSeeder
```

> **PENTING:** Nomor WhatsApp harus dalam format yang benar:
> - Format Indonesia: `081234567890` atau `6281234567890`
> - Sistem akan otomatis convert ke format internasional (62xxx)

### 4. Assign Wali Kelas ke Kelas

Pastikan setiap wali kelas sudah di-assign ke kelas yang sesuai:
```sql
UPDATE users 
SET assigned_class_id = 1 
WHERE id = 1 AND role IN ('walas', 'homeroom_teacher');
```

## 📱 Format Pesan WhatsApp

Contoh pesan yang akan dikirim ke wali kelas:

```
🔔 *NOTIFIKASI IZIN KELUAR SISWA*

Yth. Wali Kelas X RPL 1,

Ada pengajuan izin keluar yang perlu persetujuan Anda:

─────────────────────
👤 *Nama Siswa:* Ahmad Fauzi
📌 *NIS:* 12345
🏫 *Kelas:* X RPL 1

📋 *Jenis Izin:* 🤒 Sakit
📅 *Tanggal:* 11 Februari 2026
⏰ *Waktu Keluar:* 10:00 WIB

📝 *Alasan:*
Sakit perut, ingin pulang lebih awal

─────────────────────
✍️ *Diajukan oleh:* Guru Piket
🕐 *Waktu Pengajuan:* 11 Feb 2026, 09:45 WIB

⚠️ *Silakan login ke sistem untuk menyetujui/menolak permohonan ini.*

🏫 _Tim Administrasi Sekolah_
_Pesan otomatis dari Sistem Manajemen Sekolah_
```

## 🧪 Testing

### Test Koneksi API WhatsApp
Anda bisa membuat route test untuk memverifikasi koneksi:
```php
Route::get('/test-wa', function() {
    $service = new \App\Services\WhatsAppService();
    $result = $service->testConnection();
    return response()->json($result);
});
```

### Test Pengiriman Notifikasi
1. Login sebagai admin/teacher
2. Buat exit permission baru
3. Cek log di `storage/logs/laravel.log` untuk status pengiriman
4. Verifikasi wali kelas menerima WhatsApp

## 📊 Tracking Status Pengiriman

Setiap exit permission akan memiliki informasi tracking WhatsApp:
- `whatsapp_sent`: Boolean (true jika berhasil dikirim)
- `whatsapp_sent_at`: Timestamp kapan pesan dikirim
- `whatsapp_recipient`: Nomor WhatsApp tujuan

## ⚠️ Troubleshooting

### Notifikasi Tidak Terkirim?

1. **Cek API Key**
   ```bash
   php artisan tinker
   config('services.wapisender.api_key')
   ```

2. **Cek Nomor WhatsApp Wali Kelas**
   ```sql
   SELECT name, role, whatsapp_number, assigned_class_id 
   FROM users 
   WHERE role IN ('walas', 'homeroom_teacher');
   ```

3. **Cek Log Error**
   ```bash
   tail -f storage/logs/laravel.log
   ```

4. **Pastikan Wali Kelas Sudah Di-assign**
   - Setiap kelas harus punya wali kelas dengan `assigned_class_id`
   - Wali kelas harus punya nomor WhatsApp

### Error: "Nomor WhatsApp wali kelas tidak tersedia"
- Pastikan user dengan role `walas` atau `homeroom_teacher` sudah punya `whatsapp_number`
- Pastikan wali kelas sudah di-assign ke kelas (`assigned_class_id`)

### Error: "WAPISender API key tidak ditemukan"
- Pastikan file `.env` sudah dikonfigurasi dengan benar
- Jalankan `php artisan config:clear`

## 🔐 Keamanan

- API Key WAPISender disimpan di file `.env` (tidak di-commit ke Git)
- Nomor WhatsApp hanya bisa diakses oleh admin
- Log error tidak menampilkan informasi sensitif

## 📝 Catatan Penting

1. **Biaya**: Setiap pesan WhatsApp akan mengurangi saldo WAPISender Anda
2. **Rate Limit**: WAPISender memiliki rate limit, pastikan tidak spam
3. **Validasi Nomor**: Sistem otomatis memvalidasi dan format nomor WhatsApp
4. **Fallback**: Jika WhatsApp gagal, sistem tetap menyimpan exit permission
5. **Production**: Pastikan ganti nomor WhatsApp test dengan nomor aktual sebelum production

## 🚀 Fitur Tambahan (Opsional)

### 1. Notifikasi ke Orang Tua
Tambahkan nomor WhatsApp orang tua di tabel `students`:
```sql
ALTER TABLE students ADD COLUMN parent_whatsapp VARCHAR(20) AFTER parent_phone;
```

### 2. Notifikasi Multi-bahasa
Tambahkan support bahasa Indonesia dan Inggris

### 3. Template Pesan Custom
Admin bisa customize template pesan di admin panel

## 📞 Support

Jika ada kendala, hubungi:
- Technical Support: admin@sekolah.com
- WAPISender Support: https://wapisender.id/support
