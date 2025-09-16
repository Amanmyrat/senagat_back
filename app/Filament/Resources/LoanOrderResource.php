<?php

namespace App\Filament\Resources;

use App\Filament\Resources\LoanOrderResource\Pages;
use App\Models\CreditApplication;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Wizard;
use Filament\Forms\Components\Wizard\Step;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class LoanOrderResource extends Resource
{
    protected static ?string $model = CreditApplication::class;

    public static function getNavigationLabel(): string
    {
        return __('Loan Order');
    }

    public static function getModelLabel(): string
    {
        return __('Loan Order');
    }

    public static function getPluralModelLabel(): string
    {
        return __('Loan Order');
    }

    public static function getRecordTitle(?object $record = null): string
    {
        return $record ? (string) $record->user?->name : __('Loan Order');
    }

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Wizard::make([
                    Step::make('Credit Details')
                        ->schema([
                            Select::make('credit_id')->relationship('credit', 'name')->required()->disabled(),
                            TextInput::make('years')->numeric()->required()->disabled(),
                            TextInput::make('amount')->numeric()->required()->disabled(),
                            TextInput::make('interest')->numeric()->required()->disabled(),
                        ]),
                    Step::make('Profile Information')
                        ->schema([
                            Fieldset::make('User Info')
                                ->schema([
                                    TextInput::make('first_name')
                                        ->label('First Name')
                                        ->afterStateHydrated(function (TextInput $component, $state, $record) {
                                            $component->state($record->profile?->first_name);
                                        })
                                        ->disabled(),

                                    TextInput::make('last_name')
                                        ->label('Last Name')
                                        ->afterStateHydrated(function (TextInput $component, $state, $record) {
                                            $component->state($record->profile?->last_name);
                                        })
                                        ->disabled(),

                                    TextInput::make('middle_name')
                                        ->label('Middle Name')
                                        ->afterStateHydrated(function (TextInput $component, $state, $record) {
                                            $component->state($record->profile?->middle_name);
                                        })
                                        ->disabled(),

                                    TextInput::make('birth_date')
                                        ->label('Birth Date')
                                        ->afterStateHydrated(function (TextInput $component, $state, $record) {
                                            $component->state($record->profile?->birth_date?->format('d-m-Y'));
                                        })
                                        ->disabled(),

                                    TextInput::make('passport_number')
                                        ->label('Passport Number')
                                        ->afterStateHydrated(function (TextInput $component, $state, $record) {
                                            $component->state($record->profile?->passport_number);
                                        })
                                        ->disabled(),

                                    TextInput::make('issued_date')
                                        ->label('Issued Date')
                                        ->afterStateHydrated(function (TextInput $component, $state, $record) {
                                            $component->state($record->profile?->issued_date?->format('d-m-Y'));
                                        })
                                        ->disabled(),

                                    TextInput::make('issued_by')
                                        ->label('Issued By')
                                        ->afterStateHydrated(function (TextInput $component, $state, $record) {
                                            $component->state($record->profile?->issued_by);
                                        })
                                        ->disabled(),
                                    FileUpload::make('scan_passport')
                                        ->label('Passport Scan')
                                        ->afterStateHydrated(function ($component, $state, $record) {
                                            if ($record->profile?->scan_passport) {
                                                $component->state([
                                                    $record->profile->scan_passport,
                                                ]);
                                            }
                                        })
                                        ->disabled()
                                        ->downloadable()
                                        ->disk('public')
                                        ->directory('scans')
                                        ->image(),

                                ]),
                        ]),

                    Step::make('Work Info')
                        ->schema([
                            Select::make('role')
                                ->options([
                                    'manager' => 'Manager',
                                    'entrepreneur' => 'Entrepreneur',
                                ])->required()
                                ->disabled(),
                            TextInput::make('patent_number')->visible(fn ($get) => $get('role') === 'entrepreneur')->disabled(),
                            TextInput::make('registration_number')->visible(fn ($get) => $get('role') === 'entrepreneur')->disabled(),
                            TextInput::make('work_address')->visible(fn ($get) => $get('role') === 'entrepreneur')->disabled(),
                            TextInput::make('workplace')->visible(fn ($get) => $get('role') === 'manager')->disabled(),
                            TextInput::make('position')->visible(fn ($get) => $get('role') === 'manager')->disabled(),
                            TextInput::make('manager_work_address')->visible(fn ($get) => $get('role') === 'manager')->disabled(),
                            TextInput::make('phone_number')->visible(fn ($get) => $get('role') === 'manager')->disabled(),
                            TextInput::make('salary')->visible(fn ($get) => $get('role') === 'manager')->disabled(),
                        ]),
                    Step::make('Branch Info')
                        ->schema([
                            TextInput::make('country')->required()->disabled(),
                            TextInput::make('bank_name')->required()->disabled(),
                        ]),
                ]
                )
                    ->skippable()
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('profile.first_name')
                    ->label('First Name'),
                TextColumn::make('profile.last_name')
                    ->label('Last Name'),
                TextColumn::make('credit.name')
                    ->label('Credit Type'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListLoanOrders::route('/'),
            'create' => Pages\CreateLoanOrder::route('/create'),
            'edit' => Pages\EditLoanOrder::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->with('profile');
    }
}
