<?php

namespace Database\Seeders;

use App\Models\AtmanProfile;
use App\Models\Capability;
use App\Models\Competitor;
use App\Models\CoreValue;
use App\Models\EnvironmentScan;
use App\Models\IndustryForce;
use App\Models\MarketAnalysis;
use App\Models\PestelAnalysis;
use App\Models\Regulation;
use App\Models\Stakeholder;
use App\Models\StrategicIssue;
use App\Models\SwotItem;
use App\Models\TowsStrategy;

/**
 * Demo PT Sunter Lakeside Hotel Tbk (kode SNLK) — Sunlake Hotel, Sunter, Jakarta Utara (family hotel, 228 kamar).
 *
 * Angka 2025 & 2024 mengacu pada Laporan Tahunan 2025: pendapatan Rp46,0 M (2024: Rp52,8 M; target 2025 Rp65,8 M),
 * kamar Rp24,3 M, F&B Rp19,5 M, lain-lain Rp2,3 M; 45.855 malam kamar (≈ hunian 55%, ADR ≈ Rp529 ribu);
 * rugi Rp4,46 M (2024: Rp1,58 M); kas operasi Rp8,8 M; 179 karyawan (2024: 195).
 * Target 2026 (laporan tahunan): pendapatan Rp53,2 M, rugi bersih Rp0,99 M.
 * KPI non-keuangan, rincian bulanan, dan seluruh data 2026–2027 adalah simulasi.
 */
class SunlakeSeeder extends HotelShowcaseSeeder
{
    public const CODE = 'SNLK';

    public const PREFIX = 'snlk';

    public const SHORT = 'Sunlake';

    public const LT = 'Laporan Tahunan 2025 PT Sunter Lakeside Hotel Tbk';

    protected function rooms(): int
    {
        return 228;
    }

    protected function companyAttributes(): array
    {
        return [
            'name' => 'PT Sunter Lakeside Hotel Tbk', 'legal_name' => 'PT Sunter Lakeside Hotel Tbk',
            'industry' => 'Hotel keluarga bintang 4 & MICE (Sunlake Hotel Jakarta)',
            'address' => 'Jl. Danau Permai Raya Blok C1, Sunter', 'city' => 'Jakarta Utara', 'phone' => '+62 21 6530 8000', 'website' => 'https://www.sunlakehotel.com',
            'description' => 'DATA DEMO untuk pembelajaran (kode saham SNLK). Angka 2025 secara garis besar mengacu pada Laporan Tahunan 2025; KPI operasional, rincian bulanan, data 2026 dan 2027 adalah simulasi. Bukan data resmi perusahaan.',
        ];
    }

    protected function periodNote(int $year): string
    {
        return $year === 2025
            ? 'DATA DEMO. Realisasi tahunan mengacu pada Laporan Tahunan 2025; rincian bulanan ilustratif.'
            : 'DATA DEMO — SIMULASI 2026 (target pendapatan Rp53,2 M dari laporan tahunan): Jan–Agu disetujui, Sep dalam proses.';
    }

    protected function season(): array
    {
        // Hotel keluarga: puncak libur sekolah (Jun–Jul) & akhir tahun; Ramadan/Lebaran rendah.
        return [
            2025 => self::weights([1 => 7.8, 7.4, 6.4, 7.6, 8.2, 9.4, 9.6, 8.0, 7.9, 8.3, 8.6, 10.8]),
            2026 => self::weights([1 => 7.6, 6.8, 6.9, 8.0, 8.3, 9.5, 9.7, 8.1, 8.0, 8.3, 8.4, 10.4]),
        ];
    }

    protected function onTrack2026(): array
    {
        return ['C1.2', 'C2.2', 'C2.4', 'P1.2', 'P2.1', 'P3.4', 'P5.2', 'P5.3', 'L2.2', 'F2.2', 'C3.4', 'P6.1', 'L1.2'];
    }

    protected function missingSeptember(): array
    {
        return ['P4.1', 'L2.4'];
    }

    protected function returnedSeptember(): ?array
    {
        return ['C1.5', 'Data pembatalan September belum memisahkan pembatalan grup sekolah yang dijadwal ulang. Pisahkan reschedule dari pembatalan murni.'];
    }

    protected function criticalIn2026(): array
    {
        return ['F3.1'];
    }

    protected function maturityPattern(): array
    {
        return [3, 2, 2, 3, 2];
    }

    // ------------------------------------------------------------------ jati diri

