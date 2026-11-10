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
 * Demo PT Hotel Sahid Jaya International Tbk (kode SHID) — Hotel Grand Sahid Jaya, Jakarta (bintang 5).
 *
 * Angka 2025 & 2024 mengacu pada Laporan Tahunan Terintegrasi 2025: pendapatan Rp124,0 M (2024: Rp156,0 M),
 * kamar Rp44,0 M, F&B Rp63,9 M, sewa ruang toko Rp13,2 M; hunian 30,00% (2024: 43,32%), ADR Rp780.112 (2024: Rp678.871);
 * rugi tahun berjalan Rp26,7 M; kas operasi Rp29,9 M; 194 karyawan (2024: 231); air PDAM 170.061 m³.
 * Target 2026 (laporan tahunan): pendapatan Rp165,6 M, rugi bersih Rp9,95 M; strategi Program 4 Pilar SahidTANGGUH.
 * KPI non-keuangan, rincian bulanan, dan seluruh data 2026–2027 adalah simulasi.
 */
class SahidSeeder extends HotelShowcaseSeeder
{
    public const CODE = 'SHID';

    public const PREFIX = 'shid';

    public const SHORT = 'Sahid';

    public const LT = 'Laporan Tahunan 2025 PT Hotel Sahid Jaya International Tbk';

    protected function rooms(): int
    {
        return 751;
    }

    protected function companyAttributes(): array
    {
        return [
            'name' => 'PT Hotel Sahid Jaya International Tbk', 'legal_name' => 'PT Hotel Sahid Jaya International Tbk',
            'industry' => 'Hotel bintang 5, apartemen & properti (Grand Sahid Jaya Jakarta)',
            'address' => 'Jl. Jend. Sudirman No. 86', 'city' => 'Jakarta Pusat', 'phone' => '+62 21 570 4444', 'website' => 'https://www.pthsji.com',
            'description' => 'DATA DEMO untuk pembelajaran (kode saham SHID). Angka 2025 secara garis besar mengacu pada Laporan Tahunan Terintegrasi 2025; KPI operasional, rincian bulanan, data 2026 dan 2027 adalah simulasi. Bukan data resmi perusahaan.',
        ];
    }

    protected function periodNote(int $year): string
    {
        return $year === 2025
            ? 'DATA DEMO. Realisasi tahunan mengacu pada Laporan Tahunan 2025; rincian bulanan ilustratif.'
            : 'DATA DEMO — SIMULASI 2026 (target pendapatan Rp165,6 M dari laporan tahunan): Jan–Agu disetujui, Sep dalam proses.';
    }

    protected function season(): array
    {
        return [
            2025 => self::weights([1 => 7.5, 7.8, 6.6, 8.0, 8.5, 8.5, 8.0, 8.8, 8.8, 9.0, 9.2, 9.3]),
            2026 => self::weights([1 => 7.6, 6.9, 7.0, 8.2, 8.5, 8.6, 8.1, 8.8, 8.9, 9.0, 9.2, 9.2]),
        ];
    }

    protected function onTrack2026(): array
    {
        return ['C1.2', 'F1.4', 'C2.2', 'P1.2', 'P2.1', 'P3.4', 'P5.3', 'L2.2', 'L3.1', 'P6.4', 'C3.4', 'F3.2', 'P4.4', 'L1.1'];
    }

    protected function missingSeptember(): array
    {
        return ['P2.3', 'L1.2'];
    }

    protected function returnedSeptember(): ?array
    {
        return ['C3.1', 'Pendapatan banquet September masih memasukkan uang muka acara Oktober. Pisahkan berdasarkan tanggal acara (BEO) dan lampirkan rekap per event.'];
    }

    protected function criticalIn2026(): array
    {
        return ['P1.4'];
    }

    protected function maturityPattern(): array
    {
        return [3, 3, 2, 3, 3];
    }

    // ------------------------------------------------------------------ jati diri

    protected function identity(int $year): void
    {
        AtmanProfile::create([
            'vision' => 'Menjadi hotel yang mampu menumbuhkan kreativitas, inovasi, produktivitas, kualitas sumber daya manusia yang teruji dan menyajikan pelayanan yang sesuai standar internasional tanpa meninggalkan nilai-nilai luhur budaya bangsa.',
            'mission' => "1. Meningkatkan kualitas produk dan mutu pelayanan dengan sasaran memberikan kepuasan kepada pelanggan.\n2. Meningkatkan kualitas SDM agar terampil dan mampu memberikan pelayanan terbaik secara profesional dan proaktif.\n3. Mempercepat pengembangan Perseroan menjadi perusahaan yang profesional, produktif, dan efisien.\n4. Meningkatkan pengembangan usaha di bisnis utama maupun sekunder.\n5. Menggali sumber pendanaan yang inovatif dan menjalin kerja sama untuk meningkatkan efisiensi dan produktivitas.",
            'purpose' => 'Menjaga warisan hotel bintang lima legendaris di jantung CBD Jakarta sambil bertransformasi menghadapi perubahan industri.',
            'tagline' => 'Resilience in Motion — Bergerak Adaptif di Tengah Transformasi Industri',
            'brand_promise' => 'Keramahan Indonesia berstandar internasional di lokasi paling strategis Jalan Sudirman.',
            'value_proposition' => 'Hotel bintang 5 sejak 1974 di Sudirman dengan Puri Agung Convention Center, kamar baru tipe Nakula–Sadewa–Bima, outlet F&B ikonik (Bengawan Solo, Andrawina, Golden Dragon, Bushido), serta apartemen & ruang toko.',
            'culture_statement' => 'Prinsip Perusahaan: Urip Iku Urup (hidup itu menghidupi), Nguwongake Uwong (memanusiakan manusia), Tumindak Sak Madyo (berperilaku wajar), Nut Zaman Kelakone (mengikuti zaman), Urip Iku Amanah (hidup itu amanah).',
            'history' => "23 Mar 1974: Hotel Grand Sahid Jaya beroperasi dengan 439 kamar.\n1986–1987: gedung pengembangan; total 751 kamar; status bintang lima.\n8 Mei 1990: saham tercatat di Bursa Efek Indonesia.\n2025: renovasi kamar tahap I (Nakula, Sadewa, Bima); efisiensi anggaran pemerintah menekan MICE.\n2026: Program 4 Pilar SahidTANGGUH.",
            'approved_by' => $this->id('dirut'), 'approved_at' => ($year === 2027 ? 2026 : $year).'-01-20 10:00:00',
        ]);
        foreach ([
            ['Berdedikasi', 'Dedication', 'Mencurahkan kemampuan terbaik untuk tamu dan Perseroan.', "Menyelesaikan permintaan tamu sampai tuntas\nHadir tepat waktu di setiap shift"],
            ['Loyal', 'Loyalty', 'Setia pada Perseroan dan menjaga nama baik Sahid.', "Menjaga kerahasiaan data tamu\nMengutamakan kepentingan Perseroan"],
            ['Integritas', 'Integrity', 'Jujur, konsisten, dan dapat dipercaya.', "Melaporkan realisasi KPI apa adanya\nMenolak gratifikasi dari pemasok"],
            ['Etika', 'Ethics', 'Bertindak sesuai Kode Etik dan norma budaya bangsa.', "Santun kepada tamu & rekan\nMematuhi SOP dan tata kelola"],
            ['Kerja Sama', 'Teamwork', 'Bekerja lintas departemen demi pengalaman tamu yang utuh.', "Saling membantu saat event besar\nBriefing harian antar-departemen"],
        ] as $i => [$name, $local, $desc, $beh]) {
            CoreValue::create(['name' => $name, 'local_name' => $local, 'description' => $desc, 'behaviors' => $beh, 'sort' => $i + 1]);
        }
        $up = $year === 2025 ? 0 : 1;
        foreach ([
            ['Lokasi CBD Sudirman & lahan luas', 'Sumber daya fisik', 'Hotel di Jl. Sudirman 86, dekat pusat bisnis & pemerintahan.', 5, 5, true, 'Optimalisasi ruang untuk padel, restoran rooftop, ruang kreatif.'],
            ['Puri Agung Convention Center', 'Sumber daya fisik', 'Ballroom besar untuk MICE, wedding, dan konser.', 4, 5, true, 'Modernisasi AV & paket event non-pemerintah.'],
            ['Kamar bintang 5 & renovasi bertahap', 'Sumber daya fisik', '751 kamar; tipe baru Nakula, Sadewa, Yudhistira, Arjuna & Bima Suite.', 3 + $up, 4, true, 'Lanjutkan renovasi tahap II.'],
            ['Outlet F&B ikonik', 'Kompetensi', 'Bengawan Solo, Andrawina, Golden Dragon Seafood, Bushido, Solo Lounge.', 4, 5, true, 'Menu baru & promosi komunitas.'],
            ['Relasi pemerintah, korporasi & komunitas', 'Kompetensi', 'Jaringan panjang dengan instansi, asosiasi, dan korporasi.', 4, 4, false, 'Diversifikasi ke ritel, korporat, travel agent.'],
            ['Digitalisasi layanan (e-Concierge)', 'Sistem', 'Rencana aplikasi e-Concierge Sahid pra-, saat, dan pasca-menginap.', 1 + $up, 4, false, 'Peluncuran e-Concierge & low-contact service.'],
            ['Pengelolaan aset & properti', 'Sistem', 'Lini perhotelan, apartemen, dan pengelolaan properti.', 3, 4, false, 'Digitalisasi pemantauan aset.'],
            ['Program keberlanjutan menuju Net Zero', 'Kompetensi', 'Zero plastic use, daur ulang, kontrol konsumsi sumber daya.', 2 + $up, 4, false, 'Transisi energi rendah emisi.'],
        ] as [$name, $cat, $desc, $cur, $tgt, $core, $gap]) {
            Capability::create(['name' => $name, 'category' => $cat, 'description' => $desc, 'current_level' => $cur, 'target_level' => $tgt, 'is_core' => $core, 'gap_action' => $gap]);
        }
    }

