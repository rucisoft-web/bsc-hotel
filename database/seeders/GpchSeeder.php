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
 * Grand Pasundan Convention Hotel (kode GPCH), Bandung — hotel bintang 4, 164 kamar, Malibu Dome 1.200 pax.
 *
 * - 2025: PROYEKSI (tidak ada laporan tahunan publik) disusun dari pola operasional & laporan mingguan GM 2026.
 * - 2026: anggaran bulanan dari laporan GM (okupansi 52,54%, ADR Rp398.860 untuk September) dan realisasi Jan–Sep simulasi.
 * - 2027: perencanaan (draf RKAP).
 * Angka keuangan dibulatkan dan bersifat ilustrasi untuk penjelasan kepada manajemen; ganti dengan data VHP sebelum dipakai sungguhan.
 */
class GpchSeeder extends HotelShowcaseSeeder
{
    public const CODE = 'GPCH';

    public const PREFIX = 'gpch';

    public const SHORT = 'GPCH';

    public const LT = 'Proyeksi manajemen GPCH (laporan mingguan GM & anggaran 2026) — bukan laporan tahunan';

    protected function rooms(): int
    {
        return 164;
    }

    protected function companyAttributes(): array
    {
        return [
            'name' => 'Grand Pasundan Convention Hotel', 'legal_name' => 'Grand Pasundan Convention Hotel',
            'industry' => 'Hotel & konvensi bintang 4 (164 kamar, Malibu Dome 1.200 pax)',
            'address' => 'Jl. Peta No. 147–149', 'city' => 'Bandung', 'website' => 'https://grandpasundanhotel.com',
            'description' => 'DATA DEMO untuk persiapan BSC 2027 dan penjelasan kepada manajemen. Angka 2025 adalah PROYEKSI; anggaran 2026 mengacu pada laporan mingguan GM, realisasi 2026 disimulasikan. Ganti dengan data VHP sebelum dipakai sungguhan.',
        ];
    }

    protected function periodNote(int $year): string
    {
        return $year === 2025
            ? 'DATA DEMO — PROYEKSI 2025 (tidak ada laporan tahunan publik).'
            : 'DATA DEMO — anggaran 2026 dari laporan GM; realisasi Jan–Agu disetujui, Sep dalam proses (simulasi).';
    }

    protected function season(): array
    {
        $w = self::weights([1 => 7.8, 7.2, 6.2, 8.5, 8.8, 9.2, 9.4, 8.6, 8.6, 8.6, 8.8, 10.3]);

        return [2025 => $w, 2026 => $w];
    }

    protected function onTrack2026(): array
    {
        return ['C2.2', 'C2.4', 'L3.1', 'P1.4', 'P2.1', 'F1.4', 'P5.3', 'L2.2', 'P6.1'];
    }

    protected function missingSeptember(): array
    {
        return ['P6.4', 'L1.2'];
    }

    protected function returnedSeptember(): ?array
    {
        return ['P3.1', 'Food cost September masih memakai penangguhan beban persediaan. Hitung ulang dengan pemakaian riil sesuai keputusan Dewan Pengawas dan lampirkan berita acara stock opname.'];
    }

    protected function criticalIn2026(): array
    {
        return ['C3.3', 'P4.1'];
    }

    protected function maturityPattern(): array
    {
        return [2, 2, 3, 2, 2];
    }

    // ------------------------------------------------------------------ jati diri

    protected function identity(int $year): void
    {
        AtmanProfile::create([
            'vision' => 'Menjadi hotel dan pusat konvensi serbaguna berbasis pengalaman Pasundan yang menjadi kebanggaan Bandung dan pilihan utama korporasi, instansi, komunitas, dan keluarga.',
            'mission' => "1. Menghadirkan pengalaman menginap dan berkegiatan yang autentik bernuansa Sunda melalui pelayanan someah, kuliner, dan cerita.\n2. Menyediakan venue MICE, wedding, dan acara sosial yang layak, fleksibel, dan bernilai bagi pelanggan.\n3. Mengelola keuangan secara disiplin dan transparan dengan laporan bulanan yang lengkap (laba rugi, arus kas, neraca).\n4. Merawat aset dan fasilitas secara terencana agar nilai properti terus meningkat.\n5. Membangun SDM multitasking yang kompeten, sejahtera, dan bangga bekerja di Grand Pasundan.",
            'purpose' => 'Mengembalikan kejayaan Grand Pasundan sebagai landmark hotel & convention Bandung yang melestarikan tradisi Pasundan.',
            'tagline' => 'Preserve Pasundan Tradition',
            'brand_promise' => 'Kamar luas, venue besar, dan keramahan Sunda — setiap kunjungan meninggalkan cerita.',
            'value_proposition' => 'Hotel bintang 4 di koridor Pasir Koja dengan convention hall Malibu Dome 1.200 pax, 13 ruang rapat, kamar berukuran luas, kolam renang besar, parkir ±200 kendaraan, serta kuliner & budaya Sunda dengan harga terjangkau.',
            'culture_statement' => 'Kita bekerja sebagai satu tim: bersepakat dalam rapat berarti bersepakat dalam tindakan. Sistem adalah alat operasional, bukan sekadar laporan.',
            'history' => "Landmark hotel & convention Bandung dengan lahan luas dan bangunan kokoh.\nDes 2024: assessment awal operasional & fasilitas.\nMar 2025: konsep kerja hotel serbaguna berbasis pengalaman.\nApr 2025: PMS VHP Cloud live (FO, POS, Night Audit, AR, Banquet).\n2026: pengawasan oleh Dewan Pengawas pemilik; persiapan BSC 2027.",
            'approved_by' => $this->id('dirut'), 'approved_at' => ($year === 2027 ? 2026 : $year).'-01-15 10:00:00',
        ]);
        foreach ([
            ['Someah', 'Someah hade ka semah', 'Ramah, hangat, dan melayani sepenuh hati seperti menyambut tamu di rumah sendiri.', "Menyapa tamu dengan senyum dan salam\nMenceritakan Pasundan kepada tamu\nMembalas setiap ulasan dalam 24 jam"],
            ['Sabilulungan', 'Gotong royong', 'Bekerja sama lintas departemen; tim yang kuat lebih penting dari bintang perorangan.', "Membantu departemen lain saat peak (multitasking)\nMelaporkan kerusakan meski bukan tugasnya\nTidak saling menyalahkan dalam rapat"],
            ['Jujur & Amanah', 'Jujur', 'Mencatat dan melaporkan apa adanya, termasuk biaya dan persediaan.', "Tidak menangguhkan beban di data persediaan\nBukti pendukung untuk setiap realisasi KPI\nMenjaga dana deposit tamu sesuai peruntukannya"],
            ['Disiplin', 'Taat kana aturan', 'Taat pada SOP, jadwal, dan keputusan rapat.', "Input realisasi KPI paling lambat tanggal 5\nTindak lanjut notulen sesuai PIC & tenggat"],
            ['Berorientasi Hasil', 'Hasil', 'Setiap kegiatan harus berdampak pada pendapatan, biaya, atau kepuasan tamu.', "Mengukur dampak setiap promo\nMencari peluang event yang sedang tren\nMengurangi pemborosan"],
            ['Silih Asah', 'Silih asah, silih asih, silih asuh', 'Terus belajar dan saling mengajari agar kompeten dan berkembang.', "Mengikuti refresh training departemen\nMembimbing siswa PKL & trainee"],
        ] as $i => [$name, $local, $desc, $beh]) {
            CoreValue::create(['name' => $name, 'local_name' => $local, 'description' => $desc, 'behaviors' => $beh, 'sort' => $i + 1]);
        }
        $up = $year === 2025 ? 0 : 1;
        foreach ([
            ['Malibu Dome & 13 ruang rapat', 'Sumber daya fisik', 'Convention hall 1.152 m² untuk 1.200 pax theater; Half Malibu 500 pax; Jayagiri 272 m² dan 11 ruang rapat lain.', 4, 5, true, 'Perbaiki plafon Jayagiri, karpet, screen & AV (smartboard).'],
            ['Kamar luas & variasi suite', 'Sumber daya fisik', '155 kamar + 7 suite + 3-Bedroom Pasundan Suite; kamar Deluxe/Executive 4×8 m.', 4, 4, true, 'Refresh kamar bertahap 20 kamar per periode.'],
            ['Lahan, parkir & kolam renang', 'Sumber daya fisik', 'Parkir ±200 kendaraan, kolam renang besar, kids corner, poolside cafetaria.', 4, 4, true, 'Redesign area kolam; perbaiki sand filter.'],
            ['Kuliner Sunda & breakfast', 'Kompetensi', 'Nasi timbel, nampan liwet & tutug oncom, peyeum goreng; breakfast melampaui anggaran.', 3, 4, true, 'Standard recipe di VHP, menu bercerita, kelas memasak Sunda.'],
            ['Penjualan MICE & pemerintahan', 'Kompetensi', 'Relasi dengan instansi Kota/Kab. Bandung & Jawa Barat.', 3, 4, false, 'Pipeline harian, pitching korporasi & EO.'],
            ['Pemasaran digital & e-commerce', 'Kompetensi', 'WA blast, kampanye OTA, booking engine, metasearch Google.', 2 + $up, 4, false, 'Konten storytelling, influencer, kode promo website.'],
            ['Manajemen keuangan & pelaporan', 'Sistem', 'Laporan keuangan bulanan belum lengkap; neraca baru disusun; disiplin persediaan.', 2 + $up, 4, false, 'Tiga laporan wajib tiap bulan; proyeksi kas mingguan.'],
            ['Sistem informasi (VHP Cloud & BSC Hotel)', 'Sistem', 'VHP live Apr 2025; modul back office menunggu data master.', 2 + $up, 4, false, 'Lengkapi saldo awal, artikel, supplier; dasbor KPI di BSC Hotel.'],
            ['Pemeliharaan preventif', 'Kompetensi', 'Tim engineering terbatas; jadwal preventif belum konsisten.', 2, 4, false, 'Rekrut Chief Engineer, jadwal preventif & work order.'],
            ['SDM pelayanan multitasking', 'Kompetensi', '±72 karyawan + trainee; rasio ±0,44 karyawan per kamar.', 3, 4, false, 'Pelatihan silang, evaluasi kinerja bulanan, program PKL.'],
        ] as [$name, $cat, $desc, $cur, $tgt, $core, $gap]) {
            Capability::create(['name' => $name, 'category' => $cat, 'description' => $desc, 'current_level' => $cur, 'target_level' => $tgt, 'is_core' => $core, 'gap_action' => $gap]);
        }
    }

