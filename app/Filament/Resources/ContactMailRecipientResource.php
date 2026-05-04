<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ContactMailRecipientResource\Pages;
use App\Filament\Resources\ContactMailRecipientResource\RelationManagers;
use App\Models\ContactMailRecipient;
use Filament\Forms;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ContactMailRecipientResource extends Resource
{
    protected static ?string $model = ContactMailRecipient::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?int $navigationSort = 41;
    public static function getNavigationGroup(): ?string
    {
        return __('resource.complaint');
    }

    public static function getNavigationLabel(): string
    {
        return __('resource.contact_admin');
    }

    public static function getPluralModelLabel(): string
    {
        return __('resource.contact_admin');
    }

    public static function getModelLabel(): string
    {
        return __('resource.contact_admin');
    }

    public static function getRecordTitle(?object $record = null): string
    {
        return $record ? (string) $record->name : __('resource.contact_admin');
    }
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('email')
                    ->email()
                    ->label(__('resource.email'))
                    ->required(),

                Toggle::make('is_active')
                    ->label(__('resource.active'))
                    ->default(true),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
               TextColumn::make('email')
                   ->label(__('resource.email')),
               IconColumn::make('is_active')->boolean()
                   ->label(__('resource.active')),
                TextColumn::make('created_at')
                    ->label(__('resource.created_at'))
                    ->dateTime()
                    ->sortable(),
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
            ])->defaultSort('created_at', 'desc');
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
            'index' => Pages\ListContactMailRecipients::route('/'),
            'create' => Pages\CreateContactMailRecipient::route('/create'),
            'edit' => Pages\EditContactMailRecipient::route('/{record}/edit'),
        ];
    }
}
