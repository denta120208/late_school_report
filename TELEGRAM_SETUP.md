# 🤖 Panduan Setup Telegram Bot

## Step 1: Buat Bot di Telegram (5 menit)

### A. Buat Bot Baru
1. Buka **Telegram** di HP/Desktop
2. Cari dan buka chat dengan **@BotFather**
3. Ketik: `/start`
4. Ketik: `/newbot`
5. Masukkan **nama bot**: `School Late System Bot` (atau nama lain)
6. Masukkan **username bot**: `schoollate_bot` atau `namaanda_bot` (harus diakhiri `_bot`)
7. **BotFather akan memberi TOKEN** seperti ini:
   ```
   1234567890:ABCdefGhIjKlmNoPqRsTuVwXyZ
   ```
8. **COPY dan SIMPAN TOKEN INI!** ⚠️ Jangan share ke orang lain!

---

## Step 2: Buat Grup dan Tambahkan Bot

### B. Setup Grup Telegram
1. **Buat Grup Baru** di Telegram
   - Nama grup: `Guru Piket - Laporan Keterlambatan` (atau nama lain)
   
2. **Tambahkan Bot ke Grup**
   - Klik nama grup → Add Members
   - Cari `@schoollate_bot` (username bot Anda)
   - Tambahkan bot ke grup

3. **Jadikan Bot sebagai Admin** (PENTING!)
   - Klik nama grup → Edit
   - Klik Administrators
   - Tambahkan bot sebagai admin
   - Centang: "Post Messages" dan "Delete Messages"

---

## Step 3: Dapatkan Chat ID Grup

### C. Ambil Chat ID
1. **Kirim pesan** di grup (contoh: "Test bot")

2. **Buka browser**, paste URL ini (ganti `YOUR_BOT_TOKEN`):
   ```
   https://api.telegram.org/botYOUR_BOT_TOKEN/getUpdates
   ```
   
   Contoh:
   ```
   https://api.telegram.org/bot1234567890:ABCdefGhIjKlmNoPqRsTuVwXyZ/getUpdates
   ```

3. Anda akan lihat JSON response. **Cari angka di bagian `"chat":{"id":-1234567890}`**
   
   Contoh response:
   ```json
   {
     "ok": true,
     "result": [{
       "message": {
         "chat": {
           "id": -1001234567890,  👈 INI CHAT ID NYA
           "title": "Guru Piket - Laporan Keterlambatan",
           "type": "supergroup"
         }
       }
     }]
   }
   ```

4. **COPY angka Chat ID** (termasuk tanda minus `-`)
   - Contoh: `-1001234567890`

---

## Step 4: Masukkan ke File .env

### D. Konfigurasi Laravel
1. Buka file **`.env`** di folder project Laravel
2. Scroll ke bawah, tambahkan ini:
   ```env
   # Telegram Bot Configuration
   TELEGRAM_BOT_TOKEN=1234567890:ABCdefGhIjKlmNoPqRsTuVwXyZ
   TELEGRAM_CHAT_ID=-1001234567890
   ```
   
3. **Ganti dengan Token dan Chat ID Anda!**

4. **Restart server** Laravel:
   ```bash
   # Stop server (Ctrl + C)
   php artisan config:clear
   php artisan serve
   ```

---

## Step 5: Test Koneksi

### E. Cek Apakah Berhasil
1. Login ke sistem sebagai **admin** atau **guru**
2. Klik menu **"Telegram"** di navbar
3. Scroll ke bawah
4. Klik tombol **"Test Koneksi Bot"** (jika ada)
5. Atau langsung centang siswa dan klik **"Kirim ke Telegram"**

Jika berhasil:
- ✅ Muncul notif hijau "Notifikasi berhasil dikirim!"
- ✅ Pesan muncul di grup Telegram

Jika gagal:
- ❌ Cek Token dan Chat ID sudah benar?
- ❌ Bot sudah jadi admin grup?
- ❌ Sudah restart server Laravel?

---

## 📝 Contoh Pesan yang Akan Dikirim

Ketika Anda kirim 3 siswa yang telat, pesan di grup akan seperti ini:

```
📋 LAPORAN KETERLAMBATAN HARI INI
📅 Senin, 16 Januari 2026
👥 Total: 3 siswa
━━━━━━━━━━━━━━━━━━━━━

1. Ahmad Rizki
   🏫 Grade 10 PPLG
   ⏰ 08:30 WIB
   📝 Bangun kesiangan

2. Siti Nurhaliza
   🏫 Grade 10 PPLG
   ⏰ 08:45 WIB
   📝 Masalah transportasi

3. Budi Santoso
   🏫 Grade 11 DKV
   ⏰ 09:00 WIB
   📝 Hujan deras

━━━━━━━━━━━━━━━━━━━━━
🤖 Laporan otomatis dari Sistem Keterlambatan
```

---

## ⚠️ Troubleshooting

### Bot tidak bisa kirim pesan?
1. ✅ Bot sudah di-add ke grup?
2. ✅ Bot sudah jadi admin grup?
3. ✅ Token di `.env` sudah benar?
4. ✅ Chat ID pakai tanda minus `-` ?
5. ✅ Sudah `php artisan config:clear`?

### Chat ID tidak muncul di getUpdates?
- Pastikan sudah kirim pesan di grup SETELAH bot ditambahkan
- Coba kirim pesan baru lagi
- Refresh browser dan coba lagi URL getUpdates

### Error "Unauthorized"?
- Token salah atau expired
- Buat bot baru di @BotFather

---

## 🎉 Selesai!

Setelah setup selesai, setiap kali ada siswa telat:
1. Guru catat di sistem
2. Buka menu **"Telegram"**
3. Centang siswa yang mau dikirim
4. Klik **"Kirim ke Telegram"**
5. Notifikasi langsung masuk ke grup! 🚀

---

**Need help?** Hubungi developer atau cek log error di `storage/logs/laravel.log`