    // ------------------------------------------------------------------ lingkungan (ekosistem)

    protected function ecosystem(int $year): array
    {
        foreach ([
            ['Assessment awal operasional & fasilitas', '2024-12-08', 'internal', 'Assessment awal konsultan operasional (Des 2024)',
                'Fasilitas mulai kusam (lobby, toilet, karpet & screen ruang rapat, dapur & pastry, kolam). SDM: motivasi rendah, teknisi kurang, pelatihan belum terstruktur. Keuangan: neraca & laba rugi belum rutin. Keunggulan: kamar luas, lahan luas, executive floor & lounge.',
                'Perbaikan bertahap dapur, ruang rapat, lobby; tiga laporan keuangan wajib tiap bulan; PMS terhubung OTA.'],
            ['Konsep kerja 2025 — hotel serbaguna berbasis pengalaman', '2025-03-13', 'eksternal', 'Konsep Kerja GPCH 2025',
                'Pasar bergeser ke pengalaman yang fleksibel & personal; MICE pemerintah berkurang karena efisiensi anggaran. Peluang coworking/WFH, family staycation, wedding, komunitas.',
                'Storytelling Sunda, pemasaran digital, kemitraan TA/EO Jateng–Jatim, QRIS di semua outlet, SDM multitasking.'],
            ['Implementasi VHP Cloud', '2025-04-04', 'internal', 'Checklist implementasi VHP (Mar–Apr 2025)',
                'FO, POS, Night Audit, Income Audit, AR, Banquet live. Tertunda: saldo awal, aging, supplier, artikel inventory, channel manager.',
                'Lengkapi data master back office agar laba rugi & neraca dihasilkan dari sistem.'],
            ['Tinjauan likuiditas semester I 2026', '2026-06-30', 'internal', 'Analisis keuangan Juni 2026',
                'Surplus kas operasional sangat tipis (±1% penerimaan); aset lancar di bawah kewajiban operasional; pembelian F&B ±52% pendapatan F&B.',
                'Proyeksi kas mingguan, percepatan penagihan, kendali food cost, jadwal pembayaran pemasok.'],
            ['Benchmark competitive set — September 2026', '2026-09-28', 'eksternal', 'Laporan mingguan GM 21–27 Sep 2026',
                'GPCH peringkat 3 dari 5: okupansi 55,3%, ARR ±Rp331 ribu, RGI 0,92. Rating Booking.com 9,3 (tertinggi), Google 4,4. Lost business ±Rp192 juta dalam sepekan.',
                'Revenue recovery: tactical promotion di tanggal sepi, jaga ADR, banquet sebagai prioritas.'],
            ['Tren event & pameran daerah', '2026-09-23', 'eksternal', 'Rapat manajemen 23 Sep 2026',
                'Pameran mobil listrik sedang tren; PORPROV & Piala Gubernur Jawa Barat; Malibu Dome dipromosikan sebagai venue exhibition.',
                'Sales & semua kepala departemen mencari peluang event.'],
            ['Arah 2027: BSC berbasis laporan 10 departemen', '2026-11-10', 'internal', 'Rencana manajemen 2027',
                'Manajemen menyepakati laporan akhir bulan 10 departemen menjadi dasar KPI dan dasbor manajemen tahun 2027.',
                'Susun target 2027 per departemen; siklus input–verifikasi–persetujuan di BSC Hotel.'],
        ] as [$title, $date, $scope, $source, $summary, $impl]) {
            if ($year === 2025 && $date >= '2026-01-01') {
                continue;
            }
            EnvironmentScan::create(compact('title', 'scope', 'source', 'summary') + ['scan_date' => $date, 'implications' => $impl, 'status' => 'aktif', 'created_by' => $this->id('strategi')]);
        }

        foreach ([
            ['politik', 'Efisiensi anggaran belanja pemerintah', 'Pemangkasan anggaran perjalanan dinas & rapat instansi menurunkan MICE pemerintahan.', 'ancaman', 5, 4, 'naik', 'Diversifikasi ke korporasi, wedding, komunitas, pendidikan.'],
            ['politik', 'Agenda event olahraga & kebudayaan daerah', 'PORPROV, Piala Gubernur, kegiatan Disbudpar & Dispora rutin memakai hotel.', 'peluang', 3, 4, 'naik', 'Paket akomodasi atlet & ofisial.'],
            ['ekonomi', 'Kenaikan harga energi', 'Harga LPG industri & solar naik pada 2026.', 'ancaman', 4, 5, 'naik', 'Konversi LPG→CNG, lampu LED, monitoring energi mingguan.'],
            ['ekonomi', 'Biaya tenaga kerja & bahan baku naik', 'UMK, listrik, air, dan bahan F&B naik sementara harga kamar stagnan.', 'ancaman', 4, 5, 'naik', 'Kendali food cost, SDM multitasking.'],
            ['ekonomi', 'Permintaan staycation keluarga', 'Kolam renang besar & kamar luas diminati keluarga akhir pekan.', 'peluang', 3, 4, 'naik', 'Paket family staycation.'],
            ['sosial', 'Wisata pengalaman & budaya lokal', 'Tamu mencari pengalaman autentik: kuliner Sunda, cerita, desain lokal.', 'peluang', 4, 4, 'naik', 'Pasundan Experience.'],
            ['sosial', 'Pasar wedding & acara sosial Bandung', 'Permintaan venue wedding & gathering tetap tinggi.', 'peluang', 4, 3, 'stabil', 'Paket wedding Malibu Dome; wedding expo.'],
            ['teknologi', 'Dominasi OTA & metasearch', 'Sebagian besar reservasi individu lewat OTA; komisi menekan ARR.', 'ancaman', 4, 5, 'naik', 'Metasearch Google, booking engine, promo website, WA booking.'],
            ['teknologi', 'Digitalisasi pembayaran & PMS cloud', 'QRIS, VHP Cloud & dasbor mobile memungkinkan data real-time.', 'peluang', 3, 4, 'naik', 'QRIS di semua outlet; dasbor KPI.'],
            ['teknologi', 'Tren kendaraan listrik', 'Pameran mobil listrik diminati; kebutuhan charger EV di hotel.', 'peluang', 2, 3, 'naik', 'Jalur charger EV; Malibu Dome untuk pameran otomotif.'],
            ['lingkungan', 'Limbah & air tanah', 'Pajak air tanah, STP, TPS sampah meluap saat event besar.', 'ancaman', 3, 4, 'stabil', 'Pemanfaatan limbah STP, area khusus katering luar.'],
            ['hukum', 'Royalti hak cipta musik', 'Kewajiban royalti untuk musik di area publik, live music & karaoke.', 'ancaman', 3, 4, 'naik', 'Lisensi melalui LMKN.'],
            ['hukum', 'Kepatuhan pajak daerah', 'PBB & PBJT perhotelan wajib tepat waktu.', 'ancaman', 4, 4, 'stabil', 'Jadwal pembayaran & komunikasi dengan Bapenda.'],
            ['hukum', 'Penempatan tenaga kerja legal', 'Komposisi banyak daily worker & trainee perlu ditata.', 'ancaman', 3, 3, 'naik', 'Tinjau status kerja; administrasi HR lengkap.'],
        ] as [$factor, $title, $desc, $type, $impact, $like, $trend, $resp]) {
            PestelAnalysis::create(['factor' => $factor, 'title' => $title, 'description' => $desc, 'impact_type' => $type, 'impact_level' => $impact, 'likelihood' => $like, 'trend' => $trend, 'response' => $resp, 'source' => 'Analisis manajemen GPCH']);
        }

        foreach ([
            ['persaingan', 'Persaingan ketat koridor Pasir Koja – Bandung Barat', 'Hotel jaringan nasional bersaing di MICE & korporasi dengan produk lebih baru.', 5, 'Diferensiasi Pasundan Experience & kapasitas Malibu Dome.'],
            ['kekuatan_pembeli', 'Instansi & OTA menekan harga', 'Pembeli grup membandingkan harga; OTA mengendalikan visibilitas.', 4, 'Paket bernilai tambah; tingkatkan direct booking.'],
            ['pendatang_baru', 'Hotel & venue baru di Bandung', 'Venue konvensi alternatif terus bermunculan.', 3, 'Loyalitas akun korporat & pemerintah.'],
            ['produk_pengganti', 'Rapat daring & venue non-hotel', 'Gedung serbaguna, kafe & coworking sebagai pengganti.', 3, 'Paket hybrid meeting & coworking.'],
            ['kekuatan_pemasok', 'Pemasok F&B, energi & PMS', 'Harga bahan pokok & energi naik; ketergantungan vendor PMS & lift.', 3, 'Kontrak pemasok, survei harga pasar.'],
        ] as [$force, $title, $desc, $int, $impl]) {
            IndustryForce::create(['force' => $force, 'title' => $title, 'description' => $desc, 'intensity' => $int, 'implication' => $impl]);
        }

        foreach ([
            ['Instansi pemerintah (MICE pemerintahan)', 'MICE', 'Dinas & lembaga Kota/Kab. Bandung dan Jawa Barat — halfday & fullboard meeting.', 24, 'turun', true, 'Paket sesuai SBM, administrasi rapi, ruang besar.', 'Jaga akun, paket fullboard, tagih tepat waktu.'],
            ['Korporasi', 'Korporasi', 'Farmasi, perbankan, distributor — meeting, training, gathering.', 14, 'naik', true, 'Ruang rapat layak, harga fleksibel.', 'Corporate rate, paket meeting per pax.'],
            ['Grup & travel agent', 'Grup', 'Rombongan wisata & manasik umroh.', 9, 'naik', true, 'Harga grup, makan rombongan, parkir bus.', 'Kontrak TA Jateng–Jatim.'],
            ['OTA (individu)', 'OTA', 'Traveloka, Agoda, Tiket.com, Booking.com, Trip.com.', 27, 'naik', true, 'Harga kompetitif, ulasan baik.', 'Kampanye OTA, early bird, last minute.'],
            ['Direct (walk-in, website, WhatsApp)', 'Direct', 'Promo WA blast, walk-in, website & booking engine.', 11, 'naik', true, 'Respons cepat, promo eksklusif.', 'WA blast bulanan, metasearch Google.'],
            ['Wedding & acara sosial', 'Sosial', 'Pernikahan, reuni, gathering keluarga, komunitas & keagamaan.', 9, 'stabil', true, 'Venue indoor/outdoor, katering, paket all-in.', 'Paket wedding & wedding expo.'],
            ['Pendidikan & long stay group', 'Long stay', 'Kampus & PKL.', 6, 'stabil', true, 'Harga long stay, makan, laundry.', 'Tawarkan ke kampus lain.'],
            ['Leisure keluarga & staycation', 'Leisure', 'Keluarga akhir pekan & liburan sekolah.', null, 'naik', true, 'Kolam bersih, aktivitas anak, kuliner.', 'Paket Pasundan Experience.'],
            ['Work From Hotel', 'WFH', 'Pekerja jarak jauh butuh Wi-Fi cepat & meja kerja.', null, 'naik', false, 'Wi-Fi cepat, pencahayaan kamar.', 'Paket WFH setelah Wi-Fi diperbaiki.'],
        ] as [$seg, $grp, $desc, $share, $growth, $target, $needs, $strat]) {
            MarketAnalysis::create(['segment' => $seg, 'segment_group' => $grp, 'description' => $desc, 'share_percent' => $share, 'growth' => $growth, 'is_target' => $target, 'needs' => $needs, 'strategy' => $strat,
                'source' => $share ? 'PROYEKSI porsi pendapatan (data demo)' : 'Kualitatif']);
        }

        foreach ([
            ['Grand Pasundan Convention Hotel', 'Bintang 4', 164, 3, 4733, 2619, 55.33, 330913, 183110, 0.92, 0.96, 0.96, 4.4, 4.4, 8.3, 9.3, 4.1, true, 'Malibu Dome 1.200 pax, kamar luas, lahan & parkir luas, kolam besar.', 'Bangunan terkesan lama; ruang rapat & dapur perlu revitalisasi; ARR di bawah pesaing.'],
            ['Harris Hotel Festival Citylink', 'Bintang 4', null, 2, 5020, 2697, 53.72, 392520, 210880, 1.19, 1.06, 1.12, 4.6, 4.6, 8.4, 8.3, 4.5, false, 'Terhubung mal, brand jaringan nasional.', 'Ballroom lebih kecil dari Malibu Dome.'],
            ['Santika Hotel Pasir Koja', 'Bintang 3', null, 1, 2520, 1672, 66.34, 360517, 239200, 1.35, 1.31, 1.03, 4.7, 4.9, 8.6, 8.3, 4.5, false, 'Okupansi & RevPAR tertinggi.', 'Jumlah kamar lebih sedikit.'],
            ['Horison Hotel Bandung', 'Bintang 4', null, 4, 5656, 2916, 51.55, 377955, 194850, 1.10, 1.01, 1.08, 4.2, 4.4, 7.9, 7.2, 4.0, false, 'Jaringan Horison, aktif di reuni & instansi.', 'Rating OTA lebih rendah.'],
            ['Grand Asrilia Hotel', 'Bintang 4', null, 5, 5860, 2450, 41.80, 322078, 134650, 0.76, 0.82, 0.92, 4.3, 3.0, 8.3, null, 4.2, false, 'Convention & exhibition.', 'Okupansi & RevPAR terendah.'],
        ] as [$name, $cat, $rooms, $rank, $avail, $sold, $occ, $arr, $revpar, $rgi, $mpi, $ari, $g, $ta, $tv, $bk, $tk, $self, $str, $weak]) {
            Competitor::create(['name' => $name, 'category' => $cat, 'room_count' => $rooms, 'rank' => $rank, 'data_period' => 'Sep 2026 (laporan mingguan GM)',
                'room_available' => $avail, 'room_sold' => $sold, 'occupancy' => $occ, 'arr' => $arr, 'revpar' => $revpar, 'rgi' => $rgi, 'mpi' => $mpi, 'ari' => $ari,
                'rating_google' => $g, 'rating_tripadvisor' => $ta, 'rating_traveloka' => $tv, 'rating_booking' => $bk, 'rating_tiket' => $tk,
                'is_self' => $self, 'strengths' => $str, 'weaknesses' => $weak]);
        }

        foreach ([
            ['Pajak Barang dan Jasa Tertentu (PBJT) perhotelan & makanan-minuman', 'Pemerintah Kota Bandung', 'UU No. 1 Tahun 2022 (HKPD) & Perda Kota Bandung', 'Pajak', null, 'Pajak daerah atas jasa perhotelan dan F&B, disetor bulanan.', 'Harus tercermin benar di PMS (tax & service).', 'patuh', 'cfo', null],
            ['Pajak Bumi dan Bangunan (PBB-P2)', 'Bapenda Kota Bandung', null, 'Pajak', '2025-01-01', 'Kewajiban PBB tahunan atas lahan & bangunan hotel.', 'Denda bila terlambat; membebani arus kas.', 'sebagian', 'cfo', '2026-12-31'],
            ['Pajak air tanah', 'Bapenda', null, 'Pajak', null, 'Pemakaian sumur; pencatatan meter rutin.', 'Biaya utilitas.', 'patuh', 'eng', null],
            ['Royalti hak cipta lagu dan/atau musik', 'Kementerian Hukum — LMKN', 'PP No. 56 Tahun 2021', 'Hak cipta', null, 'Musik di area publik, live music & karaoke wajib royalti.', 'Risiko teguran/tuntutan.', 'dipantau', 'hr', '2026-12-31'],
            ['PKWT & alih daya', 'Kementerian Ketenagakerjaan', 'PP No. 35 Tahun 2021', 'Ketenagakerjaan', null, 'Ketentuan PKWT, alih daya, waktu kerja.', 'Status daily worker perlu ditata.', 'sebagian', 'hr', '2026-12-31'],
            ['Sertifikasi usaha & standar hotel bintang', 'Kementerian Pariwisata / LSU', 'Permenparekraf No. 4 Tahun 2021', 'Perizinan', null, 'Sertifikat usaha hotel sesuai standar klasifikasi bintang.', 'Perlu dipenuhi untuk segmen pemerintah & korporat.', 'patuh', 'dirut', null],
            ['Jaminan produk halal F&B', 'BPJPH Kementerian Agama', 'UU No. 33 Tahun 2014', 'F&B', null, 'Sertifikasi halal produk F&B yang dijual.', 'Penting untuk segmen pemerintah, umroh & keluarga.', 'dipantau', 'chef', '2026-10-17'],
            ['K3 elevator & proteksi kebakaran', 'Kementerian Ketenagakerjaan / Damkar', 'Permenaker No. 6 Tahun 2017', 'Keselamatan', null, 'Pemeriksaan berkala lift, APAR, hydrant, sprinkler.', 'Wajib laik operasi.', 'sebagian', 'sec', '2026-11-30'],
            ['Baku mutu air limbah domestik', 'Kementerian Lingkungan Hidup', 'Permen LHK No. P.68 Tahun 2016', 'Lingkungan', null, 'STP harus memenuhi baku mutu.', 'Uji lab berkala.', 'dipantau', 'eng', null],
        ] as [$title, $issuer, $ref, $cat, $eff, $desc, $impact, $status, $owner, $due]) {
            Regulation::create(['title' => $title, 'issuer' => $issuer, 'reference_no' => $ref, 'category' => $cat, 'effective_date' => $eff, 'description' => $desc, 'impact' => $impact, 'compliance_status' => $status, 'owner_id' => $this->id($owner), 'due_date' => $due]);
        }

        $sh = [];
        foreach ([
            'pemilik' => ['Pemilik & Direksi', 'internal', 'Pemilik', 5, 5, 'Hasil: laba, nilai properti, nama baik Grand Pasundan.', 'Laporan bulanan ringkas dari dasbor BSC.', 'General Manager'],
            'pengawas' => ['Dewan Pengawas pemilik', 'internal', 'Pengawas', 5, 5, 'Disiplin biaya, laporan keuangan riil, tindak lanjut keputusan.', 'Catatan pengawasan di BSC Hotel.', 'Koordinator Strategi'],
            'karyawan' => ['Karyawan (PKWT, daily worker, trainee)', 'internal', 'SDM', 5, 3, 'Gaji & service charge tepat waktu, pelatihan, kejelasan aturan.', 'Forum bulanan, evaluasi kinerja.', 'HR Manager'],
            'korporat' => ['Tamu korporat & instansi pemerintah', 'eksternal', 'Pelanggan', 5, 4, 'Ruang rapat layak, harga sesuai, administrasi rapi.', 'Sales call, account management.', 'Sales & Marketing'],
            'tamu' => ['Tamu individu & keluarga', 'eksternal', 'Pelanggan', 4, 4, 'Kamar bersih, kolam & sarapan baik, Wi-Fi cepat.', 'Survei tamu, respons ulasan.', 'Rooms Division'],
            'ota' => ['OTA', 'eksternal', 'Mitra distribusi', 4, 4, 'Paritas harga, ketersediaan, respons ulasan.', 'Business review berkala.', 'Rooms Division'],
            'ta_eo' => ['Travel agent & event organizer', 'eksternal', 'Mitra penjualan', 4, 3, 'Komisi, harga grup, kemudahan booking.', 'Kontrak & table top.', 'Sales & Marketing'],
            'vhp' => ['Vendor PMS cloud', 'eksternal', 'Vendor', 3, 3, 'Data master lengkap, tiket permintaan jelas.', 'Daftar permintaan & PIC.', 'EDP'],
            'pemasok' => ['Pemasok F&B & material', 'eksternal', 'Pemasok', 3, 4, 'Pembayaran tepat waktu.', 'Jadwal pembayaran berdasarkan prioritas.', 'Purchasing'],
            'pemkot' => ['Pemkot Bandung (Bapenda, Disbudpar, Dispora)', 'eksternal', 'Regulator & pelanggan', 4, 4, 'Kepatuhan pajak, dukungan event kota.', 'Kemitraan event.', 'Financial Controller / Sales'],
            'warga' => ['Masyarakat sekitar', 'eksternal', 'Komunitas', 2, 3, 'Kontribusi sosial, lingkungan bersih.', 'CSR & kerja sama kecamatan.', 'HR Manager'],
            'media' => ['Media lokal', 'eksternal', 'Media', 2, 3, 'Konten menarik.', 'Rilis venue exhibition, video profil.', 'Sales & Marketing'],
        ] as $key => [$name, $type, $cat, $infl, $int, $exp, $strat, $cp]) {
            $sh[$key] = Stakeholder::create(['name' => $name, 'type' => $type, 'category' => $cat, 'influence' => $infl, 'interest' => $int, 'expectations' => $exp, 'engagement_strategy' => $strat, 'contact_person' => $cp]);
        }

        $issues = [];
        foreach ([
            'rev' => ['Pendapatan jauh di bawah anggaran', 'Pendapatan Jan–Sep 2026 ±65% anggaran; shortfall terbesar di banquet & outlet F&B.', 'keuangan', 5, 5, 'dirut', ['pemilik', 'pengawas', 'korporat']],
            'banquet' => ['Banquet/MICE bergantung pada instansi pemerintah', 'Banquet ±44% anggaran; MICE pemerintah turun karena efisiensi anggaran.', 'pelanggan', 5, 5, 'sales', ['korporat', 'ta_eo', 'pemkot']],
            'cash' => ['Likuiditas tipis', 'Surplus kas operasional ±1%; deposit tamu & OTA perlu dijaga terpisah.', 'keuangan', 5, 5, 'cfo', ['pemilik', 'pengawas', 'pemasok', 'ota']],
            'foodcost' => ['Food cost & pembelian F&B tinggi', 'Pembelian F&B ±52% pendapatan F&B; praktik penangguhan beban dihentikan pengawas.', 'proses', 4, 4, 'chef', ['pengawas', 'pemasok']],
            'facility' => ['Kondisi fasilitas menurun', 'Dapur, karpet/screen ruang rapat, plafon Jayagiri, sand filter kolam, panel lift.', 'proses', 4, 5, 'eng', ['korporat', 'pemilik']],
            'arr' => ['ARR di bawah kompetitor', 'ARR ±Rp331 ribu (ARI 0,96) vs pesaing Rp378–393 ribu; diskon menekan ADR.', 'pelanggan', 4, 4, 'sales', ['ota', 'korporat']],
            'reputation' => ['Reputasi digital & pengalaman tamu', 'Akun Google palsu & komentar spam; keluhan air mineral, bangunan lama, Wi-Fi lambat.', 'pelanggan', 4, 4, 'fo', ['ota', 'media', 'tamu']],
            'reporting' => ['Pelaporan keuangan & pemanfaatan VHP belum optimal', 'Neraca belum rutin; modul back office menunggu data master.', 'proses', 4, 4, 'cfo', ['vhp', 'pengawas']],
            'hr' => ['Motivasi, kesejahteraan & kompetensi SDM', 'Riwayat keterlambatan gaji & service charge; pelatihan belum terstruktur; posisi kunci Plt.', 'sdm', 4, 4, 'hr', ['karyawan']],
            'energy' => ['Kenaikan biaya energi', 'Kenaikan LPG & solar; konsumsi listrik ±89 ribu kWh/bulan.', 'keuangan', 3, 4, 'eng', ['pemasok']],
            'safety' => ['Keselamatan & keamanan saat event besar', 'Event 1.200 pax membutuhkan kontrol akses, jalur evakuasi, dan latihan darurat.', 'proses', 3, 4, 'sec', ['korporat', 'tamu']],
            'leadership' => ['Kesinambungan kepemimpinan', 'Pergantian GM 1 Okt 2026; risiko putusnya tindak lanjut keputusan rapat.', 'sdm', 3, 4, 'dirut', ['pengawas', 'karyawan']],
        ] as $key => [$title, $desc, $persp, $urg, $imp, $owner, $stks]) {
            $issues[$key] = StrategicIssue::create(['title' => $title, 'description' => $desc, 'perspective' => $persp, 'urgency' => $urg, 'impact' => $imp,
                'status' => $year === 2025 ? 'terbuka' : 'ditangani', 'source' => 'Analisis manajemen GPCH', 'owner_id' => $this->id($owner)]);
            $issues[$key]->stakeholders()->sync(collect($stks)->map(fn ($s) => $sh[$s]->id));
        }

        $sort = 0;
        foreach ([
            ['S', 'Malibu Dome 1.200 pax + 13 ruang rapat', 'Kapasitas convention terbesar di koridor Bandung barat.', 0.15, 4],
            ['S', 'Kamar luas & 7 suite', 'Keunggulan yang tak terbantahkan.', 0.10, 4],
            ['S', 'Lahan luas, parkir ±200 kendaraan, kolam besar', 'Cocok untuk keluarga, rombongan bus, event besar.', 0.10, 3],
            ['S', 'Rating Booking.com 9,3 & resepsionis ramah', 'Ulasan memuji kebersihan & keramahan.', 0.05, 3],
            ['S', 'Breakfast & healthy club di atas anggaran', 'Outlet yang konsisten melampaui target.', 0.05, 3],
            ['W', 'Fasilitas & interior menua', 'Dapur, ruang rapat, toilet lobby, kolam.', 0.12, 2],
            ['W', 'Likuiditas tipis', 'Surplus kas ±1%.', 0.12, 1],
            ['W', 'Food cost tinggi & disiplin persediaan lemah', 'Pembelian F&B ±52% pendapatan F&B.', 0.08, 2],
            ['W', 'Outlet F&B jauh di bawah target', 'Coffee shop, room service, lounge 20–30% anggaran.', 0.08, 2],
            ['W', 'Pelaporan & sistem belum optimal; pelatihan ad hoc', 'Neraca belum rutin.', 0.10, 2],
            ['O', 'Event olahraga & kebudayaan daerah', 'PORPROV & Piala Gubernur.', 0.10, 3],
            ['O', 'Tren staycation budaya & keluarga', 'Pasundan Experience.', 0.10, 3],
            ['O', 'Pasar wedding & exhibition', 'Malibu Dome ideal untuk pameran.', 0.10, 3],
            ['O', 'Kemitraan TA/EO Jawa Tengah & Jawa Timur', 'Table top & travel mart.', 0.05, 2],
            ['T', 'Efisiensi anggaran pemerintah', 'MICE pemerintah dibatalkan/dialihkan online.', 0.15, 2],
            ['T', 'Kompetitor lebih baru & agresif', 'RGI pesaing utama 1,35.', 0.15, 2],
            ['T', 'Kenaikan biaya energi & bahan baku', 'LPG, solar, listrik naik.', 0.10, 2],
            ['T', 'Serangan reputasi digital', 'Akun Google palsu, ulasan spam.', 0.05, 3],
        ] as [$type, $title, $desc, $w, $r]) {
            SwotItem::create(['type' => $type, 'title' => $title, 'description' => $desc, 'weight' => $w, 'rating' => $r, 'sort' => ++$sort, 'source' => 'Analisis manajemen GPCH']);
        }

        return $issues;
    }

