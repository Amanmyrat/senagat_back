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
use Filament\Resources\Concerns\Translatable;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class TariffDetailResource extends Resource
{
    use Translatable;

    public static function getTranslatableLocales(): array
    {
        return ['tk', 'en', 'ru'];
    }
    public static function getNavigationLabel(): string
    {
        return __('resource.tariff_details');
    }

    public static function getPluralModelLabel(): string
    {
        return __('resource.tariff_details');
    }

    public static function getModelLabel(): string
    {
        return __('resource.tariff_details');
    }

    public static function getRecordTitle(?object $record = null): string
    {
        return $record ? (string) $record->name : __('resource.tariff_details');
    }

    protected static ?string $model = TariffDetail::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([

                Select::make('tariff_category_id')
                    ->label(__('resource.tariff_categories'))
                    ->options(function () {
                        $locale = 'tk';
                        return \App\Models\TariffCategory::query()
                            ->orderByRaw("title->>'$locale' ASC")
                            ->get()
                            ->mapWithKeys(function ($item) use ($locale) {
                                return [
                                    $item->id => $item->getTranslation('title', $locale)
                                ];
                            });
                    }),
                TextInput::make('number')->required()
                    ->label(__('resource.number'))
                ->numeric(),
                Repeater::make('details')

                        ->schema([
                        TextInput::make('sub_title')->label(__('resource.sub_title')),
                        Repeater::make('fees')
                            ->schema([
                                TextInput::make('price')->label(__('resource.service_cost')),
                                TextInput::make('gbss_fee')->label(__('resource.vat')),
                                TextInput::make('total_fee')->label(__('resource.total_payment')),
                            ])
                            ->label(__('resource.fees'))
                            ->collapsible(),
                    ])
                    ->label(__('resource.details'))
                    ->collapsible(),

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('number')
                    ->label(__('resource.number')),
                Tables\Columns\TextColumn::make('details')
                    ->label(__('resource.sub_title'))
                    ->formatStateUsing(function ($state) {
                        if (empty($state)) {
                            return '-';
                        }
                        $normalized = trim($state);
                        if (!str_starts_with($normalized, '[')) {
                            $normalized = "[$normalized]";
                        }

                        $data = json_decode($normalized, true);

                        if (json_last_error() !== JSON_ERROR_NONE || empty($data)) {
                            return '-';
                        }
                        $subTitle = $data[0]['sub_title'] ?? ($data['sub_title'] ?? '-');

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
    public static function canViewAny(): bool
    {

        return optional(auth()->user())->role === 'super-admin';

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
