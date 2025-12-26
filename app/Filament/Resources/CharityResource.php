<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CharityResource\Pages;
use App\Models\PaymentRequest;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class CharityResource extends Resource
{
    protected static ?string $model = PaymentRequest::class;

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->where('type', 'charity');
    }

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $cluster = \App\Filament\Clusters\Payments::class;

    protected static ?int $navigationSort = 2;

    public static function getNavigationLabel(): string
    {
        return __('navigation.charity');
    }

    public static function getPluralModelLabel(): string
    {
        return __('navigation.charity');
    }

    public static function getModelLabel(): string
    {
        return __('navigation.charity');
    }

    public static function canCreate(): bool
    {
        return false;
    }

    public static function canViewAny(): bool
    {

        return optional(auth()->user())->role === 'super-admin';

    }

    public static function getRecordTitle(?object $record = null): string
    {
        return $record ? (string) $record->name : __('navigation.charity');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('user.profile.first_name')->label(__('resource.first_name')),
                TextColumn::make('user.profile.last_name')->label(__('resource.last_name')),
                TextColumn::make('amount')
                    ->suffix(' TMT')
                    ->label(__('resource.amount')),
                TextColumn::make('payment_target.value')
                    ->label(__('resource.target_phone'))
                    ->searchable(),
                TextColumn::make('type')
                    ->label(__('resource.type'))
                    ->colors([
                        'success' => 'charity',
                    ])
                    ->badge(),
                TextColumn::make('created_at')
                    ->label(__('resource.created_at'))
                    ->dateTime()
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])->defaultSort('id', 'desc');
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
            'index' => Pages\ListCharities::route('/'),
            'create' => Pages\CreateCharity::route('/create'),
            'edit' => Pages\EditCharity::route('/{record}/edit'),
        ];
    }
}