    protected function tows(array $issues): void
    {
        foreach ([
            ['SO', 'Jual Malibu Dome untuk event olahraga, exhibition & wedding besar', 'PORPROV, pameran mobil listrik, wedding expo.', 5, ['banquet', 'rev']],
            ['SO', 'Paket "Pasundan Experience" untuk keluarga & staycation budaya', 'Kamar luas + kolam + kuliner Sunda + kids corner.', 4, ['rev', 'arr']],
            ['WO', 'Revitalisasi bertahap berbasis prioritas pendapatan', 'Ruang rapat & dapur lebih dulu agar tidak kehilangan event.', 4, ['facility', 'banquet']],
            ['WO', 'Disiplin food cost lewat standard recipe & survei harga pasar', 'Standard recipe di VHP; hentikan penangguhan beban.', 4, ['foodcost', 'reporting']],
            ['ST', 'Tactical pricing & revenue management harian', 'Promo hanya di tanggal sepi, jaga ADR.', 5, ['arr', 'rev']],
            ['ST', 'Diversifikasi dari MICE pemerintah ke korporasi, sosial & TA', 'Pipeline harian, sales call, kontrak TA/EO.', 5, ['banquet']],
            ['WT', 'Penyehatan arus kas', 'Proyeksi kas mingguan, penagihan piutang, rekening deposit terpisah.', 5, ['cash']],
            ['WT', 'Efisiensi energi & SDM multitasking', 'Konversi LPG→CNG, LED, pelatihan silang.', 3, ['energy', 'hr']],
            ['WT', 'Pemulihan reputasi digital', 'Bersihkan akun palsu, respons ulasan < 24 jam.', 4, ['reputation']],
            ['WO', 'BSC Hotel untuk siklus KPI 10 departemen', 'Input tanggal 5, verifikasi tanggal 7, persetujuan tanggal 8.', 4, ['reporting', 'leadership']],
            ['ST', 'Standar keamanan event besar', 'Kontrol akses, jalur evakuasi, briefing security sebelum event.', 3, ['safety']],
        ] as [$type, $title, $desc, $prio, $iss]) {
            $t = TowsStrategy::create(['type' => $type, 'title' => $title, 'description' => $desc, 'priority' => $prio, 'status' => 'dipilih']);
            $t->issues()->sync(collect($iss)->map(fn ($k) => $issues[$k]->id));
        }
    }

