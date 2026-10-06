<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TariffDetailResource\Pages;
use App\Models\TariffCategory;
use App\Models\TariffDetail;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Resources\Concerns\Translatable;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class TariffDetailResource extends Resource
{
    use Translatable;

    protected static ?string $cluster = \App\Filament\Clusters\Tariffs::class;

    protected static ?int $navigationSort = 2;

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

    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([

                Select::make('tariff_category_id')
                    ->label(__('resource.tariff_categories'))
                    ->options(function () {
                        $locale = 'tk';

                        return TariffCategory::query()
                            ->orderBy('number')
                            ->get()
                            ->mapWithKeys(function ($item) use ($locale) {
                                $title = $item->getTranslation('title', $locale);

                                return [
                                    $item->id => trim(($item->number ? $item->number.'. ' : '').$title),
                                ];
                            });
                    }),
                TextInput::make('number')
                    ->required()
                    ->label(__('resource.number')),
                TextInput::make('title')
                    ->label(__('resource.title'))
                    ->nullable(),
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
                Toggle::make('is_active')
                    ->label(__('resource.active'))
                    ->default(true),

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('number')
                    ->label(__('resource.number'))
                    ->sortable(query: function (Builder $query, string $direction): Builder {
                        return $query->orderByNumber($direction);
                    }),
                Tables\Columns\TextColumn::make('category.title')
                    ->label(__('resource.tariff_categories')),
                Tables\Columns\TextColumn::make('title')
                    ->label(__('resource.title')),
                ToggleColumn::make('is_active')
                    ->label(__('resource.active')),
                Tables\Columns\TextColumn::make('details')
                    ->label(__('resource.sub_title'))
                    ->formatStateUsing(function ($state) {
                        if (empty($state)) {
                            return '-';
                        }
                        $normalized = is_array($state) ? $state : json_decode(
                            str_starts_with(trim((string) $state), '[') ? (string) $state : '['.trim((string) $state).']',
                            true
                        );

                        if (! is_array($normalized) || empty($normalized)) {
                            return '-';
                        }

                        $first = $normalized[0] ?? $normalized;
                        $subTitle = is_array($first) ? ($first['sub_title'] ?? '-') : '-';

                        return strlen($subTitle) > 30
                            ? substr($subTitle, 0, 30).'...'
                            : $subTitle;
                    }),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('tariff_category_id')
                    ->label(__('resource.tariff_categories'))
                    ->options(function () {
                        return TariffCategory::query()
                            ->orderBy('number')
                            ->get()
                            ->mapWithKeys(function ($item) {
                                $title = $item->getTranslation('title', 'tk');

                                return [
                                    $item->id => trim(($item->number ? $item->number.'. ' : '').$title),
                                ];
                            });
                    }),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort(fn (Builder $query) => $query->orderByNumber())
            ->reorderable('sort');
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