    protected function identity(int $year): void
    {
        AtmanProfile::create([
            'vision' => 'Satisfaction is Our Commitment — kepuasan tamu adalah komitmen kami.',
            'mission' => 'Berkomitmen untuk berusaha memberikan layanan yang paling efisien, cepat, dan ramah kepada tamu.',
            'purpose' => 'Menjadi tempat menginap dan berkumpul keluarga favorit di Jakarta Utara, dengan pemandangan Danau Sunter.',
            'tagline' => 'Your Family Lakeside Retreat in North Jakarta',
            'brand_promise' => 'Kamar lapang berbalkon menghadap danau, layanan cepat dan ramah, nyaman untuk keluarga dan acara.',
            'value_proposition' => 'Family hotel di tepi Danau Sunter dengan Longstay Room berdapur, grand ballroom untuk MICE & wedding, dekat Mall of Indonesia, Mall Artha Gading, dan Mall Kelapa Gading.',
            'culture_statement' => 'Cepat, ramah, efisien: setiap tamu dilayani seperti keluarga sendiri, dan setiap rupiah dikelola dengan disiplin.',
            'history' => "Perseroan mengoperasikan Sunlake Hotel di kawasan Sunter, Jakarta Utara.\nPengembangan sayap baru menambah 84 kamar dan grand ballroom.\n2024: pendapatan Rp52,8 M, 48.109 malam kamar.\n2025: permintaan perjalanan dinas pemerintah melemah; pendapatan Rp46,0 M.\n2026: program pemulihan pendapatan & efisiensi biaya.",
            'approved_by' => $this->id('dirut'), 'approved_at' => ($year === 2027 ? 2026 : $year).'-01-22 10:00:00',
        ]);
        foreach ([
            ['Integritas', 'Integrity', 'Jujur dan bertanggung jawab atas setiap pekerjaan.', "Melaporkan data apa adanya\nMenjaga uang dan aset hotel"],
            ['Disiplin', 'Discipline', 'Taat waktu, SOP, dan anggaran.', "Tepat waktu di setiap shift\nMengikuti SOP tanpa jalan pintas"],
            ['Kelincahan', 'Agility', 'Cepat menyesuaikan diri dengan kebutuhan tamu dan pasar.', "Respons permintaan tamu ≤ 10 menit\nCepat mencoba paket baru"],
            ['Kerja Sama Tim', 'Teamwork', 'Saling mendukung lintas departemen.', "Bantu departemen lain saat okupansi penuh\nBriefing harian bersama"],
            ['Perbaikan Berkelanjutan', 'Continuous Improvement', 'Selalu mencari cara kerja yang lebih baik.', "Usulan perbaikan tiap bulan\nBelajar dari keluhan tamu"],
        ] as $i => [$name, $local, $desc, $beh]) {
            CoreValue::create(['name' => $name, 'local_name' => $local, 'description' => $desc, 'behaviors' => $beh, 'sort' => $i + 1]);
        }
        $up = $year === 2025 ? 0 : 1;
        foreach ([
            ['Lokasi tepi Danau Sunter', 'Sumber daya fisik', 'Pemandangan danau; dekat MOI, MAG, MKG, dan kawasan industri Sunter.', 5, 5, true, 'Paket keluarga & staycation bertema danau.'],
            ['Kamar berbalkon & Longstay Room berdapur', 'Sumber daya fisik', '228 kamar; tipe longstay untuk ekspatriat & keluarga.', 4, 4, true, 'Paket bulanan untuk proyek & ekspatriat.'],
            ['Grand ballroom & ruang rapat', 'Sumber daya fisik', 'Sayap baru dengan grand ballroom untuk MICE & wedding.', 4, 5, true, 'Paket wedding & korporat swasta.'],
            ['Layanan keluarga yang ramah', 'Kompetensi', 'Kids club, kolam renang, sarapan keluarga.', 3 + $up, 4, true, 'Program family weekend.'],
            ['Jaringan korporat Sunter & Kelapa Gading', 'Kompetensi', 'Kedekatan dengan industri otomotif & logistik.', 3, 4, false, 'Account manager korporat.'],
            ['Revenue management & kanal digital', 'Sistem', 'Pengelolaan harga & OTA masih manual.', 2 + $up, 4, false, 'Channel manager & RMS.'],
            ['Pengendalian biaya & persediaan', 'Sistem', 'Food cost & energi dipantau bulanan.', 2 + $up, 4, false, 'Dasbor biaya harian.'],
        ] as [$name, $cat, $desc, $cur, $tgt, $core, $gap]) {
            Capability::create(['name' => $name, 'category' => $cat, 'description' => $desc, 'current_level' => $cur, 'target_level' => $tgt, 'is_core' => $core, 'gap_action' => $gap]);
        }
    }

    // ------------------------------------------------------------------ lingkungan

