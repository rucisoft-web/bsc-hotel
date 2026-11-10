<?php

namespace Database\Seeders;

use App\Models\AnalysisPeriod;
use App\Models\Company;
use App\Models\Institutionalization;
use App\Models\Kpi;
use App\Models\KpiTarget;
use App\Models\ObjectiveRelation;
use App\Models\PerformanceReview;
use App\Models\ReviewNote;
use App\Models\StrategicChoice;
use App\Models\StrategicDependency;
use App\Models\StrategicObjective;
use App\Models\StrategicTheme;
use App\Models\UserContext;
use App\Support\DhastramContext;

/**
 * Kerangka demo hotel: peta strategi & ±48 KPI yang diturunkan dari laporan akhir bulan
 * sepuluh departemen hotel (Rooms Division, Housekeeping, F&B Service, Kitchen, Finance,
 * Sales & Marketing, Engineering, HR, Security, Purchasing & Stores).
 *
 * Perioda: 2025 (ditutup), 2026 (berjalan, simulasi Jan–Sep), dan 2027 (perencanaan: target & inisiatif).
 * Subkelas mengisi profil, jati diri, ekosistem, angka KPI, inisiatif, temuan, dan teks tinjauan hotel.
 */
abstract class HotelShowcaseSeeder extends ShowcaseSeeder
{
    /** Awalan email akun contoh, mis. "gpch" → gpch.gm@contoh.local */
    public const PREFIX = '';

    /** Nama pendek hotel untuk teks. */
    public const SHORT = '';

    // ------------------------------------------------------------------ isi khusus hotel

    /** Jumlah kamar (dipakai di rumus & teks). */
    abstract protected function rooms(): int;

    /** @return array<string,array{0:float|null,1:float,2:float,3:float,4:float,5?:float}> kode KPI => [2024, target 2025, realisasi 2025, target 2026, faktor realisasi 2026, target 2027?] */
    abstract protected function kpiNumbers(): array;

    /** Kode KPI yang realisasi 2025-nya mengacu pada laporan tahunan. */
    protected function fromAnnualReport(): array
    {
        return [];
    }

    /** @return array<string,array{0:string,1:string,2:string}> T1..T4 => [nama, uraian, warna] */
    abstract protected function themeDefs(): array;

    /** @return list<array{0:string,1:string,2:string,3:string,4?:string}> [tema, pilihan, jenis, alasan, status] */
    abstract protected function choiceDefs(): array;

    /**
     * Inisiatif ringkas per tahun (2025, 2026, 2027).
     *
     * @return array<string,array> kunci => [kode, judul, uraian, tema, pemilik, mulai, selesai, status, dampak, urgensi, risiko, level anggaran,
     *                             [sasaran], hasil, capex Rp, opex Rp, [aktivitas], [milestone]]
     */
    abstract protected function hotelInitiatives(int $year): array;

    /** @return list<array> format ShowcaseSeeder::findings() */
    abstract protected function findingData(int $year): array;

    /** @return list<array> [judul, jenis, inisiatif, sasaran, bergantung pada, uraian, pemilik, risiko, mitigasi] */
    abstract protected function hotelDependencies(int $year): array;

    /**
     * Teks tinjauan: venue, chair, annual{summary,decisions,follow_up,note}, months[m=>[summary,decisions]],
     * q1, q2 [summary, decisions], board [summary, decisions, note], sep (ringkasan draf September), plan2027 (ringkasan rapat RKAP).
     */
    abstract protected function reviewTexts(): array;

    /** Faktor target 2027 bawaan bila tidak diisi per KPI. */
    protected function growth2027(): float
    {
        return 1.06;
    }

    // ------------------------------------------------------------------ pengguna

    protected function userDefs(): array
    {
        $p = static::PREFIX;
        $h = static::SHORT;

        return [
            'admin' => ['Admin Sistem '.$h.' (contoh)', $p.'.admin', 'EDP / IT Manager', 'EDP & IT', ['company-admin']],
            'dirut' => ['General Manager '.$h.' (contoh)', $p.'.gm', 'General Manager', 'Executive Office', ['pimpinan']],
            'cfo' => ['Financial Controller '.$h.' (contoh)', $p.'.keuangan', 'Financial Controller', 'Finance & Accounting', ['keuangan']],
            'strategi' => ['Koordinator Strategi '.$h.' (contoh)', $p.'.strategi', 'Executive Assistant Manager — Strategi & Kinerja', 'Executive Office', ['strategy-office', 'editor-ekosistem']],
            'komisaris' => ['Wakil Pemilik / Pengawas '.$h.' (contoh)', $p.'.pengawas', 'Owner Representative / Dewan Pengawas', 'Pemilik & Pengawas', ['pengawas']],
            'pemilik' => ['Pemilik '.$h.' (contoh)', $p.'.pemilik', 'Pemilik / Direksi', 'Pemilik', ['management']],
            'fo' => ['Rooms Division Manager '.$h.' (contoh)', $p.'.kamar', 'Rooms Division Manager', 'Front Office & Reservasi', ['kepala-unit']],
            'hk' => ['Executive Housekeeper '.$h.' (contoh)', $p.'.hk', 'Executive Housekeeper', 'Housekeeping', ['kepala-unit']],
            'fb' => ['F&B Manager '.$h.' (contoh)', $p.'.fnb', 'Food & Beverage Manager', 'F&B Service', ['kepala-unit']],
            'chef' => ['Executive Chef '.$h.' (contoh)', $p.'.chef', 'Executive Chef', 'Kitchen', ['kepala-unit']],
            'sales' => ['Director of Sales & Marketing '.$h.' (contoh)', $p.'.sales', 'Director of Sales & Marketing', 'Sales & Marketing', ['kepala-unit', 'editor-ekosistem']],
            'eng' => ['Chief Engineer '.$h.' (contoh)', $p.'.engineering', 'Chief Engineer', 'Engineering', ['kepala-unit']],
            'hr' => ['HR Manager '.$h.' (contoh)', $p.'.hr', 'Human Resources Manager', 'Human Resources', ['kepala-unit', 'editor-jatidiri']],
            'sec' => ['Chief Security '.$h.' (contoh)', $p.'.security', 'Chief Security', 'Security & Control', ['kepala-unit']],
            'pur' => ['Purchasing Manager '.$h.' (contoh)', $p.'.purchasing', 'Purchasing & Stores Manager', 'Purchasing & Stores', ['kepala-unit']],
            'analis' => ['Income Auditor '.$h.' (contoh)', $p.'.analis', 'Income Auditor / Analis Data', 'Finance & Accounting', ['pelaksana']],
        ];
    }

