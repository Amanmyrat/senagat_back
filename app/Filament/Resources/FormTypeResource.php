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
        return ['en', 'tk', 'ru'];
    }

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('title'),
                TextInput::make('price')
                    ->label('Card Price')
                    ->numeric()
                    ->step(0.01)
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title'),
                Tables\Columns\TextColumn::make('price')
                    ->label('Price')
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
