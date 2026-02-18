# 📱 Setup Notifikasi WhatsApp Wali Kelas - Exit Permission

## 🎯 Cara Kerja

Ketika admin/guru mengisi **form izin keluar siswa** dan memilih kelas, sistem akan:

1. ✅ Menyimpan data izin keluar ke database
2. ✅ Mengambil nomor WhatsApp wali kelas dari kelas yang dipilih
3. ✅ Mengirim notifikasi WhatsApp otomatis ke wali kelas tersebut
4. ✅ Wali kelas menerima notifikasi berisi detail izin keluar siswa

### Contoh Alur:
```
Admin pilih kelas: "Grade 10 PPLG"
           ↓
Sistem cari wali kelas "Grade 10 PPLG"
           ↓
Kirim WA ke: Pak Budi Santoso (081234567890)
           ↓
Pak Budi terima notifikasi izin keluar siswa kelasnya
```

---

## 🔧 Langkah Setup

### 1. Konfigurasi API WhatsApp

Edit file `.env` dan tambahkan:

```env
WAPISENDER_API_KEY=your_api_key_here
WAPISENDER_DEVICE_KEY=your_device_key_here
WAPISENDER_BASE_URL=https://wapisender.id
```

> Dapatkan API Key dari dashboard WAPISender: https://wapisender.id

### 2. Jalankan Migration

Migration sudah dijalankan. Kolom yang ditambahkan:
- `classes.walas_name` - Nama wali kelas
- `classes.walas_whatsapp` - Nomor WhatsApp wali kelas
- `exit_permissions.whatsapp_sent` - Status pengiriman
- `exit_permissions.whatsapp_sent_at` - Waktu pengiriman
- `exit_permissions.whatsapp_recipient` - Nomor tujuan

### 3. Update Nomor WhatsApp Wali Kelas

**Cara 1: Via Seeder (Recommended untuk Testing)**

Edit file `database/seeders/UpdateClassWalasSeeder.php` dan sesuaikan data:

```php
$classWalasData = [
    'Grade 10 PPLG' => [
        'walas_name' => 'Pak Budi Santoso', 
        'walas_whatsapp' => '081234567890'
    ],
    'Grade 11 PPLG' => [
        'walas_name' => 'Bu Ani Rahmawati', 
        'walas_whatsapp' => '081234567891'
    ],
    // ... dst
];
```

Lalu jalankan:
```bash
php artisan db:seed --class=UpdateClassWalasSeeder
```

**Cara 2: Manual via Database**

```sql
UPDATE classes 
SET walas_name = 'Pak Budi Santoso', 
    walas_whatsapp = '081234567890' 
WHERE name = 'Grade 10 PPLG';
```

**Cara 3: Via Admin Panel** (jika sudah ada interface)

---

## 📊 Struktur Database

### Tabel `classes`
```
┌─────────────────┬──────────────────────┐
│ Kolom           │ Keterangan           │
├─────────────────┼──────────────────────┤
│ id              │ ID kelas             │
│ name            │ Nama kelas           │
│ grade           │ Tingkat (10/11/12)   │
│ major           │ Jurusan (PPLG/DKV)   │
│ walas_name      │ Nama wali kelas      │
│ walas_whatsapp  │ Nomor WA wali kelas  │
└─────────────────┴──────────────────────┘
```

### Tabel `exit_permissions`
```
┌────────────────────┬───────────────────────────┐
│ Kolom              │ Keterangan                │
├────────────────────┼───────────────────────────┤
│ student_id         │ ID siswa                  │
│ class_id           │ ID kelas                  │
│ whatsapp_sent      │ Status kirim (true/false) │
│ whatsapp_sent_at   │ Waktu pengiriman          │
│ whatsapp_recipient │ Nomor tujuan              │
└────────────────────┴───────────────────────────┘
```

---

## 📱 Format Pesan WhatsApp

Contoh pesan yang akan diterima wali kelas:

```
🔔 *NOTIFIKASI IZIN KELUAR SISWA*

Yth. Wali Kelas Grade 10 PPLG (Pak Budi Santoso),

Ada pengajuan izin keluar yang perlu persetujuan Anda:

─────────────────────
👤 *Nama Siswa:* Ahmad Fauzi
📌 *NIS:* 12345
🏫 *Kelas:* Grade 10 PPLG

📋 *Jenis Izin:* 🤒 Sakit
📅 *Tanggal:* 11 Februari 2026
⏰ *Waktu Keluar:* 10:00 WIB

📝 *Alasan:*
Sakit perut, perlu ke dokter

─────────────────────
✍️ *Diajukan oleh:* Guru Piket
🕐 *Waktu Pengajuan:* 11 Feb 2026, 09:45 WIB

⚠️ *Silakan login ke sistem untuk menyetujui/menolak permohonan ini.*

🏫 _Tim Administrasi Sekolah_
_Pesan otomatis dari Sistem Manajemen Sekolah_
```