    protected function ecosystem(int $year): array
    {
        foreach ([
            ['Kondisi industri & pasar Jakarta Utara 2025', '2026-01-21', 'eksternal', self::LT.' — Tinjauan Industri',
                'Permintaan perjalanan dinas pemerintah melemah akibat efisiensi anggaran; segmen keluarga & korporat swasta relatif stabil.',
                'Geser bauran ke keluarga, korporat swasta, dan wedding.'],
            ['Kinerja internal 2025', '2026-01-29', 'internal', self::LT.' — Ikhtisar Keuangan',
                'Pendapatan Rp46,0 M (−12,9%; 70% target Rp65,8 M). Rugi Rp4,46 M (2024: Rp1,58 M). Laba kotor Rp25,5 M; kas operasi Rp8,8 M.',
                'Pemulihan volume & disiplin biaya.'],
            ['Pendapatan per segmen usaha 2025', '2026-01-29', 'internal', self::LT.' — Catatan Pendapatan',
                'Kamar Rp24,3 M (2024: Rp25,3 M); F&B Rp19,5 M (2024: Rp24,9 M); lain-lain Rp2,3 M. Malam kamar 45.855 (2024: 48.109).',
                'F&B/banquet turun paling dalam — perlu MICE swasta & wedding.'],
            ['Target 2026', '2026-02-06', 'internal', self::LT.' — Prospek Usaha',
                'Target pendapatan Rp53,2 M dan rugi bersih ≤ Rp0,99 M.', 'Turunkan ke sasaran & inisiatif BSC per departemen.'],
            ['Persaingan hotel Kelapa Gading–Sunter', '2026-03-10', 'eksternal', 'Analisis manajemen (ilustrasi)',
                'Hotel baru di Kelapa Gading & PIK menawarkan harga promosi; OTA makin dominan.', 'Diferensiasi family & lakeside; direct booking.'],
            ['Arah 2027: BSC berbasis laporan 10 departemen', '2026-11-10', 'internal', 'Rencana manajemen 2027 (simulasi)',
                'Laporan akhir bulan 10 departemen menjadi dasar KPI dan dasbor manajemen 2027.', 'Susun target 2027 per departemen.'],
        ] as [$title, $date, $scope, $source, $summary, $impl]) {
            if ($year === 2025 && $date >= '2026-02-01') {
                continue;
            }
            EnvironmentScan::create(compact('title', 'scope', 'source', 'summary') + ['scan_date' => $year === 2025 ? '2025-01-21' : $date, 'implications' => $impl, 'status' => 'aktif', 'created_by' => $this->id('strategi')]);
        }

        foreach ([
            ['politik', 'Efisiensi anggaran perjalanan dinas', 'Rapat & menginap instansi berkurang.', 'ancaman', 4, 5, 'naik', 'Diversifikasi ke keluarga & korporat swasta.'],
            ['ekonomi', 'Kawasan industri & logistik Sunter–Tanjung Priok', 'Permintaan korporat & longstay proyek.', 'peluang', 4, 4, 'naik', 'Corporate & longstay rate.'],
            ['ekonomi', 'Daya beli kelas menengah', 'Staycation keluarga sensitif harga.', 'ancaman', 3, 3, 'stabil', 'Paket bernilai tambah.'],
            ['sosial', 'Staycation keluarga & libur sekolah', 'Keluarga Jakarta mencari liburan dekat rumah.', 'peluang', 4, 4, 'naik', 'Family weekend & kids club.'],
            ['sosial', 'Pernikahan & acara komunitas Jakarta Utara', 'Permintaan ballroom untuk wedding & komunitas.', 'peluang', 4, 4, 'stabil', 'Paket wedding grand ballroom.'],
            ['teknologi', 'Dominasi OTA & ulasan online', 'Ulasan sangat menentukan pilihan keluarga.', 'ancaman', 3, 5, 'naik', 'Manajemen reputasi & direct booking.'],
            ['teknologi', 'Channel manager & revenue management', 'Harga dinamis meningkatkan RevPAR.', 'peluang', 3, 4, 'naik', 'Implementasi RMS.'],
            ['lingkungan', 'Banjir rob & genangan Jakarta Utara', 'Risiko akses & kerusakan fasilitas.', 'ancaman', 4, 3, 'naik', 'Pompa & rencana kontinjensi.'],
            ['lingkungan', 'Kualitas air Danau Sunter', 'Mempengaruhi daya tarik pemandangan.', 'ancaman', 2, 3, 'stabil', 'Kerja sama pengelola danau.'],
            ['hukum', 'Pajak daerah DKI (PBJT)', 'Kepatuhan pajak hotel & F&B.', 'ancaman', 3, 4, 'stabil', 'Rekonsiliasi bulanan.'],
            ['hukum', 'Kewajiban laporan keberlanjutan (POJK 51)', 'Data energi, air, SDM wajib terukur.', 'ancaman', 2, 5, 'stabil', 'Data ESG di BSC.'],
        ] as [$factor, $title, $desc, $type, $impact, $like, $trend, $resp]) {
            PestelAnalysis::create(['factor' => $factor, 'title' => $title, 'description' => $desc, 'impact_type' => $type, 'impact_level' => $impact, 'likelihood' => $like, 'trend' => $trend, 'response' => $resp, 'source' => self::LT.' & analisis manajemen (ilustrasi)']);
        }

        foreach ([
            ['persaingan', 'Hotel bintang 3–4 di Kelapa Gading & PIK', 'Hotel baru dengan harga promosi.', 4, 'Diferensiasi lakeside & family.'],
            ['kekuatan_pembeli', 'OTA & korporat menekan harga', 'Komisi OTA & negosiasi corporate rate.', 4, 'Direct booking & kontrak volume.'],
            ['kekuatan_pemasok', 'Kenaikan harga bahan pangan & listrik', 'Menekan margin F&B.', 3, 'Kontrak pemasok & efisiensi energi.'],
            ['pendatang_baru', 'Apartemen sewa harian', 'Alternatif murah untuk keluarga.', 3, 'Layanan hotel & fasilitas keluarga.'],
            ['produk_pengganti', 'Gedung serbaguna & restoran untuk acara', 'Venue non-hotel untuk wedding.', 3, 'Paket all-in wedding.'],
        ] as [$force, $title, $desc, $int, $impl]) {
            IndustryForce::create(['force' => $force, 'title' => $title, 'description' => $desc, 'intensity' => $int, 'implication' => $impl]);
        }

        foreach ([
            ['Keluarga & leisure', 'Leisure', 'Staycation, libur sekolah, akhir pekan.', 30, 'naik', true, 'Kamar lapang, kolam, kids club.', 'Family weekend & paket sekolah.'],
            ['Korporat swasta (otomotif, logistik)', 'Korporasi', 'Tamu bisnis & rapat perusahaan sekitar Sunter.', 25, 'naik', true, 'Akses dekat, harga stabil.', 'Corporate rate & account manager.'],
            ['Pemerintah', 'MICE', 'Rapat & menginap instansi.', 12, 'turun', false, 'Sesuai SBM.', 'Pertahankan akun utama saja.'],
            ['Wedding & komunitas', 'Sosial', 'Pernikahan & acara komunitas di grand ballroom.', 15, 'naik', true, 'Ballroom & katering.', 'Paket wedding & WO mitra.'],
            ['OTA individu', 'OTA', 'Tamu individu via OTA.', 13, 'stabil', true, 'Harga & ulasan.', 'Rating ≥ 8,6 & promosi musiman.'],
            ['Longstay & ekspatriat', 'Longstay', 'Proyek & ekspatriat di Longstay Room.', 5, 'naik', true, 'Dapur, laundry, harga bulanan.', 'Paket bulanan.'],
        ] as [$seg, $grp, $desc, $share, $growth, $target, $needs, $strat]) {
            MarketAnalysis::create(['segment' => $seg, 'segment_group' => $grp, 'description' => $desc, 'share_percent' => $share, 'growth' => $growth, 'is_target' => $target, 'needs' => $needs, 'strategy' => $strat, 'source' => 'Porsi ilustrasi (data demo)']);
        }

        foreach ([
            ['Sunlake Hotel', 'Bintang 4', 228, 2, 55.1, 529300, 291600, 0.96, 0.98, 0.98, 4.4, 4.2, 8.5, 8.3, 8.6, true, 'Lakeside, kamar berbalkon, ballroom, dekat mall.', 'Rugi 2025; ketergantungan dinas pemerintah.'],
            ['Hotel bintang 4 Kelapa Gading (pembanding)', 'Bintang 4', 300, 1, 68.0, 620000, 421600, 1.20, 1.10, 1.09, 4.5, 4.3, 8.6, 8.5, 8.7, false, 'Brand jaringan, dekat mall.', 'Ballroom lebih kecil.'],
            ['Hotel bintang 3 Sunter (pembanding)', 'Bintang 3', 180, 3, 62.0, 420000, 260400, 0.85, 1.05, 0.81, 4.3, 4.1, 8.3, 8.2, 8.4, false, 'Harga murah.', 'Fasilitas terbatas.'],
            ['Hotel bintang 4 PIK (pembanding)', 'Bintang 4', 250, 4, 58.0, 650000, 377000, 1.05, 0.98, 1.07, 4.6, 4.4, 8.8, 8.7, 8.8, false, 'Produk baru, kawasan wisata.', 'Akses lebih jauh.'],
        ] as [$name, $cat, $rooms, $rank, $occ, $arr, $revpar, $rgi, $mpi, $ari, $g, $ta, $tv, $bk, $tk, $self, $str, $weak]) {
            Competitor::create(['name' => $name, 'category' => $cat, 'room_count' => $rooms, 'rank' => $rank, 'data_period' => $self ? 'FY2025 (laporan tahunan)' : 'Ilustrasi pembanding',
                'occupancy' => $occ, 'arr' => $arr, 'revpar' => $revpar, 'rgi' => $rgi, 'mpi' => $mpi, 'ari' => $ari, 'revenue' => $self ? 46.0 : null, 'revenue_growth' => $self ? -12.9 : null, 'net_margin' => $self ? -9.7 : null,
                'rating_google' => $g, 'rating_tripadvisor' => $ta, 'rating_traveloka' => $tv, 'rating_booking' => $bk, 'rating_tiket' => $tk,
                'is_self' => $self, 'strengths' => $str, 'weaknesses' => $weak, 'notes' => $self ? 'Angka dari '.self::LT.' (pendapatan Rp miliar; hunian & ADR dihitung dari malam kamar).' : 'Pembanding ilustrasi untuk demo; ganti dengan data STR/benchmark.']);
        }

        foreach ([
            ['Pedoman Tata Kelola Perusahaan Terbuka', 'OJK', 'SEOJK No. 32/SEOJK.04/2015', 'Tata kelola', '2015-11-17', 'Pedoman GCG emiten.', 'Wajib diungkap di laporan tahunan.', 'patuh', 'strategi', null],
            ['Laporan keberlanjutan emiten', 'OJK', 'POJK No. 51/POJK.03/2017', 'Keberlanjutan', '2017-07-27', 'Laporan keberlanjutan tahunan.', 'Data energi, air, SDM terukur.', 'sebagian', 'strategi', '2026-12-31'],
            ['PBJT perhotelan & makanan-minuman', 'Pemprov DKI Jakarta', 'UU No. 1 Tahun 2022 & Perda DKI', 'Pajak', null, 'Pajak daerah atas jasa hotel & F&B.', 'Rekonsiliasi bulanan.', 'patuh', 'cfo', null],
            ['Standar usaha hotel', 'Kementerian Pariwisata', 'Permenparekraf No. 4 Tahun 2021', 'Perizinan', null, 'Sertifikat usaha hotel.', 'Pemeliharaan standar.', 'patuh', 'dirut', null],
            ['Proteksi kebakaran & SLF', 'Pemprov DKI (Damkar)', 'Pergub DKI tentang SLF & proteksi kebakaran', 'Keselamatan', null, 'Sertifikat Laik Fungsi gedung.', 'Audit berkala.', 'patuh', 'sec', null],
            ['Jaminan produk halal', 'BPJPH', 'UU No. 33 Tahun 2014', 'F&B', null, 'Sertifikasi halal dapur & banquet.', 'Syarat wedding & korporat.', 'sebagian', 'chef', '2026-10-17'],
        ] as [$title, $issuer, $ref, $cat, $eff, $desc, $impact, $status, $owner, $due]) {
            Regulation::create(['title' => $title, 'issuer' => $issuer, 'reference_no' => $ref, 'category' => $cat, 'effective_date' => $eff, 'description' => $desc, 'impact' => $impact, 'compliance_status' => $status, 'owner_id' => $this->id($owner), 'due_date' => $due]);
        }

        $sh = [];
        foreach ([
            'saham' => ['Pemegang saham & investor (SNLK)', 'internal', 'Pemilik', 5, 4, 'Kembali laba.', 'RUPS & paparan publik.', 'Sekretaris Perusahaan'],
            'komisaris' => ['Dewan Komisaris & Komite Audit', 'internal', 'Pengawas', 5, 5, 'Pengendalian & kinerja.', 'Rapat kuartalan.', 'Sekretaris Perusahaan'],
            'karyawan' => ['Karyawan (179 orang)', 'internal', 'SDM', 4, 4, 'Kesejahteraan & karier.', 'Town hall & pelatihan.', 'HR'],
            'keluarga' => ['Tamu keluarga & leisure', 'eksternal', 'Pelanggan', 4, 4, 'Kamar lapang & aktivitas anak.', 'Survei tamu & program loyalitas.', 'Rooms Division'],
            'korporat' => ['Korporasi sekitar Sunter', 'eksternal', 'Pelanggan', 4, 4, 'Harga stabil & layanan cepat.', 'Account manager.', 'Sales'],
            'ota' => ['OTA & travel agent', 'eksternal', 'Mitra', 4, 3, 'Ketersediaan & harga.', 'Kontrak & promosi bersama.', 'Sales'],
            'regulator' => ['Regulator (OJK, BEI, Pemprov DKI)', 'eksternal', 'Regulator', 5, 3, 'Kepatuhan & pelaporan.', 'Pelaporan tepat waktu.', 'Sekretaris Perusahaan'],
            'pemasok' => ['Pemasok F&B & utilitas', 'eksternal', 'Pemasok', 3, 4, 'Pembayaran tepat waktu.', 'Evaluasi pemasok.', 'Purchasing'],
            'masyarakat' => ['Warga & pengelola Danau Sunter', 'eksternal', 'Komunitas', 2, 3, 'Lingkungan bersih.', 'Kerja bakti & CSR.', 'HR'],
        ] as $key => [$name, $type, $cat, $infl, $int, $exp, $strat, $cp]) {
            $sh[$key] = Stakeholder::create(['name' => $name, 'type' => $type, 'category' => $cat, 'influence' => $infl, 'interest' => $int, 'expectations' => $exp, 'engagement_strategy' => $strat, 'contact_person' => $cp]);
        }

        $issues = [];
        foreach ([
            'gov' => ['Permintaan dinas pemerintah melemah', 'Pendapatan 2025 hanya 70% target; banquet & kamar dinas turun.', 'pelanggan', 5, 5, 'sales', ['korporat', 'saham']],
            'fnb' => ['F&B & banquet turun 22%', 'F&B Rp19,5 M (2024: Rp24,9 M).', 'keuangan', 4, 5, 'fb', ['saham']],
            'loss' => ['Rugi bersih membesar', 'Rugi Rp4,46 M (2024: Rp1,58 M); target 2026 rugi ≤ Rp0,99 M.', 'keuangan', 5, 5, 'cfo', ['saham', 'komisaris']],
            'ota' => ['Ketergantungan OTA', 'Komisi OTA menekan pendapatan kamar bersih.', 'pelanggan', 3, 4, 'sales', ['ota', 'keluarga']],
            'cost' => ['Biaya tenaga kerja & energi tinggi', 'Biaya tenaga kerja ±37% pendapatan.', 'proses', 4, 4, 'hr', ['karyawan']],
            'ar' => ['Piutang korporat & instansi menua', 'Piutang > 60 hari meningkat.', 'keuangan', 4, 4, 'cfo', ['korporat']],
            'flood' => ['Risiko banjir rob', 'Genangan mengganggu akses & fasilitas.', 'proses', 3, 4, 'eng', ['keluarga', 'masyarakat']],
        ] as $key => [$title, $desc, $persp, $urg, $imp, $owner, $stks]) {
            $issues[$key] = StrategicIssue::create(['title' => $title, 'description' => $desc, 'perspective' => $persp, 'urgency' => $urg, 'impact' => $imp, 'status' => 'ditangani', 'source' => self::LT.' & analisis manajemen', 'owner_id' => $this->id($owner)]);
            $issues[$key]->stakeholders()->sync(collect($stks)->map(fn ($s) => $sh[$s]->id));
        }

        $sort = 0;
        foreach ([
            ['S', 'Lokasi tepi Danau Sunter dekat 3 mall besar', 'Daya tarik keluarga & bisnis.', 0.15, 4],
            ['S', 'Kamar berbalkon & Longstay Room', 'Produk unik untuk keluarga & longstay.', 0.10, 3],
            ['S', 'Grand ballroom sayap baru', 'Kapasitas wedding & MICE.', 0.10, 4],
            ['S', 'Hunian relatif stabil (±55%)', 'Turun lebih kecil dibanding pendapatan.', 0.05, 3],
            ['W', 'Ketergantungan pada dinas pemerintah', 'Segmen paling terdampak efisiensi.', 0.12, 1],
            ['W', 'Biaya tenaga kerja tinggi', '±37% pendapatan.', 0.10, 2],
            ['W', 'Revenue management manual', 'Harga kurang dinamis.', 0.06, 2],
            ['O', 'Staycation keluarga & libur sekolah', 'Pasar Jakarta Utara besar.', 0.08, 3],
            ['O', 'Korporat otomotif & logistik Sunter', 'Permintaan rapat & longstay.', 0.08, 3],
            ['O', 'Wedding komunitas Jakarta Utara', 'Ballroom terisi akhir pekan.', 0.06, 3],
            ['T', 'Efisiensi anggaran pemerintah', 'Segmen dinas berkurang.', 0.10, 2],
            ['T', 'Hotel baru Kelapa Gading & PIK', 'Persaingan harga.', 0.08, 2],
            ['T', 'Banjir rob', 'Gangguan operasional.', 0.05, 2],
        ] as [$type, $title, $desc, $w, $r]) {
            SwotItem::create(['type' => $type, 'title' => $title, 'description' => $desc, 'weight' => $w, 'rating' => $r, 'sort' => ++$sort, 'source' => self::LT.' & analisis manajemen']);
        }

        return $issues;
    }