    // ------------------------------------------------------------------ lingkungan

    protected function ecosystem(int $year): array
    {
        foreach ([
            ['Kondisi makro & industri perhotelan 2025', '2026-01-20', 'eksternal', self::LT.' — Tinjauan Industri',
                'Ekonomi tumbuh 5,11%; pemerintah membatasi anggaran rapat & perjalanan dinas sehingga MICE pemerintah turun. TPK hotel bintang Desember 2025 56,12%.',
                'Kurangi ketergantungan pada segmen Government/MICE; dorong ritel, korporat, travel agent.'],
            ['Kinerja internal 2025', '2026-01-28', 'internal', self::LT.' — Ikhtisar Keuangan',
                'Pendapatan Rp124,0 M (−20,5%; 84% target Rp147,5 M). Rugi Rp26,7 M. Hunian 30,00% (2024: 43,32%) namun ADR naik ke Rp780.112 setelah renovasi.',
                'Fokus pemulihan volume tanpa menggerus ADR; efisiensi biaya.'],
            ['Pendapatan per segmen usaha 2025', '2026-01-28', 'internal', self::LT.' — Catatan 26',
                'Kamar Rp44,0 M (2024: Rp49,5 M); F&B Rp63,9 M (2024: Rp95,7 M); sewa ruang toko Rp13,2 M (2024: Rp4,4 M); apartemen Rp0,85 M; lain-lain Rp2,1 M.',
                'F&B/banquet turun paling dalam; sewa ruang tumbuh tiga kali — peluang pendapatan non-kamar.'],
            ['Target 2026 & Program 4 Pilar SahidTANGGUH', '2026-02-05', 'internal', self::LT.' — Prospek Usaha',
                'Target pendapatan Rp165,6 M dan rugi bersih Rp9,95 M. Pilar: inovasi produk & optimalisasi pendapatan, kualitas aset berkelanjutan, Hospitality 4.0, menuju Net Zero Carbon.',
                'Turunkan pilar menjadi sasaran & inisiatif BSC.'],
            ['Strategi pemasaran 2026', '2026-02-10', 'eksternal', self::LT.' — Aspek Pemasaran',
                'Renovasi kamar bertahap, modernisasi koridor & lobi lift, padel & restoran rooftop, spa & fitness baru; penetrasi segmen korporasi & komunitas; wedding & event.',
                'Program penjualan per segmen dengan target bulanan.'],
            ['Arah 2027: BSC berbasis laporan 10 departemen', '2026-11-10', 'internal', 'Rencana manajemen 2027 (simulasi)',
                'Laporan akhir bulan 10 departemen menjadi dasar KPI dan dasbor manajemen 2027.', 'Susun target 2027 per departemen.'],
        ] as [$title, $date, $scope, $source, $summary, $impl]) {
            if ($year === 2025 && $date >= '2026-02-01') {
                continue;
            }
            EnvironmentScan::create(compact('title', 'scope', 'source', 'summary') + ['scan_date' => $year === 2025 ? '2025-01-20' : $date, 'implications' => $impl, 'status' => 'aktif', 'created_by' => $this->id('strategi')]);
        }

        foreach ([
            ['politik', 'Efisiensi anggaran belanja pemerintah', 'Pembatasan anggaran rapat & konferensi menurunkan MICE pemerintah di Jakarta.', 'ancaman', 5, 5, 'naik', 'Diversifikasi ke korporat, komunitas, wedding.'],
            ['politik', 'Pemindahan sebagian fungsi pemerintahan ke IKN', 'Berpotensi mengurangi permintaan dinas di Jakarta jangka panjang.', 'ancaman', 3, 3, 'naik', 'Perkuat segmen swasta & leisure.'],
            ['ekonomi', 'Pertumbuhan ekonomi & mobilitas bisnis', 'Ekonomi 5,11%; mobilitas bisnis & leisure meningkat.', 'peluang', 4, 4, 'naik', 'Paket korporat & staycation.'],
            ['ekonomi', 'Persaingan harga hotel bintang 5 Jakarta', 'Banyak hotel internasional baru dengan harga promosi.', 'ancaman', 4, 4, 'naik', 'Diferensiasi warisan budaya & lokasi.'],
            ['sosial', 'Gaya hidup urban: padel, rooftop dining, wellness', 'Permintaan fasilitas gaya hidup modern di CBD.', 'peluang', 4, 4, 'naik', 'Lapangan padel, rooftop, spa & fitness baru.'],
            ['sosial', 'Pasar wedding & acara sosial Jakarta', 'Permintaan ballroom besar untuk pernikahan tetap tinggi.', 'peluang', 4, 4, 'stabil', 'Paket wedding Puri Agung.'],
            ['teknologi', 'Hospitality 4.0 & layanan low contact', 'Tamu mengharapkan check-in digital & layanan via aplikasi.', 'peluang', 4, 4, 'naik', 'e-Concierge Sahid.'],
            ['teknologi', 'Dominasi OTA', 'Komisi OTA menekan margin kamar.', 'ancaman', 3, 5, 'naik', 'Direct booking & loyalitas.'],
            ['lingkungan', 'Tuntutan Net Zero & ESG', 'Investor & korporat mensyaratkan praktik berkelanjutan.', 'peluang', 3, 4, 'naik', 'Pilar 4 SahidTANGGUH.'],
            ['lingkungan', 'Konsumsi air & energi gedung tua', 'Gedung 1974/1986 boros energi & air (170.061 m³ air PDAM 2025).', 'ancaman', 3, 4, 'stabil', 'Retrofit MEP & monitoring.'],
            ['hukum', 'Kewajiban laporan keberlanjutan (POJK 51)', 'Emiten wajib menyampaikan laporan keberlanjutan.', 'ancaman', 2, 5, 'stabil', 'Data ESG terukur di BSC.'],
            ['hukum', 'Pajak daerah DKI (PBJT perhotelan & F&B)', 'Tarif & kepatuhan pajak daerah.', 'ancaman', 3, 4, 'stabil', 'Rekonsiliasi pajak bulanan.'],
        ] as [$factor, $title, $desc, $type, $impact, $like, $trend, $resp]) {
            PestelAnalysis::create(['factor' => $factor, 'title' => $title, 'description' => $desc, 'impact_type' => $type, 'impact_level' => $impact, 'likelihood' => $like, 'trend' => $trend, 'response' => $resp, 'source' => self::LT.' & analisis manajemen (ilustrasi)']);
        }

        foreach ([
            ['persaingan', 'Hotel bintang 5 internasional di CBD Jakarta', 'Jaringan global dengan program loyalitas besar.', 5, 'Diferensiasi warisan & ballroom besar, harga kompetitif.'],
            ['kekuatan_pembeli', 'Instansi & korporat menekan harga paket', 'Pembeli MICE membandingkan harga lintas hotel.', 4, 'Paket bernilai tambah.'],
            ['kekuatan_pemasok', 'Kenaikan biaya F&B & energi', 'Harga bahan baku & listrik naik.', 3, 'Kontrak pemasok & efisiensi energi.'],
            ['pendatang_baru', 'Hotel & venue baru di Jakarta', 'Venue konvensi baru di koridor Sudirman–Senayan.', 3, 'Renovasi & modernisasi fasilitas.'],
            ['produk_pengganti', 'Rapat daring & venue non-hotel', 'Gedung serbaguna, coworking, rapat hybrid.', 3, 'Paket hybrid & ruang kreatif.'],
        ] as [$force, $title, $desc, $int, $impl]) {
            IndustryForce::create(['force' => $force, 'title' => $title, 'description' => $desc, 'intensity' => $int, 'implication' => $impl]);
        }

        foreach ([
            ['Government & MICE pemerintah', 'MICE', 'Instansi pusat & daerah — rapat, konferensi, fullboard.', 30, 'turun', true, 'Paket sesuai SBM, ruang besar.', 'Pertahankan akun utama; paket efisien.'],
            ['Korporasi & asosiasi', 'Korporasi', 'Rapat, pelatihan, gathering, konferensi asosiasi.', 22, 'naik', true, 'Fasilitas modern, harga fleksibel.', 'Corporate rate & account manager.'],
            ['Wedding & acara sosial', 'Sosial', 'Pernikahan, konser, acara komunitas di Puri Agung.', 15, 'naik', true, 'Ballroom besar, katering.', 'Paket wedding & kemitraan WO.'],
            ['Travel agent & grup', 'Grup', 'Wisatawan grup domestik & mancanegara.', 8, 'naik', true, 'Harga grup, lokasi strategis.', 'Kontrak TA.'],
            ['OTA & individu', 'OTA', 'Tamu bisnis & leisure individu.', 15, 'stabil', true, 'Kamar baru, harga kompetitif.', 'Kampanye OTA & direct booking.'],
            ['Penyewa ruang toko & apartemen', 'Properti', 'Ruang toko (arcade) & apartemen servis.', 10, 'naik', true, 'Lokasi CBD, layanan pengelolaan.', 'Optimalisasi ruang & ruang kreatif.'],
        ] as [$seg, $grp, $desc, $share, $growth, $target, $needs, $strat]) {
            MarketAnalysis::create(['segment' => $seg, 'segment_group' => $grp, 'description' => $desc, 'share_percent' => $share, 'growth' => $growth, 'is_target' => $target, 'needs' => $needs, 'strategy' => $strat, 'source' => 'Porsi ilustrasi (data demo)']);
        }

        foreach ([
            ['Hotel Grand Sahid Jaya', 'Bintang 5', 751, 4, 30.0, 780112, 234034, 0.78, 0.55, 1.42, 4.5, 4.3, 8.4, 8.3, 8.5, true, 'Lokasi Sudirman, ballroom besar, warisan budaya, outlet ikonik.', 'Gedung tua; hunian 30% di 2025; renovasi bertahap.'],
            ['Hotel bintang 5 internasional A (pembanding)', 'Bintang 5', 400, 1, 72.0, 1650000, 1188000, 1.30, 1.15, 1.13, 4.7, 4.6, 8.9, 8.9, 8.9, false, 'Brand global & loyalitas.', 'Harga tinggi.'],
            ['Hotel bintang 5 internasional B (pembanding)', 'Bintang 5', 520, 2, 68.0, 1350000, 918000, 1.12, 1.08, 1.04, 4.6, 4.5, 8.7, 8.6, 8.8, false, 'Ballroom & MICE kuat.', 'Produk mulai menua.'],
            ['Hotel bintang 5 lokal (pembanding)', 'Bintang 5', 350, 3, 60.0, 950000, 570000, 0.92, 0.95, 0.97, 4.5, 4.3, 8.5, 8.4, 8.6, false, 'Harga kompetitif.', 'Fasilitas MICE lebih kecil.'],
        ] as [$name, $cat, $rooms, $rank, $occ, $arr, $revpar, $rgi, $mpi, $ari, $g, $ta, $tv, $bk, $tk, $self, $str, $weak]) {
            Competitor::create(['name' => $name, 'category' => $cat, 'room_count' => $rooms, 'rank' => $rank, 'data_period' => $self ? 'FY2025 (laporan tahunan)' : 'Ilustrasi pembanding',
                'occupancy' => $occ, 'arr' => $arr, 'revpar' => $revpar, 'rgi' => $rgi, 'mpi' => $mpi, 'ari' => $ari, 'revenue' => $self ? 124.0 : null, 'revenue_growth' => $self ? -20.5 : null, 'net_margin' => $self ? -21.4 : null,
                'rating_google' => $g, 'rating_tripadvisor' => $ta, 'rating_traveloka' => $tv, 'rating_booking' => $bk, 'rating_tiket' => $tk,
                'is_self' => $self, 'strengths' => $str, 'weaknesses' => $weak, 'notes' => $self ? 'Angka dari '.self::LT.' (pendapatan Rp miliar; RevPAR dihitung).' : 'Pembanding ilustrasi untuk demo; ganti dengan data STR/benchmark.']);
        }

        foreach ([
            ['Pedoman Tata Kelola Perusahaan Terbuka', 'OJK', 'SEOJK No. 32/SEOJK.04/2015', 'Tata kelola', '2015-11-17', 'Pedoman GCG emiten.', 'Wajib diungkap di laporan tahunan.', 'patuh', 'strategi', null],
            ['Laporan keberlanjutan emiten', 'OJK', 'POJK No. 51/POJK.03/2017', 'Keberlanjutan', '2017-07-27', 'Kewajiban laporan keberlanjutan tahunan.', 'Data energi, air, limbah, SDM harus terukur.', 'patuh', 'strategi', null],
            ['PBJT perhotelan & makanan-minuman', 'Pemprov DKI Jakarta', 'UU No. 1 Tahun 2022 & Perda DKI', 'Pajak', null, 'Pajak daerah atas jasa hotel & F&B.', 'Rekonsiliasi bulanan.', 'patuh', 'cfo', null],
            ['Standar usaha hotel bintang 5', 'Kementerian Pariwisata', 'Permenparekraf No. 4 Tahun 2021', 'Perizinan', null, 'Sertifikat usaha sesuai klasifikasi.', 'Renovasi menjaga standar bintang 5.', 'patuh', 'dirut', null],
            ['Keselamatan gedung & proteksi kebakaran', 'Pemprov DKI (Damkar)', 'Pergub DKI tentang SLF & proteksi kebakaran', 'Keselamatan', null, 'Sertifikat Laik Fungsi & sistem proteksi kebakaran gedung tinggi.', 'Audit berkala.', 'sebagian', 'sec', '2026-12-31'],
            ['Jaminan produk halal', 'BPJPH', 'UU No. 33 Tahun 2014', 'F&B', null, 'Sertifikasi halal outlet F&B.', 'Segmen pemerintah & muslim.', 'sebagian', 'chef', '2026-10-17'],
            ['Pengelolaan limbah & air limbah', 'DLH DKI', 'Permen LHK No. P.68 Tahun 2016', 'Lingkungan', null, 'Baku mutu air limbah domestik.', 'Uji lab berkala.', 'patuh', 'eng', null],
        ] as [$title, $issuer, $ref, $cat, $eff, $desc, $impact, $status, $owner, $due]) {
            Regulation::create(['title' => $title, 'issuer' => $issuer, 'reference_no' => $ref, 'category' => $cat, 'effective_date' => $eff, 'description' => $desc, 'impact' => $impact, 'compliance_status' => $status, 'owner_id' => $this->id($owner), 'due_date' => $due]);
        }

        $sh = [];
        foreach ([
            'saham' => ['Pemegang saham & investor (SHID)', 'internal', 'Pemilik', 5, 4, 'Pemulihan laba, tata kelola.', 'RUPS, paparan publik.', 'Sekretaris Perusahaan'],
            'komisaris' => ['Dewan Komisaris & Komite Audit', 'internal', 'Pengawas', 5, 5, 'Pengendalian risiko & kinerja.', 'Rapat gabungan kuartalan.', 'Sekretaris Perusahaan'],
            'karyawan' => ['Karyawan (194 orang)', 'internal', 'SDM', 4, 4, 'Kesejahteraan & pengembangan.', 'Pelatihan & komunikasi.', 'HR'],
            'pemerintah' => ['Instansi pemerintah (pelanggan MICE)', 'eksternal', 'Pelanggan', 5, 4, 'Paket sesuai SBM, administrasi rapi.', 'Account management.', 'Sales'],
            'korporat' => ['Korporasi & asosiasi', 'eksternal', 'Pelanggan', 4, 4, 'Fasilitas modern, harga kompetitif.', 'Corporate rate.', 'Sales'],
            'tamu' => ['Tamu individu & leisure', 'eksternal', 'Pelanggan', 4, 4, 'Kamar nyaman, layanan cepat.', 'Survei tamu & e-Concierge.', 'Rooms Division'],
            'penyewa' => ['Penyewa ruang toko & apartemen', 'eksternal', 'Pelanggan', 3, 4, 'Lingkungan ramai & terawat.', 'Event & promosi bersama.', 'Pengelola Properti'],
            'regulator' => ['Regulator (OJK, BEI, Pemprov DKI)', 'eksternal', 'Regulator', 5, 3, 'Kepatuhan & pelaporan.', 'Pelaporan tepat waktu.', 'Sekretaris Perusahaan'],
            'pemasok' => ['Pemasok F&B & kontraktor renovasi', 'eksternal', 'Pemasok', 3, 4, 'Pembayaran tepat waktu.', 'Kontrak & evaluasi pemasok.', 'Purchasing'],
            'masyarakat' => ['Masyarakat & lingkungan', 'eksternal', 'Komunitas', 2, 3, 'Program TJSL & lingkungan.', 'CSR & zero plastic.', 'HR'],
        ] as $key => [$name, $type, $cat, $infl, $int, $exp, $strat, $cp]) {
            $sh[$key] = Stakeholder::create(['name' => $name, 'type' => $type, 'category' => $cat, 'influence' => $infl, 'interest' => $int, 'expectations' => $exp, 'engagement_strategy' => $strat, 'contact_person' => $cp]);
        }

        $issues = [];
        foreach ([
            'mice' => ['MICE pemerintah turun tajam', 'F&B/banquet turun dari Rp95,7 M ke Rp63,9 M akibat efisiensi anggaran pemerintah.', 'pelanggan', 5, 5, 'sales', ['pemerintah', 'saham']],
            'occ' => ['Hunian rendah (30%)', 'Hunian 2025 turun ke 30,00% dari 43,32%; sebagian kamar dalam renovasi.', 'pelanggan', 5, 5, 'fo', ['tamu', 'saham']],
            'loss' => ['Rugi bersih membesar', 'Rugi Rp26,7 M (2024: Rp12,7 M); target 2026 rugi Rp9,95 M.', 'keuangan', 5, 5, 'cfo', ['saham', 'komisaris']],
            'asset' => ['Aset gedung menua', 'Gedung 1974/1986; renovasi kamar & area publik bertahap.', 'proses', 4, 4, 'eng', ['tamu', 'saham']],
            'nonroom' => ['Optimalisasi pendapatan non-kamar', 'Sewa ruang toko naik ke Rp13,2 M; ruang & lahan belum optimal.', 'keuangan', 3, 4, 'dirut', ['penyewa', 'saham']],
            'digital' => ['Digitalisasi layanan tertinggal', 'e-Concierge belum diluncurkan.', 'proses', 3, 4, 'admin', ['tamu']],
            'sdm' => ['Pengurangan karyawan & beban kerja', 'Karyawan turun dari 231 ke 194; risiko kualitas layanan.', 'sdm', 4, 4, 'hr', ['karyawan']],
            'esg' => ['Menuju Net Zero Carbon', 'Komitmen Pilar 4 perlu data energi & air yang terukur.', 'proses', 3, 3, 'eng', ['regulator', 'masyarakat']],
        ] as $key => [$title, $desc, $persp, $urg, $imp, $owner, $stks]) {
            $issues[$key] = StrategicIssue::create(['title' => $title, 'description' => $desc, 'perspective' => $persp, 'urgency' => $urg, 'impact' => $imp, 'status' => 'ditangani', 'source' => self::LT.' & analisis manajemen', 'owner_id' => $this->id($owner)]);
            $issues[$key]->stakeholders()->sync(collect($stks)->map(fn ($s) => $sh[$s]->id));
        }

        $sort = 0;
        foreach ([
            ['S', 'Lokasi CBD Sudirman', 'Akses ke pusat bisnis & pemerintahan.', 0.15, 4],
            ['S', 'Ballroom besar Puri Agung', 'Kapasitas event besar.', 0.12, 4],
            ['S', 'Merek legendaris sejak 1974', 'Dikenal luas & dekat dengan budaya Indonesia.', 0.08, 3],
            ['S', 'ADR naik setelah renovasi (Rp780 ribu)', 'Kamar baru diterima pasar.', 0.08, 3],
            ['W', 'Hunian sangat rendah', '30% pada 2025.', 0.12, 1],
            ['W', 'Ketergantungan pada MICE pemerintah', 'Segmen terbesar paling terdampak.', 0.10, 1],
            ['W', 'Gedung tua & biaya pemeliharaan tinggi', 'Renovasi butuh capex besar.', 0.08, 2],
            ['W', 'Digitalisasi layanan tertinggal', 'e-Concierge belum ada.', 0.05, 2],
            ['O', 'Gaya hidup urban: padel, rooftop, wellness', 'Fasilitas baru menarik komunitas.', 0.08, 3],
            ['O', 'Wedding & konser', 'Event non-pemerintah tumbuh.', 0.06, 3],
            ['O', 'Sewa ruang kreatif', 'Pendapatan non-kamar.', 0.05, 3],
            ['T', 'Efisiensi anggaran pemerintah', 'MICE pemerintah berkurang.', 0.15, 2],
            ['T', 'Hotel internasional baru', 'Persaingan harga.', 0.10, 2],
            ['T', 'Kenaikan biaya energi & bahan baku', 'Menekan margin.', 0.06, 2],
        ] as [$type, $title, $desc, $w, $r]) {
            SwotItem::create(['type' => $type, 'title' => $title, 'description' => $desc, 'weight' => $w, 'rating' => $r, 'sort' => ++$sort, 'source' => self::LT.' & analisis manajemen']);
        }

        return $issues;
    }