    // ------------------------------------------------------------------ peta strategi

    /** Sasaran baku hotel: kode => [perspektif, tema, judul, uraian, pemilik, bobot]. */
    public const OBJECTIVES = [
        'F1' => ['keuangan', 'T1', 'Pertumbuhan pendapatan hotel', 'Pendapatan kamar, F&B/banquet, dan lain-lain mencapai anggaran (laporan Finance & Rooms Division).', 'cfo', 3],
        'F2' => ['keuangan', 'T3', 'Profitabilitas & disiplin biaya', 'Margin GOP naik; biaya operasional & tenaga kerja sesuai anggaran.', 'cfo', 3],
        'F3' => ['keuangan', 'T3', 'Likuiditas & pengelolaan piutang', 'Arus kas operasi kuat, piutang lama tertagih.', 'cfo', 2],
        'C1' => ['pelanggan', 'T1', 'Okupansi, ADR & RevPAR optimal', 'Hunian dan harga rata-rata kamar seimbang; no-show & pembatalan terkendali (Rooms Division).', 'fo', 3],
        'C2' => ['pelanggan', 'T2', 'Tamu puas & reputasi digital kuat', 'Kepuasan tamu tinggi, keluhan rendah dan cepat diselesaikan.', 'fo', 2],
        'C3' => ['pelanggan', 'T1', 'Bisnis MICE, korporat & penjualan langsung tumbuh', 'Pendapatan MICE, konversi prospek, dan direct booking naik (Sales & Marketing).', 'sales', 2],
        'P1' => ['proses', 'T2', 'Kamar bersih & siap jual tepat waktu', 'Waktu penyiapan kamar singkat, skor inspeksi tinggi, linen & amenitas efisien (Housekeeping).', 'hk', 1.5],
        'P2' => ['proses', 'T2', 'Layanan F&B yang unggul', 'Belanja per tamu naik dan standar layanan outlet dipatuhi (F&B Service).', 'fb', 1.5],
        'P3' => ['proses', 'T3', 'Dapur bermutu, aman & efisien', 'Food cost, sisa terbuang, dan higiene pangan terkendali (Kitchen).', 'chef', 1.5],
        'P4' => ['proses', 'T3', 'Aset andal & hemat energi', 'Pemeliharaan preventif terlaksana, perbaikan cepat, energi & air efisien (Engineering).', 'eng', 1.5],
        'P5' => ['proses', 'T2', 'Lingkungan aman & terkendali', 'Insiden minimal, latihan darurat rutin, barang temuan kembali ke pemilik (Security & Control).', 'sec', 1],
        'P6' => ['proses', 'T3', 'Pengadaan & persediaan efisien', 'Pesanan tepat waktu, persediaan berputar sehat, selisih stok kecil (Purchasing & Stores).', 'pur', 1],
        'P7' => ['proses', 'T3', 'Pelaporan keuangan tepat waktu & akurat', 'Laporan bulanan (laba rugi, arus kas, neraca) terbit cepat dari sistem (Finance).', 'cfo', 1],
        'L1' => ['sdm', 'T4', 'SDM kompeten & multitasking', 'Pelatihan terstruktur dan sertifikasi kompetensi (HR).', 'hr', 1.5],
        'L2' => ['sdm', 'T4', 'Karyawan terlibat & bertahan', 'Turnover rendah, kehadiran tinggi, lembur terkendali.', 'hr', 1.5],
        'L3' => ['sdm', 'T4', 'Produktivitas SDM & sistem informasi', 'Rasio karyawan per kamar efisien dan pendapatan per karyawan naik.', 'strategi', 1],
    ];

    /** Relasi sebab-akibat: [dari, ke, kekuatan]. */
    public const RELATIONS = [
        ['L1', 'P1', 3], ['L1', 'P2', 3], ['L1', 'P3', 2], ['L2', 'P1', 2], ['L2', 'P2', 2], ['L2', 'P5', 2],
        ['L3', 'P7', 3], ['L3', 'P6', 2], ['L3', 'C1', 2], ['L1', 'P4', 2],
        ['P1', 'C2', 3], ['P2', 'C2', 3], ['P2', 'C3', 2], ['P3', 'C2', 2], ['P3', 'F2', 3], ['P4', 'C2', 2], ['P4', 'F2', 2],
        ['P5', 'C2', 2], ['P6', 'F2', 2], ['P6', 'P3', 2], ['P7', 'F3', 3],
        ['C2', 'C1', 3], ['C2', 'C3', 2], ['C1', 'F1', 3], ['C3', 'F1', 3], ['F1', 'F2', 3], ['F2', 'F3', 2],
    ];

