<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CreditTypesResource\Pages;
use App\Models\CreditType;
use Filament\Forms\Components\HasManyRepeater;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Wizard;
use Filament\Forms\Components\Wizard\Step;
use Filament\Forms\Form;
use Filament\Resources\Concerns\Translatable;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class CreditTypesResource extends Resource
{
    use Translatable;

    public static function getTranslatableLocales(): array
    {
        return ['en', 'tk', 'ru'];
    }

    protected static ?string $model = CreditType::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Wizard::make(
                    [
                        Step::make('Credit Type')
                            ->schema([
                                TextInput::make('name')
                                    ->label('Credit Type Name')
                                    ->required(),
                                Textarea::make('description')
                                    ->label('Description'),
                                TextInput::make('term')
                                    ->label('maximum term')
                                    ->numeric()
                                    ->minValue(1)
                                    ->required(),
                                TextInput::make('amount')
                                    ->label('Amount')
                                    ->numeric()
                                    ->required(),
                                TextInput::make('interest')
                                    ->label('Interest (%)')
                                    ->numeric()
                                    ->suffix('%')
                                    ->step(0.01)
                                    ->required(),
                            ]),
                        Step::make('Requirments')
                            ->schema([
                                HasManyRepeater::make('requirementGroups')
                                    ->relationship('requirementGroups')
                                    ->label('Requirements / Documents')
                                    ->schema([
                                        TextInput::make('title')->label('Group Title'),
                                        HasManyRepeater::make('categories')
                                            ->relationship('categories')
                                            ->label('Categories')
                                            ->schema([
                                                TextInput::make('name')->required()->label('Category Name'),

                                                HasManyRepeater::make('items')
                                                    ->relationship('items')
                                                    ->label('Items / Rules')
                                                    ->schema([
                                                        TextInput::make('name')->required()->label('Item / Rule'),
                                                    ]),
                                            ]),
                                    ]),
                            ]),
                    ]
                )
                    ->skippable()
                    ->columnSpanFull(),

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name'),
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
            'index' => Pages\ListCreditTypes::route('/'),
            'create' => Pages\CreateCreditTypes::route('/create'),
            'edit' => Pages\EditCreditTypes::route('/{record}/edit'),
        ];
    }
}
