<?php

namespace App\Filament\Resources;

use App\Filament\Clusters\Tariffs;
use App\Filament\Resources\TariffCategoryResource\Pages;
use App\Models\TariffCategory;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Resources\Concerns\Translatable;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Table;

class TariffCategoryResource extends Resource
{
    protected static ?string $model = TariffCategory::class;

    protected static ?string $cluster = Tariffs::class;

    protected static ?int $navigationSort = 1;

    protected static ?string $navigationIcon = 'heroicon-o-tag';

    use Translatable;

    public static function getTranslatableLocales(): array
    {
        return ['tk', 'en', 'ru'];
    }

    public static function getNavigationLabel(): string
    {
        return __('resource.tariff_categories');
    }

    public static function getPluralModelLabel(): string
    {
        return __('resource.tariff_categories');
    }

    public static function getModelLabel(): string
    {
        return __('resource.tariff_categories');
    }

    public static function getRecordTitle(?object $record = null): string
    {
        return $record ? (string) $record->name : __('resource.tariff_categories');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('title')
                    ->required()
                    ->label(__('resource.title')),
                TextInput::make('number')
                    ->required()
                    ->numeric()
                    ->integer()
                    ->minValue(1)
                    ->label(__('resource.number')),
                Toggle::make('is_active')
                    ->label(__('resource.active'))
                    ->default(true),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('number')
                    ->label(__('resource.number'))
                    ->sortable()
                    ->alignCenter(),
                TextColumn::make('title')
                    ->label(__('resource.title')),
                ToggleColumn::make('is_active')
                    ->label(__('resource.active')),
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
            ])
            ->defaultSort('number')
            ->reorderable('number');
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function canViewAny(): bool
    {

        return optional(auth()->user())->role === 'super-admin';

    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListTariffCategories::route('/'),
            'create' => Pages\CreateTariffCategory::route('/create'),
            'edit' => Pages\EditTariffCategory::route('/{record}/edit'),
        ];
    }
}
