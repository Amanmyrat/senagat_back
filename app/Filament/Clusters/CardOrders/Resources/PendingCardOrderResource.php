<?php

namespace App\Filament\Clusters\CardOrders\Resources;

use App\Filament\Clusters\CardOrders;
use App\Filament\Clusters\CardOrders\Resources\PendingCardOrderResource\Pages;
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

class PendingCardOrderResource extends Resource
{
    protected static ?string $model = CardOrder::class;

    public static function getNavigationBadge(): ?string
    {
        return (string) static::getEloquentQuery()->count();
    }

    protected static ?string $navigationLabel = 'Pending Orders';

    protected static ?string $navigationIcon = 'heroicon-o-clock';

    protected static ?string $pluralModelLabel = 'Pending Card Orders';

    protected static ?string $cluster = CardOrders::class;
    public static function getNavigationLabel(): string
    {
        return __('navigation.pending_orders');
    }

    public static function getPluralModelLabel(): string
    {
        return __('navigation.pending_orders');
    }

    public static function getModelLabel(): string
    {
        return __('navigation.pending_orders');
    }

    public static function getRecordTitle(?object $record = null): string
    {
        return $record ? (string) $record->name : __('navigation.pending_orders');
    }


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Wizard::make([
                    Step::make('Card Order Status')
                        ->label(__('resource.card_order_status'))
                        ->schema([
                            Section::make(__('resource.card_order_status'))
                                ->schema([
                                    ToggleButtons::make('status')
                                        ->label(__('resource.card_order_status'))
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
                        ->label(__('resource.profile_information'))
                        ->schema([
                            ProfileInfo::make(),
                        ]),
                    Step::make('Card Information')
                        ->label(__('resource.card_information'))
                        ->schema([
                            TextInput::make('cardType.title')
                                ->label(__('resource.title'))
                                ->afterStateHydrated(fn ($component, $state, $record) => $component->state($record->cardType?->title)
                                )
                                ->disabled(),
                            TextInput::make('phone_number')
                                ->label(__('resource.phone'))
                                ->disabled(),
                            TextInput::make('branch.name')
                                ->label(__('resource.branch_name'))

                                ->afterStateHydrated(fn ($component, $state, $record) => $component->state($record->branch?->name)
                                )
                                ->disabled(),
                            TextInput::make('home_phone_number')->disabled()
                                ->label(__('resource.home_phone_number')),
                            TextInput::make('cardType.price')
                                ->label(__('resource.price'))
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
                TextColumn::make('profile.first_name')->searchable()
                    ->label(__('resource.first_name')),
                TextColumn::make('profile.last_name')->searchable()
                    ->label(__('resource.last_name')),
                TextColumn::make('cardType.title')
                    ->label(__('resource.card_type')),

                TextColumn::make('status')
                    ->label(__('resource.status'))
                    ->default('Pending')
                    ->formatStateUsing(fn ($state) => __("resource.$state"))
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
            'index' => Pages\ListPendingCardOrders::route('/'),
            'create' => Pages\CreatePendingCardOrder::route('/create'),
            'edit' => Pages\EditPendingCardOrder::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->with(['branch', 'profile', 'cardType'])
            ->where('status', 'pending');
    }
}