    protected function tows(array $issues): void
    {
        foreach ([
            ['SO', 'Puri Agung sebagai pusat wedding, konser & konvensi swasta', 'Gunakan ballroom & lokasi untuk event non-pemerintah.', 5, ['mice']],
            ['SO', 'Fasilitas gaya hidup: padel, rooftop, spa & fitness', 'Tarik komunitas CBD.', 4, ['nonroom', 'occ']],
            ['WO', 'Renovasi kamar tahap II & modernisasi area publik', 'Naikkan daya saing sambil menjaga ADR.', 5, ['asset', 'occ']],
            ['WO', 'e-Concierge Sahid', 'Layanan digital pra-, saat, dan pasca-menginap.', 3, ['digital']],
            ['ST', 'Diversifikasi segmen: ritel, korporat, travel agent', 'Kurangi ketergantungan MICE pemerintah.', 5, ['mice', 'occ']],
            ['ST', 'Revenue management berbasis segmen', 'Harga dinamis per segmen & hari.', 4, ['occ', 'loss']],
            ['WT', 'Efisiensi biaya & produktivitas SDM', 'Cross-training dan struktur ramping.', 4, ['loss', 'sdm']],
            ['WT', 'Program Net Zero: energi & air', 'Retrofit MEP, monitoring konsumsi.', 3, ['esg', 'asset']],
        ] as [$type, $title, $desc, $prio, $iss]) {
            $t = TowsStrategy::create(['type' => $type, 'title' => $title, 'description' => $desc, 'priority' => $prio, 'status' => 'dipilih']);
            $t->issues()->sync(collect($iss)->map(fn ($k) => $issues[$k]->id));
        }
    }

