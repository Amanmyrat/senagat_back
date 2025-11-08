<?php

namespace App\Filament\Clusters\CardOrders\Resources;

use App\Filament\Clusters\CardOrders;
use App\Filament\Clusters\CardOrders\Resources\RejectedCardOrderResource\Pages;
use App\Forms\Components\ProfileInfo;
use App\Models\RejectedCardOrder;
use Filament\Forms\Components\Checkbox;
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
    protected static ?string $model = RejectedCardOrder::class;
    protected static ?int $navigationSort = 5;
    public static function getNavigationBadge(): ?string
    {
        return (string) static::getEloquentQuery()->count();
    }

    protected static ?string $navigationLabel = 'Rejected Orders';

    protected static ?string $navigationIcon = 'heroicon-o-x-circle';

    protected static ?string $pluralModelLabel = 'Rejected Card Orders';

    protected static ?string $cluster = CardOrders::class;

    public static function getNavigationLabel(): string
    {
        return __('navigation.rejected_card_orders');
    }

    public static function getPluralModelLabel(): string
    {
        return __('navigation.rejected_card_orders');
    }

    public static function getModelLabel(): string
    {
        return __('navigation.rejected_card_orders');
    }

    public static function getRecordTitle(?object $record = null): string
    {
        return $record ? (string) $record->name : __('navigation.rejected_card_orders');
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
                            TextInput::make('work_position')
                                ->label(__('resource.work_position'))
                                ->disabled(),
                            TextInput::make('work_phone')
                                ->label(__('resource.work_phone'))
                                ->disabled(),
                            TextInput::make('email')
                                ->label(__('resource.email'))
                                ->disabled(),

                            Checkbox::make('internet_service')
                                ->label(__('resource.internet_service'))
                                ->disabled(),
                            Checkbox::make('delivery')
                                ->label(__('resource.delivery'))
                                ->disabled(),
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
                    ->label(__('resource.title')),

                TextColumn::make('status')
                    ->label(__('resource.status'))
                    ->default('Pending')
                    ->colors([
                        'warning' => 'pending',
                        'success' => 'approved',
                        'danger' => 'rejected',
                    ])
                    ->formatStateUsing(fn ($state) => __("resource.$state"))
                    ->badge(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\ViewAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([

                ]),
            ]);
    }

    public static function canViewAny(): bool
    {
        return in_array(optional(auth()->user())->role, ['super-admin', 'operator', 'credit-card-viewer']);
    }

    public static function canCreate(): bool
    {
        return optional(auth()->user())->role === 'super-admin';
    }

    public static function canEdit($record): bool
    {
        return in_array(optional(auth()->user())->role, ['super-admin', 'credit-card-viewer']);
    }

    public static function canDelete($record): bool
    {
        return in_array(optional(auth()->user())->role, ['super-admin']);
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

        /** @var \App\Models\Admin|null $admin */
        $admin = auth('admin')->user();
        $query = parent::getEloquentQuery()
            ->with(['branch', 'profile', 'cardType'])
            ->where('status', 'rejected');

        if ($admin && in_array($admin->role, ['card-viewer', 'credit-card-viewer'])) {
            $query->where('bank_branch_id', $admin->branch_id);

        }

        return $query;
    }
}
