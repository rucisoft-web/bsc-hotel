<?php

namespace Database\Seeders;

use App\Models\AnalysisPeriod;
use App\Models\Company;
use App\Models\Role;
use App\Models\User;
use App\Models\UserContext;
use App\Support\DhastramContext;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

/**
 * Hotel contoh untuk demo & pelatihan (is_demo = true, hapus dengan `php artisan rucibsc:hapus-contoh`).
 *
 * - GPCH: Grand Pasundan Convention Hotel — proyeksi manajemen (laporan mingguan GM & anggaran 2026), lihat GpchSeeder.
 * - SHID: PT Hotel Sahid Jaya International Tbk — angka 2025 dari laporan tahunan, lihat SahidSeeder.
 * - SNLK: PT Sunter Lakeside Hotel Tbk — angka 2025 dari laporan tahunan, lihat SunlakeSeeder.
 * - Setiap hotel punya perioda 2025 (ditutup), 2026 (berjalan, realisasi Jan–Sep) dan 2027 (perencanaan),
 *   dengan 53 KPI yang diturunkan dari laporan akhir bulan 10 departemen hotel.
 * - Semua demo bertanda is_demo dan menampilkan peringatan "data demo" (App\Support\DemoNotice).
 */
class DemoSeeder extends Seeder
{
    public const PASSWORD = 'Contoh-2026!';

    public const ADMIN_EMAIL = 'admin@rucibsc.local';

    /** @var list<class-string<HotelShowcaseSeeder>> */
    public const HOTELS = [GpchSeeder::class, SahidSeeder::class, SunlakeSeeder::class];

    public function run(): void
    {
        $admin = User::updateOrCreate(['email' => self::ADMIN_EMAIL], [
            'name' => 'Super Admin BSC Hotel', 'job_title' => 'Konsultan', 'department' => 'Manajemen', 'is_active' => true,
            'password' => Hash::make(config('dhastram.demo_admin_password')), 'must_change_password' => false, 'email_verified_at' => now(),
        ]);
        $this->assign($admin, 'super-admin', null);

        foreach (self::HOTELS as $seeder) {
            (new $seeder(self::PASSWORD))->run();
        }

        UserContext::updateOrCreate(['user_id' => $admin->id], [
            'company_id' => Company::where('code', 'GPCH')->value('id'),
            'analysis_period_id' => AnalysisPeriod::whereHas('company', fn ($q) => $q->where('code', 'GPCH'))->where('is_active', true)->value('id'),
        ]);
        app(DhastramContext::class)->clear();
    }

    protected function assign(User $user, string $slug, ?int $companyId): void
    {
        $role = Role::where('slug', $slug)->firstOrFail();
        if (! $user->roles()->where('roles.id', $role->id)->wherePivot('company_id', $companyId)->exists()) {
            $user->roles()->attach($role->id, ['company_id' => $companyId]);
        }
    }
}