    protected function strategy(int $year): array
    {
        $themes = [];
        foreach ($this->themeDefs() as $code => [$name, $desc, $color]) {
            $themes[$code] = StrategicTheme::create(['code' => $code, 'name' => $name, 'description' => $desc, 'color' => $color, 'sort' => count($themes) + 1]);
        }
        foreach ($this->choiceDefs() as $c) {
            StrategicChoice::create(['strategic_theme_id' => $themes[$c[0]]->id, 'title' => $c[1], 'choice_type' => $c[2], 'rationale' => $c[3],
                'status' => $c[4] ?? ($year === 2027 ? 'diusulkan' : 'dipilih')]);
        }
        $obj = [];
        foreach (self::OBJECTIVES as $code => [$persp, $th, $title, $desc, $owner, $w]) {
            $obj[$code] = StrategicObjective::create(['code' => $code, 'perspective' => $persp, 'strategic_theme_id' => $themes[$th]->id, 'title' => $title,
                'description' => $desc, 'owner_id' => $this->id($owner), 'weight' => $w, 'sort' => count($obj) + 1]);
        }
        foreach (self::RELATIONS as [$s, $t, $str]) {
            ObjectiveRelation::create(['source_objective_id' => $obj[$s]->id, 'target_objective_id' => $obj[$t]->id, 'strength' => $str]);
        }

        return [$themes, $obj];
    }

    // ------------------------------------------------------------------ katalog KPI 10 departemen

