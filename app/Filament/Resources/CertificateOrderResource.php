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
            ])
            ->filters([

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
            'index' => Pages\ListCertificateOrders::route('/'),
            'create' => Pages\CreateCertificateOrder::route('/create'),
            'edit' => Pages\EditCertificateOrder::route('/{record}/edit'),
        ];
    }
}