    // ------------------------------------------------------------------ tema & pilihan

    protected function themeDefs(): array
    {
        return [
            'T1' => ['Pemulihan Pendapatan', 'Revenue recovery kamar & banquet: tactical pricing, diversifikasi segmen, kemitraan TA/EO.', '#A8432A'],
            'T2' => ['Pengalaman Pasundan', 'Storytelling Sunda, kamar & kolam yang terawat, reputasi digital, keamanan tamu.', '#B8862B'],
            'T3' => ['Disiplin Keuangan & Operasional', 'Tiga laporan wajib, food cost, energi, pengadaan, pemeliharaan preventif.', '#34506E'],
            'T4' => ['SDM Multitasking yang Kompeten & Sejahtera', 'Gaji & service tepat waktu, pelatihan terstruktur, struktur ramping.', '#4F6B3A'],
        ];
    }

    protected function choiceDefs(): array
    {
        return [
            ['T1', 'Fokus korporasi, MICE swasta, sosial & grup; kurangi ketergantungan MICE pemerintah', 'pasar', 'MICE pemerintah turun akibat efisiensi anggaran.'],
            ['T1', 'Tactical promotion di tanggal sepi, bukan diskon menyeluruh', 'harga', 'ADR jauh di bawah anggaran dan ARI 0,96.'],
            ['T1', 'Jaringan travel agent & event organizer Jawa Tengah – Jawa Timur', 'saluran', 'Semarang, Surabaya, Solo, Yogyakarta.'],
            ['T2', 'Diferensiasi "Pasundan Experience"', 'produk', 'Identitas Pasundan belum terasa di lobby, coffee shop, kamar.'],
            ['T2', 'Reposisi Executive Floor & Lounge sebagai kelas VIP', 'produk', 'Variasi tingkatan kamar sebagai keunggulan.', 'diusulkan'],
            ['T3', 'Revitalisasi bertahap: dapur & ruang rapat lebih dulu', 'operasi', 'Risiko food safety & kehilangan event.'],
            ['T3', 'Tiga laporan keuangan wajib & VHP sebagai alat operasional', 'operasi', 'Sistem adalah alat operasional, bukan laporan.'],
            ['T3', 'Konversi LPG ke CNG & pemanfaatan limbah STP', 'operasi', 'Harga LPG naik.'],
            ['T4', 'Kajian alih daya supporting department', 'organisasi', 'Perlu kajian biaya-manfaat.', 'diusulkan'],
            ['T4', 'Pola kerja multitasking & shift berbasis okupansi', 'organisasi', 'Rasio karyawan ±0,44 per kamar.'],
        ];
    }