    protected function tows(array $issues): void
    {
        foreach ([
            ['SO', 'Family Lakeside Weekend & paket libur sekolah', 'Manfaatkan lokasi danau & kamar lapang untuk keluarga.', 5, ['gov', 'ota']],
            ['SO', 'Grand ballroom untuk wedding & MICE swasta', 'Isi ballroom akhir pekan & hari kerja.', 5, ['fnb', 'gov']],
            ['WO', 'Revenue management & channel manager', 'Harga dinamis, kurangi ketergantungan OTA.', 4, ['ota', 'loss']],
            ['WO', 'Longstay korporat otomotif & logistik', 'Kontrak bulanan perusahaan sekitar Sunter.', 4, ['gov']],
            ['ST', 'Direct booking & manajemen reputasi', 'Rating tinggi melawan hotel baru.', 4, ['ota']],
            ['WT', 'Efisiensi biaya tenaga kerja & energi', 'Multi-skilling & retrofit energi.', 5, ['cost', 'loss']],
            ['WT', 'Penagihan piutang terstruktur', 'Batas kredit & penagihan mingguan.', 4, ['ar', 'loss']],
            ['WT', 'Rencana kontinjensi banjir', 'Pompa, tanggul kecil, SOP evakuasi.', 3, ['flood']],
        ] as [$type, $title, $desc, $prio, $iss]) {
            $t = TowsStrategy::create(['type' => $type, 'title' => $title, 'description' => $desc, 'priority' => $prio, 'status' => 'dipilih']);
            $t->issues()->sync(collect($iss)->map(fn ($k) => $issues[$k]->id));
        }
    }

