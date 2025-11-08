<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TariffDetailResource\Pages;
use App\Filament\Resources\TariffDetailResource\RelationManagers;
use App\Models\TariffDetail;
use Filament\Forms;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class TariffDetailResource extends Resource
{
    protected static ?string $model = TariffDetail::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('tariff_category_id')
                    ->label('Tariff Category')
                    ->relationship('category', 'title')
                    ->required(),
                TextInput::make('number')->required()
                ->numeric(),
                Repeater::make('details')
                    ->schema([
                        TextInput::make('sub_title')->label('Sub title'),
                        Repeater::make('fees')
                            ->schema([

                                TextInput::make('price')->label('Service cost'),
                                TextInput::make('gbss_fee')->label('vat'),
                                TextInput::make('total_fee')->label('Total payment'),
                            ])
                            ->label('Fees')
                            ->collapsible(),
                    ])
                    ->label('Details')
                    ->collapsible(),

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('number'),
                Tables\Columns\TextColumn::make('details')
                    ->label('Sub Title')
                    ->formatStateUsing(function ($state) {
                        $data = json_decode($state, true);
                        $subTitle = $data['sub_title'] ?? '';
                        return strlen($subTitle) > 30
                            ? substr($subTitle, 0, 30) . '...'
                            : $subTitle;
                    }),
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
            'index' => Pages\ListTariffDetails::route('/'),
            'create' => Pages\CreateTariffDetail::route('/create'),
            'edit' => Pages\EditTariffDetail::route('/{record}/edit'),
        ];
    }
}