    // ------------------------------------------------------------------ angka KPI

    protected function kpiNumbers(): array
    {
        // [2024, target 2025, realisasi 2025, target 2026, faktor realisasi 2026, target 2027?] — Rp juta kecuali disebut lain
        return [
            'F1.1' => [27800, 30000, 25450, 32861, .70, 33500], 'F1.2' => [11000, 12000, 10200, 13336, .82, 13900],
            'F1.3' => [15700, 16900, 14200, 18388, .56, 18500], 'F1.4' => [1100, 1100, 1050, 1137, .95, 1200],
            'F2.1' => [12.0, 16.0, 9.0, 18.0, .72, 18.0], 'F2.2' => [104, 100, 106, 100, 1.05, 100], 'F2.3' => [38, 34, 40, 33, 1.14, 33],
            'F3.1' => [150, 150, 168, 60, 2.1, 50], 'F3.2' => [600, 900, 300, 1200, .45, 1500],
            'C1.1' => [52.0, 54.0, 50.9, 55.5, .915, 57.0], 'C1.2' => [352, 365, 334, 401, .87, 395], 'C1.3' => [183, 197, 170, 223, .80, 225],
            'C1.4' => [31200, 32300, 30500, 33233, .935, 34100], 'C1.5' => [6.0, 5.5, 6.4, 5.0, 1.12, 4.8],
            'C2.1' => [82, 85, 83, 87, .98, 88], 'C2.2' => [8.3, 8.5, 8.5, 8.7, 1.0, 8.9], 'C2.3' => [3.5, 3.0, 3.4, 2.6, 1.15, 2.4], 'C2.4' => [70, 85, 80, 92, 1.0, 95],
            'C3.1' => [11000, 12500, 9800, 14949, .48, 14000], 'C3.2' => [330, 360, 300, 360, .83, 370], 'C3.3' => [25, 28, 24, 30, .85, 32], 'C3.4' => [6, 8, 7, 12, .80, 15],
            'P1.1' => [50, 45, 48, 40, 1.08, 35], 'P1.2' => [82, 86, 84, 90, .96, 92], 'P1.3' => [45, 44, 47, 44, 1.04, 43], 'P1.4' => [600, 700, 650, 960, .9, 1000],
            'P2.1' => [95, 100, 98, 105, 1.0, 110], 'P2.2' => [30000, 33000, 31500, 34400, .86, 35000], 'P2.3' => [78, 84, 80, 88, .95, 90],
            'P3.1' => [38, 35, 39.5, 35, 1.12, 34], 'P3.2' => [28, 26, 29, 25, 1.08, 25], 'P3.3' => [7.0, 6.0, 7.5, 5.0, 1.25, 4.5], 'P3.4' => [75, 82, 78, 88, .93, 90],
            'P4.1' => [55, 70, 60, 90, .78, 92], 'P4.2' => [14, 10, 12, 8, 1.25, 7], 'P4.3' => [36, 34, 35, 32, 1.06, 30], 'P4.4' => [1.20, 1.10, 1.15, 1.0, 1.08, 0.95],
            'P5.1' => [10, 8, 9, 6, 1.15, 5], 'P5.2' => [1, 2, 1, 2, 1.0, 2], 'P5.3' => [70, 75, 72, 85, 1.0, 88],
            'P6.1' => [80, 88, 84, 92, 1.0, 94], 'P6.2' => [2.0, 2.4, 2.1, 2.6, .90, 2.8], 'P6.3' => [1.5, 1.0, 1.4, 0.6, 1.9, 0.5], 'P6.4' => [80, 120, 110, 180, .85, 220],
            'P7.1' => [25, 15, 20, 10, 1.2, 8],
            'L1.1' => [6, 12, 8, 24, .55, 24], 'L1.2' => [35, 50, 40, 65, .9, 75], 'L2.1' => [18, 15, 17, 12, 1.1, 10], 'L2.2' => [95.0, 96.0, 95.5, 97.0, 1.0, 97.5],
            'L2.3' => [10, 8, 9, 7, 1.1, 6.5], 'L2.4' => [58, 65, 60, 70, .95, 74], 'L3.1' => [0.50, 0.55, 0.47, 0.55, .82, 0.52], 'L3.2' => [339, 353, 339, 411, .72, 430],
        ];
    }

