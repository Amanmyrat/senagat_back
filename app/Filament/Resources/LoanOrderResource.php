<?php

namespace App\Filament\Resources;

use App\Filament\Resources\LoanOrderResource\Pages;
use App\Forms\Components\ProfileInfo;
use App\Models\CreditApplication;
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
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class LoanOrderResource extends Resource
{
    public static function getNavigationGroup(): ?string
    {
        return 'Credit';
    }
    public static function canViewAny(): bool
    {
        $user = auth('admin')->user();

        return in_array($user->role->value, ['super-admin']);

    }
    public static function getNavigationBadge(): ?string
    {
        return (string) static::getEloquentQuery()->count();
    }
    protected static ?string $model = CreditApplication::class;

    public static function getNavigationLabel(): string
    {
        return __('Loan Order');
    }

    public static function getModelLabel(): string
    {
        return __('Loan Order');
    }

    public static function getPluralModelLabel(): string
    {
        return __('Loan Order');
    }

    public static function getRecordTitle(?object $record = null): string
    {
        return $record ? (string) $record->user?->name : __('Loan Order');
    }

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

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
            'index' => Pages\ListLoanOrders::route('/'),
            'create' => Pages\CreateLoanOrder::route('/create'),
            'edit' => Pages\EditLoanOrder::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->with('profile');
    }
}
