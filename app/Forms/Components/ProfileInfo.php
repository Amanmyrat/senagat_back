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
            ->label(__('resource.profile_information'))
            ->schema([
                TextInput::make('first_name')
                    ->label(__('resource.first_name'))
                    ->afterStateHydrated(fn ($component, $state, $record) => $component->state($record->profile?->first_name))
                    ->disabled(),

                TextInput::make('last_name')
                    ->label(__('resource.last_name'))
                    ->afterStateHydrated(fn ($component, $state, $record) => $component->state($record->profile?->last_name))
                    ->disabled(),

                TextInput::make('middle_name')
                    ->label(__('resource.middle_name'))
                    ->afterStateHydrated(fn ($component, $state, $record) => $component->state($record->profile?->middle_name))
                    ->disabled(),

                TextInput::make('birth_date')
                    ->label(__('resource.birth_date'))
                    ->afterStateHydrated(fn ($component, $state, $record) => $component->state($record->profile?->birth_date?->format('d-m-Y')))
                    ->disabled(),

                TextInput::make('passport_number')
                    ->label(__('resource.passport_number'))
                    ->afterStateHydrated(fn ($component, $state, $record) => $component->state($record->profile?->passport_number))
                    ->disabled(),

                TextInput::make('issued_date')
                    ->label(__('resource.issued_date'))
                    ->afterStateHydrated(fn ($component, $state, $record) => $component->state($record->profile?->issued_date?->format('d-m-Y')))
                    ->disabled(),

                TextInput::make('issued_by')
                    ->label(__('resource.issued_by'))
                    ->afterStateHydrated(fn ($component, $state, $record) => $component->state($record->profile?->issued_by))
                    ->disabled(),
                TextInput::make('citizenship')->label(__('resource.citizenship'))->disabled()
                    ->afterStateHydrated(fn ($component, $state, $record) => $component->state($record->profile?->citizenship)),
                TextInput::make('home_phone')->label(__('resource.home_phone_number'))->disabled()
                    ->afterStateHydrated(fn ($component, $state, $record) => $component->state($record->profile?->home_phone)),
                TextInput::make('home_address')->label(__('resource.home_address'))->disabled()
                    ->afterStateHydrated(fn ($component, $state, $record) => $component->state($record->profile?->home_address)),
                TextInput::make('phone')->label(__('resource.phone'))->disabled()
                    ->afterStateHydrated(fn ($component, $state, $record) => $component->state($record->user?->phone)),
                FileUpload::make('scan_passport')
                    ->label(__('resource.scan_passport'))
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
