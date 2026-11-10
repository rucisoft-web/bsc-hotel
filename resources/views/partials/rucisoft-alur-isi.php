<?php

// Isi blok halaman awal seragam (partials/rucisoft-alur.blade.php) khusus produk ini.
return [
    'slug' => 'ruci-bsc',
    'nama' => 'Ruci BSC',
    'aksen' => '#1F4E8C',
    'aksen_2' => '#D32F2F',
    'coba_url' => '#data-contoh',
    'masalah_judul' => 'Strategi yang baik sering berhenti di dokumen rencana.',
    'masalah_lead' => 'Rencana strategis disusun dengan serius, tetapi setelah disahkan jarang dibaca lagi. Gejalanya mudah dikenali di banyak organisasi.',
    'masalah' => [
        ['Strategi tidak dipahami', 'Sebagian besar karyawan tidak tahu sasaran perusahaan dan bagaimana pekerjaannya ikut menentukan hasil.'],
        ['KPI tanpa pemilik', 'Indikator ditulis di dokumen, tetapi tidak jelas siapa yang bertanggung jawab dan berapa target bulanannya.'],
        ['Anggaran lepas dari strategi', 'Inisiatif dan anggaran disusun terpisah, sehingga dana tidak selalu jatuh ke sasaran yang paling penting.'],
        ['Rapat tanpa data', 'Strategi jarang masuk agenda rapat pimpinan, dan rekap Excel dari setiap unit berbeda-beda versi.'],
    ],
    'penyebab_judul' => 'Akar masalahnya ada pada cara strategi diterjemahkan dan dipantau.',
    'penyebab_lead' => 'Kaplan & Norton, perancang Balanced Scorecard, menyebutnya empat hambatan klasik pelaksanaan strategi.',
    'penyebab' => [
        ['Hambatan visi', 'Strategi ditulis panjang dan abstrak, tanpa peta sebab-akibat yang bisa dibaca semua orang.'],
        ['Hambatan manusia', 'Target dan insentif manajer tidak terkait dengan sasaran strategis.'],
        ['Hambatan sumber daya', 'Proses anggaran berjalan sendiri, tidak terhubung ke inisiatif strategis.'],
        ['Hambatan manajemen', 'Tidak ada ritme review bulanan dan satu sumber data yang dipercaya semua pihak.'],
    ],
    'solusi_judul' => 'Ruci BSC menerjemahkan strategi menjadi pekerjaan yang dipantau setiap bulan.',
    'solusi_lead' => 'Dari peta strategi sampai rapat review kinerja, semuanya dalam satu aplikasi dengan data yang sama.',
    'solusi' => [
        ['Peta Strategi satu halaman', 'Sasaran per perspektif dengan hubungan sebab-akibat yang mudah dipahami dari Komisaris sampai kepala unit.', 'Strategi tidak dipahami'],
        ['KPI, target, dan pemilik', 'Setiap KPI punya PIC, target bulanan, dan skor yang terlihat jelas.', 'KPI tanpa pemilik'],
        ['Inisiatif terhubung anggaran', 'Setiap inisiatif tertaut ke sasaran, lengkap dengan anggaran dan serapannya.', 'Anggaran lepas dari strategi'],
        ['Pusat Kendali & review bulanan', 'Realisasi diinput unit, diverifikasi, disetujui, lalu dibahas dalam rapat dengan satu sumber data.', 'Rapat tanpa data'],
    ],
];