    protected function themeDefs(): array
    {
        return [
            'T1' => ['Family & Lakeside Experience', 'Pengalaman keluarga di tepi danau: kamar, kolam, kids club, sarapan.', '#1F6F8B'],
            'T2' => ['Pemulihan Pendapatan: MICE Swasta, Wedding & Korporat', 'Isi ballroom dan kamar dari segmen non-pemerintah.', '#C0792B'],
            'T3' => ['Efisiensi & Disiplin Biaya', 'Biaya tenaga kerja, energi, F&B cost, dan piutang terkendali.', '#2F5D50'],
            'T4' => ['Tim Lincah & Melayani', 'SDM cepat, ramah, multi-skill.', '#5A4E8C'],
        ];
    }

    protected function choiceDefs(): array
    {
        return [
            ['T1', 'Fokus pasar keluarga Jakarta Utara & Bekasi', 'pasar', 'Segmen keluarga paling stabil.'],
            ['T1', 'Paket Family Lakeside Weekend', 'produk', 'Kamar berbalkon & aktivitas anak.'],
            ['T2', 'Wedding all-in grand ballroom', 'produk', 'F&B/banquet turun 22% pada 2025.'],
            ['T2', 'Longstay & corporate rate kawasan Sunter', 'harga', 'Industri otomotif & logistik.'],
            ['T2', 'Direct booking via situs & WhatsApp', 'saluran', 'Kurangi komisi OTA.'],
            ['T3', 'Multi-skilling & penjadwalan berbasis okupansi', 'operasi', 'Biaya tenaga kerja ±37%.'],
            ['T3', 'Retrofit energi (LED, chiller, pompa)', 'operasi', 'Biaya listrik tinggi.'],
            ['T4', 'Struktur ramping & budaya cepat-ramah', 'organisasi', 'Karyawan 179 orang.'],
            ['T2', 'Kerja sama agen perjalanan sekolah', 'saluran', 'Study tour Jakarta.', 'diusulkan'],
        ];
    }

    protected function fromAnnualReport(): array
    {
        return ['F1.1', 'F1.2', 'F1.3', 'F1.4', 'F3.2', 'C1.1', 'C1.2', 'C1.3', 'C1.4', 'L3.1', 'L3.2'];
    }