    protected function themeDefs(): array
    {
        return [
            'T1' => ['SahidTANGGUH Berinovasi Produk & Optimalisasi Pendapatan', 'Pilar 1: produk & jasa di luar kamar dan F&B, optimalisasi ruang & lahan, diversifikasi segmen.', '#8C1D2B'],
            'T2' => ['SahidTANGGUH Pelayanan Hospitality 4.0', 'Pilar 3: layanan low contact & e-Concierge; pengalaman tamu bintang lima.', '#B88A2B'],
            'T3' => ['SahidTANGGUH Kualitas Aset Berkelanjutan & Net Zero', 'Pilar 2 & 4: renovasi aset, efisiensi biaya, energi & air.', '#2F5D50'],
            'T4' => ['SDM Unggul & Tata Kelola', 'SDM kompeten, produktif, dan berintegritas.', '#3A4E7A'],
        ];
    }

    protected function choiceDefs(): array
    {
        return [
            ['T1', 'Diversifikasi ke segmen ritel, korporat & travel agent', 'pasar', 'MICE pemerintah turun akibat efisiensi anggaran.'],
            ['T1', 'Optimalisasi ruang: padel, rooftop, ruang kreatif & arcade', 'produk', 'Sewa ruang toko naik tiga kali pada 2025.'],
            ['T1', 'Jaga ADR hasil renovasi, dorong volume di hari kerja', 'harga', 'ADR Rp780 ribu dengan hunian 30%.'],
            ['T2', 'Peluncuran e-Concierge Sahid', 'saluran', 'Pilar 3 Hospitality 4.0.'],
            ['T2', 'Wedding & konser sebagai pilar event baru', 'produk', 'Puri Agung & pengalaman acara.'],
            ['T3', 'Renovasi kamar bertahap & standarisasi desain', 'operasi', 'Pilar 2 kualitas aset.'],
            ['T3', 'Transisi energi rendah emisi & zero plastic', 'operasi', 'Pilar 4 Net Zero.'],
            ['T4', 'Cross-training & struktur organisasi ramping', 'organisasi', 'Karyawan 194 orang.'],
            ['T4', 'Kemitraan operator untuk pengelolaan hotel baru', 'organisasi', 'Ekspansi pengelolaan hotel.', 'diusulkan'],
        ];
    }

