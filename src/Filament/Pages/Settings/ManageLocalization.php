<?php

namespace Cachet\Filament\Pages\Settings;

use Cachet\Settings\AppSettings;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Pages\SettingsPage;
use Illuminate\Support\Str;

class ManageLocalization extends SettingsPage
{
    protected static string $settings = AppSettings::class;

    protected static ?string $navigationGroup = 'Settings';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make()->columns(2)->schema([
                    Forms\Components\Select::make('timezone')
                        ->label(__('Timezone'))
                        ->options(fn () => collect(timezone_identifiers_list())
                            ->mapToGroups(
                                fn ($timezone) => [
                                    Str::of($timezone)
                                        ->before('/')
                                        ->toString() => [$timezone => $timezone],
                                ]
                            )
                            ->map(fn ($group) => $group->collapse()))
                        ->searchable()
                        ->suffixIcon('heroicon-o-globe-alt'),

                    Forms\Components\Select::make('locale')
                        ->label(__('Language'))
                        ->options([
                            'en' => 'English',
                            'es' => 'Spanish',
                        ])->searchable()
                        ->suffixIcon('heroicon-o-language'),

                    Forms\Components\Toggle::make('show_timezone')
                        ->label(__('Show Timezone')),
                ]),
            ]);
    }
}
