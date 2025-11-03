<?php

namespace App\Filament\Clusters\CertificateOrder\Resources;

use App\Filament\Clusters\CertificateOrder;
use App\Filament\Clusters\CertificateOrder\Resources\RejectedCertificateOrderResource\Pages;
use App\Forms\Components\ProfileInfo;
use App\Models\RejectedCertificateOrder;
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

class RejectedCertificateOrderResource extends Resource
{
    protected static ?string $model = RejectedCertificateOrder::class;

    public static function getNavigationBadge(): ?string
    {
        return (string) static::getEloquentQuery()->count();
    }

    protected static ?string $navigationLabel = 'Rejected Certificate Orders';

    protected static ?string $navigationIcon = 'heroicon-o-x-circle';

    protected static ?string $pluralModelLabel = 'Rejected Certificate Orders';

    protected static ?string $cluster = CertificateOrder::class;

    public static function getNavigationLabel(): string
    {
        return __('navigation.rejected_certificate_orders');
    }

    public static function getPluralModelLabel(): string
    {
        return __('navigation.rejected_certificate_orders');
    }

    public static function getModelLabel(): string
    {
        return __('navigation.rejected_certificate_orders');
    }

    public static function getRecordTitle(?object $record = null): string
    {
        return $record ? (string) $record->name : __('navigation.rejected_certificate_orders');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Wizard::make([
                    Step::make('Certificate Order Status')
                        ->label(__('resource.certificate_order_status'))
                        ->schema([
                            Section::make(__('resource.certificate_order_status'))
                                ->schema([
                                    ToggleButtons::make('status')
                                        ->label(__('resource.certificate_order_status'))
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
                    Step::make('Certificate Information')
                        ->label(__('resource.certificate_information'))
                        ->schema([
                            TextInput::make('certificateType.title')
                                ->label(__('resource.title'))
                                ->afterStateHydrated(fn ($component, $state, $record) => $component->state($record->certificateType?->title)

                                )
                                ->disabled(),
                            TextInput::make('certificateType.price')
                                ->label(__('resource.price'))
                                ->afterStateHydrated(fn ($component, $state, $record) => $component->state($record->certificateType?->price)

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
                            TextInput::make('home_address')
                                ->label(__('resource.home_address'))
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
                TextColumn::make('profile.first_name')
                    ->label(__('resource.first_name')),
                TextColumn::make('profile.last_name')
                    ->label(__('resource.last_name')),
                TextColumn::make('certificateType.title')
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
                Tables\Actions\ViewAction::make()
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([

                ]),
            ]);
    }
    public static function canViewAny(): bool
    {
        return in_array(optional(auth()->user())->role, ['super-admin','operator','certificate-viewer']);
    }
    public static function canCreate(): bool
    {
        return optional(auth()->user())->role === 'super-admin';
    }

    public static function canEdit($record): bool
    {
        return in_array(optional(auth()->user())->role, ['super-admin','operator']);
    }

    public static function canDelete($record): bool
    {
        return in_array(optional(auth()->user())->role, ['super-admin','operator']);
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
            'index' => Pages\ListRejectedCertificateOrders::route('/'),
            'create' => Pages\CreateRejectedCertificateOrder::route('/create'),
            'edit' => Pages\EditRejectedCertificateOrder::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()

            ->where('status', 'rejected');
    }
}