    // ------------------------------------------------------------------ inisiatif

    protected function hotelInitiatives(int $year): array
    {
        if ($year === 2025) {
            return [
                'vhp' => ['GPCH-25-01', 'Implementasi VHP Cloud (PMS & back office)', 'Setup FO, POS, Night Audit, Income Audit, AR, Banquet; data master back office.', 'T3', 'cfo', '2025-02-01', '2025-09-30', 'selesai', 4, 5, 3, 3, ['P7', 'L3'], 'PMS live; laporan harian dari sistem.', 350_000_000, 60_000_000,
                    ['Setup FO & reservasi', 'Setup POS 4 outlet', 'Night Audit & Income Audit', 'Modul AR & Banquet', 'Pelatihan pengguna'], ['VHP live', 'Laporan harian dari sistem']],
                'konsep' => ['GPCH-25-02', 'Konsep kerja hotel serbaguna & pemasaran digital', 'Storytelling Sunda, kode promo website, QRIS, kemitraan TA/EO.', 'T1', 'sales', '2025-03-15', '2025-12-31', 'selesai', 4, 4, 2, 2, ['C3', 'C1'], 'Direct booking naik; kemitraan TA baru.', 0, 120_000_000,
                    ['Kode promo & booking engine', 'QRIS di semua outlet', 'Konten media sosial', 'Table top TA Jateng–Jatim'], ['Booking engine live', '10 kontrak TA baru']],
                'dapur1' => ['GPCH-25-03', 'Perbaikan dapur & pastry tahap 1', 'Lantai epoxy, saluran, exhaust.', 'T3', 'chef', '2025-06-01', '2025-11-30', 'selesai', 4, 4, 3, 3, ['P3'], 'Dapur memenuhi standar higiene dasar.', 280_000_000, 20_000_000,
                    ['Desain & RAB', 'Pekerjaan epoxy', 'Exhaust & saluran'], ['Dapur beroperasi kembali']],
                'sop' => ['GPCH-25-04', 'Penyusunan SOP 10 departemen', 'SOP & format laporan akhir bulan per departemen.', 'T4', 'hr', '2025-04-01', '2025-12-31', 'berjalan', 3, 3, 2, 1, ['L1', 'P7'], 'SOP & format laporan bulanan seragam.', 0, 35_000_000,
                    ['SOP Rooms & HK', 'SOP F&B & Kitchen', 'SOP Engineering & Security', 'SOP Finance, HR, Purchasing'], ['SOP disahkan GM']],
                'malibu' => ['GPCH-25-05', 'Promosi Malibu Dome untuk wedding & exhibition', 'Paket wedding all-in, kerja sama WO, venue exhibition.', 'T1', 'sales', '2025-05-01', '2025-12-31', 'selesai', 4, 3, 2, 2, ['C3'], 'Event non-pemerintah bertambah.', 0, 90_000_000,
                    ['Paket wedding', 'Kerja sama WO', 'Kampanye venue exhibition'], ['5 event exhibition']],
            ];
        }
        if ($year === 2027) {
            return [
                'kamar27' => ['GPCH-27-01', 'Refresh kamar tahap 2 (60 kamar)', 'Karpet, tirai, pencahayaan kerja, smart TV, amenitas bernuansa Sunda.', 'T2', 'hk', '2027-01-15', '2027-09-30', 'direncanakan', 4, 4, 3, 4, ['P1', 'C2', 'C1'], 'ADR naik ±Rp20 ribu untuk kamar yang direfresh.', 1_800_000_000, 80_000_000,
                    ['Desain & RAB', 'Pengadaan material', 'Pekerjaan per lantai', 'Inspeksi & serah terima'], ['Lantai 5–6 selesai', 'Lantai 7–8 selesai']],
                'wedding27' => ['GPCH-27-02', 'Pasundan Wedding & Exhibition Center', 'Paket wedding adat Sunda, kalender exhibition tahunan Malibu Dome.', 'T1', 'sales', '2027-01-01', '2027-12-31', 'direncanakan', 5, 4, 2, 3, ['C3', 'F1'], 'Pendapatan banquet Rp14 M.', 250_000_000, 300_000_000,
                    ['Kalender exhibition 2027', 'Paket wedding adat Sunda', 'Kemitraan WO & EO', 'Wedding expo'], ['12 exhibition terkontrak', '40 wedding terkontrak']],
                'rm27' => ['GPCH-27-03', 'Revenue management & channel manager', 'RMS sederhana, rate shopping harian, channel manager terhubung VHP.', 'T1', 'fo', '2027-01-01', '2027-06-30', 'direncanakan', 4, 4, 2, 2, ['C1', 'F1'], 'RGI ≥ 1,00.', 150_000_000, 60_000_000,
                    ['Pemilihan channel manager', 'Integrasi VHP', 'Pelatihan revenue meeting'], ['Channel manager live']],
                'energi27' => ['GPCH-27-04', 'Hemat energi tahap 2: CNG & panel surya atap', 'Konversi seluruh dapur ke CNG; PLTS atap 100 kWp.', 'T3', 'eng', '2027-03-01', '2027-12-31', 'direncanakan', 3, 3, 3, 4, ['P4', 'F2'], 'kWh per malam kamar −10%.', 1_200_000_000, 40_000_000,
                    ['Studi kelayakan PLTS', 'Konversi CNG', 'Instalasi PLTS'], ['CNG seluruh dapur', 'PLTS beroperasi']],
                'akademi27' => ['GPCH-27-05', 'Akademi Someah (pelatihan & sertifikasi)', 'Kurikulum pelatihan per departemen, sertifikasi BNSP 75% karyawan.', 'T4', 'hr', '2027-01-15', '2027-12-15', 'direncanakan', 4, 3, 2, 2, ['L1', 'L2'], '24 jam pelatihan per karyawan.', 0, 180_000_000,
                    ['Kurikulum', 'Pelatihan silang', 'Uji kompetensi BNSP'], ['50% tersertifikasi', '75% tersertifikasi']],
                'bsc27' => ['GPCH-27-06', 'Integrasi VHP–BSC Hotel (otomasi realisasi KPI)', 'Ekspor otomatis statistik harian VHP ke BSC Hotel.', 'T3', 'strategi', '2027-02-01', '2027-08-31', 'direncanakan', 3, 3, 2, 2, ['P7', 'L3'], 'Laporan bulanan terbit H+8.', 120_000_000, 30_000_000,
                    ['Pemetaan data', 'Integrasi', 'Uji paralel'], ['Integrasi live']],
            ];
        }

        return [
            'revenue' => ['GPCH-26-01', 'Revenue recovery kamar', 'Tactical promotion tanggal sepi, review pickup harian, kampanye OTA, WA blast.', 'T1', 'fo', '2026-01-01', '2026-12-31', 'berjalan', 5, 5, 2, 2, ['C1', 'F1'], 'Okupansi 55,5% & ADR Rp401 ribu.', 0, 180_000_000,
                ['Rapat revenue harian', 'Kalender promo tanggal sepi', 'Kampanye OTA (10.10, birthday sale)', 'WA blast database tamu', 'Metasearch Google'], ['Rapat revenue rutin', 'Metasearch live', 'Direct booking 12%']],
            'banquet' => ['GPCH-26-02', 'Diversifikasi banquet: korporasi, wedding & exhibition', 'Daily pipeline report, sales call, paket meeting korporasi, wedding expo, exhibition.', 'T1', 'sales', '2026-01-01', '2026-12-31', 'berjalan', 5, 5, 3, 2, ['C3', 'F1'], 'Pendapatan banquet Rp14,9 M.', 0, 250_000_000,
                ['Daily pipeline report', 'Sales call 20 akun/minggu', 'Paket meeting korporasi', 'Pameran mobil listrik', 'Wedding expo'], ['Pipeline harian berjalan', 'Pameran EV terlaksana', 'Kontrak wedding 2027']],
            'meeting' => ['GPCH-26-03', 'Revitalisasi ruang rapat (Jayagiri & 12 ruang)', 'Plafon Jayagiri, karpet, screen & smartboard.', 'T2', 'eng', '2026-02-01', '2026-11-30', 'berjalan', 4, 5, 3, 4, ['C3', 'P4'], 'Tidak ada lagi event pindah karena fasilitas.', 950_000_000, 40_000_000,
                ['Desain & RAB', 'Plafon Jayagiri', 'Karpet 6 ruang', 'Screen & smartboard', 'Karpet 7 ruang'], ['Jayagiri selesai', 'Seluruh ruang selesai']],
            'dapur' => ['GPCH-26-04', 'Disiplin food cost & standard recipe', 'Standard recipe di VHP, par stock, waste log, survei harga pasar, stock opname bersama.', 'T3', 'chef', '2026-01-15', '2026-12-31', 'berjalan', 5, 5, 2, 1, ['P3', 'P6', 'F2'], 'Food cost ≤ 35%.', 0, 45_000_000,
                ['Standard recipe 120 menu', 'Par stock & waste log', 'Survei harga pasar mingguan', 'Stock opname bersama Finance'], ['Standard recipe di VHP', 'Food cost ≤ 37%']],
            'kamar' => ['GPCH-26-05', 'Refresh kamar tahap 1 & general cleaning', 'Refresh 40 kamar, general cleaning 20 kamar/minggu, perbaikan Wi-Fi.', 'T2', 'hk', '2026-03-01', '2026-12-31', 'berjalan', 4, 4, 3, 3, ['P1', 'C2'], 'Skor inspeksi 90%; keluhan Wi-Fi turun.', 1_100_000_000, 60_000_000,
                ['General cleaning terjadwal', 'Upgrade Wi-Fi', 'Refresh lantai 3–4', 'Refresh lantai 5'], ['Wi-Fi baru live', '40 kamar selesai']],
            'energi' => ['GPCH-26-06', 'Efisiensi energi: LPG→CNG & lampu LED', 'Konversi dapur utama ke CNG, LED di area publik, monitoring energi mingguan.', 'T3', 'eng', '2026-04-01', '2026-12-31', 'berjalan', 3, 4, 2, 3, ['P4', 'F2'], 'Biaya energi −12%.', 420_000_000, 15_000_000,
                ['Kontrak CNG', 'Instalasi jalur CNG', 'Lampu LED area publik', 'Monitoring mingguan'], ['CNG dapur utama', 'LED selesai']],
            'pm' => ['GPCH-26-07', 'Program pemeliharaan preventif & work order', 'Jadwal PM per peralatan, work order digital, panel lift, sand filter.', 'T3', 'eng', '2026-01-15', '2026-12-31', 'berjalan', 4, 4, 3, 3, ['P4'], 'PM terlaksana ≥ 90%.', 380_000_000, 30_000_000,
                ['Inventarisasi aset', 'Jadwal PM', 'Work order digital', 'Panel lift 1', 'Sand filter kolam'], ['Jadwal PM disahkan', 'Panel lift baru']],
            'finance' => ['GPCH-26-08', 'Tiga laporan wajib & penyehatan arus kas', 'Laba rugi, arus kas, neraca bulanan; proyeksi kas mingguan; penagihan piutang.', 'T3', 'cfo', '2026-01-01', '2026-12-31', 'berjalan', 5, 5, 2, 1, ['P7', 'F3'], 'Laporan terbit H+10; piutang > 60 hari ≤ Rp60 juta.', 0, 25_000_000,
                ['Saldo awal & data master VHP', 'Proyeksi kas mingguan', 'Penagihan piutang lama', 'Neraca bulanan'], ['Neraca pertama dari sistem', 'Laporan H+10']],
            'sdm' => ['GPCH-26-09', 'Pelatihan terstruktur & pembayaran tepat waktu', 'Kalender pelatihan, cross-training, evaluasi kinerja, gaji & service tepat waktu.', 'T4', 'hr', '2026-01-15', '2026-12-31', 'berjalan', 4, 4, 2, 2, ['L1', 'L2'], '2 jam pelatihan/karyawan/bulan.', 0, 90_000_000,
                ['Kalender pelatihan', 'Cross-training FO–HK–F&B', 'Evaluasi kinerja bulanan', 'Employee of the month'], ['Kalender disahkan', 'Evaluasi kinerja pertama']],
            'safety' => ['GPCH-26-10', 'Keamanan event besar & latihan darurat', 'SOP event > 500 pax, CCTV tambahan, fire drill semesteran.', 'T2', 'sec', '2026-03-01', '2026-12-31', 'berjalan', 3, 3, 2, 2, ['P5'], 'Nol insiden besar saat event.', 150_000_000, 20_000_000,
                ['SOP event besar', 'CCTV tambahan', 'Fire drill semester I', 'Fire drill semester II'], ['SOP disahkan', 'Fire drill semester II']],
            'bsc' => ['GPCH-26-11', 'Implementasi BSC Hotel & persiapan target 2027', 'KPI 10 departemen, siklus input–verifikasi–persetujuan, workshop RKAP 2027.', 'T3', 'strategi', '2026-09-01', '2027-01-31', 'berjalan', 4, 4, 2, 2, ['P7', 'L3'], 'Seluruh departemen melapor di BSC Hotel; target 2027 disahkan.', 0, 75_000_000,
                ['Workshop KPI 10 departemen', 'Input data awal', 'Workshop RKAP 2027', 'Pengesahan target 2027'], ['Go-live BSC Hotel', 'Target 2027 disahkan']],
        ];
    }

