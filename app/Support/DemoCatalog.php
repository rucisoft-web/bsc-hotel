<?php

namespace App\Support;

use App\Models\AnalysisPeriod;
use App\Models\Company;
use Illuminate\Support\Facades\DB;

/** Daftar perusahaan contoh (studi kasus) yang dipakai di halaman depan, login, dan Kenali BSC Hotel. */
class DemoCatalog
{
    /** [kode, nama, sektor, pelajaran utama] */
    public const CASES = [
        ['GPCH', 'Grand Pasundan Convention Hotel', 'Hotel & konvensi (164 kamar)', 'Pemulihan pendapatan banquet & F&B, disiplin biaya, dan persiapan RKAP 2027 berbasis 10 departemen.'],
        ['SHID', 'Hotel Sahid Jaya International', 'Hotel bintang 5 Jakarta (751 kamar)', 'Hunian 30% setelah efisiensi anggaran pemerintah: renovasi aset, diversifikasi segmen, Program 4 Pilar SahidTANGGUH.'],
        ['SNLK', 'Sunter Lakeside Hotel', 'Family hotel & MICE (228 kamar)', 'Hunian stabil tetapi pendapatan turun: segmen keluarga, wedding, biaya tenaga kerja, dan piutang.'],
    ];

    /** Perioda pembuka sebuah perusahaan: tahun berjalan (aktif) lebih dulu, lalu tahun terbaru. */
    public static function startPeriodId(int $companyId): ?int
    {
        return AnalysisPeriod::where('company_id', $companyId)
            ->orderByDesc('is_active')->orderByDesc('year')->value('id');
    }

    /**
     * Perusahaan contoh yang terpasang, dengan perioda tahun berjalan dan jumlah sasaran/KPI/inisiatifnya.
     *
     * @return list<array{code:string,name:string,sector:string,lesson:string,year:?int,objectives:int,kpis:int,initiatives:int}>
     */
    public static function installed(): array
    {
        return app(DhastramContext::class)->withoutScope(function () {
            $companies = Company::whereIn('code', array_column(self::CASES, 0))->get()->keyBy('code');
            $out = [];
            foreach (self::CASES as [$code, $name, $sector, $lesson]) {
                $company = $companies->get($code);
                if (! $company) {
                    continue;
                }
                $periodId = self::startPeriodId($company->id);
                $count = fn (string $table) => $periodId ? DB::table($table)->where('analysis_period_id', $periodId)->count() : 0;
                $out[] = [
                    'code' => $code, 'name' => $name, 'sector' => $sector, 'lesson' => $lesson,
                    'year' => $periodId ? AnalysisPeriod::whereKey($periodId)->value('year') : null,
                    'objectives' => $count('strategic_objectives'),
                    'kpis' => $count('kpis'),
                    'initiatives' => $count('strategic_initiatives'),
                ];
            }

            return $out;
        });
    }
}