    protected function fromAnnualReport(): array
    {
        return ['F1.1', 'F1.2', 'F1.3', 'F1.4', 'F2.2', 'F3.2', 'C1.1', 'C1.2', 'C1.3', 'C1.4', 'P3.1', 'P4.4', 'L3.1', 'L3.2'];
    }

    protected function kpiNumbers(): array
    {
        return [
            'F1.1' => [155976, 147529, 123996, 165568, .90, 175000], 'F1.2' => [49473, 52000, 44013, 58000, .93, 62000],
            'F1.3' => [95749, 85000, 63861, 88000, .78, 92000], 'F1.4' => [10754, 10529, 16122, 19568, 1.02, 21000],
            'F2.1' => [18.0, 20.0, 9.5, 15.0, .9, 18.0], 'F2.2' => [101.0, 100, 95.8, 100, 1.02, 100], 'F2.3' => [31.0, 30.0, 36.5, 31.0, 1.06, 30.0],
            'F3.1' => [3800, 3000, 4200, 3000, 1.1, 2700], 'F3.2' => [40368, 35000, 29931, 36000, 1.0, 40000],
            'C1.1' => [43.3, 45.0, 30.0, 42.0, .93, 48.0], 'C1.2' => [679, 700, 780, 790, 1.0, 810], 'C1.3' => [294, 315, 234, 332, .93, 389],
            'C1.4' => [72875, 74286, 56419, 73418, .93, 78500], 'C1.5' => [6.5, 6.0, 7.8, 6.0, 1.08, 5.5],
            'C2.1' => [84.0, 86.0, 83.5, 87.0, .99, 88.0], 'C2.2' => [8.4, 8.6, 8.5, 8.7, 1.0, 8.8], 'C2.3' => [3.2, 3.0, 3.6, 2.8, 1.07, 2.6], 'C2.4' => [82, 88, 86, 92, .98, 94],
            'C3.1' => [62000, 55000, 38500, 56000, .76, 60000], 'C3.2' => [980, 950, 640, 900, .86, 960], 'C3.3' => [28, 30, 24, 30, .9, 32], 'C3.4' => [14, 16, 15.5, 20, 1.0, 22],
            'P1.1' => [45, 40, 42, 35, 1.06, 32], 'P1.2' => [88, 90, 89, 92, 1.0, 93], 'P1.3' => [62, 60, 66, 60, 1.05, 58], 'P1.4' => [1800, 2000, 1650, 2100, .78, 2200],
            'P2.1' => [185, 190, 205, 210, 1.0, 220], 'P2.2' => [182400, 157900, 123700, 152400, .9, 160000], 'P2.3' => [85, 88, 87, 90, .98, 92],
            'P3.1' => [31.7, 32.0, 35.8, 32.0, 1.05, 31.0], 'P3.2' => [24, 24, 26, 23, 1.04, 22], 'P3.3' => [5.5, 5.0, 6.2, 4.5, 1.1, 4.0], 'P3.4' => [86, 88, 87, 92, 1.0, 93],
            'P4.1' => [78, 85, 80, 90, .94, 92], 'P4.2' => [9, 8, 8.5, 6, 1.12, 5.5], 'P4.3' => [52, 50, 60, 52, 1.05, 48], 'P4.4' => [2.46, 2.40, 3.01, 2.60, .98, 2.40],
            'P5.1' => [14, 12, 11, 9, 1.0, 8], 'P5.2' => [2, 2, 2, 2, 1.0, 2], 'P5.3' => [72, 75, 78, 80, 1.0, 85],
            'P6.1' => [86, 90, 88, 93, .98, 94], 'P6.2' => [2.6, 2.8, 2.4, 2.8, .95, 3.0], 'P6.3' => [0.9, 0.7, 0.8, 0.5, 1.3, 0.45], 'P6.4' => [600, 800, 950, 1100, 1.0, 1200],
            'P7.1' => [12, 10, 10, 8, 1.1, 7],
            'L1.1' => [14, 16, 15, 20, 1.0, 22], 'L1.2' => [62, 70, 68, 80, .95, 85], 'L2.1' => [14.0, 12.0, 16.0, 10.0, 1.08, 9.0], 'L2.2' => [96.5, 97.0, 96.8, 97.5, 1.0, 97.5],
            'L2.3' => [9.0, 8.0, 7.5, 7.0, 1.04, 6.5], 'L2.4' => [70, 73, 68, 74, .98, 76], 'L3.1' => [0.31, 0.30, 0.26, 0.26, 1.0, 0.26], 'L3.2' => [675.2, 650, 639.2, 828, .79, 860],
        ];
    }

