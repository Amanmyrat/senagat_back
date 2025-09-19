<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ContactAddressResource\Pages;
use App\Models\ContactAddress;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Concerns\Translatable;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class ContactAddressResource extends Resource
{
    public static function getNavigationGroup(): ?string
    {
        return 'Contact';
    }

    use Translatable;

    public static function getTranslatableLocales(): array
    {
        return ['en', 'tk', 'ru'];
    }

    protected static ?string $model = ContactAddress::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('title'),
                RichEditor::make('address'),
                TextInput::make('phone_number'),
                TextInput::make('fax_number'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title'),
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
            'index' => Pages\ListContactAddresses::route('/'),
            'create' => Pages\CreateContactAddress::route('/create'),
            'edit' => Pages\EditContactAddress::route('/{record}/edit'),
        ];
    }
}
