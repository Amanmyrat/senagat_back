<?php

namespace App\Filament\Resources;

use App\Filament\Clusters\CardOrders;
use App\Filament\Resources\ApprovedCardOrderResource\Pages;
use App\Forms\Components\ProfileInfo;
use App\Models\ApprovedCardOrder;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\ToggleButtons;
use Filament\Forms\Components\Wizard;
use Filament\Forms\Components\Wizard\Step;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\Action;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class ApprovedCardOrderResource extends Resource
{
    protected static ?string $model = ApprovedCardOrder::class;

    protected static ?int $navigationSort = 4;

    public static function getNavigationBadge(): ?string
    {
        return (string) static::getEloquentQuery()->count();
    }

    protected static ?string $navigationLabel = 'Approved Orders';

    protected static ?string $navigationIcon = 'heroicon-o-check-badge';

    protected static ?string $pluralModelLabel = 'Approved Card Orders';

    protected static ?string $cluster = CardOrders::class;

    public static function getNavigationLabel(): string
    {
        return __('navigation.approved_card_orders');
    }

    public static function getPluralModelLabel(): string
    {
        return __('navigation.approved_card_orders');
    }

    public static function getModelLabel(): string
    {
        return __('navigation.approved_card_orders');
    }

    public static function getRecordTitle(?object $record = null): string
    {
        return $record ? (string) $record->name : __('navigation.approved_card_orders');
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
                Tables\Actions\ViewAction::make(),
                //                Action::make('print')
                //                    ->label('Yazdır')
                //                    ->icon('heroicon-o-printer')
                //                    ->url(fn ($record) => route('approved-card-orders.print-direct', $record))
                //                    ->openUrlInNewTab()
                // Filament action

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
            'index' => Pages\ListApprovedCardOrders::route('/'),
            'create' => Pages\CreateApprovedCardOrder::route('/create'),
            'edit' => Pages\EditApprovedCardOrder::route('/{record}/edit'),
        ];
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

    public static function getEloquentQuery(): Builder
    {
        /** @var \App\Models\Admin|null $admin */
        $admin = auth('admin')->user();
        $query = parent::getEloquentQuery()
            ->with(['branch', 'profile', 'cardType'])
            ->where('status', 'approved');

        if ($admin && in_array($admin->role, ['card-viewer', 'credit-card-viewer'])) {
            $query->where('bank_branch_id', $admin->branch_id);

        }

        return $query;
    }
}