    protected function hotelInitiatives(int $year): array
    {
        if ($year === 2025) {
            return [
                'reno1' => ['SHID-25-01', 'Renovasi kamar tahap I (Nakula, Sadewa, Bima)', 'Tipe kamar baru dan pembaruan interior.', 'T3', 'eng', '2025-01-15', '2025-12-15', 'selesai', 5, 4, 3, 5, ['P1', 'C1'], 'ADR naik setelah renovasi.', 15_000_000_000, 200_000_000,
                    ['Desain interior', 'Pekerjaan sipil & MEP', 'Furnitur & instalasi', 'Inspeksi & serah terima'], ['Nakula & Sadewa siap jual', 'Bima Suite siap jual']],
                'arcade' => ['SHID-25-02', 'Optimalisasi sewa ruang toko (arcade)', 'Penyewa baru & penataan arcade.', 'T1', 'dirut', '2025-02-01', '2025-12-31', 'selesai', 4, 3, 2, 2, ['F1'], 'Pendapatan sewa ruang tiga kali lipat.', 500_000_000, 100_000_000,
                    ['Pemetaan ruang', 'Pemasaran ke penyewa', 'Penataan ulang arcade'], ['Okupansi arcade 85%']],
                'efisiensi' => ['SHID-25-03', 'Efisiensi biaya operasional', 'Penataan struktur organisasi & pengendalian biaya.', 'T4', 'cfo', '2025-03-01', '2025-12-31', 'selesai', 4, 5, 2, 1, ['F2', 'L3'], 'Biaya operasional di bawah anggaran.', 0, 50_000_000,
                    ['Kajian struktur', 'Pengendalian biaya energi', 'Renegosiasi kontrak'], ['Biaya ≤ anggaran']],
                'wedding' => ['SHID-25-04', 'Paket wedding & konser Puri Agung', 'Kemitraan WO, konser, acara komunitas.', 'T1', 'sales', '2025-04-01', '2025-12-31', 'selesai', 4, 4, 2, 2, ['C3'], 'Event swasta bertambah.', 0, 300_000_000,
                    ['Paket wedding', 'Kemitraan promotor konser', 'Wedding expo'], ['Konser besar terlaksana']],
                'esg' => ['SHID-25-05', 'Zero plastic & daur ulang', 'Pengurangan plastik sekali pakai.', 'T3', 'hk', '2025-03-01', '2025-12-31', 'berjalan', 3, 3, 1, 1, ['P4'], 'Plastik sekali pakai −50%.', 0, 80_000_000,
                    ['Dispenser air minum', 'Amenitas tanpa plastik', 'Bank sampah'], ['Kamar bebas botol plastik']],
            ];
        }
        if ($year === 2027) {
            return [
                'reno3' => ['SHID-27-01', 'Renovasi kamar tahap III & koridor', 'Lanjutan standarisasi desain seluruh lantai.', 'T3', 'eng', '2027-01-15', '2027-12-15', 'direncanakan', 5, 4, 3, 5, ['P1', 'C1'], 'Hunian 48%.', 18_000_000_000, 250_000_000,
                    ['Desain', 'Pekerjaan per lantai', 'Serah terima'], ['Lantai 8–10 selesai', 'Lantai 11–14 selesai']],
                'loyal' => ['SHID-27-02', 'Program loyalitas Sahid Rewards', 'Poin untuk menginap, F&B, event.', 'T2', 'sales', '2027-02-01', '2027-10-31', 'direncanakan', 4, 3, 2, 3, ['C2', 'C3'], 'Direct booking 22%.', 1_500_000_000, 400_000_000,
                    ['Desain program', 'Integrasi PMS & POS', 'Peluncuran'], ['Peluncuran Sahid Rewards']],
                'surya' => ['SHID-27-03', 'PLTS atap & chiller efisiensi tinggi', 'Transisi energi rendah emisi.', 'T3', 'eng', '2027-03-01', '2027-12-31', 'direncanakan', 4, 3, 3, 4, ['P4', 'F2'], 'kWh per malam kamar −8%.', 9_000_000_000, 150_000_000,
                    ['Studi kelayakan', 'Pengadaan', 'Instalasi'], ['PLTS beroperasi']],
                'operator' => ['SHID-27-04', 'Pengelolaan hotel baru (jaringan)', 'Kontrak manajemen hotel pihak ketiga.', 'T1', 'dirut', '2027-01-01', '2027-12-31', 'direncanakan', 4, 3, 3, 2, ['F1'], '2 kontrak pengelolaan baru.', 0, 600_000_000,
                    ['Prospek pemilik hotel', 'Uji tuntas', 'Penandatanganan'], ['Kontrak pertama']],
                'akademi' => ['SHID-27-05', 'Sahid Hospitality Academy', 'Pelatihan & sertifikasi berjenjang.', 'T4', 'hr', '2027-01-15', '2027-12-15', 'direncanakan', 3, 3, 2, 2, ['L1', 'L2'], '85% karyawan tersertifikasi.', 0, 350_000_000,
                    ['Kurikulum', 'Pelatihan', 'Uji kompetensi'], ['Angkatan pertama lulus']],
            ];
        }

        return [
            'reno2' => ['SHID-26-01', 'Renovasi kamar tahap II (Yudhistira & Arjuna Suite)', 'Pilar 2: renovasi aset & standarisasi desain.', 'T3', 'eng', '2026-01-15', '2026-12-15', 'berjalan', 5, 4, 3, 5, ['P1', 'C1'], 'Kamar siap jual bertambah; ADR ≥ Rp790 ribu.', 16_000_000_000, 250_000_000,
                ['Desain & tender', 'Pekerjaan sipil', 'MEP & interior', 'Furnitur', 'Serah terima'], ['Yudhistira Suite siap', 'Arjuna Suite siap', 'Lantai tahap II selesai']],
            'koridor' => ['SHID-26-02', 'Modernisasi koridor & lobi lift', 'Area publik sesuai standar bintang lima.', 'T3', 'eng', '2026-03-01', '2026-10-31', 'berjalan', 3, 3, 2, 3, ['C2', 'P4'], 'Skor kepuasan area publik naik.', 4_500_000_000, 100_000_000,
                ['Desain', 'Pekerjaan koridor', 'Lobi lift'], ['Koridor selesai', 'Lobi lift selesai']],
            'padel' => ['SHID-26-03', 'Lapangan padel & restoran rooftop', 'Pilar 1: produk di luar kamar & F&B; optimalisasi lahan.', 'T1', 'dirut', '2026-02-01', '2026-11-30', 'berjalan', 4, 4, 3, 4, ['F1', 'C3'], 'Pendapatan lain-lain Rp19,6 M.', 6_000_000_000, 400_000_000,
                ['Studi kelayakan', 'Perizinan', 'Konstruksi padel', 'Fit-out rooftop', 'Peluncuran'], ['Padel beroperasi', 'Rooftop soft opening']],
            'spa' => ['SHID-26-04', 'Spa & fitness centre baru', 'Fasilitas gaya hidup untuk tamu & member.', 'T1', 'fo', '2026-04-01', '2026-12-31', 'berjalan', 3, 3, 2, 3, ['F1', 'C2'], 'Member fitness 300 orang.', 3_000_000_000, 150_000_000,
                ['Desain', 'Konstruksi', 'Rekrutmen terapis', 'Pemasaran membership'], ['Soft opening']],
            'concierge' => ['SHID-26-05', 'e-Concierge Sahid (Hospitality 4.0)', 'Pilar 3: pre-check-in, layanan kamar, pembayaran, ulasan.', 'T2', 'admin', '2026-03-01', '2026-11-30', 'berjalan', 4, 4, 3, 3, ['C2', 'C3'], 'Direct booking 20%.', 1_200_000_000, 200_000_000,
                ['Pemilihan vendor', 'Integrasi PMS', 'Uji coba', 'Peluncuran'], ['Uji coba internal', 'Peluncuran ke tamu']],
            'segmen' => ['SHID-26-06', 'Diversifikasi segmen: ritel, korporat & travel agent', 'Penguatan kanal pemasaran & kerja sama mitra.', 'T1', 'sales', '2026-01-01', '2026-12-31', 'berjalan', 5, 5, 2, 2, ['C3', 'C1'], 'Porsi non-pemerintah ≥ 60%.', 0, 900_000_000,
                ['Account plan korporat', 'Kontrak travel agent', 'Paket komunitas', 'Kampanye digital'], ['30 akun korporat baru', 'Kontrak TA']],
            'wedding' => ['SHID-26-07', 'Puri Agung Wedding & Event', 'Paket wedding, konser, pameran.', 'T2', 'sales', '2026-01-01', '2026-12-31', 'berjalan', 4, 4, 2, 2, ['C3'], 'Pendapatan MICE Rp56 M.', 500_000_000, 600_000_000,
                ['Paket wedding 2026', 'Kemitraan WO', 'Kalender konser'], ['50 wedding terkontrak']],
            'netzero' => ['SHID-26-08', 'Menuju Hotel Net Zero Carbon', 'Pilar 4: kontrol konsumsi energi & air, operasi low carbon.', 'T3', 'eng', '2026-02-01', '2026-12-31', 'berjalan', 3, 3, 2, 3, ['P4'], 'Air per malam kamar ≤ 2,6 m³.', 2_000_000_000, 100_000_000,
                ['Audit energi', 'Smart meter', 'Retrofit LED & pompa', 'Kampanye hemat air'], ['Audit energi selesai', 'Smart meter terpasang']],
            'fnb' => ['SHID-26-09', 'Pengendalian F&B cost & menu engineering', 'Standard recipe, menu engineering, kontrak pemasok.', 'T3', 'chef', '2026-01-15', '2026-12-31', 'berjalan', 4, 4, 2, 1, ['P3', 'P6'], 'F&B cost ≤ 32%.', 0, 60_000_000,
                ['Standard recipe', 'Menu engineering', 'Kontrak pemasok'], ['Menu baru']],
            'sdm' => ['SHID-26-10', 'Cross-training & produktivitas SDM', 'Pelatihan silang & penilaian kinerja.', 'T4', 'hr', '2026-01-15', '2026-12-31', 'berjalan', 4, 3, 2, 2, ['L1', 'L2', 'L3'], '20 jam pelatihan per karyawan.', 0, 250_000_000,
                ['Matriks kompetensi', 'Cross-training', 'Sertifikasi BNSP'], ['Matriks kompetensi disahkan']],
        ];
    }

