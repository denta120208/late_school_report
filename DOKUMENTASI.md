# DOKUMENTASI SISTEM ABSENSI DAN PERIZINAN SISWA

## 📋 Daftar Isi
1. [Ringkasan Sistem](#ringkasan-sistem)
2. [Arsitektur Sistem](#arsitektur-sistem)
3. [Fitur-Fitur Utama](#fitur-fitur-utama)
4. [API dan Integrasi](#api-dan-integrasi)
5. [Controller dan Fungsi-Fungsinya](#controller-dan-fungsi-fungsinya)
6. [Service Layer](#service-layer)
7. [Model dan Database](#model-dan-database)
8. [Alur Kerja Sistem](#alur-kerja-sistem)

---

## 🎯 Ringkasan Sistem

Sistem Absensi dan Perizinan Siswa adalah aplikasi web berbasis Laravel yang dirancang untuk:
- Mencatat keterlambatan siswa secara digital
- Mengelola izin keluar siswa (sakit, izin pulang cepat, izin keluar)
- Mencatat ketidakhadiran siswa (Sakit/Izin/Alpha)
- Mengirim notifikasi otomatis ke orang tua melalui **Telegram** dan **WhatsApp**
- Menghasilkan laporan harian dalam format PDF

### Teknologi yang Digunakan
- **Backend**: Laravel 11
- **Database**: MySQL
- **Frontend**: Blade Templates + Tailwind CSS
- **API Eksternal**: 
  - Telegram Bot API (notifikasi ke grup)
  - WAPISender API (notifikasi WhatsApp ke orang tua)

---

## 🏗️ Arsitektur Sistem

### Role-Based Access Control (RBAC)
Sistem memiliki 4 jenis pengguna:

1. **Admin** - Akses penuh ke semua fitur
2. **Teacher (Guru)** - Dapat mencatat keterlambatan, mengelola izin
3. **Homeroom Teacher (Wali Kelas)** - Approve izin keluar untuk kelas yang diampu
4. **Shared Walas Account** - Akun khusus wali kelas dengan password per kelas

### Layer Arsitektur

```
┌─────────────────────────────────────────┐
│         Presentation Layer              │
│    (Blade Views + Controllers)          │
├─────────────────────────────────────────┤
│         Service Layer                   │
│  (TelegramService, WhatsAppService)     │
├─────────────────────────────────────────┤
│         Model Layer                     │
│    (Eloquent ORM + Relationships)       │
├─────────────────────────────────────────┤
│         Database Layer                  │
│         (MySQL Database)                │
└─────────────────────────────────────────┘
         ↓              ↓
   Telegram API    WhatsApp API
```

---

## 🚀 Fitur-Fitur Utama

### 1. **Fitur Keterlambatan (Late Attendance)**

#### Pencatatan Keterlambatan
- **Single Student**: Catat keterlambatan 1 siswa
- **Multi Student**: Catat banyak siswa dengan data individual
- **Bulk Entry**: Pilih siswa dari daftar kelas dan input langsung

#### Notifikasi Otomatis
Setiap keterlambatan yang dicatat akan:
1. ✅ Tersimpan di database
2. 📱 Kirim notifikasi ke **Telegram** (grup guru)
3. 📲 Kirim notifikasi ke **WhatsApp** (nomor orang tua siswa)

#### Fitur Tambahan
- Filter berdasarkan kelas, tanggal, status
- Tracking status: pending, approved, rejected
- Hitung total keterlambatan per siswa per bulan
- Sistem peringatan otomatis (≥3x warning, ≥5x notif ortu)

---

### 2. **Fitur Izin Keluar (Exit Permission)**

#### Jenis Izin
- **Sakit** (sick)
- **Izin Pulang Cepat** (leave_early)
- **Izin Keluar** (permission_out) - harus kembali

#### Approval Workflow (2 Tahap)
```
Submission → Walas Approval → Admin Approval → Approved/Rejected
```

1. **Tahap 1**: Wali Kelas approve/reject
2. **Tahap 2**: Admin/Teacher approve/reject (hanya jika Walas approve)

#### Fitur Password per Kelas
- Shared Walas account menggunakan password unik per kelas
- Wali kelas input password kelas untuk approve izin
- Keamanan tambahan untuk data sensitif

---

### 3. **Fitur Ketidakhadiran Siswa (Student Absence)**

#### Tipe Ketidakhadiran
- **S** - Sakit (Badge biru)
- **I** - Izin (Badge kuning)
- **A** - Alpha/tanpa keterangan (Badge merah)
- **T** - Tefa/Teaching Factory (Badge ungu) ✨ *NEW*
- **D** - Dispen/Dispensasi (Badge hijau) ✨ *NEW*

#### Input Ketidakhadiran
- Input per kelas secara massal
- Pilih tanggal dan kelas
- Centang siswa yang tidak hadir dengan statusnya (S/I/A/T/D)
- Data tersimpan dan ditampilkan di laporan harian
- Setiap status memiliki warna badge yang berbeda untuk kemudahan identifikasi

---

### 4. **Laporan Multi-Range (Harian/Bulanan/Tahunan)** ✨ *NEW*

#### Tipe Laporan
Sistem mendukung 3 jenis laporan dengan filter tanggal yang berbeda:

1. **Laporan Harian**
   - Filter: Pilih tanggal spesifik
   - Tampilkan data keterlambatan dan ketidakhadiran untuk 1 hari
   - Export PDF: `laporan-daily-YYYY-MM-DD.pdf`

2. **Laporan Bulanan** ✨ *NEW*
   - Filter: Pilih bulan dan tahun
   - Tampilkan semua data dalam 1 bulan
   - Export PDF: `laporan-monthly-YYYY-MM.pdf`

3. **Laporan Tahunan** ✨ *NEW*
   - Filter: Pilih tahun
   - Tampilkan semua data dalam 1 tahun
   - Export PDF: `laporan-yearly-YYYY.pdf`

#### Konten Laporan
- Daftar siswa terlambat dengan detail waktu dan alasan
- Daftar siswa tidak hadir (S/I/A/T/D) per kelas ✨ *Updated*
- Daftar guru yang tidak hadir
- Statistik dan insights
- Nama guru piket yang mencatat

#### Fitur Dinamis
- **Form berubah otomatis** sesuai tipe laporan yang dipilih
- **Tipe Harian**: Tampilkan date picker
- **Tipe Bulanan**: Tampilkan dropdown bulan + tahun
- **Tipe Tahunan**: Tampilkan dropdown tahun
- Filter tambahan: kelas, status, pencarian nama siswa

#### Export PDF
- Download laporan dalam format PDF sesuai range yang dipilih
- Judul PDF otomatis sesuai tipe (Laporan Harian/Bulanan/Tahunan)
- Filename dinamis sesuai tipe dan periode
- Professional layout dengan logo sekolah
- Siap untuk dokumentasi dan arsip

---

## 📊 Ringkasan Fitur dan Fungsi

Tabel berikut merangkum semua fitur utama dan fungsi-fungsi yang menjalankannya:

| **Fitur** | **Controller** | **Fungsi Utama** | **Notifikasi** |
|-----------|---------------|------------------|----------------|
| **Dashboard** | DashboardController | `index()` | - |
| **Daftar Kelas** | ClassController | `index()`, `show()` | - |
| **Profil Siswa** | StudentController | `show()` | - |
| **Input Keterlambatan Single** | LateAttendanceController | `create()`, `store()` | ✅ Telegram + WhatsApp |
| **Input Keterlambatan Multi** | LateAttendanceController | `multiCreate()`, `multiStore()` | ✅ Telegram + WhatsApp |
| **Input Keterlambatan Bulk** | LateAttendanceController | `bulkReview()`, `bulkStore()` | ✅ Telegram + WhatsApp |
| **Daftar Keterlambatan** | LateAttendanceController | `index()` | - |
| **Laporan Multi-Range** ✨ | LateAttendanceController | `dailyReport()` | - |
| **Export PDF Multi-Range** ✨ | LateAttendanceController | `exportPDF()` | - |
| **Update Status Keterlambatan** | LateAttendanceController | `updateStatus()` | - |
| **Daftar Izin Keluar** | ExitPermissionController | `index()`, `classList()` | - |
| **Buat Izin Keluar** | ExitPermissionController | `create()`, `store()` | - |
| **Detail Izin Keluar** | ExitPermissionController | `show()` | - |
| **Approval Wali Kelas** | ExitPermissionController | `walasApprove()` | - |
| **Approval Admin** | ExitPermissionController | `adminApprove()` | - |
| **Dashboard Wali Kelas** | WalasController | `dashboard()`, `showPasswordForm()` | - |
| **Verifikasi Password Kelas** | WalasController | `verifyPasswordAndShowRequests()` | - |
| **Input Ketidakhadiran Siswa** | StudentAbsenceController | `create()`, `store()` | - |
| **Manajemen Kelas** | Admin\ClassManagementController | CRUD functions | - |
| **Manajemen Siswa** | Admin\StudentManagementController | CRUD functions | - |
| **Manajemen Profil** | ProfileController | `edit()`, `update()`, `destroy()` | - |

### 🔔 Fitur Notifikasi Otomatis

Notifikasi otomatis **Telegram** dan **WhatsApp** dikirim pada fitur berikut:

1. **Input Keterlambatan Single** (`LateAttendanceController@store`)
   - Telegram → Grup guru
   - WhatsApp → Nomor orang tua siswa

2. **Input Keterlambatan Multi** (`LateAttendanceController@multiStore`)
   - Telegram → Grup guru (bulk individual)
   - WhatsApp → Semua nomor orang tua siswa yang terlambat

3. **Input Keterlambatan Bulk** (`LateAttendanceController@bulkStore`)
   - Telegram → Grup guru (bulk individual)
   - WhatsApp → Semua nomor orang tua siswa yang terlambat

**Catatan**: API Telegram dan WhatsApp sudah ada dan tidak perlu diubah.

---

## 🔄 Alur Kerja Sistem (Workflow)

### 1️⃣ Alur Input Keterlambatan Single

```
User → Klik siswa di halaman kelas (classes.show)
  ↓
LateAttendanceController@create → Tampilkan form
  ↓
User → Input data (tanggal, waktu, alasan, catatan)
  ↓
LateAttendanceController@store
  ├─ Validasi data
  ├─ Simpan ke database (transaction)
  ├─ TelegramService@sendSingleLateNotification
  ├─ WhatsAppService@sendLateNotificationToParent
  └─ Update status notifikasi (telegram_sent, whatsapp_sent)
  ↓
Redirect → classes.show dengan pesan sukses
```

### 2️⃣ Alur Input Keterlambatan Multi

```
User → Akses /late-attendance/multi-create
  ↓
LateAttendanceController@multiCreate → Tampilkan daftar siswa
  ↓
User → Centang beberapa siswa + input data individual
  ↓
LateAttendanceController@multiStore
  ├─ Validasi array data siswa
  ├─ Loop dan simpan semua records (transaction)
  ├─ TelegramService@sendBulkIndividualLateNotification
  ├─ WhatsAppService@sendBulkLateNotificationToParents
  └─ Update status notifikasi untuk semua records
  ↓
Redirect → late-attendance.index dengan pesan sukses
```

### 3️⃣ Alur Input Keterlambatan Bulk (dari Kelas)

```
User → Di halaman kelas (classes.show)
  ↓
User → Centang beberapa siswa → Submit form
  ↓
LateAttendanceController@bulkReview
  ├─ Terima student_ids
  ├─ Load data siswa
  └─ Tampilkan form review untuk input data tiap siswa
  ↓
User → Input data untuk setiap siswa
  ↓
LateAttendanceController@bulkStore
  ├─ Validasi array data
  ├─ Simpan semua records (transaction)
  ├─ Kirim notifikasi Telegram
  ├─ Kirim notifikasi WhatsApp
  └─ Update status
  ↓
Redirect → classes.index dengan pesan sukses
```

### 4️⃣ Alur Approval Izin Keluar (2 Tahap)

```
User (Guru Piket) → Buat izin keluar
  ↓
ExitPermissionController@create → Form input
  ↓
User → Input data siswa, tipe izin, waktu, alasan
  ↓
ExitPermissionController@store
  ├─ Validasi (conditional: time_in wajib untuk permission_out)
  ├─ Simpan dengan status: walas_status=pending, admin_status=pending
  └─ status keseluruhan = 'pending'
  ↓
Notifikasi → Wali Kelas dapat pending request

--- TAHAP 1: Approval Wali Kelas ---

Wali Kelas → Login dan lihat dashboard
  ↓
WalasController@dashboard → Lihat kelas dengan pending
  ↓
Wali Kelas → Pilih kelas → Input password kelas
  ↓
WalasController@verifyPasswordAndShowRequests
  ├─ Cek password kelas
  └─ Tampilkan pending requests jika password benar
  ↓
Wali Kelas → Approve/Reject dengan catatan
  ↓
ExitPermissionController@walasApprove
  ├─ Update walas_status (approved/rejected)
  ├─ Update walas_approved_by, walas_approved_at
  └─ Call updateOverallStatus()
  ↓
Jika APPROVED → Lanjut ke Tahap 2
Jika REJECTED → Status keseluruhan = 'rejected' (STOP)

--- TAHAP 2: Approval Admin ---

Admin/Teacher → Lihat pending yang sudah walas approve
  ↓
ExitPermissionController@adminApprove
  ├─ Cek: walas_status harus 'approved' dulu
  ├─ Update admin_status (approved/rejected)
  ├─ Update admin_approved_by, admin_approved_at
  └─ Call updateOverallStatus()
  ↓
Status Akhir:
  - Jika kedua approved → status = 'approved'
  - Jika salah satu rejected → status = 'rejected'
```

### 5️⃣ Alur Input Ketidakhadiran Siswa (S/I/A/T/D) ✨ *Updated*

```
User (Admin/Teacher) → Akses /student-absences/input
  ↓
StudentAbsenceController@create
  ├─ Pilih tanggal, grade, major
  └─ Load siswa dari kelas terpilih
  ↓
User → Centang status (S/I/A/T/D) untuk setiap siswa ✨
  ├─ S (Sakit) - Badge biru
  ├─ I (Izin) - Badge kuning
  ├─ A (Alpa) - Badge merah
  ├─ T (Tefa) - Badge ungu ✨ NEW
  └─ D (Dispen) - Badge hijau ✨ NEW
  ↓
StudentAbsenceController@store
  ├─ Validasi data (in:S,I,A,T,D) ✨
  ├─ Delete existing records untuk tanggal ini (transaction)
  ├─ Insert new records untuk siswa yang dipilih
  └─ Commit transaction
  ↓
Data tersimpan dan muncul di Laporan (Harian/Bulanan/Tahunan)
```

### 6️⃣ Alur Laporan Multi-Range (Harian/Bulanan/Tahunan) ✨ *Updated*

```
User → Akses /late-attendance/report
  ↓
User → Pilih Tipe Laporan ✨
  ├─ Harian → Form tampilkan Date Picker
  ├─ Bulanan → Form tampilkan Month + Year Selector
  └─ Tahunan → Form tampilkan Year Selector
  ↓
LateAttendanceController@dailyReport
  ├─ Deteksi tipe laporan (daily/monthly/yearly) ✨
  ├─ Apply filter tanggal sesuai tipe:
  │  ├─ Daily: byDate($date)
  │  ├─ Monthly: whereMonth() + whereYear() ✨
  │  └─ Yearly: whereYear() ✨
  ├─ Get data keterlambatan
  ├─ Get data ketidakhadiran siswa (S/I/A/T/D) ✨
  ├─ Get data guru absent
  ├─ Hitung statistik (total, per kelas, time range, excused)
  ├─ Identifikasi guru piket (dari recordedBy)
  └─ Get monthly insights
  ↓
Tampilkan laporan lengkap dengan:
  - Dropdown tipe laporan dengan 3 tombol (Harian/Bulanan/Tahunan) ✨
  - Form filter dinamis sesuai tipe yang dipilih ✨
  - Tabel siswa terlambat (groupable by class)
  - Tabel ketidakhadiran (S/I/A/T/D) per kelas ✨
  - Tabel guru absent
  - Card statistik
  - Nama guru piket
  - Judul periode dinamis (contoh: "8 Februari 2026" / "Februari 2026" / "Tahun 2026") ✨
  ↓
User → Klik Export PDF
  ↓
LateAttendanceController@exportPDF
  ├─ Deteksi tipe laporan dari request ✨
  ├─ Apply filter yang sama dengan dailyReport ✨
  ├─ Generate period label dinamis ✨
  ├─ Generate filename dinamis: ✨
  │  ├─ laporan-daily-2026-02-08.pdf
  │  ├─ laporan-monthly-2026-02.pdf
  │  └─ laporan-yearly-2026.pdf
  ├─ Generate PDF dengan DomPDF
  │  └─ Judul: "LAPORAN HARIAN/BULANAN/TAHUNAN" ✨
  └─ Download file PDF
```

---

## 📝 Kesimpulan

### Pemetaan Fitur ke Fungsi (Feature to Function Mapping)

Dokumentasi ini telah menjelaskan secara lengkap:

✅ **Controller dan Fungsi**
- DashboardController - Statistik dan dashboard
- ClassController - Manajemen kelas
- StudentController - Profil siswa
- **LateAttendanceController** - Fitur utama keterlambatan (10 fungsi)
- ExitPermissionController - Manajemen izin keluar (9 fungsi)
- WalasController - Dashboard wali kelas dengan password
- StudentAbsenceController - Input ketidakhadiran S/I/A
- Admin Controllers - CRUD untuk kelas, siswa, users, late reasons
- ProfileController - Manajemen profil user

✅ **Service Layer**
- **TelegramService** - Notifikasi ke grup Telegram (4 fungsi)
- **WhatsAppService** - Notifikasi ke orang tua via WhatsApp (4 fungsi)

✅ **Workflow/Alur Kerja**
- Input keterlambatan (3 cara: single, multi, bulk)
- Approval izin keluar (2 tahap: walas → admin)
- Input ketidakhadiran siswa
- Laporan harian + export PDF

### Fitur dengan Notifikasi Otomatis

Hanya **3 fungsi** yang mengirim notifikasi otomatis:
1. `LateAttendanceController@store` - Single input
2. `LateAttendanceController@multiStore` - Multi input
3. `LateAttendanceController@bulkStore` - Bulk input

Semua menggunakan:
- `TelegramService` untuk notifikasi ke grup guru
- `WhatsAppService` untuk notifikasi ke nomor orang tua

**API Telegram dan WhatsApp sudah ada dan tidak perlu diubah.**

### Database Tables Utama

- `users` - Data pengguna (admin, teacher, homeroom_teacher)
- `classes` - Data kelas dengan password
- `students` - Data siswa dengan parent_phone
- `late_attendances` - Record keterlambatan + status notifikasi (telegram_sent, whatsapp_sent)
- `exit_permissions` - Izin keluar dengan 2 tahap approval
- `student_absences` - Ketidakhadiran S/I/A
- `teacher_absences` - Guru yang tidak hadir
- `late_reasons` - Master alasan terlambat

---

## 📖 Controller dan Fungsi-Fungsinya

### 1. **DashboardController**

**File**: `app/Http/Controllers/DashboardController.php`

#### `index()`
**Route**: `GET /dashboard`  
**Fitur**: Dashboard utama dengan statistik  
**Fungsi**: Menampilkan statistik berdasarkan role user

**Kode yang bekerja**:
```php
// Untuk Admin/Teacher - statistik semua kelas
$stats = [
    'total_late_today' => LateAttendance::whereDate('late_date', today())->count(),
    'total_late_this_month' => LateAttendance::whereMonth('late_date', now()->month)->count(),
    'pending_count' => ExitPermission::pending()->count(),
    'top_late_students' => Student::withCount('lateAttendances')->orderBy('late_attendances_count', 'desc')->take(5)->get(),
    'classes_with_most_late' => SchoolClass::withCount('lateAttendances')->orderBy('late_attendances_count', 'desc')->take(5)->get(),
];

// Untuk Homeroom Teacher - hanya kelas yang diampu
$stats = [
    'total_late_today' => LateAttendance::where('class_id', $user->assigned_class_id)->whereDate('late_date', today())->count(),
    // ... filter berdasarkan assigned_class_id
];
```

**Output**: View `dashboard.blade.php` dengan variabel `$stats`

---

### 2. **ClassController**

**File**: `app/Http/Controllers/ClassController.php`

#### `index()`
**Route**: `GET /classes`  
**Fitur**: Daftar semua kelas  
**Fungsi**: Menampilkan daftar kelas berdasarkan role

**Kode yang bekerja**:
```php
if ($user->isHomeroomTeacher()) {
    // Wali kelas hanya lihat kelas mereka
    $classes = SchoolClass::where('id', $user->assigned_class_id)->active()->get();
} else {
    // Admin/Teacher lihat semua
    $classes = SchoolClass::active()->get();
}
```

#### `show($id)`
**Route**: `GET /classes/{id}`  
**Fitur**: Detail kelas dengan daftar siswa  
**Fungsi**: Menampilkan detail kelas dan daftar siswa aktif

**Kode yang bekerja**:
```php
$class = SchoolClass::with(['students' => function($query) {
    $query->active()->orderBy('name');
}])->findOrFail($id);

// Cek akses wali kelas
if (auth()->user()->isHomeroomTeacher() && auth()->user()->assigned_class_id != $id) {
    abort(403);
}
```

**Output**: View `classes.show` dengan daftar siswa untuk input keterlambatan

---

### 3. **StudentController**

**File**: `app/Http/Controllers/StudentController.php`

#### `show($id)`
**Route**: `GET /students/{id}`  
**Fitur**: Profil siswa dengan riwayat keterlambatan  
**Fungsi**: Menampilkan detail siswa dan history keterlambatan

**Kode yang bekerja**:
```php
$student = Student::with(['schoolClass', 'lateAttendances' => function($query) {
    $query->with(['lateReason', 'recordedBy'])->orderBy('late_date', 'desc');
}])->findOrFail($id);

$totalLateCount = $student->getTotalLateCount();
$lateStatus = $student->getLateStatus(); // normal/warning/danger
```

**Output**: View `students.show` dengan riwayat lengkap

---

### 4. **LateAttendanceController** ⭐ (Controller Utama)

**File**: `app/Http/Controllers/LateAttendanceController.php`

#### `create($studentId)`
**Route**: `GET /late-attendance/create/{studentId}`  
**Fitur**: Form input keterlambatan single siswa  
**Fungsi**: Menampilkan form untuk mencatat keterlambatan 1 siswa

**Kode yang bekerja**:
```php
$student = Student::with('schoolClass')->findOrFail($studentId);

// Cek akses wali kelas
if (auth()->user()->isHomeroomTeacher() && auth()->user()->assigned_class_id != $student->class_id) {
    abort(403);
}

$lateReasons = LateReason::active()->get();
```

**Output**: View `late-attendance.create`

#### `store(Request $request)`
**Route**: `POST /late-attendance`  
**Fitur**: Simpan keterlambatan single siswa + kirim notifikasi  
**Fungsi**: Menyimpan data keterlambatan dan mengirim notifikasi Telegram & WhatsApp

**Kode yang bekerja**:
```php
// 1. Validasi data
$validated = $request->validate([
    'student_id' => 'required|exists:students,id',
    'class_id' => 'required|exists:classes,id',
    'late_reason_id' => 'required|exists:late_reasons,id',
    'late_date' => 'required|date',
    'arrival_time' => 'required',
    'notes' => 'nullable|string',
]);

// 2. Simpan ke database dengan transaction
DB::beginTransaction();
$record = LateAttendance::create($validated);
DB::commit();

// 3. Kirim notifikasi Telegram otomatis
$telegramService = new TelegramService();
$telegramSent = $telegramService->sendSingleLateNotification($recordWithRelations);
if ($telegramSent) {
    $record->update(['telegram_sent' => true, 'telegram_sent_at' => now()]);
}

// 4. Kirim notifikasi WhatsApp ke orang tua otomatis
$whatsappService = new WhatsAppService();
$whatsappSent = $whatsappService->sendLateNotificationToParent($recordWithRelations);
if ($whatsappSent) {
    $record->update(['whatsapp_sent' => true, 'whatsapp_sent_at' => now()]);
}
```

**Output**: Redirect ke `classes.show` dengan pesan sukses

#### `multiCreate()`
**Route**: `GET /late-attendance/multi-create`  
**Fitur**: Form input keterlambatan multi siswa dengan pilihan dinamis  
**Fungsi**: Pilih beberapa siswa dan input data individual untuk masing-masing

**Kode yang bekerja**:
```php
$studentsQuery = Student::with('schoolClass')->where('is_active', true);

// Filter untuk wali kelas
if (auth()->user()->isHomeroomTeacher()) {
    $studentsQuery->where('class_id', auth()->user()->assigned_class_id);
}

$students = $studentsQuery->orderBy('name')->get();
$lateReasons = LateReason::active()->get();
```

**Output**: View `late-attendance.multi-create` dengan pilihan checkbox siswa

#### `multiStore(Request $request)`
**Route**: `POST /late-attendance/multi-store`  
**Fitur**: Simpan keterlambatan multi siswa + kirim notifikasi  
**Fungsi**: Simpan banyak siswa sekaligus dengan data individual masing-masing

**Kode yang bekerja**:
```php
// 1. Validasi array siswa dengan data individual
$validated = $request->validate([
    'students' => 'required|array|min:1',
    'students.*.student_id' => 'required|exists:students,id',
    'students.*.late_date' => 'required|date',
    'students.*.arrival_time' => 'required',
    'students.*.late_reason_id' => 'required|exists:late_reasons,id',
    'students.*.notes' => 'nullable|string',
]);

// 2. Simpan semua record dalam transaction
DB::beginTransaction();
foreach ($validated['students'] as $studentData) {
    $record = LateAttendance::create([...]);
    $createdRecords[] = $record;
}
DB::commit();

// 3. Kirim notifikasi Telegram untuk semua siswa
$telegramService->sendBulkIndividualLateNotification($recordsWithRelations);

// 4. Kirim notifikasi WhatsApp ke semua orang tua
$whatsappService->sendBulkLateNotificationToParents($recordsWithRelations);
```

**Output**: Redirect ke `late-attendance.index` dengan pesan sukses

#### `bulkReview(Request $request)`
**Route**: `POST /late-attendance/bulk-review`  
**Fitur**: Review halaman untuk bulk input dari kelas  
**Fungsi**: Menampilkan form review setelah pilih siswa dari halaman kelas

**Kode yang bekerja**:
```php
// 1. Terima student_ids dari form sebelumnya
$validated = $request->validate([
    'student_ids' => 'required|array|min:1',
    'existing_form_data' => 'nullable|json', // support tambah siswa
]);

// 2. Merge existing + new student IDs
$allStudentIds = array_unique(array_merge($existingStudentIds, $validated['student_ids']));

// 3. Load students dengan kelas
$students = Student::whereIn('id', $allStudentIds)->with('schoolClass')->get();
$classes = $students->pluck('schoolClass')->unique('id');
$lateReasons = LateReason::active()->get();
```

**Output**: View `late-attendance.bulk-review` untuk input data setiap siswa

#### `bulkStore(Request $request)`
**Route**: `POST /late-attendance/bulk-store`  
**Fitur**: Simpan bulk keterlambatan dari review page  
**Fungsi**: Sama seperti multiStore tapi dari flow berbeda

**Kode yang bekerja**: Sama seperti `multiStore()` - simpan banyak record + kirim notifikasi

#### `index(Request $request)`
**Route**: `GET /late-attendance`  
**Fitur**: Daftar semua keterlambatan dengan filter  
**Fungsi**: Menampilkan history keterlambatan dengan pencarian dan filter

**Kode yang bekerja**:
```php
$query = LateAttendance::with(['student', 'schoolClass', 'lateReason', 'recordedBy']);

// Filter berdasarkan role
if (auth()->user()->isHomeroomTeacher()) {
    $query->where('class_id', auth()->user()->assigned_class_id);
}

// Apply filters
if ($request->filled('search')) {
    $query->whereHas('student', function($q) use ($request) {
        $q->where('name', 'like', '%' . $request->search . '%');
    });
}

if ($request->filled('class_id')) {
    $query->where('class_id', $request->class_id);
}

if ($request->filled('date')) {
    $query->whereDate('late_date', $request->date);
}

if ($request->filled('status')) {
    $query->where('status', $request->status);
}

$lateAttendances = $query->orderBy('late_date', 'desc')->paginate(20);
```

**Output**: View `late-attendance.index` dengan pagination

#### `dailyReport(Request $request)` ✨ *Updated*
**Route**: `GET /late-attendance/report?type={daily|monthly|yearly}`  
**Fitur**: Laporan multi-range (harian/bulanan/tahunan)  
**Fungsi**: Menampilkan laporan keterlambatan + ketidakhadiran dengan filter range dinamis

**Kode yang bekerja**:
```php
// 1. Deteksi tipe laporan
$reportType = $request->get('type', 'daily'); // daily, monthly, yearly ✨
$date = $request->get('date', Carbon::today()->format('Y-m-d'));
$month = $request->get('month', Carbon::today()->format('m')); // ✨ NEW
$year = $request->get('year', Carbon::today()->format('Y')); // ✨ NEW

// 2. Data keterlambatan dengan filter dinamis
$query = LateAttendance::with(['student', 'schoolClass', 'lateReason', 'recordedBy']);

if ($reportType === 'daily') {
    $query->byDate($date);
} elseif ($reportType === 'monthly') {
    $query->whereMonth('late_date', $month)->whereYear('late_date', $year); // ✨
} elseif ($reportType === 'yearly') {
    $query->whereYear('late_date', $year); // ✨
}

$lateAttendances = $query->orderBy('arrival_time')->get();

// 3. Data ketidakhadiran siswa (S/I/A/T/D) ✨ Updated
$studentAbsencesQuery = StudentAbsence::with(['student', 'schoolClass', 'recordedBy']);

if ($reportType === 'daily') {
    $studentAbsencesQuery->byDate($date);
} elseif ($reportType === 'monthly') {
    $studentAbsencesQuery->whereMonth('absence_date', $month)->whereYear('absence_date', $year); // ✨
} elseif ($reportType === 'yearly') {
    $studentAbsencesQuery->whereYear('absence_date', $year); // ✨
}

$studentAbsences = $studentAbsencesQuery->orderBy('class_id')->get();

// 4. Data guru absent dengan filter yang sama ✨
$teacherAbsencesQuery = TeacherAbsence::query();

if ($reportType === 'daily') {
    $teacherAbsencesQuery->byDate($date);
} elseif ($reportType === 'monthly') {
    $teacherAbsencesQuery->whereMonth('absence_date', $month)->whereYear('absence_date', $year);
} elseif ($reportType === 'yearly') {
    $teacherAbsencesQuery->whereYear('absence_date', $year);
}

$teacherAbsences = $teacherAbsencesQuery->orderBy('teacher_name')->get();

// 5. Statistik (sama seperti sebelumnya)
$totalLateStudents = $lateAttendances->count();
$absentByStatus = $studentAbsences->groupBy('status')->map->count(); // Termasuk T & D ✨
```

**Output**: View `late-attendance.daily-report` dengan:
- Dropdown tipe laporan (3 tombol: Harian/Bulanan/Tahunan) ✨
- Form filter dinamis yang berubah sesuai tipe ✨
- Judul periode dinamis ✨
- Data sesuai range yang dipilih

#### `exportPDF(Request $request)` ✨ *Updated*
**Route**: `GET /late-attendance/export-pdf?type={daily|monthly|yearly}`  
**Fitur**: Export laporan ke PDF (mendukung semua tipe)  
**Fungsi**: Generate PDF dari laporan dengan range dinamis

**Kode yang bekerja**:
```php
// 1. Deteksi tipe dan ambil data sesuai range ✨
$reportType = $request->get('type', 'daily');
$date = $request->get('date', Carbon::today()->format('Y-m-d'));
$month = $request->get('month', Carbon::today()->format('m'));
$year = $request->get('year', Carbon::today()->format('Y'));

// Apply filter yang sama dengan dailyReport() ✨
$query = LateAttendance::with([...]); 

if ($reportType === 'daily') {
    $query->byDate($date);
} elseif ($reportType === 'monthly') {
    $query->whereMonth('late_date', $month)->whereYear('late_date', $year);
} elseif ($reportType === 'yearly') {
    $query->whereYear('late_date', $year);
}

$lateAttendances = $query->get();
// ... sama untuk studentAbsences dan teacherAbsences

// 2. Generate period label dinamis ✨
if ($reportType === 'daily') {
    $periodLabel = Carbon::parse($date)->format('d F Y');
    $filenameDate = $date;
} elseif ($reportType === 'monthly') {
    $periodLabel = Carbon::create($year, $month, 1)->format('F Y');
    $filenameDate = $year . '-' . $month;
} else {
    $periodLabel = 'Tahun ' . $year;
    $filenameDate = $year;
}

// 3. Generate PDF ✨
$data = [
    'reportType' => $reportType, // ✨ NEW
    'periodLabel' => $periodLabel, // ✨ NEW
    'lateAttendances' => $lateAttendances,
    'studentAbsences' => $studentAbsences, // Termasuk status T & D ✨
    // ... data lainnya
];

$pdf = Pdf::loadView('late-attendance.pdf-report', $data);
$filename = 'laporan-' . $reportType . '-' . $filenameDate . '.pdf'; // ✨ Dinamis

return $pdf->download($filename);
```

**Output**: Download file PDF dengan:
- Filename dinamis: `laporan-daily-2026-02-08.pdf` / `laporan-monthly-2026-02.pdf` / `laporan-yearly-2026.pdf` ✨
- Judul PDF: "LAPORAN HARIAN/BULANAN/TAHUNAN TERLAMBAT DAN KETIDAKHADIRAN" ✨
- Konten sesuai range yang dipilih ✨

#### `updateStatus(Request $request, $id)`
**Route**: `PATCH /late-attendance/{id}/status`  
**Fitur**: Update status keterlambatan (admin/teacher only)  
**Fungsi**: Ubah status pending → approved/rejected

**Kode yang bekerja**:
```php
$validated = $request->validate([
    'status' => 'required|in:pending,approved,rejected',
]);

$attendance = LateAttendance::findOrFail($id);
$attendance->update($validated);
```

**Output**: Redirect back dengan pesan sukses

---

### 5. **ExitPermissionController**

**File**: `app/Http/Controllers/ExitPermissionController.php`

#### `index()`
**Route**: `GET /exit-permissions`  
**Fitur**: Daftar semua izin keluar  
**Fungsi**: Menampilkan daftar izin keluar dengan filter

**Kode yang bekerja**:
```php
// Untuk shared Walas account - redirect ke class selection
if ($user->role === 'homeroom_teacher' && !$user->assigned_class_id) {
    return $this->showWalasClassSelection();
}

$query = ExitPermission::with(['student', 'schoolClass', 'submittedBy', 'walasApprovedBy', 'adminApprovedBy']);

// Filter berdasarkan role
if ($user->role === 'homeroom_teacher' && $user->assigned_class_id) {
    $query->where('class_id', $user->assigned_class_id);
}

// Apply filters
if ($request->filled('class_id')) {
    $query->where('class_id', $request->class_id);
}

if ($request->filled('status')) {
    $query->where('status', $request->status);
}

$exitPermissions = $query->latest()->paginate(15);
```

**Output**: View `exit-permissions.index`

#### `create()`
**Route**: `GET /exit-permissions/create`  
**Fitur**: Form buat izin keluar baru  
**Fungsi**: Menampilkan form input izin keluar

**Kode yang bekerja**:
```php
if ($user->role === 'homeroom_teacher' && $user->assigned_class_id) {
    $classes = SchoolClass::where('id', $user->assigned_class_id)->get();
    $students = Student::where('class_id', $user->assigned_class_id)->active()->get();
} else {
    $classes = SchoolClass::all();
    $students = Student::active()->get();
}
```

**Output**: View `exit-permissions.create`

#### `store(Request $request)`
**Route**: `POST /exit-permissions`  
**Fitur**: Simpan izin keluar baru  
**Fungsi**: Menyimpan data izin keluar ke database

**Kode yang bekerja**:
```php
// 1. Validasi dengan conditional rules
$rules = [
    'student_id' => 'required|exists:students,id',
    'permission_type' => 'required|in:sick,leave_early,permission_out',
    'exit_date' => 'required|date',
    'exit_time' => 'nullable|date_format:H:i',
    'time_out' => 'required|date_format:H:i',
    'reason' => 'required|string|max:1000',
    'additional_notes' => 'nullable|string|max:1000',
];

// time_in wajib untuk permission_out
if ($request->permission_type === 'permission_out') {
    $rules['time_in'] = 'required|date_format:H:i|after:time_out';
}

// 2. Simpan dengan status awal pending
$exitPermission = ExitPermission::create([
    'student_id' => $validated['student_id'],
    'class_id' => $student->class_id,
    'submitted_by' => Auth::id(),
    'permission_type' => $validated['permission_type'],
    // ... field lainnya
]);
```

**Output**: Redirect ke `exit-permissions.index`

#### `show(ExitPermission $exitPermission)`
**Route**: `GET /exit-permissions/{exitPermission}`  
**Fitur**: Detail izin keluar  
**Fungsi**: Menampilkan detail lengkap izin keluar dengan status approval

**Kode yang bekerja**:
```php
// Cek akses untuk wali kelas
if ($user->role === 'homeroom_teacher' && $user->assigned_class_id && 
    $exitPermission->class_id !== $user->assigned_class_id) {
    abort(403);
}

$exitPermission->load(['student', 'schoolClass', 'submittedBy', 'walasApprovedBy', 'adminApprovedBy']);
```

**Output**: View `exit-permissions.show`

#### `walasApprove(Request $request, ExitPermission $exitPermission)`
**Route**: `POST /exit-permissions/{exitPermission}/walas-approve`  
**Fitur**: Approval wali kelas (Tahap 1)  
**Fungsi**: Wali kelas approve/reject izin keluar

**Kode yang bekerja**:
```php
// 1. Validasi action
$validated = $request->validate([
    'action' => 'required|in:approve,reject',
    'walas_notes' => 'nullable|string|max:500',
]);

// 2. Update status walas
$exitPermission->update([
    'walas_status' => $validated['action'] === 'approve' ? 'approved' : 'rejected',
    'walas_approved_by' => $user->id,
    'walas_approved_at' => now(),
    'walas_notes' => $validated['walas_notes'] ?? null,
]);

// 3. Update overall status
$exitPermission->updateOverallStatus();
```

**Output**: Redirect back dengan pesan sukses

#### `adminApprove(Request $request, ExitPermission $exitPermission)`
**Route**: `POST /exit-permissions/{exitPermission}/admin-approve`  
**Fitur**: Approval admin (Tahap 2)  
**Fungsi**: Admin/Teacher approve/reject izin keluar setelah walas approve

**Kode yang bekerja**:
```php
// 1. Cek sequential approval - hanya bisa approve jika walas sudah approve
if ($exitPermission->walas_status !== 'approved') {
    return redirect()->back()->with('error', 'Admin approval can only be processed after Homeroom Teacher approval!');
}

// 2. Update status admin
$exitPermission->update([
    'admin_status' => $validated['action'] === 'approve' ? 'approved' : 'rejected',
    'admin_approved_by' => $user->id,
    'admin_approved_at' => now(),
    'admin_notes' => $validated['admin_notes'] ?? null,
]);

// 3. Update overall status
$exitPermission->updateOverallStatus();
```

**Output**: Redirect back dengan pesan sukses

#### `classList()`
**Route**: `GET /exit-permissions/classes`  
**Fitur**: Daftar kelas dengan pending count  
**Fungsi**: Menampilkan kelas-kelas dengan jumlah izin pending

**Kode yang bekerja**:
```php
$classes = SchoolClass::active()->get();

// Load pending count per kelas
$classes->load(['exitPermissions' => function($query) use ($user) {
    if ($user->role === 'homeroom_teacher') {
        $query->where('walas_status', 'pending');
    } else {
        $query->where('status', 'pending');
    }
}]);
```

**Output**: View `exit-permissions.classes`

#### `showClassExitPermissions($classId)`
**Route**: `GET /exit-permissions/classes/{classId}`  
**Fitur**: Daftar izin keluar per kelas  
**Fungsi**: Menampilkan semua izin keluar untuk kelas tertentu

**Kode yang bekerja**:
```php
$class = SchoolClass::findOrFail($classId);

// Cek authorization
if ($user->role === 'homeroom_teacher' && $user->assigned_class_id && 
    $class->id !== $user->assigned_class_id) {
    abort(403);
}

$query = ExitPermission::where('class_id', $class->id)
    ->with(['student', 'submittedBy', 'walasApprovedBy', 'adminApprovedBy']);

if ($user->role === 'homeroom_teacher') {
    $query->where('walas_status', 'pending');
}

$exitPermissions = $query->latest()->get();
```

**Output**: View `exit-permissions.class-show`

#### `getStudentsByClass(Request $request)`
**Route**: `GET /exit-permissions/ajax/students-by-class`  
**Fitur**: AJAX endpoint untuk get siswa by kelas  
**Fungsi**: Return JSON siswa untuk dropdown dinamis

**Kode yang bekerja**:
```php
$students = Student::where('class_id', $request->class_id)
    ->active()
    ->orderBy('name')
    ->get(['id', 'name', 'student_number']);

return response()->json($students);
```

**Output**: JSON response

---

### 6. **WalasController**

**File**: `app/Http/Controllers/WalasController.php`

#### `dashboard()`
**Route**: `GET /walas/dashboard`  
**Fitur**: Dashboard wali kelas  
**Fungsi**: Menampilkan semua kelas dengan pending requests

**Kode yang bekerja**:
```php
// Untuk shared Walas account - show ALL classes dengan pending requests
$classesWithRequests = SchoolClass::whereHas('exitPermissions', function ($query) {
    $query->where('walas_status', 'pending');
})->withCount(['exitPermissions' => function ($query) {
    $query->where('walas_status', 'pending');
}])->with(['exitPermissions' => function ($query) {
    $query->where('walas_status', 'pending')->latest()->take(3);
}])->get();
```

**Output**: View `walas.dashboard`

#### `showPasswordForm(SchoolClass $class)`
**Route**: `GET /walas/classes/{class}/verify-password`  
**Fitur**: Form verifikasi password kelas  
**Fungsi**: Menampilkan form input password sebelum akses requests kelas

**Output**: View `walas.verify-password`

#### `verifyPasswordAndShowRequests(Request $request, SchoolClass $class)`
**Route**: `POST /walas/classes/{class}/verify-password`  
**Fitur**: Verifikasi password dan tampilkan requests  
**Fungsi**: Cek password kelas dan tampilkan pending exit permissions

**Kode yang bekerja**:
```php
// 1. Validasi password
$request->validate(['password' => 'required|string']);

// 2. Cek password kelas
if ($request->password !== $class->password) {
    return back()->withErrors(['password' => 'Invalid class password.']);
}

// 3. Get pending requests untuk kelas ini
$exitPermissions = ExitPermission::where('class_id', $class->id)
    ->where('walas_status', 'pending')
    ->with(['student', 'submittedBy'])
    ->orderBy('created_at', 'desc')
    ->get();
```

**Output**: View `exit-permissions.class-show`

---

### 7. **StudentAbsenceController**

**File**: `app/Http/Controllers/StudentAbsenceController.php`

#### `create(Request $request)`
**Route**: `GET /student-absences/input`  
**Fitur**: Form input ketidakhadiran siswa (S/I/A)  
**Fungsi**: Input ketidakhadiran per kelas secara massal

**Kode yang bekerja**:
```php
$date = $request->get('date', Carbon::today()->format('Y-m-d'));
$grade = $request->get('grade');
$major = $request->get('major');

// 1. Get dropdown options
$grades = SchoolClass::active()->select('grade')->distinct()->orderBy('grade')->pluck('grade');
$majors = SchoolClass::active()->select('major')->distinct()->orderBy('major');

if ($grade) {
    $majors->where('grade', $grade);
}
$majors = $majors->pluck('major');

// 2. Get kelas dan siswa jika sudah dipilih
if ($grade && $major) {
    $selectedClass = SchoolClass::active()->where('grade', $grade)->where('major', $major)->first();
    
    if ($selectedClass) {
        $students = $selectedClass->students()->active()->orderBy('name')->get();
        
        // Load existing absences untuk tanggal ini
        $existingAbsences = StudentAbsence::with(['student'])
            ->byDate($date)
            ->where('class_id', $selectedClass->id)
            ->get()
            ->keyBy('student_id');
    }
}
```

**Output**: View `student-absences.create` dengan form grid siswa

#### `store(Request $request)`
**Route**: `POST /student-absences`  
**Fitur**: Simpan ketidakhadiran siswa  
**Fungsi**: Simpan data S/I/A untuk siswa yang dipilih

**Kode yang bekerja**:
```php
// 1. Validasi
$validated = $request->validate([
    'absence_date' => ['required', 'date'],
    'class_id' => ['required', 'exists:classes,id'],
    'statuses' => ['array'],
    'statuses.*' => ['nullable', 'in:S,I,A'],
]);

// 2. Filter hanya yang ada statusnya
$statuses = collect($validated['statuses'] ?? [])
    ->filter(function ($value) {
        return in_array($value, ['S', 'I', 'A'], true);
    });

// 3. Delete existing + insert new dalam transaction
DB::transaction(function () use ($date, $class, $studentIds, $statuses) {
    // Delete existing untuk tanggal ini
    StudentAbsence::where('class_id', $class->id)
        ->whereDate('absence_date', $date)
        ->whereIn('student_id', $studentIds)
        ->delete();
    
    // Insert new records
    $rows = [];
    foreach ($statuses as $studentId => $status) {
        $rows[] = [
            'student_id' => $studentId,
            'class_id' => $class->id,
            'recorded_by' => auth()->id(),
            'absence_date' => $date,
            'status' => $status,
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
    
    if (count($rows) > 0) {
        StudentAbsence::insert($rows);
    }
});
```

**Output**: Redirect back dengan pesan sukses

---

### 8. **ProfileController**

**File**: `app/Http/Controllers/ProfileController.php`

#### `edit(Request $request)`
**Route**: `GET /profile`  
**Fitur**: Edit profil user  
**Fungsi**: Menampilkan form edit profil

#### `update(ProfileUpdateRequest $request)`
**Route**: `PATCH /profile`  
**Fitur**: Update profil  
**Fungsi**: Simpan perubahan profil user

#### `destroy(Request $request)`
**Route**: `DELETE /profile`  
**Fitur**: Hapus akun  
**Fungsi**: Delete akun user

---

### 9. **Admin Controllers**

**File**: `app/Http/Controllers/Admin/*`

#### ClassManagementController
- `index()` - Daftar kelas
- `create()` - Form tambah kelas
- `store()` - Simpan kelas baru
- `edit($id)` - Form edit kelas
- `update($id)` - Update kelas
- `destroy($id)` - Hapus kelas

#### StudentManagementController
- `index()` - Daftar siswa
- `create()` - Form tambah siswa
- `store()` - Simpan siswa baru
- `edit($id)` - Form edit siswa
- `update($id)` - Update siswa
- `destroy($id)` - Hapus siswa

#### UserManagementController
- (Belum diimplementasi)

#### LateReasonManagementController
- (Belum diimplementasi)

---

## 🛠️ Service Layer

### TelegramService

**File**: `app/Services/TelegramService.php`

Service ini menangani semua komunikasi dengan Telegram Bot API untuk mengirim notifikasi ke grup guru.

**Konfigurasi yang Dibutuhkan**:
```env
TELEGRAM_BOT_TOKEN=your_bot_token_here
TELEGRAM_CHAT_ID=your_group_chat_id
```

**Fungsi-fungsi**:

| Fungsi | Tujuan | Input | Output |
|--------|--------|-------|--------|
| `sendSingleLateNotification($lateAttendance)` | Kirim 1 notifikasi keterlambatan | LateAttendance model | boolean |
| `sendBulkIndividualLateNotification($lateAttendances)` | Kirim banyak notifikasi individual | Collection | boolean |
| `sendBatchNotification($lateAttendances)` | Kirim ringkasan batch | Collection | boolean |
| `testConnection()` | Test koneksi bot | - | array |

**Cara Kerja**:
```php
// Di LateAttendanceController
$telegramService = new TelegramService();
$sent = $telegramService->sendSingleLateNotification($record);

if ($sent) {
    $record->update([
        'telegram_sent' => true,
        'telegram_sent_at' => now()
    ]);
}
```

---

### WhatsAppService

**File**: `app/Services/WhatsAppService.php`

Service ini menangani pengiriman pesan WhatsApp ke nomor orang tua siswa menggunakan WAPISender API.

**Konfigurasi yang Dibutuhkan**:
```env
WAPISENDER_API_KEY=your_api_key
WAPISENDER_DEVICE_KEY=your_device_key
WAPISENDER_BASE_URL=https://wapisender.id
```

**Fungsi-fungsi**:

| Fungsi | Tujuan | Input | Output |
|--------|--------|-------|--------|
| `sendLateNotificationToParent($lateAttendance)` | Kirim notifikasi ke 1 orang tua | LateAttendance model | boolean |
| `sendBulkLateNotificationToParents($lateAttendances)` | Kirim ke banyak orang tua | Collection | boolean |
| `formatPhoneNumber($phone)` | Format nomor ke +62xxx | string | string |
| `testConnection()` | Test koneksi API | - | array |

**Cara Kerja**:
```php
// Di LateAttendanceController
$whatsappService = new WhatsAppService();
$sent = $whatsappService->sendLateNotificationToParent($record);

if ($sent) {
    $record->update([
        'whatsapp_sent' => true,
        'whatsapp_sent_at' => now()
    ]);
}
```

**Fitur Khusus**:
- Auto format nomor telepon (081xxx → 6281xxx)
- Pesan berbeda untuk siswa dengan ≥5 keterlambatan (warning khusus)
- Delay 0.5 detik antar pengiriman bulk untuk avoid rate limit

---

## 🔌 API dan Integrasi

### 1. **Telegram Bot API**

#### Konfigurasi
```env
TELEGRAM_BOT_TOKEN=your_bot_token_here
TELEGRAM_CHAT_ID=your_group_chat_id
```

#### Fungsi Telegram Service

##### `sendSingleLateNotification($lateAttendance)`
**Tujuan**: Kirim notifikasi 1 siswa terlambat ke grup Telegram

**Parameter**: 
- `$lateAttendance` - Model LateAttendance dengan relasi

**Return**: `true` jika berhasil, `false` jika gagal

**Format Pesan**:
```
🚨 LAPORAN KETERLAMBATAN SISWA

👤 Nama: [Nama Siswa]
📌 NIS: [Nomor Induk]
🏫 Kelas: [Nama Kelas]
📅 Tanggal: [Tanggal]
⏰ Jam Kedatangan: [Waktu] WIB
📝 Alasan: [Alasan Terlambat]
💬 Catatan: [Catatan Tambahan]

━━━━━━━━━━━━━━━━━━━━━
👨‍🏫 Dicatat oleh: [Nama Guru]
🤖 Notifikasi otomatis dari Sistem Keterlambatan
```

##### `sendBulkIndividualLateNotification($lateAttendances)`
**Tujuan**: Kirim notifikasi banyak siswa dengan detail individual

**Parameter**: 
- `$lateAttendances` - Collection of LateAttendance models

**Return**: `true` jika berhasil, `false` jika gagal

**Format Pesan**:
```
🚨 LAPORAN KETERLAMBATAN SISWA

🏫 Kelas: [Nama Kelas]
📅 Tanggal: [Tanggal]
👥 Total: [Jumlah] siswa
━━━━━━━━━━━━━━━━━━━━━

1. [Nama Siswa 1]
   📌 NIS: [NIS]
   ⏰ Jam: [Waktu] WIB
   📝 Alasan: [Alasan]
   💬 Catatan: [Catatan]

2. [Nama Siswa 2]
   ...
```

##### `sendBatchNotification($lateAttendances)`
**Tujuan**: Kirim ringkasan batch (untuk review manual)

**Digunakan di**: Halaman Telegram Review

##### `testConnection()`
**Tujuan**: Test koneksi Telegram Bot

**Return**: Array dengan status dan info bot
```php
[
    'success' => true/false,
    'message' => 'Status message',
    'bot_name' => 'Bot Name',
    'bot_username' => '@bot_username'
]
```

---

### 2. **WhatsApp API (WAPISender)**

#### Konfigurasi
```env
WAPISENDER_API_KEY=your_api_key
WAPISENDER_DEVICE_KEY=your_device_key
WAPISENDER_BASE_URL=https://wapisender.id
```

#### Fungsi WhatsApp Service

##### `sendLateNotificationToParent($lateAttendance)`
**Tujuan**: Kirim notifikasi keterlambatan ke nomor WhatsApp orang tua

**Parameter**: 
- `$lateAttendance` - Model LateAttendance dengan relasi student

**Proses**:
1. Cek apakah nomor orang tua tersedia (`parent_phone`)
2. Format nomor ke format internasional (62xxx)
3. Kirim pesan via WAPISender API v5
4. Log hasil pengiriman

**Return**: `true` jika berhasil, `false` jika gagal

**Format Pesan WhatsApp**:
```
🔔 *NOTIFIKASI KETERLAMBATAN SISWA*

Yth. Orang Tua/Wali dari:
👤 *Nama:* [Nama Siswa]
📌 *NIS:* [NIS]
🏫 *Kelas:* [Kelas]

─────────────────────
📅 *Tanggal:* [Tanggal]
⏰ *Jam Kedatangan:* [Waktu] WIB
📝 *Alasan:* [Alasan]
💬 *Catatan:* [Catatan]
─────────────────────

📊 *Total Keterlambatan Bulan Ini:* [Jumlah]x

⚠️ *PERHATIAN:*
Siswa telah terlambat ≥5 kali bulan ini.
Mohon perhatian khusus dari orang tua.

Terima kasih atas perhatian dan kerjasamanya.

🏫 _Tim Piket Sekolah_
_Pesan otomatis dari Sistem Absensi Sekolah_
```

##### `sendBulkLateNotificationToParents($lateAttendances)`
**Tujuan**: Kirim notifikasi ke banyak orang tua sekaligus

**Parameter**: 
- `$lateAttendances` - Collection of LateAttendance

**Proses**:
- Loop setiap siswa dan kirim individual
- Delay 0.5 detik antar pengiriman (avoid rate limit)
- Track success/failed count

**Return**: `true` jika ada yang berhasil

##### `formatPhoneNumber($phone)`
**Tujuan**: Format nomor telepon ke format internasional

**Contoh**:
- Input: `081234567890` → Output: `6281234567890`
- Input: `62811111111` → Output: `62811111111`
- Input: `+62822222222` → Output: `62822222222`

##### `testConnection()`
**Tujuan**: Test koneksi WAPISender API

**Return**: Array dengan status dan data profil
```php
[
    'success' => true/false,
    'message' => 'Status message',
    'data' => [API response data]
]
```

---

