<?php

namespace App\Filament\Widgets;

use App\Filament\Resources\PendingProfileResource;
use App\Filament\Resources\UsersResource;
use App\Models\User;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class LatestUsersWidget extends BaseWidget
{
    protected static ?int $sort = 5;

    protected int|string|array $columnSpan = 'full';

    public function table(Table $table): Table
    {
        return $table
            ->heading(__('resource.latest_user_registrations'))
            ->query(
                User::query()
                    ->with('profile')
                    ->latest()
                    ->limit(10)
            )
            ->columns([
                TextColumn::make('id')
                    ->label('ID')
                    ->sortable(),

                TextColumn::make('name')
                    ->label(__('resource.name'))
                    ->searchable()
                    ->limit(25),

                TextColumn::make('phone_number')
                    ->label(__('resource.phone'))
                    ->searchable(),

                TextColumn::make('profile.approved')
                    ->label(__('resource.profile_status'))
                    ->badge()
                    ->colors([
                        'warning' => 'pending',
                        'success' => 'approved',
                        'danger' => 'rejected',
                    ])
                    ->default(__('resource.no_profile')),

                TextColumn::make('created_at')
                    ->label(__('resource.registered'))
                    ->dateTime('M d, Y')
                    ->sortable(),
            ])
            ->actions([
                Tables\Actions\Action::make('view_profile')
                    ->label(__('resource.view'))
                    ->url(fn (User $record): string => $record->profile
                        ? PendingProfileResource::getUrl('edit', ['record' => $record->profile])
                        : UsersResource::getUrl('edit', ['record' => $record]))
                    ->icon('heroicon-o-eye'),
            ]);
    }
}
