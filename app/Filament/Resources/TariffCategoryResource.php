<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TariffCategoryResource\Pages;
use App\Models\TariffCategory;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Concerns\Translatable;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class TariffCategoryResource extends Resource
{
    protected static ?string $model = TariffCategory::class;

    protected static ?string $cluster = \App\Filament\Clusters\Tariffs::class;

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
                Forms\Components\TextInput::make('title')
                    ->required()
                    ->label(__('resource.title')),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->label(__('resource.title')),
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
