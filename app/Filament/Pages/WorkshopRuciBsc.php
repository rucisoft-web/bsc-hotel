<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;

/** Rundown dan materi Workshop Ruci BSC dua hari, bekerja sama dengan PSMPT UIN Sunan Kalijaga. */
class WorkshopRuciBsc extends Page
{
    protected static ?string $title = 'Workshop Ruci BSC';

    protected static ?string $navigationLabel = 'Workshop Ruci BSC';

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-academic-cap';

    protected static string|\UnitEnum|null $navigationGroup = 'Panduan';

    protected static ?int $navigationSort = 4;

    protected static ?string $slug = 'workshop-ruci-bsc';

    protected string $view = 'filament.pages.workshop-ruci-bsc';

    public static function canAccess(): bool
    {
        return auth()->check();
    }

    protected function getViewData(): array
    {
        return [
            'workshopUrl' => config('dhastram.workshop_url'),
            'workshopContact' => config('dhastram.workshop_contact'),
        ];
    }
}
