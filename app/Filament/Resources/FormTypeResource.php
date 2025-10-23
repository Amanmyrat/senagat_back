<?php

namespace App\Filament\Resources;

use App\Filament\Resources\FormTypeResource\Pages;
use App\Models\CertificateType;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Concerns\Translatable;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class FormTypeResource extends Resource
{
    public static function getNavigationGroup(): ?string
    {
        return 'Certification';
    }

    public static function canViewAny(): bool
    {
        $user = auth('admin')->user();

        return in_array($user->role->value, ['super-admin']);

    }

    protected static ?string $model = CertificateType::class;

    use Translatable;

    public static function getTranslatableLocales(): array
    {
        return ['tk', 'en', 'ru'];
    }

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    public static function getNavigationBadge(): ?string
    {
        return (string) static::getEloquentQuery()->count();
    }
    public static function getNavigationLabel(): string
    {
        return __('resource.certificate_type');
    }

    public static function getPluralModelLabel(): string
    {
        return __('resource.certificate_type');
    }

    public static function getModelLabel(): string
    {
        return __('resource.certificate_type');
    }

    public static function getRecordTitle(?object $record = null): string
    {
        return $record ? (string) $record->name : __('resource.certificate_type');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('title')
                    ->label(__('resource.title')),
                TextInput::make('price')
                    ->label(__('resource.card_price'))
                    ->numeric()
                    ->step(0.01)
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title')
                    ->label(__('resource.title')),
                Tables\Columns\TextColumn::make('price')

                    ->label(__('resource.price'))
                    ->formatStateUsing(fn ($state) => number_format($state, 2, ',', '.').' TMT'),
            ])
            ->filters([

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
            'index' => Pages\ListFormTypes::route('/'),
            'create' => Pages\CreateFormType::route('/create'),
            'edit' => Pages\EditFormType::route('/{record}/edit'),
        ];
    }
}
