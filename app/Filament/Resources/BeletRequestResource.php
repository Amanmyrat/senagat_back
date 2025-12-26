<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BeletRequestResource\Pages;
use App\Models\PaymentRequest;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class BeletRequestResource extends Resource
{
    protected static ?string $model = PaymentRequest::class;

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->whereIn('type', ['topup', 'confirm']);
    }

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $cluster = \App\Filament\Clusters\Payments::class;

    protected static ?int $navigationSort = 1;

    public static function getNavigationLabel(): string
    {
        return __('navigation.belet_payment');
    }

    public static function getPluralModelLabel(): string
    {
        return __('navigation.belet_payment');
    }

    public static function getModelLabel(): string
    {
        return __('navigation.belet_payment');
    }

    public static function getRecordTitle(?object $record = null): string
    {
        return $record ? (string) $record->name : __('navigation.belet_payment');
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
                TextColumn::make('user.phone')
                    ->sortable()
                    ->label(__('resource.user_phone')),
                TextColumn::make('payment_target.value')
                    ->label(__('resource.target_phone'))
                    ->searchable(),
                TextColumn::make('type')
                    ->label(__('resource.type'))
                    ->colors([
                        'success' => 'topup',
                        'danger' => 'confirm',
                    ])
                    ->badge(),
                TextColumn::make('amount')
                    ->suffix(' TMT')
                    ->label(__('resource.amount')),
                TextColumn::make('external_id')
                    ->label(__('resource.order_id'))

                    ->copyable()
                    ->searchable(),

                TextColumn::make('status')
                    ->label(__('resource.status'))
                    ->colors([
                        'gray' => 'sent',
                        'info' => 'notConfirmed',
                        'warning' => 'confirming',
                        'success' => 'confirmed',
                        'danger' => 'failed',
                    ])->badge(),

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

    public static function canCreate(): bool
    {
        return false;
    }

    public static function canViewAny(): bool
    {

        return optional(auth()->user())->role === 'super-admin';

    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListBeletRequests::route('/'),
            'create' => Pages\CreateBeletRequest::route('/create'),
            'edit' => Pages\EditBeletRequest::route('/{record}/edit'),
        ];
    }
}