    protected function findingData(int $year): array
    {
        if ($year === 2025) {
            return [
                ['Pendapatan 2025 hanya 84% target', 'Pendapatan Rp124,0 M vs target Rp147,5 M; rugi Rp26,7 M vs target rugi Rp11,8 M.', 'tinjauan', 'tahunan', 'keuangan', 'kritis', 23_533_000_000, 'F1.1', null, 'komisaris', '2026-01-27',
                    [['Program 4 Pilar SahidTANGGUH 2026', 'dirut', '2026-12-31', 'berjalan', 60]], null],
                ['Hunian turun ke 30%', 'Hunian 30,00% vs 43,32% (2024).', 'tinjauan', 'tahunan', 'pelanggan', 'tinggi', null, 'C1.1', null, 'dirut', '2026-01-27',
                    [['Diversifikasi segmen 2026', 'sales', '2026-12-31', 'berjalan', 55]], null],
                ['Data konsumsi energi belum konsisten', 'Data energi untuk laporan keberlanjutan berbeda antar-sumber.', 'audit', null, 'proses', 'sedang', null, 'P4.3', 'esg', 'strategi', '2025-09-15',
                    [['Pencatatan meter harian', 'eng', '2025-12-31', 'selesai', 100]], ['2026-01-10', 'Pencatatan meter harian berjalan.']],
            ];
        }
        if ($year === 2027) {
            return [];
        }

        return [
            ['Jadwal renovasi tahap II mundur', 'Pekerjaan MEP terlambat 6 minggu; kamar siap jual berkurang.', 'timwas', 'boc', 'proses', 'tinggi', null, 'P1.4', 'reno2', 'komisaris', '2026-07-28',
                [['Tambah tim kontraktor MEP', 'eng', '2026-09-30', 'selesai', 100], ['Percepatan furnitur', 'eng', '2026-11-30', 'berjalan', 60]], null],
            ['MICE pemerintah masih di bawah target', 'Banquet Q2 82% target.', 'tinjauan', 'q2', 'pelanggan', 'tinggi', 5_000_000_000, 'C3.1', 'segmen', 'dirut', '2026-07-20',
                [['Account plan 30 korporat', 'sales', '2026-09-30', 'selesai', 100], ['Paket komunitas', 'sales', '2026-12-31', 'berjalan', 50]], null],
            ['e-Concierge belum terintegrasi PMS', 'Integrasi pembayaran tertunda.', 'internal', null, 'proses', 'sedang', null, 'C3.4', 'concierge', 'admin', '2026-08-20',
                [['Integrasi API pembayaran', 'admin', '2026-10-31', 'berjalan', 70]], null],
            ['Selisih stock opname F&B', 'Selisih 1,1% pada opname Juni.', 'audit', null, 'keuangan', 'sedang', 85_000_000, 'P6.3', 'fnb', 'cfo', '2026-07-05',
                [['Opname mingguan item bernilai tinggi', 'pur', '2026-08-31', 'selesai', 100]], ['2026-09-05', 'Selisih Agustus 0,5%.']],
            ['Keluhan kebisingan renovasi', 'Keluhan tamu meningkat di lantai dekat renovasi.', 'pelanggan', null, 'pelanggan', 'sedang', null, 'C2.3', 'reno2', 'fo', '2026-05-12',
                [['Jam kerja renovasi dibatasi', 'eng', '2026-05-31', 'selesai', 100], ['Blok kamar dekat area renovasi', 'fo', '2026-06-15', 'selesai', 100]], ['2026-06-30', 'Keluhan kebisingan turun.']],
        ];
    }

