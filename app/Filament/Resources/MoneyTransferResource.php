<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MoneyTransferResource\Pages;
use App\Models\MoneyTransfer;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Concerns\Translatable;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class MoneyTransferResource extends Resource
{
    use Translatable;

    protected static ?string $model = MoneyTransfer::class;

    protected static ?string $cluster = \App\Filament\Clusters\ContentManagement::class;

    protected static ?int $navigationSort = 2;

    protected static ?string $navigationIcon = 'heroicon-o-arrow-path-rounded-square';

    public static function getTranslatableLocales(): array
    {
        return ['tk', 'en', 'ru'];
    }

    public static function getNavigationLabel(): string
    {
        return __('resource.money_transfers');
    }

    public static function getPluralModelLabel(): string
    {
        return __('resource.money_transfers');
    }

    public static function getModelLabel(): string
    {
        return __('resource.money_transfer');
    }

    public static function getRecordTitle(?object $record = null): string
    {
        return $record ? (string) $record->title : __('resource.money_transfer');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('title')
                    ->label(__('resource.title'))
                    ->required(),
                TextInput::make('sub_title')
                    ->label(__('resource.sub_title')),
                TextInput::make('main_title')
                    ->label(__('resource.main_title'))
                    ->required(),
                TextInput::make('description')
                    ->label(__('resource.description')),
                RichEditor::make('header_text')
                    ->label(__('resource.header_text'))
                    ->columnSpanFull(),
                RichEditor::make('footer_text')
                    ->label(__('resource.footer_text'))
                    ->columnSpanFull(),
                Repeater::make('advantages')
                    ->label(__('resource.advantages'))
                    ->schema([
                        TextInput::make('title')->label(__('resource.value')),
                    ])
                    ->collapsible(),
                Repeater::make('tariff_details')
                    ->label(__('resource.tariff_details'))
                    ->schema([
                        TextInput::make('table_title')
                            ->label(__('resource.table_title'))
                            ->helperText(__('resource.table_title_helper')),
                        Repeater::make('rows')
                            ->label(__('resource.tariff_rows'))
                            ->schema([
                                TextInput::make('service_type')->label(__('resource.service_type')),
                                TextInput::make('service_cost')->label(__('resource.service_cost')),
                                TextInput::make('vat')->label(__('resource.vat')),
                                TextInput::make('total_payment')->label(__('resource.total_payment')),
                            ])
                            ->columns(4)
                            ->defaultItems(1)
                            ->collapsible()
                            ->itemLabel(fn (array $state): ?string => $state['service_type'] ?? null),
                    ])
                    ->collapsible()
                    ->itemLabel(fn (array $state): ?string => $state['table_title'] ?? __('resource.tariff_table'))
                    ->defaultItems(1),
                TextInput::make('background_color')
                    ->label(__('resource.background_color').' (HEX code)')
                    ->translateLabel(false),
                FileUpload::make('image_url')
                    ->image()
                    ->label(__('resource.image_url'))
                    ->translateLabel(false),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title')
                    ->label(__('resource.title'))
                    ->searchable(),
                TextColumn::make('main_title')
                    ->label(__('resource.main_title'))
                    ->searchable(),
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
            'index' => Pages\ListMoneyTransfers::route('/'),
            'create' => Pages\CreateMoneyTransfer::route('/create'),
            'edit' => Pages\EditMoneyTransfer::route('/{record}/edit'),
        ];
    }
}