---

## ✅ Testing

### 1. Cek Data Kelas
```bash
php artisan tinker
>>> DB::table('classes')->select('name', 'walas_name', 'walas_whatsapp')->get();
```

### 2. Test Notifikasi
1. Login sebagai admin/teacher
2. Buka form exit permission: `/exit-permissions/create`
3. Pilih siswa dan kelas
4. Isi form dan submit
5. Cek log: `storage/logs/laravel.log`
6. Verifikasi wali kelas menerima WhatsApp

### 3. Cek Status Pengiriman
```sql
SELECT 
    ep.id,
    s.name as siswa,
    c.name as kelas,
    c.walas_name,
    ep.whatsapp_sent,
    ep.whatsapp_sent_at,
    ep.whatsapp_recipient
FROM exit_permissions ep
JOIN students s ON ep.student_id = s.id
JOIN classes c ON ep.class_id = c.id
ORDER BY ep.created_at DESC
LIMIT 10;
```

---

## ⚠️ Troubleshooting

### Notifikasi Tidak Terkirim?

**1. Cek API Key**
```bash
php artisan tinker
>>> config('services.wapisender.api_key')
```

**2. Cek Nomor WhatsApp Wali Kelas**
```sql
SELECT name, walas_name, walas_whatsapp 
FROM classes 
WHERE walas_whatsapp IS NULL OR walas_whatsapp = '';
```

**3. Cek Log Error**
```bash
tail -f storage/logs/laravel.log
```

### Error: "Nomor WhatsApp wali kelas tidak tersedia"

✅ **Solusi:**
- Pastikan kolom `walas_whatsapp` di tabel `classes` sudah diisi
- Jalankan seeder: `php artisan db:seed --class=UpdateClassWalasSeeder`
- Atau update manual via SQL

### Error: "WAPISender API key tidak ditemukan"

✅ **Solusi:**
- Cek file `.env` sudah ada konfigurasi WAPISender
- Jalankan `php artisan config:clear`
- Restart server

---

## 📝 Format Nomor WhatsApp

Sistem akan otomatis convert nomor ke format internasional:

| Input         | Output       | Status |
|---------------|--------------|--------|
| 081234567890  | 6281234567890 | ✅ OK |
| 6281234567890 | 6281234567890 | ✅ OK |
| +6281234567890| 6281234567890 | ✅ OK |
| 8234567890    | 628234567890  | ✅ OK |

---

## 💡 Tips Production

1. **Update Data Real**: Ganti semua nomor test dengan nomor aktual wali kelas
2. **Test Dulu**: Gunakan nomor test sebelum production
3. **Monitor Log**: Pantau `storage/logs/laravel.log` untuk error
4. **Saldo WAPISender**: Pastikan saldo cukup untuk kirim pesan
5. **Rate Limit**: WAPISender punya rate limit, jangan spam

---

## 🚀 Next Steps (Opsional)

### 1. Buat Interface Admin untuk Manage Nomor WA
- Admin bisa update nomor WA wali kelas via web
- Tidak perlu edit database manual

### 2. Notifikasi ke Orang Tua Juga
- Kirim notifikasi ke orang tua siswa
- Tambah field `parent_whatsapp` di tabel `students`

### 3. Dashboard Monitoring
- Lihat history pengiriman WhatsApp
- Filter yang gagal/berhasil
- Retry yang gagal

---

## 📞 Support

Jika ada kendala:
- **Technical**: Cek log di `storage/logs/laravel.log`
- **WAPISender**: https://wapisender.id/support
- **Database**: Cek seeder di `database/seeders/UpdateClassWalasSeeder.php`

---

## 📄 File yang Dimodifikasi

**Created:**
- `database/migrations/*_add_walas_info_to_classes_table.php`
- `database/seeders/UpdateClassWalasSeeder.php`

**Modified:**
- `app/Services/WhatsAppService.php` - Logic notifikasi per kelas
- `app/Models/SchoolClass.php` - Tambah fillable walas_name & walas_whatsapp
- `app/Http/Controllers/ExitPermissionController.php` - Integrasi WhatsApp

---

**Status: ✅ READY TO USE**

Sistem sudah siap digunakan. Tinggal update nomor WhatsApp wali kelas dengan data real!
