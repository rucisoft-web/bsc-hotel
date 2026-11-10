# BSC Hotel

Edisi hotel dari **Ruci BSC Professional**: aplikasi **Balanced Scorecard multi-perusahaan** berbasis Laravel + MySQL, dikembangkan dari edisi DHASTRAM (ARAH GPCH). KPI bawaannya diturunkan dari laporan akhir bulan 10 departemen hotel (Finance, Rooms Division, Sales & Marketing, Housekeeping, F&B Service, Kitchen, Engineering, Security, Purchasing, HR) untuk persiapan tahun anggaran 2027.
Satu instalasi melayani banyak perusahaan; setiap perusahaan punya data, perioda, admin dan pengguna sendiri, dan datanya bisa diupload satu per satu lewat file Excel.

**Instalasi di Laragon → [PANDUAN-LARAGON.md](PANDUAN-LARAGON.md)** · **Instalasi di cPanel → [PANDUAN-CPANEL.md](PANDUAN-CPANEL.md)**

## Teknologi

| Lapisan | Komponen |
|---|---|
| Runtime | PHP 8.3+, **Laravel 13**, Livewire 4 |
| Antarmuka | **Filament v5** (panel `/admin`), stylesheet statis `public/css/arah.css` (tanpa Node.js) |
| Basis data | **MySQL 8 / MariaDB 10.6+** (SQLite untuk test) |
| Konteks | `DhastramContext` (sesi + tabel `user_contexts`) & global scope `BelongsToDhastramContext` menyaring setiap query per perusahaan/perioda |
| Excel | OpenSpout: import, template kosong, dan ekspor data perioda |
| Audit | `audit_logs` mencatat buat/ubah/hapus (`DHASTRAM_AUDIT_ENABLED`) |
| Jadwal | `rucibsc:reminders` harian (pengingat siklus input → verifikasi → persetujuan) |

## Multi-perusahaan

- **Super Admin** mengelola semua perusahaan, peran, dan semua akun.
- **Company Admin** mengelola pengguna dan penugasan peran **hanya di perusahaan yang sedang aktif**. Akun yang juga terdaftar di perusahaan lain hanya bisa diubah Super Admin (mencegah reset sandi lintas perusahaan).
- Peran diberikan per perusahaan (`role_user.company_id`); satu orang boleh punya peran di beberapa perusahaan dan berpindah lewat **Pilih Perusahaan & Perioda**.

## Import data perusahaan (menu Administrasi › Import Data)

1. Pilih perusahaan & perioda tujuan.
2. Unduh **template kosong** atau **ekspor data perioda saat ini**.
3. Isi sheet yang diperlukan: Jati Diri, Nilai Inti, Tema, Sasaran, Relasi Sasaran, KPI, Target, Realisasi, Inisiatif. Sheet yang tidak ada di file tidak diubah.
4. **Pratinjau** dulu (tidak menyimpan apa pun), lalu **Proses Import**.

Kode (sasaran, KPI, tema, inisiatif) menjadi kunci, jadi upload ulang memperbarui data, bukan menduplikasi. Baris yang salah dilewati dan dilaporkan dengan nomor barisnya. Angka boleh format Indonesia (`11.098.665`, `6,62`). Realisasi masuk sebagai **draf**, kecuali pengguna punya izin persetujuan dan mencentang "langsung setujui". Import terakhir sebuah perioda bisa **dibatalkan** (nilai sebelumnya dipulihkan). Izin: `import.manage`.

## Modul

- **Umum:** Beranda, Pusat Kendali Eksekutif, Alur Kerja, Peta Strategi, Laporan (+ Excel), Pilih Perusahaan & Perioda.
- **Ekosistem:** Pemindaian Lingkungan, PESTEL, Analisis Industri, Pasar & Pelanggan, Pesaing, Regulasi, Pemangku Kepentingan, Isu Strategis, SWOT, TOWS.
- **Jati Diri:** visi, misi, nilai inti, budaya, kapabilitas.
- **Kinerja:** Tema, Pilihan Strategis, Sasaran, Relasi Sasaran, KPI, Target, Realisasi (draf → terverifikasi → disetujui/terkunci, atau dikembalikan), Tinjauan Kinerja.
- **Perbaikan:** Portofolio & Inisiatif Strategis, Aktivitas, Milestone, Anggaran, Temuan, Tindakan Korektif.
- **Kesinambungan:** Kematangan Manajemen Strategi, Ketergantungan, Institusionalisasi.
- **Administrasi:** Perusahaan, Pengguna, Peran, Penugasan Peran, Import Data, Log Audit.