    /**
     * kode => [sasaran, nama, satuan, arah, agregasi, desimal, keuangan, kritis, pemilik, rumus, sumber data, departemen, frekuensi?]
     * Rumus memakai {rooms} untuk jumlah kamar hotel.
     */
    public const CATALOG = [
        // Finance
        'F1.1' => ['F1', 'Total pendapatan hotel', 'Rp juta', 'higher', 'sum', 0, true, true, 'cfo', 'Pendapatan kamar + F&B (outlet & banquet) + lain-lain', 'Income Audit / laporan laba rugi', 'Finance'],
        'F1.2' => ['F1', 'Pendapatan kamar', 'Rp juta', 'higher', 'sum', 0, true, false, 'fo', 'Room revenue neto (tanpa pajak & service)', 'PMS — Room Revenue Report', 'Rooms Division'],
        'F1.3' => ['F1', 'Pendapatan F&B (outlet & banquet)', 'Rp juta', 'higher', 'sum', 0, true, false, 'fb', 'Restoran, bar, room service, breakfast, banquet', 'POS & laporan banquet', 'F&B Service'],
        'F1.4' => ['F1', 'Pendapatan lain-lain (sewa ruang, laundry, parkir, spa)', 'Rp juta', 'higher', 'sum', 0, true, false, 'cfo', 'Pendapatan di luar kamar dan F&B', 'Income Audit', 'Finance'],
        'F2.1' => ['F2', 'Margin GOP (gross operating profit)', '%', 'higher', 'average', 1, true, true, 'cfo', 'GOP ÷ total pendapatan × 100 (USALI)', 'Laporan laba rugi departemental', 'Finance'],
        'F2.2' => ['F2', 'Realisasi biaya operasional terhadap anggaran', '%', 'lower', 'average', 1, true, false, 'cfo', 'Biaya operasional realisasi ÷ anggaran × 100', 'Laporan anggaran vs realisasi', 'Finance'],
        'F2.3' => ['F2', 'Biaya tenaga kerja terhadap pendapatan', '%', 'lower', 'average', 1, true, false, 'hr', 'Gaji, tunjangan, service charge & BPJS ÷ total pendapatan × 100', 'Payroll & laba rugi', 'Human Resources'],
        'F3.1' => ['F3', 'Piutang usaha berumur > 60 hari', 'Rp juta', 'lower', 'last', 0, true, false, 'cfo', 'Saldo AR aging > 60 hari pada akhir bulan', 'AR Aging (city ledger)', 'Finance'],
        'F3.2' => ['F3', 'Kas neto dari aktivitas operasi', 'Rp juta', 'higher', 'sum', 0, true, true, 'cfo', 'Arus kas operasi bulanan', 'Laporan arus kas', 'Finance'],
        // Rooms Division
        'C1.1' => ['C1', 'Tingkat hunian kamar (occupancy)', '%', 'higher', 'average', 1, false, true, 'fo', 'Kamar terjual ÷ kamar tersedia × 100', 'PMS — Statistik harian', 'Rooms Division'],
        'C1.2' => ['C1', 'Tarif rata-rata per kamar (ADR)', 'Rp ribu', 'higher', 'average', 0, false, true, 'fo', 'Pendapatan kamar ÷ kamar terjual', 'PMS — Statistik harian', 'Rooms Division'],
        'C1.3' => ['C1', 'Pendapatan per kamar tersedia (RevPAR)', 'Rp ribu', 'higher', 'average', 0, false, false, 'fo', 'Pendapatan kamar ÷ kamar tersedia (= hunian × ADR)', 'PMS — Statistik harian', 'Rooms Division'],
        'C1.4' => ['C1', 'Malam kamar terjual (room nights)', 'malam kamar', 'higher', 'sum', 0, false, false, 'fo', 'Jumlah kamar terjual per malam', 'PMS — Statistik harian', 'Rooms Division'],
        'C1.5' => ['C1', 'No-show & pembatalan terhadap reservasi', '%', 'lower', 'average', 1, false, false, 'fo', '(No-show + pembatalan) ÷ total reservasi × 100', 'PMS — Reservation Report', 'Rooms Division'],
        'C2.1' => ['C2', 'Indeks kepuasan tamu', '%', 'higher', 'average', 1, false, true, 'fo', 'Rata-rata skor survei kepuasan tamu (guest comment & survei pasca-menginap)', 'Survei tamu', 'Rooms Division'],
        'C2.2' => ['C2', 'Rating ulasan online (skala 10)', 'skor', 'higher', 'last', 1, false, false, 'fo', 'Rata-rata tertimbang Google, Booking.com, Traveloka, Tiket.com (dikonversi ke skala 10)', 'Reputation dashboard', 'Rooms Division'],
        'C2.3' => ['C2', 'Keluhan tamu per 1.000 malam kamar', 'rasio', 'lower', 'average', 2, false, false, 'fo', 'Keluhan tercatat ÷ malam kamar terjual × 1.000', 'Logbook FO & ulasan', 'Rooms Division'],
        'C2.4' => ['C2', 'Keluhan diselesaikan ≤ 24 jam', '%', 'higher', 'average', 0, false, false, 'fo', 'Keluhan selesai ≤ 24 jam ÷ total keluhan × 100', 'Logbook FO', 'Rooms Division'],
        // Sales & Marketing
        'C3.1' => ['C3', 'Pendapatan MICE, banquet & wedding', 'Rp juta', 'higher', 'sum', 0, true, true, 'sales', 'Paket meeting, konvensi, pameran, wedding & acara sosial', 'Laporan banquet / BEO', 'Sales & Marketing'],
        'C3.2' => ['C3', 'Jumlah event MICE & sosial terlaksana', 'event', 'higher', 'sum', 0, false, false, 'sales', 'Event terlaksana (meeting, konvensi, wedding, gathering)', 'Banquet Event Order', 'Sales & Marketing'],
        'C3.3' => ['C3', 'Konversi prospek menjadi pemesanan', '%', 'higher', 'average', 1, false, false, 'sales', 'Prospek menjadi pemesanan pasti ÷ total prospek × 100', 'Sales pipeline', 'Sales & Marketing'],
        'C3.4' => ['C3', 'Kontribusi direct booking terhadap pendapatan kamar', '%', 'higher', 'average', 1, false, false, 'sales', 'Pendapatan kamar dari website, WhatsApp, telepon & walk-in ÷ pendapatan kamar × 100', 'PMS — Source of Business', 'Sales & Marketing'],
        // Housekeeping
        'P1.1' => ['P1', 'Waktu penyiapan kamar (check-out → siap jual)', 'menit', 'lower', 'average', 0, false, false, 'hk', 'Rata-rata menit dari status check-out sampai kamar inspected', 'PMS — Room Status / HK log', 'Housekeeping'],
        'P1.2' => ['P1', 'Skor inspeksi kebersihan kamar', '%', 'higher', 'average', 1, false, false, 'hk', 'Rata-rata skor checklist inspeksi supervisor', 'Room inspection checklist', 'Housekeeping'],
        'P1.3' => ['P1', 'Biaya linen & amenitas per malam kamar', 'Rp ribu', 'lower', 'average', 1, true, false, 'hk', 'Biaya linen, laundry & guest supplies ÷ malam kamar terjual', 'Laporan biaya HK', 'Housekeeping'],
        'P1.4' => ['P1', 'Kamar selesai general cleaning', 'kamar', 'higher', 'sum', 0, false, false, 'hk', 'Jumlah kamar selesai general cleaning / deep cleaning', 'Jadwal general cleaning', 'Housekeeping'],
        // F&B Service
        'P2.1' => ['P2', 'Rata-rata belanja per tamu outlet', 'Rp ribu', 'higher', 'average', 0, false, false, 'fb', 'Pendapatan outlet ÷ jumlah cover', 'POS outlet', 'F&B Service'],
        'P2.2' => ['P2', 'Jumlah tamu dilayani outlet (cover)', 'cover', 'higher', 'sum', 0, false, false, 'fb', 'Cover restoran, bar, room service, breakfast', 'POS outlet', 'F&B Service'],
        'P2.3' => ['P2', 'Kepatuhan standar layanan F&B', '%', 'higher', 'average', 1, false, false, 'fb', 'Skor audit layanan / mystery guest', 'Audit standar layanan', 'F&B Service'],
        // Kitchen
        'P3.1' => ['P3', 'Food & beverage cost', '%', 'lower', 'average', 1, true, true, 'chef', '(Persediaan awal + pembelian − persediaan akhir) ÷ pendapatan F&B × 100', 'F&B Reconciliation', 'Kitchen'],
        'P3.2' => ['P3', 'Beverage cost', '%', 'lower', 'average', 1, true, false, 'fb', 'Biaya minuman ÷ pendapatan minuman × 100', 'F&B Reconciliation', 'F&B Service'],
        'P3.3' => ['P3', 'Sisa makanan terbuang terhadap pembelian bahan', '%', 'lower', 'average', 1, false, false, 'chef', 'Nilai waste tercatat ÷ pembelian food × 100', 'Waste log dapur', 'Kitchen'],
        'P3.4' => ['P3', 'Skor audit higiene & keamanan pangan', '%', 'higher', 'average', 1, false, true, 'chef', 'Skor audit HACCP/higiene sanitasi internal', 'Audit higiene', 'Kitchen'],
        // Engineering
        'P4.1' => ['P4', 'Pemeliharaan preventif terlaksana', '%', 'higher', 'average', 0, false, false, 'eng', 'Pekerjaan preventif terlaksana ÷ terjadwal × 100', 'Jadwal PM & work order', 'Engineering'],
        'P4.2' => ['P4', 'Rata-rata waktu perbaikan kerusakan', 'jam', 'lower', 'average', 1, false, false, 'eng', 'Rata-rata jam dari laporan kerusakan sampai selesai', 'Work order', 'Engineering'],
        'P4.3' => ['P4', 'Konsumsi listrik per malam kamar terisi', 'kWh', 'lower', 'average', 1, false, false, 'eng', 'Total kWh ÷ malam kamar terjual', 'Meter PLN & laporan energi', 'Engineering'],
        'P4.4' => ['P4', 'Konsumsi air per malam kamar terisi', 'm³', 'lower', 'average', 2, false, false, 'eng', 'Total m³ air (PDAM + air tanah) ÷ malam kamar terjual', 'Meter air', 'Engineering'],
        // Security & Control
        'P5.1' => ['P5', 'Insiden keamanan & keselamatan', 'kasus', 'lower', 'sum', 0, false, true, 'sec', 'Insiden tamu, karyawan, kehilangan, kebakaran kecil & kecelakaan kerja', 'Incident report', 'Security & Control'],
        'P5.2' => ['P5', 'Latihan darurat & evakuasi terlaksana', 'event', 'higher', 'sum', 0, false, false, 'sec', 'Fire drill & evakuasi yang dilaksanakan dan didokumentasikan', 'Laporan latihan darurat', 'Security & Control', 'semesteran'],
        'P5.3' => ['P5', 'Barang temuan dikembalikan ke pemilik', '%', 'higher', 'average', 0, false, false, 'sec', 'Barang lost & found dikembalikan ÷ barang ditemukan × 100', 'Buku lost & found', 'Security & Control'],
        // Purchasing & Stores
        'P6.1' => ['P6', 'Pesanan pembelian diterima tepat waktu', '%', 'higher', 'average', 0, false, false, 'pur', 'PO diterima sesuai tanggal ÷ total PO × 100', 'Receiving report', 'Purchasing & Stores'],
        'P6.2' => ['P6', 'Perputaran persediaan F&B', 'kali', 'higher', 'average', 1, false, false, 'pur', 'Pemakaian bulanan ÷ rata-rata persediaan', 'Laporan gudang', 'Purchasing & Stores'],
        'P6.3' => ['P6', 'Selisih stock opname', '%', 'lower', 'average', 2, true, false, 'pur', '|Nilai fisik − nilai buku| ÷ nilai buku × 100', 'Berita acara stock opname', 'Purchasing & Stores'],
        'P6.4' => ['P6', 'Penghematan dari negosiasi pengadaan', 'Rp juta', 'higher', 'sum', 0, true, false, 'pur', 'Selisih harga lama vs harga baru × volume', 'Laporan purchasing', 'Purchasing & Stores'],
        // Finance — pelaporan
        'P7.1' => ['P7', 'Laporan keuangan bulanan terbit', 'hari', 'lower', 'average', 0, false, false, 'cfo', 'Jumlah hari setelah tutup bulan sampai laba rugi, arus kas & neraca terbit', 'Accounting', 'Finance'],
        // Human Resources
        'L1.1' => ['L1', 'Jam pelatihan per karyawan', 'jam', 'higher', 'sum', 1, false, false, 'hr', 'Total jam pelatihan ÷ jumlah karyawan', 'Training record', 'Human Resources'],
        'L1.2' => ['L1', 'Karyawan bersertifikat kompetensi (BNSP)', '%', 'higher', 'last', 1, false, false, 'hr', 'Karyawan bersertifikat kompetensi ÷ total karyawan × 100', 'HRIS', 'Human Resources'],
        'L2.1' => ['L2', 'Turnover karyawan', '%', 'lower', 'sum', 2, false, false, 'hr', 'Karyawan keluar ÷ rata-rata jumlah karyawan × 100', 'HRIS', 'Human Resources'],
        'L2.2' => ['L2', 'Tingkat kehadiran karyawan', '%', 'higher', 'average', 1, false, false, 'hr', 'Hari hadir ÷ hari kerja terjadwal × 100', 'Absensi', 'Human Resources'],
        'L2.3' => ['L2', 'Jam lembur per karyawan', 'jam', 'lower', 'average', 1, false, false, 'hr', 'Total jam lembur ÷ jumlah karyawan', 'Absensi & payroll', 'Human Resources'],
        'L2.4' => ['L2', 'Indeks keterlibatan karyawan', 'skor', 'higher', 'last', 0, false, false, 'hr', 'Survei keterlibatan semesteran (skala 100)', 'Survei karyawan', 'Human Resources', 'semesteran'],
        'L3.1' => ['L3', 'Rasio karyawan per kamar', 'rasio', 'lower', 'last', 2, false, false, 'hr', 'Total karyawan ÷ {rooms} kamar', 'HRIS', 'Human Resources'],
        'L3.2' => ['L3', 'Pendapatan per karyawan', 'Rp juta', 'higher', 'sum', 1, false, false, 'cfo', 'Total pendapatan ÷ jumlah karyawan', 'HRIS & laba rugi', 'Finance'],
    ];

