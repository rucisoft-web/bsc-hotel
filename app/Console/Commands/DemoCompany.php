<?php

namespace App\Console\Commands;

use App\Models\AnalysisPeriod;
use App\Models\Company;
use App\Models\MaturityQuestion;
use App\Models\Role;
use App\Models\User;
use App\Support\DhastramContext;
use Database\Seeders\DhastramRolePermissionSeeder;
use Database\Seeders\GpchSeeder;
use Database\Seeders\MaturityQuestionSeeder;
use Database\Seeders\SahidSeeder;
use Database\Seeders\ShowcaseSeeder;
use Database\Seeders\SunlakeSeeder;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

/** Memuat demo lengkap satu hotel (perioda 2025, 2026 + 2027) ke server yang sudah berjalan. */
class DemoCompany extends Command
{
    /** @var array<string,class-string<ShowcaseSeeder>> */
    public const DEMOS = ['GPCH' => GpchSeeder::class, 'SHID' => SahidSeeder::class, 'SNLK' => SunlakeSeeder::class];

    protected $signature = 'rucibsc:demo
        {perusahaan=GPCH : Kode demo: GPCH (Grand Pasundan Convention Hotel), SHID (Hotel Sahid Jaya), SNLK (Sunter Lakeside Hotel)}
        {--password= : Kata sandi akun contoh perusahaan itu (bila kosong dibuat acak dan ditampilkan)}
        {--reset : Hapus dulu data hotel itu untuk perioda 2025, 2026 & 2027 yang sudah ada}
        {--force : Lewati konfirmasi}';

    protected $description = 'Muat demo hotel lengkap (Strategy Map, 53 KPI 10 departemen, inisiatif, ekosistem, tinjauan) perioda 2025, 2026 & 2027: GPCH, SHID, atau SNLK';

    protected $aliases = ['bschotel:demo'];

    public function handle(): int
    {
        if (! Role::exists()) {
            $this->call('db:seed', ['--class' => DhastramRolePermissionSeeder::class, '--force' => true]);
        }
        if (! MaturityQuestion::exists()) {
            $this->call('db:seed', ['--class' => MaturityQuestionSeeder::class, '--force' => true]);
        }

        $code = strtoupper($this->argument('perusahaan'));
        $seeder = self::DEMOS[$code] ?? null;
        if (! $seeder) {
            $this->error('Kode demo tidak dikenal. Pilihan: '.implode(', ', array_keys(self::DEMOS)));

            return self::FAILURE;
        }
        $company = Company::where('code', $code)->first();
        $periods = $company ? AnalysisPeriod::where('company_id', $company->id)->whereIn('code', ['2025', '2026', '2027'])->get() : collect();
        if ($periods->isNotEmpty()) {
            if (! $this->option('reset')) {
                $this->error('Perusahaan '.$code.' sudah punya perioda '.$periods->pluck('code')->join(' & ').'. Jalankan ulang dengan --reset untuk menggantinya dengan data demo.');

                return self::FAILURE;
            }
            if (! $this->option('force') && ! $this->confirm('Semua data '.$code.' perioda '.$periods->pluck('code')->join(' & ').' akan dihapus dan diganti data demo. Lanjutkan?')) {
                return self::FAILURE;
            }
        }

        $password = $this->option('password') ?: Str::password(14, symbols: false);
        $company = DB::transaction(function () use ($periods, $password, $seeder) {
            $periods->each->delete(); // seluruh tabel data perioda memakai cascadeOnDelete

            return (new $seeder($password))->run();
        });
        app(DhastramContext::class)->clear();

        $this->info('Demo '.$company->name.' siap: perioda 2025 (ditutup), 2026 (berjalan, bawaan) & 2027 (perencanaan).');
        $this->line('Akun contoh: '.User::where('email', 'like', strtolower($code).'.%@contoh.local')->orderBy('id')->pluck('email')->join(', '));
        if (! $this->option('password')) {
            $this->warn('Kata sandi akun contoh: '.$password);
        }
        $this->line('Hapus semua data contoh sebelum go-live dengan: php artisan rucibsc:hapus-contoh');

        return self::SUCCESS;
    }
}