    protected function findingData(int $year): array
    {
        if ($year === 2025) {
            return [
                ['Neraca & laba rugi belum terbit rutin', 'Laporan bulanan belum lengkap sehingga pemilik sulit mengambil keputusan.', 'audit', null, 'proses', 'tinggi', null, 'P7.1', 'vhp', 'komisaris', '2025-06-20',
                    [['Lengkapi data master back office VHP', 'cfo', '2025-09-30', 'selesai', 100], ['Tutup buku bulanan maksimal H+15', 'cfo', '2025-12-31', 'berjalan', 70]], null],
                ['Dapur & pastry tidak memenuhi standar higiene', 'Lantai rusak, saluran tersumbat, exhaust lemah.', 'audit', null, 'proses', 'kritis', null, 'P3.4', 'dapur1', 'dirut', '2025-05-10',
                    [['Perbaikan dapur tahap 1', 'chef', '2025-11-30', 'selesai', 100]], ['2025-12-05', 'Dapur tahap 1 selesai dan lolos audit internal.']],
                ['Okupansi & pendapatan 2025 di bawah target', 'Pendapatan proyeksi 2025 ±85% target; MICE pemerintah turun.', 'tinjauan', 'tahunan', 'keuangan', 'tinggi', 4_550_000_000, 'F1.1', null, 'komisaris', '2026-01-27',
                    [['Program revenue recovery 2026', 'fo', '2026-12-31', 'berjalan', 55], ['Diversifikasi banquet 2026', 'sales', '2026-12-31', 'berjalan', 50]], null],
            ];
        }
        if ($year === 2027) {
            return [];
        }

        return [
            ['Penangguhan beban persediaan F&B', 'Biaya F&B ditangguhkan di persediaan saat pendapatan rendah sehingga food cost tidak mencerminkan kondisi riil.', 'timwas', 'boc', 'keuangan', 'kritis', null, 'P3.1', 'dapur', 'komisaris', '2026-06-03',
                [['Bebankan biaya riil; hentikan penangguhan', 'cfo', '2026-07-31', 'selesai', 100], ['Stock opname bersama setiap akhir bulan', 'pur', '2026-12-31', 'berjalan', 75]], null],
            ['Banquet jauh di bawah anggaran', 'Pendapatan banquet ±44% anggaran; event pindah ke pesaing karena plafon Jayagiri.', 'tinjauan', 'q2', 'pelanggan', 'kritis', 6_000_000_000, 'C3.1', 'banquet', 'dirut', '2026-07-20',
                [['Daily pipeline report', 'sales', '2026-08-15', 'selesai', 100], ['Perbaikan plafon Jayagiri', 'eng', '2026-10-31', 'berjalan', 80], ['Paket meeting korporasi baru', 'sales', '2026-09-30', 'selesai', 100]], null],
            ['Lost business tinggi karena kalah pitching & bentrok jadwal', 'Lost business ±Rp192 juta dalam sepekan September.', 'tinjauan', 'rm8', 'pelanggan', 'tinggi', 192_500_000, 'C3.3', 'banquet', 'sales', '2026-09-28',
                [['Analisis loss per event', 'sales', '2026-10-15', 'berjalan', 60], ['Kalender Malibu Dome terpadu', 'sales', '2026-10-31', 'belum', 0]], null],
            ['Pemeliharaan preventif tertinggal', 'PM terlaksana ±70%; panel lift & sand filter bermasalah.', 'audit', null, 'proses', 'tinggi', null, 'P4.1', 'pm', 'komisaris', '2026-05-20',
                [['Jadwal PM per peralatan', 'eng', '2026-06-30', 'selesai', 100], ['Penggantian panel lift 1', 'eng', '2026-10-31', 'berjalan', 85]], null],
            ['Akun Google palsu & ulasan spam', 'Merusak reputasi dan membingungkan tamu.', 'pelanggan', null, 'pelanggan', 'sedang', null, 'C2.2', 'revenue', 'fo', '2026-08-12',
                [['Laporkan & verifikasi akun resmi', 'fo', '2026-09-15', 'selesai', 100]], ['2026-09-20', 'Akun palsu dihapus; profil resmi terverifikasi.']],
            ['Keterlambatan pembayaran service charge', 'Service charge terlambat di bulan dengan arus kas rendah.', 'internal', null, 'sdm', 'tinggi', null, 'L2.1', 'sdm', 'hr', '2026-03-10',
                [['Rekening khusus service charge', 'cfo', '2026-04-30', 'selesai', 100]], ['2026-05-10', 'Service charge dibayar tepat waktu sejak April.']],
            ['Keluhan Wi-Fi lambat berulang', 'Keluhan Wi-Fi muncul di ulasan setiap bulan.', 'pelanggan', null, 'pelanggan', 'sedang', null, 'C2.3', 'kamar', 'fo', '2026-04-15',
                [['Upgrade bandwidth & access point', 'admin', '2026-08-31', 'selesai', 100], ['Survei kepuasan Wi-Fi', 'fo', '2026-10-31', 'berjalan', 50]], null],
        ];
    }