    /**
     * Tren bulanan 2026 agar grafik hidup: tiap KPI punya arah tren sendiri (membaik/memburuk, deterministik dari kodenya),
     * ditambah penurunan musiman Maret (Ramadan–Lebaran 2026). Rata-rata Jan–Sep tetap sekitar faktor tahunan.
     */
    protected function actualFactor2026(string $code, string $dir, float $f26, int $month): float
    {
        $drift = ((crc32(static::CODE.$code) % 15) - 5) / 100; // −5% … +9% dari Jan ke Sep
        $better = $drift * ($month - 5) / 4 + ($month === 3 ? -0.035 : 0) + ($month === 7 ? 0.015 : 0);

        return $dir === 'lower' ? $f26 * (1 - $better) : $f26 * (1 + $better);
    }

    protected function kpiDefs(): array
    {
        $nums = $this->kpiNumbers();
        $lt = $this->fromAnnualReport();
        $out = [];
        foreach (self::CATALOG as $code => $c) {
            [$o, $name, $unit, $dir, $agg, $dec, $fin, $crit, $owner, $formula, $source, $dept] = $c;
            [$b24, $t25, $a25, $t26, $f26] = $nums[$code];
            $out[] = [$code, $o, $name, $unit, $dir, $agg, $dec, $fin, $crit, $owner, str_replace('{rooms}', (string) $this->rooms(), $formula),
                $source.' · Laporan bulanan '.$dept, $b24, $t25, $a25, $t26, $f26, in_array($code, $lt, true), $c[12] ?? 'bulanan'];
        }

        return $out;
    }

