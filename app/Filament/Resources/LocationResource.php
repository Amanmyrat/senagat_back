<?php

namespace App\Filament\Resources;

use App\Filament\Resources\LocationResource\Pages;
use App\Filament\Resources\LocationResource\RelationManagers;
use App\Models\Location;
use ArberMustafa\FilamentLocationPickrField\Forms\Components\LocationPickr;
use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Resources\Concerns\Translatable;

use Filament\Tables\Table;


use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class LocationResource extends Resource
{
    use Translatable;

    public static function getTranslatableLocales(): array
    {
        return ['en', 'tk', 'ru'];
    }
    protected static ?string $model = Location::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
           Select::make('type')
                ->label('Type')
                ->options([
                    'ATM'=>'ATM',
                    'Branch'=>'Branch'
                ])
                ->required(),
           TextInput::make('name')
           ->label('Name')->required(),
            TextInput::make('address')
                ->label('Address')
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
                        $location['lat'] = $state !== null ? (float) $state : null; // ✅ doğru alan
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
                        $location['lng'] = $state !== null ? (float) $state : null; // ✅ doğru alan
                        $set('location', $location);
                    }),

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('type'),
                TextColumn::make('name'),
                TextColumn::make('address'),
                TextColumn::make('location')


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
            'index' => Pages\ListLocations::route('/'),
            'create' => Pages\CreateLocation::route('/create'),
            'edit' => Pages\EditLocation::route('/{record}/edit'),
        ];
    }
}
