<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ContactMessageResource\Pages;
use App\Models\ContactMessage;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class ContactMessageResource extends Resource
{
    public static function getNavigationGroup(): ?string
    {
        return 'Contact';
    }

    protected static ?string $model = ContactMessage::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function getNavigationBadge(): ?string
    {
        return (string) static::getEloquentQuery()->count();
    }

    public static function getNavigationLabel(): string
    {
        return __('resource.contact_messages');
    }

    public static function getPluralModelLabel(): string
    {
        return __('resource.contact_messages');
    }

    public static function getModelLabel(): string
    {
        return __('resource.contact_messages');
    }

    public static function getRecordTitle(?object $record = null): string
    {
        return $record ? (string) $record->name : __('resource.contact_messages');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                    ->disabled()
                    ->label(__('resource.name')),
                TextInput::make('email')
                    ->disabled()
                    ->label(__('resource.email')),
                TextInput::make('phone_number')
                    ->disabled()
                    ->label(__('resource.phone_number')),
                RichEditor::make('message')
                    ->disabled()
                    ->label(__('resource.messages')),

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label(__('resource.name')),
                TextColumn::make('email')
                    ->label(__('resource.email')),
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
            'index' => Pages\ListContactMessages::route('/'),
            'create' => Pages\CreateContactMessage::route('/create'),
            'edit' => Pages\EditContactMessage::route('/{record}/edit'),
        ];
    }
}
