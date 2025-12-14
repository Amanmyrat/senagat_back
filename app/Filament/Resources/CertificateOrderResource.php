<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CertificateOrderResource\Pages;
use App\Forms\Components\ProfileInfo;
use App\Models\CertificateOrder;
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

class CertificateOrderResource extends Resource
{
    public static function getNavigationBadge(): ?string
    {
        return (string) static::getEloquentQuery()->count();
    }

    protected static ?int $navigationSort = 2;

    protected static ?string $model = CertificateOrder::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $cluster = \App\Filament\Clusters\CertificateOrder::class;

    public static function getNavigationLabel(): string
    {
        return __('navigation.certificate_orders');
    }

    public static function getPluralModelLabel(): string
    {
        return __('navigation.certificate_orders');
    }

    public static function getModelLabel(): string
    {
        return __('navigation.certificate_orders');
    }

    public static function getRecordTitle(?object $record = null): string
    {
        return $record ? (string) $record->name : __('navigation.certificate_orders');
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
                                ->afterStateHydrated(function ($component, $state, $record) {
                                    $locale = 'tk'; // app()->getLocale() dynamic
                                    $component->state($record->certificateType?->getTranslation('title', $locale));
                                })
                                ->disabled(),
                            TextInput::make('certificateType.price')
                                ->label(__('resource.price'))
                                ->afterStateHydrated(fn ($component, $state, $record) => $component->state($record->certificateType?->price)

                                )
                                ->disabled(),
                            TextInput::make('phone')->label(__('resource.phone'))->disabled()
                                ->afterStateHydrated(fn ($component, $state, $record) => $component->state($record->user?->phone)),
                            TextInput::make('branch.name')
                                ->label(__('resource.branch_name'))
                                ->afterStateHydrated(fn ($component, $state, $record) => $component->state($record->branch?->name)
                                )
                                ->disabled(),
                            TextInput::make('home_address')->disabled()
                                ->label(__('resource.home_address')),
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
                TextColumn::make('created_at')
                    ->label(__('resource.created_at'))
                    ->dateTime()
                    ->sortable(),
            ])
            ->filters([

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
        return in_array(optional(auth()->user())->role, ['super-admin', 'operator', 'certificate-viewer']);
    }

    public static function canCreate(): bool
    {
        return optional(auth()->user())->role === 'super-admin';
    }

    public static function canEdit($record): bool
    {
        return in_array(optional(auth()->user())->role, ['super-admin', 'certificate-viewer']);
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
            'index' => Pages\ListCertificateOrders::route('/'),
            'create' => Pages\CreateCertificateOrder::route('/create'),
            'edit' => Pages\EditCertificateOrder::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): \Illuminate\Database\Eloquent\Builder
    {
        /** @var \App\Models\Admin|null $admin */
        $admin = auth('admin')->user();
        $query = parent::getEloquentQuery();

        if ($admin && in_array($admin->role, ['certificate', 'certificate-viewer'])) {
            $query->where('bank_branch_id', $admin->branch_id);
        }

        return $query;

    }
}
