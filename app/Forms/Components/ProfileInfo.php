<?php

namespace App\Forms\Components;

use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;

class ProfileInfo
{
    public static function make(): Fieldset
    {
        return Fieldset::make('User Info')
            ->schema([
                TextInput::make('first_name')
                    ->label('First Name')
                    ->afterStateHydrated(fn ($component, $state, $record) =>
                    $component->state($record->profile?->first_name))
                    ->disabled(),

                TextInput::make('last_name')
                    ->label('Last Name')
                    ->afterStateHydrated(fn ($component, $state, $record) =>
                    $component->state($record->profile?->last_name))
                    ->disabled(),

                TextInput::make('middle_name')
                    ->label('Middle Name')
                    ->afterStateHydrated(fn ($component, $state, $record) =>
                    $component->state($record->profile?->middle_name))
                    ->disabled(),

                TextInput::make('birth_date')
                    ->label('Birth Date')
                    ->afterStateHydrated(fn ($component, $state, $record) =>
                    $component->state($record->profile?->birth_date?->format('d-m-Y')))
                    ->disabled(),

                TextInput::make('passport_number')
                    ->label('Passport Number')
                    ->afterStateHydrated(fn ($component, $state, $record) =>
                    $component->state($record->profile?->passport_number))
                    ->disabled(),

                TextInput::make('issued_date')
                    ->label('Issued Date')
                    ->afterStateHydrated(fn ($component, $state, $record) =>
                    $component->state($record->profile?->issued_date?->format('d-m-Y')))
                    ->disabled(),

                TextInput::make('issued_by')
                    ->label('Issued By')
                    ->afterStateHydrated(fn ($component, $state, $record) =>
                    $component->state($record->profile?->issued_by))
                    ->disabled(),

                FileUpload::make('scan_passport')
                    ->label('Passport Scan')
                    ->afterStateHydrated(function ($component, $state, $record) {
                        if ($record->profile?->scan_passport) {
                            $component->state([$record->profile->scan_passport]);
                        }
                    })
                    ->disabled()
                    ->downloadable()
                    ->disk('public')
                    ->directory('scans')
                    ->image(),
            ]);
    }
}
