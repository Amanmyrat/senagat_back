<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ClientsResource\Pages;
use App\Models\Clients;
use Filament\Forms;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Concerns\Translatable;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class ClientsResource extends Resource
{
    protected static ?string $model = Clients::class;

    protected static ?string $cluster = \App\Filament\Clusters\ContentManagement::class;

    protected static ?int $navigationSort = 6;

    public static function getNavigationLabel(): string
    {
        return __('resource.clients');
    }

    public static function getPluralModelLabel(): string
    {
        return __('resource.clients');
    }

    public static function getModelLabel(): string
    {
        return __('resource.clients');
    }

    public static function getRecordTitle(?object $record = null): string
    {
        return $record ? (string) $record->name : __('resource.clients');
    }

    protected static ?string $navigationIcon = 'heroicon-o-building-office-2';

    use Translatable;

    public static function getTranslatableLocales(): array
    {
        return ['tk', 'en', 'ru'];
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('title')
                    ->required()
                    ->label(__('resource.title')),
                TextInput::make('company_type')
                    ->label(__('resource.company_type')),
                Forms\Components\RichEditor::make('description')
                    ->label(__('resource.description')),
                FileUpload::make('image_url')->image()
                    ->required()
                    ->label(__('resource.image')),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')->label(__('resource.title')),
                Tables\Columns\TextColumn::make('company_type')->label(__('resource.company_type')),
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
            'index' => Pages\ListClients::route('/'),
            'create' => Pages\CreateClients::route('/create'),
            'edit' => Pages\EditClients::route('/{record}/edit'),
        ];
    }
}
