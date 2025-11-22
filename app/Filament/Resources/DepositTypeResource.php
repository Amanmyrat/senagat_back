<?php

namespace App\Filament\Resources;

use App\Filament\Resources\DepositTypeResource\Pages;
use App\Models\DepositType;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Concerns\Translatable;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class DepositTypeResource extends Resource
{
    protected static ?string $model = DepositType::class;

    protected static ?string $cluster = \App\Filament\Clusters\ContentManagement::class;

    protected static ?int $navigationSort = 7;

    use Translatable;

    public static function getTranslatableLocales(): array
    {
        return ['tk', 'en', 'ru'];
    }

    public static function getNavigationLabel(): string
    {
        return __('resource.deposit_types');
    }

    public static function getPluralModelLabel(): string
    {
        return __('resource.deposit_types');
    }

    public static function getModelLabel(): string
    {
        return __('resource.deposit_types');
    }

    public static function getRecordTitle(?object $record = null): string
    {
        return $record ? (string) $record->name : __('resource.deposit_types');
    }

    protected static ?string $navigationIcon = 'heroicon-o-banknotes';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('title')->required()
                    ->label(__('resource.title'))
                    ->required(),
                TextInput::make('description')
                    ->required()
                    ->label(__('resource.description')),
                TextInput::make('background_color')
                    ->required()
                    ->label(__('resource.background_color').' (HEX code)'),
                FileUpload::make('image_url')->image()
                    ->required()
                    ->label(__('resource.image_url')),
                Repeater::make('advantages')
                    ->label(__('resource.advantages'))
                    ->schema([
                        TextInput::make('name')->label(__('resource.value')),
                        Textarea::make('description')->label(__('resource.description')),
                    ])
                    ->collapsible(),
                Repeater::make('details')
                    ->schema([
                        Textarea::make('description')->label(__('resource.description')),
                    ])
                    ->label(__('resource.details'))
                    ->collapsible(),
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

    public static function canViewAny(): bool
    {

        return optional(auth()->user())->role === 'super-admin';

    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListDepositTypes::route('/'),
            'create' => Pages\CreateDepositType::route('/create'),
            'edit' => Pages\EditDepositType::route('/{record}/edit'),
        ];
    }
}
