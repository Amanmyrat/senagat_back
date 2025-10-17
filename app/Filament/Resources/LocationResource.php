<?php

namespace App\Filament\Resources;

use App\Filament\Resources\LocationResource\Pages;
use App\Models\Location;
use ArberMustafa\FilamentLocationPickrField\Forms\Components\LocationPickr;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Wizard;
use Filament\Forms\Components\Wizard\Step;
use Filament\Forms\Form;
use Filament\Resources\Concerns\Translatable;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class LocationResource extends Resource
{
    use Translatable;

    public static function getTranslatableLocales(): array
    {
        return ['en', 'tk', 'ru'];
    }
    public static function canViewAny(): bool
    {
        $user = auth('admin')->user();

        return in_array($user->role->value, ['super-admin']);

    }

    protected static ?string $model = Location::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function getNavigationLabel(): string
    {
        return __('navigation.location');
    }

    public static function getPluralModelLabel(): string
    {
        return __('navigation.location');
    }

    public static function getModelLabel(): string
    {
        return __('navigation.location');
    }

    public static function getRecordTitle(?object $record = null): string
    {
        return $record ? (string) $record->name : __('navigation.location');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Wizard::make([
                    Step::make('First Step')
                        ->schema([
                            Select::make('type')
                                ->translateLabel()
                                ->label(_('resource.type'))
                                ->options([
                                    'ATM' => 'ATM',
                                    'Branch' => 'Branch',
                                ])
                                ->required(),
                            TextInput::make('name')
                                ->translateLabel()
                                ->label(_('resource.name'))
                                ->required(),
                            TextInput::make('address')
                                ->translateLabel()
                                ->label(_('resource.address'))
                                ->required(),
                            LocationPickr::make('location')
                                ->label('Location')
                                ->reactive()
                                ->afterStateUpdated(function ($state, callable $set) {
                                    if ($state) {
                                        $set('lat', $state['lat']);
                                        $set('lng', $state['lng']);
                                    }
                                }),

                            TextInput::make('lat')
                                ->label('Latitude')
                                ->required()
                                ->numeric()
                                ->reactive()
                                ->default(fn ($get) => $get('location')['lat'] ?? null)
                                ->afterStateUpdated(function ($state, callable $set, callable $get) {
                                    $location = $get('location') ?? ['lat' => null, 'lng' => null];
                                    $location['lat'] = $state !== null ? (float) $state : null;
                                    $set('location', $location);
                                }),

                            TextInput::make('lng')
                                ->label('Longitude')
                                ->required()
                                ->numeric()
                                ->reactive()
                                ->default(fn ($get) => $get('location')['lng'] ?? null)
                                ->afterStateUpdated(function ($state, callable $set, callable $get) {
                                    $location = $get('location') ?? ['lat' => null, 'lng' => null];
                                    $location['lng'] = $state !== null ? (float) $state : null;
                                    $set('location', $location);
                                }),
                        ]),
                    Step::make('Second Step')
                        ->schema([
                            TextInput::make('phone_number')
                                ->label('Phone Number'),
                            TextInput::make('fax_number')
                                ->label('Fax Number'),
                            TextInput::make('home_number')
                                ->label('Help desk number'),
                            Section::make('Branch Services')
                                ->description('Select which services this branch provides.')
                                ->schema([
                                    Grid::make(3)
                                        ->schema([
                                            Checkbox::make('offers_credit')->label('Offers Credit'),
                                            Checkbox::make('offers_card')->label('Offers Card'),
                                            Checkbox::make('offers_certificate')->label('Offers Certificate'),
                                        ])
                                ])


                        ]),
                    Step::make('Third Step')
                        ->schema([
                            Repeater::make('hours')
                                ->label('Working Hours')
                                ->schema([
                                    TextInput::make('day')
                                        ->label('Day'),
                                    TextInput::make('from')
                                        ->label('From'),
                                    TextInput::make('to')
                                        ->label('To'),
                                ])
                                ->columns(3),
                        ])
            ])->columnSpanFull()
                ->skippable(),




            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('type')
                    ->translateLabel()
                    ->label(_('resource.type'))
                    ->badge(),
                TextColumn::make('name')->translateLabel()
                    ->label(_('resource.name')),
                TextColumn::make('address')->translateLabel()
                    ->label(_('resource.address')),

            ])
            ->filters([])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->translateLabel()
                    ->label(_('resource.edit')),
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
            'index' => Pages\ListLocations::route('/'),
            'create' => Pages\CreateLocation::route('/create'),
            'edit' => Pages\EditLocation::route('/{record}/edit'),
        ];
    }
}