    protected function kpiNumbers(): array
    {
        // [2024, target 2025, realisasi 2025, target 2026, faktor realisasi 2026, target 2027] — Rp juta kecuali disebut lain
        return [
            'F1.1' => [52848, 65834, 46011, 53220, .88, 57000], 'F1.2' => [25349, 30000, 24273, 27000, .92, 28800],
            'F1.3' => [24899, 31500, 19465, 23500, .80, 25300], 'F1.4' => [2600, 4334, 2273, 2720, .97, 2900],
            'F2.1' => [27.0, 30.0, 22.0, 26.0, .88, 28.0], 'F2.2' => [101.5, 100, 103.2, 100, 1.0, 100], 'F2.3' => [33.0, 30.0, 37.0, 33.0, 1.08, 32.0],
            'F3.1' => [420, 350, 610, 400, 1.28, 350], 'F3.2' => [9064, 10000, 8780, 9500, .9, 10500],
            'C1.1' => [57.6, 59.5, 55.1, 59.0, .96, 61.0], 'C1.2' => [527, 560, 529, 550, 1.0, 565], 'C1.3' => [304, 333, 292, 325, .95, 345],
            'C1.4' => [48109, 49474, 45855, 49100, .96, 50800], 'C1.5' => [5.8, 5.0, 6.6, 5.0, 1.10, 4.6],
            'C2.1' => [84.0, 86.0, 84.5, 87.0, .99, 88.0], 'C2.2' => [8.4, 8.6, 8.5, 8.6, 1.0, 8.8], 'C2.3' => [3.0, 2.8, 3.3, 2.6, 1.08, 2.4], 'C2.4' => [85, 90, 88, 92, 1.0, 94],
            'C3.1' => [12500, 16000, 9600, 12000, .78, 13200], 'C3.2' => [420, 480, 360, 430, .86, 460], 'C3.3' => [26, 30, 24, 30, .88, 32], 'C3.4' => [12, 15, 13, 18, 1.0, 21],
            'P1.1' => [42, 38, 41, 36, 1.04, 34], 'P1.2' => [87, 90, 88, 91, 1.0, 92], 'P1.3' => [38, 36, 40, 37, 1.04, 36], 'P1.4' => [600, 680, 560, 684, .9, 700],
            'P2.1' => [118, 125, 120, 128, 1.0, 132], 'P2.2' => [92000, 105000, 80000, 92000, .9, 96000], 'P2.3' => [84, 88, 85, 89, .98, 90],
            'P3.1' => [34.0, 33.0, 35.5, 33.0, 1.05, 32.0], 'P3.2' => [27, 26, 28, 26, 1.03, 25], 'P3.3' => [6.0, 5.5, 6.5, 5.0, 1.12, 4.5], 'P3.4' => [85, 88, 86, 90, 1.0, 91],
            'P4.1' => [72, 80, 75, 88, .93, 90], 'P4.2' => [9, 8, 9.5, 7, 1.15, 6.5], 'P4.3' => [42, 40, 44, 40, 1.06, 38], 'P4.4' => [1.45, 1.40, 1.50, 1.35, 1.05, 1.30],
            'P5.1' => [9, 7, 8, 6, 1.1, 5], 'P5.2' => [2, 2, 2, 2, 1.0, 2], 'P5.3' => [74, 78, 76, 80, 1.0, 85],
            'P6.1' => [86, 90, 87, 92, 1.0, 93], 'P6.2' => [2.2, 2.5, 2.1, 2.6, .92, 2.8], 'P6.3' => [1.1, 0.8, 1.2, 0.6, 1.4, 0.5], 'P6.4' => [150, 200, 180, 250, .9, 280],
            'P7.1' => [14, 10, 12, 8, 1.15, 7],
            'L1.1' => [10, 14, 11, 20, .88, 22], 'L1.2' => [45, 55, 50, 62, 1.0, 70], 'L2.1' => [16.0, 12.0, 14.0, 11.0, 1.12, 10.0], 'L2.2' => [96.0, 97.0, 96.5, 97.0, 1.0, 97.5],
            'L2.3' => [9.5, 8.0, 10.0, 7.5, 1.1, 7.0], 'L2.4' => [66, 70, 64, 72, .97, 75], 'L3.1' => [0.86, 0.82, 0.79, 0.78, 1.0, 0.76], 'L3.2' => [271, 300, 257, 296, .88, 320],
        ];
    }