    protected function hotelDependencies(int $year): array
    {
        if ($year === 2025) {
            return [
                ['Data master dari tiap departemen untuk VHP', 'internal', 'vhp', 'P7', 'Seluruh kepala departemen', 'Saldo awal, artikel, supplier harus diserahkan.', 'cfo', 'tinggi', 'Tenggat per departemen di rapat mingguan.'],
            ];
        }
        if ($year === 2027) {
            return [
                ['Persetujuan RKAP & capex 2027 oleh pemilik', 'internal', 'kamar27', 'C1', 'Pemilik & Dewan Pengawas', 'Refresh kamar & PLTS bergantung persetujuan capex.', 'dirut', 'tinggi', 'Paparan bisnis dengan payback.'],
                ['API VHP untuk ekspor statistik', 'eksternal', 'bsc27', 'P7', 'Vendor PMS', 'Integrasi bergantung ketersediaan API/ekspor terjadwal.', 'admin', 'sedang', 'Ekspor CSV terjadwal sebagai cadangan.'],
                ['Kontraktor PLTS bersertifikat', 'eksternal', 'energi27', 'P4', 'Kontraktor PLTS', 'Perizinan & instalasi oleh kontraktor bersertifikat.', 'eng', 'sedang', 'Tender 3 penawaran.'],
            ];
        }

        return [
            ['Kontraktor plafon Jayagiri', 'eksternal', 'meeting', 'C3', 'Kontraktor interior', 'Jadwal event harus disesuaikan dengan pekerjaan plafon.', 'eng', 'tinggi', 'Kerja malam & blok kalender.'],
            ['Pasokan CNG', 'eksternal', 'energi', 'P4', 'Pemasok CNG', 'Konversi dapur bergantung kontrak & instalasi pemasok.', 'eng', 'sedang', 'LPG tetap sebagai cadangan.'],
            ['Data harian VHP untuk KPI', 'internal', 'bsc', 'P7', 'Night Audit & Income Audit', 'Realisasi KPI bergantung pada data VHP yang lengkap.', 'cfo', 'sedang', 'Checklist night audit.'],
            ['Arus kas untuk refresh kamar', 'internal', 'kamar', 'P1', 'Financial Controller', 'Refresh kamar dibiayai kas operasional.', 'cfo', 'tinggi', 'Pentahapan per lantai.'],
            ['Dukungan pemilik untuk pembayaran tepat waktu', 'internal', 'sdm', 'L2', 'Pemilik', 'Gaji & service charge tepat waktu butuh dana talangan saat sepi.', 'dirut', 'sedang', 'Proyeksi kas mingguan.'],
        ];
    }

    protected function reviewTexts(): array
    {
        return [
            'venue' => 'Ruang Niskala, Grand Pasundan', 'chair' => 'General Manager',
            'annual' => [
                'summary' => "Pendapatan 2025 (proyeksi) ±Rp25,5 M = 85% target; okupansi ±50,9%, ADR ±Rp334 ribu.\nBanquet turun karena efisiensi anggaran pemerintah; breakfast & healthy club di atas target.\nVHP Cloud live; dapur tahap 1 selesai; SOP 10 departemen 80%.",
                'decisions' => "1. Anggaran 2026: pendapatan Rp32,9 M, okupansi 55,5%, ADR Rp401 ribu.\n2. Prioritas: revenue recovery, diversifikasi banquet, ruang rapat, food cost, tiga laporan wajib.\n3. Laporan akhir bulan 10 departemen menjadi dasar KPI.",
                'follow_up' => 'Koordinator Strategi memasukkan KPI & target 2026 ke BSC Hotel.',
                'note' => 'Pengawas meminta laporan bulanan memuat banquet per segmen dan food cost riil tanpa penangguhan beban.',
            ],
            'months' => [
                1 => ['Okupansi Januari 46% (anggaran 50%); banquet sepi pasca-akhir tahun.', 'Promo tanggal sepi; sales call korporasi.'],
                3 => ['Ramadan menurunkan banquet & okupansi; iftar menaikkan food cost.', 'Paket bukber; kendali porsi & waste.'],
                6 => ['Libur sekolah: okupansi 61%; arus kas semester I sangat tipis.', 'Proyeksi kas mingguan; tagih piutang lama.'],
                8 => ['Okupansi 53%, ADR Rp345 ribu; plafon Jayagiri menyebabkan event pindah.', 'Percepat perbaikan Jayagiri; daily pipeline report.'],
            ],
            'q1' => ['Pendapatan Q1 ±62% anggaran; food cost 41%; okupansi 42%.', 'Standard recipe; diversifikasi banquet; penundaan capex non-prioritas.'],
            'q2' => ['Pendapatan H1 ±66% anggaran; banquet 46%; skor inspeksi kamar 85%.', 'Revitalisasi ruang rapat dipercepat; refresh kamar tahap 1.'],
            'board' => ['Pengawas menyoroti penangguhan beban persediaan, likuiditas, dan banquet.', 'Biaya dibebankan riil; stock opname bersama tiap bulan.', 'Mohon laporan arus kas mingguan dan pipeline banquet per event untuk rapat berikutnya.'],
            'sep' => 'Okupansi September ±49%, ADR ±Rp335 ribu; lost business ±Rp192 juta. Food cost September dikembalikan untuk dihitung ulang.',
            'plan2027' => 'Draf RKAP 2027: pendapatan Rp33,5 M, okupansi 57%, banquet Rp14 M, food cost 34%; inisiatif refresh kamar tahap 2, Pasundan Wedding & Exhibition Center, revenue management, hemat energi, Akademi Someah, integrasi VHP–BSC.',
        ];
    }
}
