<?php

namespace App\Filament\Clusters\CardOrders\Resources;

use App\Filament\Clusters\CardOrders;
use App\Filament\Clusters\CardOrders\Resources\RejectedCardOrderResource\Pages;
use App\Forms\Components\ProfileInfo;
use App\Models\CardOrder;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\ToggleButtons;
use Filament\Forms\Components\Wizard;
use Filament\Forms\Components\Wizard\Step;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class RejectedCardOrderResource extends Resource
{
    protected static ?string $model = CardOrder::class;

    public static function getNavigationBadge(): ?string
    {
        return (string) static::getEloquentQuery()->count();
    }

    protected static ?string $navigationLabel = 'Rejected Orders';

    protected static ?string $navigationIcon = 'heroicon-o-x-circle';

    protected static ?string $pluralModelLabel = 'Rejected Card Orders';

    protected static ?string $cluster = CardOrders::class;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Wizard::make([
                    Step::make('Card Order Status')
                        ->schema([
                            Section::make(__('Loan Status'))
                                ->schema([
                                    ToggleButtons::make('status')
                                        ->label(__('Loan Status'))
                                        ->options([
                                            'approved' => __('resource.approved'),
                                            'rejected' => __('resource.rejected'),
                                        ])
                                        ->icons([
                                            'approved' => 'heroicon-o-check-badge',
                                            'rejected' => 'heroicon-o-x-circle',
                                        ])
                                        ->colors([
                                            'approved' => 'success',
                                            'rejected' => 'danger',
                                        ])
                                        ->inline(),
                                ]),
                        ]),
                    Step::make('Profile Information')
                        ->schema([
                            ProfileInfo::make(),
                        ]),
                    Step::make('Card Information')
                        ->schema([
                            TextInput::make('cardType.title')
                                ->afterStateHydrated(fn ($component, $state, $record) => $component->state($record->cardType?->title)
                                )
                                ->disabled(),
                            TextInput::make('phone_number')
                                ->disabled(),
                            TextInput::make('branch.name')
                                ->label('Branch name')
                                ->afterStateHydrated(fn ($component, $state, $record) => $component->state($record->branch?->name)
                                )
                                ->disabled(),
                            TextInput::make('home_phone_number')->disabled(),
                            TextInput::make('cardType.price')
                                ->afterStateHydrated(fn ($component, $state, $record) => $component->state($record->cardType?->price)
                                )
                                ->disabled(),
                        ]),

                ])->skippable()
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('profile.first_name')->searchable(),
                TextColumn::make('profile.last_name')->searchable(),
                TextColumn::make('cardType.title'),

                TextColumn::make('status')
                    ->default('Pending')
                    ->colors([
                        'warning' => 'pending',
                        'success' => 'approved',
                        'danger' => 'rejected',
                    ])
                    ->badge(),
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
            'index' => Pages\ListRejectedCardOrders::route('/'),
            'create' => Pages\CreateRejectedCardOrder::route('/create'),
            'edit' => Pages\EditRejectedCardOrder::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->with(['branch', 'profile', 'cardType'])
            ->where('status', 'rejected');
    }
}