Skor KPI: polaritas naik = realisasi ÷ target × 100, turun = target ÷ realisasi × 100, maksimal 120; hijau ≥ 100, kuning ≥ 80. Agregasi jumlah, rata-rata, atau terakhir.

## Peran bawaan

`super-admin`, `company-admin`, `strategy-office`, `management`, `pimpinan`, `keuangan`, `kepala-unit`, `kpi-owner`, `initiative-pic`, `reviewer`, `pengawas`, `admin-sistem`, `editor-ekosistem`, `editor-jatidiri`, `pelaksana`, `viewer`. Isi izin peran berlaku global dan hanya diubah Super Admin.

## Data contoh

Di luar produksi (atau bila `RUCI_SEED_DEMO=true`) seeder memuat tiga hotel contoh. Setiap hotel punya perioda **2025** (ditutup), **2026** (berjalan: realisasi Jan–Agu disetujui, Sep dalam proses) dan **2027** (perencanaan: target & inisiatif saja), dengan 4 tema strategis, 16 sasaran, 27 relasi sebab-akibat, dan **53 KPI dari 10 departemen hotel** (hunian, ADR, RevPAR, GOP, F&B cost, kepuasan tamu, waktu siap kamar, kWh & air per malam kamar, turnover, dsb.), plus lingkungan (PESTEL, Porter, segmen pasar, pesaing STR, regulasi, pemangku kepentingan), jati diri, inisiatif dengan aktivitas/milestone/anggaran, temuan & tindakan korektif, tinjauan kinerja, kesinambungan, dan kematangan.

| Kode | Hotel | Sumber angka 2025 |
|---|---|---|
| GPCH | Grand Pasundan Convention Hotel (164 kamar) | Proyeksi manajemen (laporan mingguan GM & anggaran 2026), sudah disamarkan; bukan laporan tahunan |
| SHID | PT Hotel Sahid Jaya International Tbk — Grand Sahid Jaya Jakarta (751 kamar) | Laporan Tahunan 2025: pendapatan Rp124,0 M, hunian 30,00%, ADR Rp780.112, target 2026 Rp165,6 M |
| SNLK | PT Sunter Lakeside Hotel Tbk — Sunlake Hotel Jakarta Utara (228 kamar) | Laporan Tahunan 2025: pendapatan Rp46,0 M, 45.855 malam kamar, target 2026 Rp53,2 M |

Akun: Super Admin `admin@rucibsc.local` / `Ruci@BSC2026` (ubah lewat `RUCI_ADMIN_PASSWORD`). Akun contoh per hotel, kata sandi `Contoh-2026!`:
`gpch.admin`, `gpch.gm`, `gpch.keuangan`, `gpch.strategi`, `gpch.pengawas`, `gpch.pemilik`, `gpch.kamar`, `gpch.hk`, `gpch.fnb`, `gpch.chef`, `gpch.sales`, `gpch.engineering`, `gpch.hr`, `gpch.security`, `gpch.purchasing`, `gpch.analis` (@contoh.local); pola yang sama untuk `shid.*` dan `snlk.*`.

**Peringatan data demo.** Semua data contoh adalah DATA DEMO untuk pembelajaran dan penjelasan kepada manajemen. Untuk SHID dan SNLK, angka 2025 secara garis besar mengacu pada Laporan Tahunan 2025 (kolom `companies.demo_source`); untuk GPCH angka adalah proyeksi. KPI operasional, rincian bulanan, data 2026 dan 2027 adalah simulasi. Peringatan ini tampil sebagai pita di setiap halaman hotel demo (`App\Support\DemoNotice`), di halaman login, dan di sheet Petunjuk template Excel.

