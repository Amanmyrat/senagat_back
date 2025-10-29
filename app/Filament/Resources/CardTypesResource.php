<?php

namespace App\Filament\Resources;

use App\Filament\Clusters\CardOrders;
use App\Filament\Resources\CardTypesResource\Pages;
use App\Models\CardType;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Concerns\Translatable;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class CardTypesResource extends Resource
{
    protected static ?string $cluster = CardOrders::class;

    use Translatable;

    public static function getTranslatableLocales(): array
    {
        return ['tk', 'en', 'ru'];
    }

    protected static ?string $model = CardType::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function getNavigationLabel(): string
    {
        return __('resource.card_type');
    }

    public static function getPluralModelLabel(): string
    {
        return __('resource.card_type');
    }

    public static function getModelLabel(): string
    {
        return __('resource.card_type');
    }

    public static function getRecordTitle(?object $record = null): string
    {
        return $record ? (string) $record->name : __('resource.card_type');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('title')->required()
                    ->label(__('resource.title')),
                TextInput::make('price')
                    ->label(__('resource.price'))
                    ->numeric()
                    ->step(0.01)
                    ->required(),
                Select::make('category')
                    ->label(__('resource.category'))
                    ->options([
                        'For the individual' => __('resource.individual'),
                        'For the entrepreneur' => __('resource.entrepreneur'),
                    ]),
                FileUpload::make('image_url')->image()
                    ->label(__('resource.image_url')),

                Repeater::make('advantages')
                    ->label(__('resource.advantages'))
                    ->schema([
                        TextInput::make('name')->label(__('resource.value')),
                        Textarea::make('description')->label(__('resource.description')),
                    ])
                    ->collapsible(),
                RichEditor::make('text')
                    ->label(__('resource.text'))
                    ->columnSpan('full'),
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
            'index' => Pages\ListCardTypes::route('/'),
            'create' => Pages\CreateCardTypes::route('/create'),
            'edit' => Pages\EditCardTypes::route('/{record}/edit'),
        ];
    }
}
