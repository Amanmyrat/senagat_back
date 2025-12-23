<?php

namespace App\Filament\Resources;

use App\Filament\Clusters\InternationalPayment;
use App\Filament\Resources\InternationalPaymentTypeResource\Pages;
use App\Models\InternationalPaymentTypes;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Concerns\Translatable;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class InternationalPaymentTypeResource extends Resource
{
    protected static ?string $model = InternationalPaymentTypes::class;

    protected static ?string $cluster = InternationalPayment::class;

    protected static ?int $navigationSort = 1;

    protected static ?string $navigationIcon = 'heroicon-o-globe-alt';

    use Translatable;

    public static function getTranslatableLocales(): array
    {
        return ['tk', 'en', 'ru'];
    }

    public static function getNavigationLabel(): string
    {
        return __('resource.international_payment_types');
    }

    public static function getPluralModelLabel(): string
    {
        return __('resource.international_payment_types');
    }

    public static function getModelLabel(): string
    {
        return __('resource.international_payment_types');
    }

    public static function getRecordTitle(?object $record = null): string
    {
        return $record ? (string) $record->name : __('resource.international_payment_types');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('title')->required()
                    ->label(__('resource.title')),
                Repeater::make('required_files')
                    ->label(__('resource.requirements'))
                    ->schema([
                        TextInput::make('title')->label(__('resource.name')),

                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title')
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

    public static function canViewAny(): bool
    {
        return optional(auth()->user())->role === 'super-admin';
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
            'index' => Pages\ListInternationalPaymentTypes::route('/'),
            'create' => Pages\CreateInternationalPaymentType::route('/create'),
            'edit' => Pages\EditInternationalPaymentType::route('/{record}/edit'),
        ];
    }
}