Memuat satu demo di server yang sudah berjalan: `php artisan rucibsc:demo GPCH|SHID|SNLK` (alias `bschotel:demo`). Kata sandi akun contoh dibuat acak dan ditampilkan (atau tentukan dengan `--password=`). Bila hotel itu sudah punya perioda 2025/2026/2027, tambahkan `--reset` untuk menggantinya.

Situs demo/promosi: `RUCI_GUEST_LOGIN=true` menampilkan tombol **Masuk sebagai Tamu (lihat-lihat)** di halaman login (rute `/masuk-tamu`, menerima `?perusahaan=KODE` untuk membuka perusahaan contoh pada tahun berjalan dan `?ke=kenali|panduan|implementasi|workshop`). Rute `/` menjadi halaman depan promosi (`LandingController`, `resources/views/landing.blade.php`, `public/css/landing.css`) dengan daftar data demo dari `App\Support\DemoCatalog`; bila akses Tamu mati, `/` diarahkan ke `/admin`. Akun Tamu (peran `tamu`, global) hanya punya izin lihat tanpa log audit dan ekspor, konteksnya disimpan per sesi, dan `App\Support\GuestMode` menolak setiap penyimpanan/penghapusan model oleh Tamu sebagai pengaman terakhir.

Menu **Kenali Ruci BSC** (`/admin/kenali-ruci-bsc`, tautan berbagi `/kenali`) menjelaskan Ruci BSC untuk pimpinan dan mengajak ikut Workshop; tautan dan kontak Workshop lewat `RUCI_WORKSHOP_URL` dan `RUCI_WORKSHOP_CONTACT`. Tangkapan layarnya ada di `public/images/kenali/`. Grup menu **Panduan** juga berisi **Panduan Pengguna** (per peran, tangkapan layar di `public/images/panduan/`) dan **Panduan Implementasi** (prasyarat, lingkup, jadwal, sumber daya, organisasi proyek, mutu, komunikasi, risiko, pengadaan, integrasi; bisa dicetak ke PDF), serta **Workshop Ruci BSC** (rundown & materi workshop sehari, jadwal otomatis setiap Minggu pertama awal bulan, plus edisi khusus setengah hari untuk Komisaris dan Direksi BUMN; nama narasumber tamu lewat `RUCI_WORKSHOP_SPECIAL_SPEAKER`).

Sebelum dipakai sungguhan: `php artisan rucibsc:hapus-contoh` menghapus semua perusahaan dan akun contoh, lalu ganti sandi Super Admin.

## Perintah penting

| Perintah | Fungsi |
|---|---|
| `php artisan dhastram:doctor` | Cek PHP, ekstensi, database, izin, peran, data contoh |
| `php artisan dhastram:create-admin` | Membuat Super Admin baru |
| `php artisan db:seed --class=DhastramRolePermissionSeeder` | Memperbarui izin & peran (aman diulang) |
| `php artisan rucibsc:demo GPCH\|SHID\|SNLK [--reset]` | Memuat satu demo hotel lengkap (2025, 2026, 2027) |
| `php artisan rucibsc:hapus-contoh` | Menghapus hotel & akun contoh |
| `php artisan rucibsc:reminders --date=2026-11-03` | Uji pengingat |
| `php vendor/bin/phpunit` | Menjalankan test otomatis |

## Produksi (cPanel / VPS)

Langkah lengkap untuk cPanel (dengan atau tanpa Terminal) ada di [PANDUAN-CPANEL.md](PANDUAN-CPANEL.md).


`APP_ENV=production`, `APP_DEBUG=false`, `SESSION_SECURE_COOKIE=true`; document root ke `public/`; cron `* * * * * php /path/ruci-bsc/artisan schedule:run`.
Di produksi `DatabaseSeeder` hanya membuat izin, peran, dan pertanyaan kematangan. Buat Super Admin dengan `dhastram:create-admin`, tambahkan perusahaan, lalu upload datanya lewat Import Data.
Rilis: `composer install --no-dev --optimize-autoloader` → `php artisan migrate --force` → `php artisan optimize` → `php artisan dhastram:doctor`.
