<?php

namespace App\Filament\Clusters\CreditApplication\Resources;

use App\Filament\Clusters\CreditApplication;
use App\Filament\Clusters\CreditApplication\Resources\ApprovedLoanOrdersResource\Pages;
use App\Forms\Components\ProfileInfo;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
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

class ApprovedLoanOrdersResource extends Resource
{
    protected static ?string $model = \App\Models\CreditApplication::class;

    public static function getNavigationBadge(): ?string
    {
        return (string) static::getEloquentQuery()->count();
    }

    protected static ?string $navigationLabel = 'Approved Loans';

    protected static ?string $navigationIcon = 'heroicon-o-check-badge';

    protected static ?string $pluralModelLabel = 'Approved Loans';

    protected static ?string $cluster = CreditApplication::class;

    public static function form(Form $form): Form
    {
        return $form
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
                Wizard::make([
                    Step::make('Credit Details')
                        ->schema([
                            Select::make('credit_id')->relationship('credit', 'name')->required()->disabled(),
                            TextInput::make('term')->numeric()->required()->disabled(),
                            TextInput::make('amount')->numeric()->required()->disabled(),
                            TextInput::make('interest')->numeric()->required()->disabled(),
                            TextInput::make('monthly_payment')->numeric()->required()->disabled(),
                        ]),
                    Step::make('Profile Information')
                        ->schema([
                            ProfileInfo::make(),
                        ]),

                    Step::make('Work Info')
                        ->schema([
                            Select::make('role')
                                ->options([
                                    'manager' => 'Manager',
                                    'entrepreneur' => 'Entrepreneur',
                                ])->required()
                                ->disabled(),
                            TextInput::make('patent_number')->visible(fn ($get) => $get('role') === 'entrepreneur')->disabled(),
                            TextInput::make('registration_number')->visible(fn ($get) => $get('role') === 'entrepreneur')->disabled(),
                            TextInput::make('work_address')->visible(fn ($get) => $get('role') === 'entrepreneur')->disabled(),
                            TextInput::make('workplace')->visible(fn ($get) => $get('role') === 'manager')->disabled(),
                            TextInput::make('position')->visible(fn ($get) => $get('role') === 'manager')->disabled(),
                            TextInput::make('manager_work_address')->visible(fn ($get) => $get('role') === 'manager')->disabled(),
                            TextInput::make('phone_number')->visible(fn ($get) => $get('role') === 'manager')->disabled(),
                            TextInput::make('salary')->visible(fn ($get) => $get('role') === 'manager')->disabled(),
                        ]),
                    Step::make('Branch Info')
                        ->schema([
                            TextInput::make('country')->required()->disabled(),
                            TextInput::make('branch.name')
                                ->label('Branch name')
                                ->afterStateHydrated(fn ($component, $state, $record) => $component->state($record->branch?->name)
                                )
                                ->disabled(),
                        ]),
                ]
                )
                    ->skippable()
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('profile.first_name')
                    ->label('First Name'),
                TextColumn::make('profile.last_name')
                    ->label('Last Name'),
                TextColumn::make('credit.name')
                    ->label('Credit Type'),
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
            'index' => Pages\ListApprovedLoanOrders::route('/'),
            'create' => Pages\CreateApprovedLoanOrders::route('/create'),
            'edit' => Pages\EditApprovedLoanOrders::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()

            ->where('status', 'approved');
    }
}