    // ------------------------------------------------------------------ tinjauan kinerja

    protected function reviews(int $year): array
    {
        $t = $this->reviewTexts();
        $r = [];
        $rec = $this->id('strategi');
        $base = ['venue' => $t['venue'], 'recorded_by' => $rec];
        if ($year === 2025) {
            $r['tahunan'] = PerformanceReview::create($base + [
                'title' => 'Tinjauan Kinerja Tahunan 2025', 'review_type' => 'tahunan', 'review_date' => '2026-01-27', 'period_label' => 'Tahun 2025',
                'chair' => $t['chair'], 'participants' => 'Pemilik/Direksi, General Manager, seluruh kepala departemen',
                'summary' => $t['annual']['summary'], 'decisions' => $t['annual']['decisions'], 'follow_up' => $t['annual']['follow_up'], 'status' => 'final',
            ]);
            ReviewNote::create(['performance_review_id' => $r['tahunan']->id, 'user_id' => $this->id('komisaris'), 'note' => $t['annual']['note']]);
            foreach ([3 => 'Maret', 6 => 'Juni', 9 => 'September'] as $m => $label) {
                $r['q'.$m] = PerformanceReview::create($base + [
                    'title' => 'Tinjauan Kuartalan — '.$label.' 2025', 'review_type' => 'kuartalan', 'review_date' => sprintf('2025-%02d-15', $m + 1),
                    'period_label' => 'Kuartal '.($m / 3).' 2025', 'chair' => $t['chair'], 'participants' => 'GM, Financial Controller, kepala departemen',
                    'summary' => 'Tinjauan laporan akhir bulan 10 departemen dan dasbor manajemen kuartal '.($m / 3).' 2025.',
                    'decisions' => 'Pemilik KPI merah menyampaikan analisis akar masalah dan rencana tindakan pada rapat berikutnya.', 'status' => 'final',
                ]);
            }

            return $r;
        }
        $months = [1 => 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus'];
        foreach ($months as $m => $label) {
            [$sum, $dec] = $t['months'][$m] ?? ['Tinjauan laporan akhir bulan 10 departemen: sasaran merah/kuning dan tindak lanjut keputusan bulan sebelumnya.', 'Lanjutkan rencana tindakan; pemilik KPI merah menyampaikan analisis akar masalah.'];
            $r['rm'.$m] = PerformanceReview::create($base + [
                'title' => 'Rapat Manajemen Akhir Bulan — '.$label.' 2026', 'review_type' => 'rapat_manajemen', 'review_date' => sprintf('2026-%02d-10', $m + 1),
                'period_label' => $label.' 2026', 'chair' => $t['chair'], 'participants' => 'GM & seluruh kepala departemen (10 laporan departemen)',
                'summary' => $sum, 'decisions' => $dec, 'status' => 'final',
            ]);
        }
        foreach ([1 => '2026-04-20', 2 => '2026-07-20'] as $q => $date) {
            [$sum, $dec] = $t['q'.$q];
            $r['q'.$q] = PerformanceReview::create($base + [
                'title' => 'Tinjauan Kuartalan — Kuartal '.$q.' 2026', 'review_type' => 'kuartalan', 'review_date' => $date, 'period_label' => 'Kuartal '.$q.' 2026',
                'chair' => $t['chair'], 'participants' => 'Pemilik/Direksi, GM, Financial Controller, kepala departemen', 'summary' => $sum, 'decisions' => $dec, 'status' => 'final',
            ]);
        }
        [$sum, $dec, $note] = $t['board'];
        $r['boc'] = PerformanceReview::create($base + [
            'title' => 'Rapat Pemilik & Dewan Pengawas — Semester I 2026', 'review_type' => 'rapat_timwas', 'review_date' => '2026-07-28', 'period_label' => 'Semester I 2026',
            'chair' => 'Wakil Pemilik / Dewan Pengawas', 'participants' => 'Pemilik, Dewan Pengawas, GM, Financial Controller', 'summary' => $sum, 'decisions' => $dec, 'status' => 'final',
        ]);
        ReviewNote::create(['performance_review_id' => $r['boc']->id, 'user_id' => $this->id('komisaris'), 'note' => $note]);
        for ($w = 1; $w <= 4; $w++) {
            $r['weekly'.$w] = PerformanceReview::create($base + [
                'title' => 'Laporan Mingguan GM — September 2026 minggu ke-'.$w, 'review_type' => 'weekly_gm', 'review_date' => sprintf('2026-09-%02d', 7 * $w),
                'period_label' => 'Sep 2026 minggu '.$w, 'chair' => 'General Manager', 'participants' => 'GM & kepala departemen',
                'summary' => 'Pickup kamar, pipeline MICE, keluhan tamu, dan biaya F&B minggu ke-'.$w.' (data simulasi).',
                'decisions' => 'Tindak lanjut harian oleh Rooms Division & Sales; Financial Controller memantau food cost mingguan.', 'status' => 'final',
            ]);
        }
        $r['rm9'] = PerformanceReview::create($base + [
            'title' => 'Rapat Manajemen Akhir Bulan — September 2026', 'review_type' => 'rapat_manajemen', 'review_date' => '2026-10-10', 'period_label' => 'September 2026',
            'chair' => $t['chair'], 'participants' => 'GM & seluruh kepala departemen', 'summary' => $t['sep'],
            'decisions' => 'Draf notulen — finalkan setelah seluruh realisasi September disetujui.', 'status' => 'draf',
        ]);

        return $r;
    }

    // ------------------------------------------------------------------ inisiatif (dibangkitkan dari definisi ringkas)

    protected function initiativeData(int $year): array
    {
        $asOf = match ($year) { 2025 => '2025-12-31', 2026 => '2026-11-10', default => '2026-11-10' };
        $defs = $activities = $milestones = $budgets = [];
        foreach ($this->hotelInitiatives($year) as $k => $d) {
            [$code, $title, $desc, $th, $owner, $start, $end, $status, $imp, $urg, $risk, $bud, $objs, $outcome, $capex, $opex, $acts, $mils] = $d;
            $defs[$k] = [$code, $title, $desc, $th, $owner, $start, $end, $status, $imp, $urg, $risk, $bud, $objs, $outcome];
            $s = strtotime($start);
            $e = strtotime($end);
            $n = max(1, count($acts));
            $lag = 0.86 + (crc32(static::CODE.$code) % 16) / 100; // 0,86–1,01: ada yang tepat waktu, ada yang tertinggal
            $progressSum = 0;
            foreach (array_values($acts) as $i => $act) {
                [$name, $who] = is_array($act) ? $act : [$act, $owner];
                $as = $s + (int) (($e - $s) * $i / $n * 0.85);
                $ae = $s + (int) (($e - $s) * ($i + 1) / $n);
                $prog = match (true) {
                    $status === 'selesai' => 100,
                    $status === 'direncanakan' || strtotime($asOf) <= $as => 0,
                    default => (int) min(100, round(max(0, (strtotime($asOf) - $as) / max(1, $ae - $as)) * 100 * $lag / 5) * 5),
                };
                $progressSum += $prog;
                $activities[] = [$k, $name, $who, date('Y-m-d', $as), date('Y-m-d', $ae), $prog];
            }
            $m = max(1, count($mils));
            foreach (array_values($mils) as $i => $mil) {
                $due = date('Y-m-d', $s + (int) (($e - $s) * ($i + 1) / $m));
                $done = $status === 'selesai' || ($status !== 'direncanakan' && $due <= $asOf && ($i + 1) / $m <= $progressSum / $n / 100 + 0.15);
                $milestones[] = [$k, $mil, $due, $done];
            }
            $pct = $progressSum / $n / 100;
            if ($capex > 0) {
                $budgets[] = [$k, 'Belanja modal — '.$title, 'capex', $capex, round($capex * $pct * (0.92 + $lag / 10), -5), null, 'Kas internal'];
            }
            if ($opex > 0) {
                $budgets[] = [$k, 'Biaya pelaksanaan — '.$title, 'opex', $opex, round($opex * $pct * (0.9 + $lag / 10), -5), null, 'Anggaran operasional'];
            }
        }

        return ['defs' => $defs, 'activities' => $activities, 'milestones' => $milestones, 'budgets' => $budgets];
    }

    // ------------------------------------------------------------------ penguatan institusi

    protected function continuityData(int $year): array
    {
        $st = fn (string $s25, string $s26) => $year === 2025 ? $s25 : $s26;

        return [
            'dependencies' => $this->hotelDependencies($year),
            'institutionalizations' => [
                ['Siklus laporan akhir bulan 10 departemen di BSC Hotel', 'sistem', 'Input realisasi KPI tanggal 5 → verifikasi Financial Controller tanggal 7 → persetujuan GM tanggal 8 → rapat manajemen tanggal 10.', 'Bulanan', 'strategi', $st('rencana', 'melembaga')],
                ['Dasbor manajemen akhir bulan (okupansi, ADR, pendapatan, kepuasan tamu)', 'sistem', 'Pusat Kendali Eksekutif menjadi bahan utama rapat manajemen dan laporan ke pemilik.', 'Bulanan', 'dirut', $st('rencana', 'melembaga')],
                ['Rapat revenue harian (pickup, forecast, rate)', 'rapat', 'Rooms Division, Sales & Finance meninjau pickup, forecast 30 hari, dan keputusan harga.', 'Harian', 'fo', $st('berjalan', 'melembaga')],
                ['Briefing harian antar-departemen', 'rapat', 'Briefing pagi: tamu VIP, event hari ini, kamar out-of-order, keluhan terbuka.', 'Harian', 'dirut', 'melembaga'],
                ['Rapat kepala departemen mingguan', 'rapat', 'Tindak lanjut keputusan, pipeline MICE, laporan engineering & security.', 'Mingguan', 'dirut', 'melembaga'],
                ['SOP pengendalian food cost & stock opname bulanan', 'sop', 'Standard recipe, par stock, waste log, stock opname akhir bulan bersama Finance.', 'Bulanan', 'chef', $st('rencana', 'berjalan')],
                ['Jadwal pemeliharaan preventif & work order digital', 'sop', 'Seluruh pekerjaan engineering tercatat; PM terjadwal per peralatan.', 'Mingguan', 'eng', $st('rencana', 'berjalan')],
                ['Program pelatihan & sertifikasi kompetensi', 'pelatihan', 'Kalender pelatihan per departemen, cross-training, sertifikasi BNSP.', 'Bulanan', 'hr', $st('rencana', 'berjalan')],
                ['Latihan darurat & audit keamanan', 'sop', 'Fire drill, evakuasi, audit kunci & akses, uji CCTV.', 'Semesteran', 'sec', 'berjalan'],
                ['Tinjauan kuartalan bersama pemilik & pengawas', 'rapat', 'Tinjauan kinerja, risiko, dan keputusan investasi.', 'Kuartalan', 'komisaris', 'berjalan'],
                ['Budaya layanan & penghargaan karyawan teladan', 'budaya', 'Employee of the month berdasarkan pujian tamu dan kinerja KPI.', 'Bulanan', 'hr', $st('rencana', 'berjalan')],
                ['Kebijakan pengadaan & persetujuan PR berjenjang', 'kebijakan', 'Tiga penawaran untuk pembelian di atas batas tertentu; persetujuan di sistem.', 'Berkelanjutan', 'pur', $st('berjalan', 'melembaga')],
            ],
        ];
    }

    // ------------------------------------------------------------------ perioda 2027 (perencanaan)

    public function run(): Company
    {
        $company = parent::run();
        $p2026 = AnalysisPeriod::where('company_id', $company->id)->where('code', '2026')->firstOrFail();
        $p2027 = AnalysisPeriod::updateOrCreate(['company_id' => $company->id, 'code' => '2027'], [
            'name' => 'Tahun 2027', 'year' => 2027, 'start_date' => '2027-01-01', 'end_date' => '2027-12-31', 'status' => 'perencanaan', 'is_active' => false,
            'notes' => 'Perencanaan 2027: target KPI, inisiatif, dan RKAP disusun dari proyeksi akhir 2026 (data demo).',
        ]);
        $ctx = app(DhastramContext::class);
        $ctx->set($company->id, $p2027->id);
        $this->identity(2027);
        $issues = $this->ecosystem(2027);
        [$themes, $obj] = $this->strategy(2027);
        $this->kpis2027($obj);
        $this->initiatives(2027, $themes, $obj);
        $this->tows($issues);
        foreach ($this->hotelDependencies(2027) as [$title, $type, $iniKey, $objKey, $dep, $desc, $owner, $risk, $mit]) {
            // inisiatif 2027 dicari lewat kode di tabel karena initiatives() tidak mengembalikan kunci di sini
            $ini = \App\Models\StrategicInitiative::where('code', $this->hotelInitiatives(2027)[$iniKey][0])->first();
            StrategicDependency::create(['title' => $title, 'dependency_type' => $type, 'strategic_initiative_id' => $ini?->id, 'strategic_objective_id' => $obj[$objKey]->id,
                'depends_on' => $dep, 'description' => $desc, 'owner_id' => $this->id($owner), 'risk_level' => $risk, 'mitigation' => $mit, 'status' => 'aktif']);
        }
        foreach ($this->continuityData(2027)['institutionalizations'] as [$title, $type, $desc, $freq, $owner, $status]) {
            Institutionalization::create(['title' => $title, 'mechanism_type' => $type, 'description' => $desc, 'frequency' => $freq, 'owner_id' => $this->id($owner),
                'status' => $status, 'evidence' => null, 'started_at' => '2027-01-02', 'next_review_date' => '2027-06-30']);
        }
        $t = $this->reviewTexts();
        PerformanceReview::create(['title' => 'Rapat Penyusunan RKAP & BSC 2027', 'review_type' => 'tahunan', 'review_date' => '2026-11-20', 'period_label' => 'Perencanaan 2027',
            'chair' => $t['chair'], 'venue' => $t['venue'], 'participants' => 'Pemilik/Direksi, GM, seluruh kepala departemen',
            'summary' => $t['plan2027'], 'decisions' => 'Draf target 2027 dibahas per departemen; finalisasi pada rapat Desember 2026.', 'status' => 'draf', 'recorded_by' => $this->id('strategi')]);

        foreach ($this->u as $user) {
            UserContext::updateOrCreate(['user_id' => $user->id], ['company_id' => $company->id, 'analysis_period_id' => $p2026->id]);
        }
        $ctx->set($company->id, $p2026->id);

        return $company;
    }

    /** KPI 2027: target bulanan dari target tahunan 2027, baseline = proyeksi akhir 2026; belum ada realisasi. */
    protected function kpis2027(array $obj): void
    {
        $nums = $this->kpiNumbers();
        $w = $this->season()[2026];
        foreach (self::CATALOG as $code => $c) {
            [$o, $name, $unit, $dir, $agg, $dec, $fin, $crit, $owner, $formula, $source, $dept] = $c;
            $freq = $c[12] ?? 'bulanan';
            [, , , $t26, $f26] = $nums[$code];
            $t27 = $nums[$code][5] ?? ($dir === 'lower' ? $t26 * 0.95 : $t26 * $this->growth2027());
            if ($unit === '%' && $dir === 'higher') {
                $t27 = min($t27, 100);
            }
            $t27 = round($t27, $dec);
            $baseline = round($t26 * $f26, $dec);
            $kpi = Kpi::create([
                'code' => $code, 'strategic_objective_id' => $obj[$o]->id, 'name' => $name, 'unit' => $unit, 'direction' => $dir, 'aggregation' => $agg,
                'frequency' => $freq, 'owner_id' => $this->id($owner), 'weight' => 1, 'is_financial' => $fin, 'is_critical' => $crit, 'decimals' => $dec,
                'baseline' => $baseline, 'annual_target' => $t27, 'formula' => str_replace('{rooms}', (string) $this->rooms(), $formula),
                'data_source' => $source.' · Laporan bulanan '.$dept,
                'description' => 'DATA DEMO. Target 2027 (draf RKAP) — baseline adalah proyeksi akhir 2026.', 'is_active' => true,
            ]);
            $months = $freq === 'semesteran' ? [6, 12] : range(1, 12);
            $sum = 0;
            foreach ($months as $m) {
                $v = round(match ($agg) {
                    'sum' => count($months) === 12 ? $t27 * $w[$m] : $t27 / count($months),
                    'average' => $t27,
                    default => $baseline + ($t27 - $baseline) * $m / 12,
                }, $dec);
                if ($agg === 'sum' && $m === 12) {
                    $v = round($t27 - $sum, $dec);
                }
                $sum += $v;
                KpiTarget::create(['kpi_id' => $kpi->id, 'month' => $m, 'target' => $v]);
            }
        }
    }
}