    protected function hotelInitiatives(int $year): array
    {
        if ($year === 2025) {
            return [
                'kids' => ['SNLK-25-01', 'Kids club & paket libur sekolah', 'Area bermain anak, aktivitas harian, paket libur sekolah.', 'T1', 'fo', '2025-03-01', '2025-07-31', 'selesai', 4, 4, 2, 2, ['C1', 'C2'], 'Hunian Juni–Juli ≥ 70%.', 600_000_000, 120_000_000,
                    ['Desain area', 'Renovasi ringan', 'Program aktivitas', 'Promosi sekolah'], ['Kids club dibuka']],
                'wedding' => ['SNLK-25-02', 'Paket wedding grand ballroom', 'Paket all-in bersama WO mitra.', 'T2', 'sales', '2025-02-01', '2025-12-31', 'selesai', 4, 4, 2, 2, ['C3'], 'Wedding bertambah.', 0, 250_000_000,
                    ['Paket & harga', 'Kemitraan WO', 'Wedding open house'], ['Open house pertama']],
                'ota' => ['SNLK-25-03', 'Optimasi listing OTA & ulasan', 'Foto, deskripsi, respons ulasan.', 'T1', 'sales', '2025-01-15', '2025-06-30', 'selesai', 3, 4, 1, 1, ['C2', 'C3'], 'Rating ≥ 8,5.', 0, 60_000_000,
                    ['Foto profesional', 'Template respons ulasan'], ['Listing baru tayang']],
                'cost' => ['SNLK-25-04', 'Pengendalian biaya operasional', 'Penjadwalan staf & pengendalian energi.', 'T3', 'cfo', '2025-04-01', '2025-12-31', 'berjalan', 4, 5, 2, 1, ['F2', 'L3'], 'Biaya ≤ anggaran.', 0, 40_000_000,
                    ['Kajian jadwal kerja', 'Pengendalian energi', 'Renegosiasi kontrak'], ['Laporan biaya mingguan']],
                'flood' => ['SNLK-25-05', 'Kontinjensi banjir rob', 'Pompa tambahan & SOP evakuasi.', 'T3', 'eng', '2025-01-10', '2025-04-30', 'selesai', 3, 4, 3, 2, ['P5', 'P4'], 'Tidak ada gangguan operasional.', 450_000_000, 30_000_000,
                    ['Pengadaan pompa', 'Pelatihan SOP'], ['Pompa terpasang']],
            ];
        }
        if ($year === 2027) {
            return [
                'renov' => ['SNLK-27-01', 'Penyegaran kamar sayap lama', 'Soft refurbishment 144 kamar sayap lama.', 'T1', 'eng', '2027-01-15', '2027-11-30', 'direncanakan', 4, 3, 3, 4, ['P1', 'C1'], 'ADR Rp565 ribu.', 7_500_000_000, 150_000_000,
                    ['Desain', 'Pekerjaan per lantai', 'Serah terima'], ['Lantai 1–3 selesai', 'Lantai 4–6 selesai']],
                'loyal' => ['SNLK-27-02', 'Program loyalitas Sunlake Family', 'Poin untuk menginap, F&B, wedding.', 'T1', 'sales', '2027-02-01', '2027-09-30', 'direncanakan', 4, 3, 2, 2, ['C2', 'C3'], 'Direct booking 21%.', 600_000_000, 200_000_000,
                    ['Desain program', 'Integrasi PMS', 'Peluncuran'], ['Peluncuran program']],
                'surya' => ['SNLK-27-03', 'PLTS atap ballroom', 'Energi surya untuk area publik.', 'T3', 'eng', '2027-03-01', '2027-10-31', 'direncanakan', 3, 3, 2, 3, ['P4', 'F2'], 'kWh per malam kamar −5%.', 2_500_000_000, 60_000_000,
                    ['Studi kelayakan', 'Pengadaan', 'Instalasi'], ['PLTS beroperasi']],
                'akademi' => ['SNLK-27-04', 'Sunlake Service Academy', 'Pelatihan multi-skill & sertifikasi.', 'T4', 'hr', '2027-01-15', '2027-12-15', 'direncanakan', 3, 3, 1, 2, ['L1', 'L2'], '70% karyawan tersertifikasi.', 0, 180_000_000,
                    ['Kurikulum', 'Pelatihan', 'Uji kompetensi'], ['Angkatan pertama lulus']],
            ];
        }

        return [
            'family' => ['SNLK-26-01', 'Family Lakeside Weekend', 'Paket akhir pekan keluarga: kamar balkon, sarapan, kolam, aktivitas danau.', 'T1', 'fo', '2026-01-15', '2026-12-31', 'berjalan', 5, 4, 2, 2, ['C1', 'C2'], 'Hunian akhir pekan ≥ 75%.', 300_000_000, 350_000_000,
                ['Desain paket', 'Kerja sama aktivitas danau', 'Kampanye media sosial', 'Evaluasi bulanan'], ['Peluncuran paket', 'Evaluasi libur sekolah']],
            'wedding' => ['SNLK-26-02', 'Wedding & MICE swasta grand ballroom', 'Paket wedding all-in & rapat korporat.', 'T2', 'sales', '2026-01-01', '2026-12-31', 'berjalan', 5, 5, 2, 2, ['C3', 'F1'], 'Pendapatan MICE Rp12 M.', 400_000_000, 450_000_000,
                ['Paket 2026', 'Kemitraan WO', 'Wedding expo', 'Account plan korporat'], ['40 wedding terkontrak', 'Expo wedding']],
            'longstay' => ['SNLK-26-03', 'Longstay korporat kawasan Sunter', 'Kontrak bulanan Longstay Room untuk proyek & ekspatriat.', 'T2', 'sales', '2026-02-01', '2026-12-31', 'berjalan', 4, 4, 2, 1, ['C1', 'C3'], '20 kamar terkontrak bulanan.', 0, 120_000_000,
                ['Pemetaan perusahaan', 'Penawaran paket', 'Kontrak'], ['10 kamar terkontrak']],
            'rms' => ['SNLK-26-04', 'Revenue management & channel manager', 'Harga dinamis per hari & segmen; channel manager.', 'T2', 'fo', '2026-03-01', '2026-09-30', 'berjalan', 4, 4, 3, 3, ['C1', 'C3'], 'RevPAR Rp325 ribu.', 450_000_000, 90_000_000,
                ['Pemilihan vendor', 'Integrasi PMS', 'Pelatihan', 'Go-live'], ['Go-live channel manager']],
            'direct' => ['SNLK-26-05', 'Direct booking & reputasi online', 'Booking engine, WhatsApp reservasi, respons ulasan.', 'T1', 'sales', '2026-02-01', '2026-12-31', 'berjalan', 3, 4, 1, 2, ['C2', 'C3'], 'Direct booking 18%.', 150_000_000, 100_000_000,
                ['Booking engine', 'WhatsApp reservasi', 'Program ulasan'], ['Booking engine live']],
            'labor' => ['SNLK-26-06', 'Multi-skilling & jadwal berbasis okupansi', 'Staf lintas fungsi FO–F&B–HK; jadwal mengikuti forecast.', 'T3', 'hr', '2026-01-15', '2026-12-31', 'berjalan', 5, 5, 2, 1, ['F2', 'L3'], 'Biaya tenaga kerja ≤ 33%.', 0, 80_000_000,
                ['Matriks keterampilan', 'Cross-training', 'Jadwal berbasis forecast'], ['Matriks disahkan', '50 staf multi-skill']],
            'energy' => ['SNLK-26-07', 'Efisiensi energi & air', 'LED, pengaturan chiller, sensor kamar.', 'T3', 'eng', '2026-03-01', '2026-11-30', 'berjalan', 3, 3, 2, 3, ['P4', 'F2'], 'kWh per malam kamar ≤ 40.', 1_200_000_000, 50_000_000,
                ['Audit energi', 'Penggantian LED', 'Sensor kamar'], ['Audit selesai', 'LED terpasang']],
            'ar' => ['SNLK-26-08', 'Penagihan piutang terstruktur', 'Batas kredit, penagihan mingguan, deposit event.', 'T3', 'cfo', '2026-01-15', '2026-12-31', 'berjalan', 4, 5, 2, 1, ['F3'], 'Piutang > 60 hari ≤ Rp400 juta.', 0, 30_000_000,
                ['Kebijakan kredit', 'Rapat penagihan mingguan', 'Deposit 50% event'], ['Kebijakan kredit disahkan']],
            'fnb' => ['SNLK-26-09', 'Menu engineering & food cost', 'Standard recipe, menu keluarga, kontrak pemasok.', 'T3', 'chef', '2026-02-01', '2026-12-31', 'berjalan', 3, 4, 1, 1, ['P3', 'P6'], 'F&B cost ≤ 33%.', 0, 40_000_000,
                ['Standard recipe', 'Menu keluarga', 'Kontrak pemasok'], ['Menu baru']],
        ];
    }

