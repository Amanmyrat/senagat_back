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
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class CertificateOrderResource extends Resource
{
    public static function getNavigationGroup(): ?string
    {
        return 'Certification';
    }
    public static function canViewAny(): bool
    {
        $user = auth('admin')->user();

        return in_array($user->role->value, ['super-admin']);

    }
    protected static ?string $model = CertificateOrder::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

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
                    Step::make('Certificate Information')
                        ->schema([
                            TextInput::make('certificateType.title')
                                ->afterStateHydrated(fn ($component, $state, $record) => $component->state($record->certificateType?->title)

                                )
                                ->disabled(),
                            TextInput::make('certificateType.price')
                                ->afterStateHydrated(fn ($component, $state, $record) => $component->state($record->certificateType?->price)

                                )
                                ->disabled(),
                            TextInput::make('phone_number')
                                ->disabled(),
                            TextInput::make('branch.name')
                                ->label('Branch name')
                                ->afterStateHydrated(fn ($component, $state, $record) => $component->state($record->branch?->name)
                                )
                                ->disabled(),
                            TextInput::make('home_address')->disabled(),
                        ]),

                ])->skippable()
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('profile.first_name'),
                TextColumn::make('profile.last_name'),
                TextColumn::make('certificateType.title'),

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
                SelectFilter::make('status')
                    ->options([
                        'pending' => 'Pending',
                        'approved' => 'Approved',
                        'rejected' => 'Rejected',
                    ]),
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
