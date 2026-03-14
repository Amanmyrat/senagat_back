<?php

namespace App\Filament\Resources;

use App\Filament\Clusters\Payments;
use App\Filament\Resources\AstuRequestResource\Pages;
use App\Models\PaymentRequest;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class AstuRequestResource extends Resource
{
    protected static ?string $model = PaymentRequest::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->whereIn('type', ['astu inet', 'astu cdma', 'astu phone', 'astu iptv']);
    }

    public static function getNavigationLabel(): string
    {
        return __('navigation.astu_payment');
    }

    public static function getPluralModelLabel(): string
    {
        return __('navigation.astu_payment');
    }

    public static function getModelLabel(): string
    {
        return __('navigation.astu_payment');
    }

    public static function getRecordTitle(?object $record = null): string
    {
        return $record ? (string) $record->name : __('navigation.astu_payment');
    }

    public static function canViewAny(): bool
    {
        return optional(auth()->user())->role === 'super-admin';
    }

    protected static ?string $cluster = Payments::class;

    protected static ?int $navigationSort = 4;

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
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])->defaultSort('created_at', 'desc');
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
            'index' => Pages\ListAstuRequests::route('/'),
            'create' => Pages\CreateAstuRequest::route('/create'),
            'edit' => Pages\EditAstuRequest::route('/{record}/edit'),
        ];
    }
}
