<?php

namespace App\Filament\Resources;

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
    public static function getNavigationGroup(): ?string
    {
        return 'Card';
    }
    use Translatable;

    public static function getTranslatableLocales(): array
    {
        return ['en', 'tk', 'ru'];
    }

    protected static ?string $model = CardType::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('title')->required(),
                TextInput::make('price')
                    ->label('Card Price')
            ->numeric()
            ->required(),
                Select::make('category')
                    ->label('Category')
                    ->options([
                        'For the individual' => __('resource.individual'),
                        'For the entrepreneur' => __('resource.entrepreneur'),
                    ]),
                FileUpload::make('image_url')->image(),

                Repeater::make('advantages')
                    ->schema([
                        TextInput::make('name'),
                        Textarea::make('description'),
                    ])
                    ->collapsible(),
                RichEditor::make('text')
                    ->columnSpan('full')
              ]);

    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title'),
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