    protected function findingData(int $year): array
    {
        if ($year === 2025) {
            return [
                ['Pendapatan 2025 hanya 70% target', 'Pendapatan Rp46,0 M vs target Rp65,8 M; rugi Rp4,46 M.', 'tinjauan', 'tahunan', 'keuangan', 'kritis', 19_823_000_000, 'F1.1', null, 'komisaris', '2026-01-28',
                    [['Rencana pemulihan pendapatan 2026', 'dirut', '2026-12-31', 'berjalan', 60]], null],
                ['Banquet turun tajam', 'F&B/banquet turun 22% karena berkurangnya rapat instansi.', 'tinjauan', 'tahunan', 'pelanggan', 'tinggi', null, 'C3.1', null, 'dirut', '2026-01-28',
                    [['Paket wedding & MICE swasta 2026', 'sales', '2026-12-31', 'berjalan', 55]], null],
                ['Genangan rob mengganggu lobi', 'Genangan Desember menutup akses lobi 3 jam.', 'internal', null, 'proses', 'sedang', 35_000_000, 'P5.1', 'flood', 'eng', '2025-02-10',
                    [['Pompa tambahan', 'eng', '2025-04-30', 'selesai', 100]], ['2025-05-10', 'Pompa terpasang dan diuji.']],
            ];
        }
        if ($year === 2027) {
            return [];
        }

        return [
            ['Piutang event & korporat > 60 hari meningkat', 'Piutang menua naik ke Rp520 juta per Juli.', 'audit', null, 'keuangan', 'tinggi', 520_000_000, 'F3.1', 'ar', 'komisaris', '2026-07-25',
                [['Rapat penagihan mingguan', 'cfo', '2026-08-31', 'selesai', 100], ['Deposit 50% untuk event', 'sales', '2026-10-31', 'berjalan', 70]], null],
            ['Pendapatan banquet di bawah target', 'Banquet H1 78% target.', 'tinjauan', 'q2', 'pelanggan', 'tinggi', 1_400_000_000, 'C3.1', 'wedding', 'dirut', '2026-07-18',
                [['Wedding expo September', 'sales', '2026-09-30', 'selesai', 100], ['Account plan 20 korporat', 'sales', '2026-12-31', 'berjalan', 50]], null],
            ['Go-live channel manager mundur', 'Integrasi PMS tertunda 5 minggu.', 'internal', null, 'proses', 'sedang', null, 'C1.3', 'rms', 'fo', '2026-06-20',
                [['Eskalasi ke vendor PMS', 'admin', '2026-07-31', 'selesai', 100], ['Go-live bertahap', 'fo', '2026-10-31', 'berjalan', 75]], null],
            ['Keluhan antrean sarapan akhir pekan', 'Antrean > 15 menit saat okupansi penuh.', 'pelanggan', null, 'pelanggan', 'sedang', null, 'C2.3', 'family', 'fb', '2026-07-08',
                [['Tambah stasiun sarapan', 'fb', '2026-07-31', 'selesai', 100]], ['2026-08-31', 'Antrean turun di bawah 8 menit.']],
            ['Lembur tinggi saat libur sekolah', 'Lembur rata-rata 13 jam/karyawan pada Juli.', 'internal', null, 'sdm', 'sedang', 60_000_000, 'L2.3', 'labor', 'hr', '2026-08-05',
                [['Pekerja harian terencana', 'hr', '2026-09-30', 'berjalan', 60]], null],
        ];
    }

    protected function hotelDependencies(int $year): array
    {
        if ($year === 2025) {
            return [['Pemasok pompa banjir', 'eksternal', 'flood', 'P5', 'Pemasok pompa', 'Pengiriman sebelum musim hujan.', 'eng', 'sedang', 'Kontrak dengan jadwal tegas.']];
        }
        if ($year === 2027) {
            return [
                ['Pendanaan penyegaran kamar', 'internal', 'renov', 'C1', 'Direksi & pemegang saham', 'Capex Rp7,5 M.', 'cfo', 'tinggi', 'Pendanaan bertahap.'],
                ['Integrasi loyalitas dengan PMS', 'eksternal', 'loyal', 'C3', 'Vendor PMS', 'Poin otomatis butuh API.', 'admin', 'sedang', 'Uji integrasi bertahap.'],
            ];
        }

        return [
            ['Vendor channel manager & PMS', 'eksternal', 'rms', 'C1', 'Vendor PMS', 'Harga dinamis bergantung integrasi.', 'admin', 'tinggi', 'SLA & go-live bertahap.'],
            ['WO mitra wedding', 'eksternal', 'wedding', 'C3', 'Wedding organizer', 'Penjualan paket wedding.', 'sales', 'sedang', 'Minimal 5 WO mitra.'],
            ['Data forecast okupansi untuk jadwal staf', 'internal', 'labor', 'L3', 'Front Office', 'Jadwal staf mengikuti forecast.', 'fo', 'sedang', 'Forecast 14 hari diperbarui harian.'],
        ];
    }

    protected function reviewTexts(): array
    {
        return [
            'venue' => 'Meeting Room Danau, Sunlake Hotel', 'chair' => 'Direktur Utama',
            'annual' => [
                'summary' => "Pendapatan Rp46,0 M (70% target Rp65,8 M; −12,9%). Kamar Rp24,3 M, F&B Rp19,5 M, lain-lain Rp2,3 M.\n45.855 malam kamar (hunian ±55%), ADR ±Rp529 ribu.\nRugi Rp4,46 M; kas operasi Rp8,8 M; 179 karyawan.",
                'decisions' => "1. Target 2026: pendapatan Rp53,2 M, rugi bersih ≤ Rp0,99 M.\n2. Fokus segmen keluarga, korporat swasta, wedding.\n3. Laporan akhir bulan 10 departemen menjadi dasar KPI & dasbor manajemen.",
                'follow_up' => 'Koordinator Strategi memasukkan KPI & target 2026 ke BSC Hotel paling lambat 15 Februari.',
                'note' => 'Dewan Komisaris meminta pemantauan bulanan banquet, biaya tenaga kerja, dan piutang.',
            ],
            'months' => [
                2 => ['Ramadan: banquet sepi, bukber keluarga naik.', 'Paket bukber keluarga & korporat.'],
                3 => ['Lebaran: hunian turun, staycation keluarga naik di akhir libur.', 'Promosi staycation pasca-Lebaran.'],
                6 => ['Libur sekolah: hunian 72%, antrean sarapan.', 'Tambah stasiun sarapan & pekerja harian.'],
                7 => ['Puncak libur sekolah; lembur tinggi.', 'Atur jadwal berbasis forecast.'],
            ],
            'q1' => ['Pendapatan Q1 86% target; banquet 74%.', 'Percepat paket wedding & MICE swasta.'],
            'q2' => ['Pendapatan H1 88% target; hunian 57%; biaya tenaga kerja 35%.', 'Multi-skilling & penagihan piutang.'],
            'board' => ['Komisaris menyoroti piutang menua, banquet, dan biaya tenaga kerja.', 'Laporan piutang mingguan ke Direksi.', 'Mohon rencana tindakan rinci piutang > 60 hari per debitur.'],
            'sep' => 'Realisasi September sebagian masih draf; data pembatalan dikembalikan untuk memisahkan reschedule grup sekolah.',
            'plan2027' => 'Draf RKAP 2027: pendapatan Rp57 M, hunian 61%, ADR Rp565 ribu; penyegaran kamar sayap lama, Sunlake Family, PLTS atap, Sunlake Service Academy.',
        ];
    }
}
