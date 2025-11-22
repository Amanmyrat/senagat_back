<?php

namespace App\Filament\Widgets;

use App\Filament\Resources\CardOrderResource;
use App\Models\CardOrder;
use Filament\Tables;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class RecentOrdersWidget extends BaseWidget
{
    protected static ?int $sort = 3;

    protected int|string|array $columnSpan = 'full';

    public function table(Table $table): Table
    {
        return $table
            ->heading(__('resource.recent_card_orders'))
            ->query(
                CardOrder::query()
                    ->with(['user', 'cardType'])
                    ->latest()
                    ->limit(10)
            )
            ->columns([
                TextColumn::make('id')
                    ->label(__('resource.order_number'))
                    ->sortable(),

                TextColumn::make('user.name')
                    ->label(__('resource.user'))
                    ->searchable()
                    ->limit(20),

                TextColumn::make('cardType.name')
                    ->label(__('resource.card_type'))
                    ->limit(20)
                    ->default('-'),

                BadgeColumn::make('status')
                    ->label(__('resource.status'))
                    ->colors([
                        'warning' => 'pending',
                        'success' => 'approved',
                        'danger' => 'rejected',
                    ])
                    ->icons([
                        'heroicon-o-clock' => 'pending',
                        'heroicon-o-check-circle' => 'approved',
                        'heroicon-o-x-circle' => 'rejected',
                    ]),

                TextColumn::make('created_at')
                    ->label(__('resource.date'))
                    ->dateTime('M d, Y H:i')
                    ->sortable(),
            ])
            ->actions([
                Tables\Actions\Action::make('view')
                    ->label(__('resource.view'))
                    ->url(fn (CardOrder $record): string => CardOrderResource::getUrl('edit', ['record' => $record]))
                    ->icon('heroicon-o-eye'),
            ]);
    }
}