    protected function hotelDependencies(int $year): array
    {
        if ($year === 2025) {
            return [['Kontraktor interior tahap I', 'eksternal', 'reno1', 'P1', 'Kontraktor interior', 'Penyelesaian kamar bergantung kontraktor.', 'eng', 'tinggi', 'Denda keterlambatan dalam kontrak.']];
        }
        if ($year === 2027) {
            return [
                ['Pendanaan renovasi tahap III', 'internal', 'reno3', 'C1', 'Direksi & pemegang saham', 'Capex besar butuh pendanaan.', 'cfo', 'tinggi', 'Pendanaan bertahap & pinjaman bank.'],
                ['Integrasi loyalitas dengan PMS', 'eksternal', 'loyal', 'C3', 'Vendor PMS', 'Poin otomatis butuh API.', 'admin', 'sedang', 'Uji integrasi bertahap.'],
            ];
        }

        return [
            ['Perizinan lapangan padel & rooftop', 'eksternal', 'padel', 'F1', 'Pemprov DKI', 'Konstruksi bergantung izin.', 'dirut', 'tinggi', 'Pendampingan konsultan perizinan.'],
            ['Vendor aplikasi e-Concierge', 'eksternal', 'concierge', 'C2', 'Vendor aplikasi', 'Integrasi PMS & pembayaran.', 'admin', 'sedang', 'SLA & uji coba bertahap.'],
            ['Kontraktor MEP renovasi', 'eksternal', 'reno2', 'P1', 'Kontraktor MEP', 'Jadwal kamar siap jual.', 'eng', 'tinggi', 'Tambah tim kontraktor.'],
            ['Data meter energi & air', 'internal', 'netzero', 'P4', 'Engineering', 'KPI energi & air bergantung pencatatan meter.', 'eng', 'sedang', 'Smart meter.'],
        ];
    }

    protected function reviewTexts(): array
    {
        return [
            'venue' => 'Meeting Room Lantai 2, Hotel Grand Sahid Jaya', 'chair' => 'Direktur Utama',
            'annual' => [
                'summary' => "Pendapatan Rp124,0 M (84% target Rp147,5 M; −20,5%). Kamar Rp44,0 M, F&B Rp63,9 M, sewa ruang toko Rp13,2 M.\nHunian 30,00% (2024: 43,32%); ADR Rp780.112 (+14,9%) setelah renovasi tahap I.\nRugi tahun berjalan Rp26,7 M; kas operasi Rp29,9 M; 194 karyawan.",
                'decisions' => "1. Target 2026: pendapatan Rp165,6 M, rugi bersih ≤ Rp9,95 M.\n2. Program 4 Pilar SahidTANGGUH sebagai kerangka strategi.\n3. Laporan akhir bulan 10 departemen menjadi dasar KPI & dasbor manajemen.",
                'follow_up' => 'Koordinator Strategi memasukkan KPI & target 2026 ke BSC Hotel paling lambat 15 Februari.',
                'note' => 'Dewan Komisaris meminta pemantauan bulanan hunian, banquet per segmen, dan progres renovasi.',
            ],
            'months' => [
                2 => ['Ramadan mulai pertengahan Februari; banquet turun, buka puasa bersama naik.', 'Paket bukber korporat; jaga food cost.'],
                3 => ['Lebaran 20 Maret menurunkan bisnis; renovasi tahap II dimulai.', 'Blok kamar renovasi; promosi staycation Lebaran.'],
                6 => ['Semester I: pendapatan 89% target; ADR di atas target, hunian di bawah target.', 'Fokus volume hari kerja & korporat.'],
                7 => ['Libur sekolah: hunian 41%; wedding ramai di Puri Agung.', 'Tambah paket wedding akhir pekan.'],
            ],
            'q1' => ['Pendapatan Q1 87% target; hunian 36%; F&B cost 34%.', 'Percepat kampanye korporat & paket komunitas.'],
            'q2' => ['Pendapatan H1 89% target; banquet 82%; ADR Rp795 ribu.', 'Account plan 30 korporat; percepat e-Concierge.'],
            'board' => ['Komisaris menyoroti jadwal renovasi, banquet, dan rugi bersih.', 'Laporan progres renovasi bulanan.', 'Mohon analisis dampak renovasi terhadap kamar siap jual dan pendapatan per bulan.'],
            'sep' => 'Realisasi September sebagian masih draf; pendapatan banquet dikembalikan untuk dipisahkan berdasarkan tanggal acara.',
            'plan2027' => 'Draf RKAP 2027: pendapatan Rp175 M, hunian 48%, ADR Rp810 ribu; renovasi tahap III, Sahid Rewards, PLTS atap, pengelolaan hotel baru, Sahid Hospitality Academy.',
        ];
    }
}
