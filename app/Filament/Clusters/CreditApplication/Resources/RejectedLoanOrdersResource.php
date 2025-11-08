<?php

namespace App\Filament\Clusters\CreditApplication\Resources;

use App\Filament\Clusters\CreditApplication;
use App\Filament\Clusters\CreditApplication\Resources\RejectedLoanOrdersResource\Pages;
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

class RejectedLoanOrdersResource extends Resource
{
    protected static ?string $model = \App\Models\RejectedLoanOrder::class;
    protected static ?int $navigationSort = 5;

    public static function getNavigationBadge(): ?string
    {
        return (string) static::getEloquentQuery()->count();
    }

    protected static ?string $navigationLabel = 'Rejected Loans';

    protected static ?string $navigationIcon = 'heroicon-o-x-circle';

    protected static ?string $pluralModelLabel = 'Rejected Loans';

    protected static ?string $cluster = CreditApplication::class;

    public static function getNavigationLabel(): string
    {
        return __('navigation.rejected_loan_orders');
    }

    public static function getPluralModelLabel(): string
    {
        return __('navigation.rejected_loan_orders');
    }

    public static function getModelLabel(): string
    {
        return __('navigation.rejected_loan_orders');
    }

    public static function getRecordTitle(?object $record = null): string
    {
        return $record ? (string) $record->name : __('navigation.rejected_loan_orders');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make(__('resource.loan_order'))
                    ->schema([
                        ToggleButtons::make('status')
                            ->label(__('resource.loan_order'))
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
                        ->label(__('resource.credit_details'))
                        ->schema([
                            Select::make('credit_id')->relationship('credit', 'name')->required()->disabled()
                                ->label(__('resource.credit_name')),
                            TextInput::make('term')->numeric()->required()->disabled()
                                ->label(__('resource.term')),
                            TextInput::make('amount')->numeric()->required()->disabled()
                                ->label(__('resource.amount')),
                            TextInput::make('interest')->numeric()->required()->disabled()
                                ->label(__('resource.interest')),
                            TextInput::make('monthly_payment')->numeric()->required()->disabled()
                                ->label(__('resource.monthly_payment')),
                        ]),
                    Step::make('Profile Information')
                        ->label(__('resource.profile_information'))
                        ->schema([
                            ProfileInfo::make(),
                        ]),

                    Step::make('Work Info')
                        ->label(__('resource.work_information'))
                        ->schema([
                            Select::make('role')
                                ->label(__('resource.role'))
                                ->options([
                                    'manager' => 'Manager',
                                    'entrepreneur' => 'Entrepreneur',
                                ])
                                ->disabled(),
                            TextInput::make('patent_number')->visible(fn ($get) => $get('role') === 'entrepreneur')->disabled()
                                ->label(__('resource.patent_number')),
                            TextInput::make('registration_number')->visible(fn ($get) => $get('role') === 'entrepreneur')->disabled()
                                ->label(__('resource.registration_number')),
                            TextInput::make('work_address')->visible(fn ($get) => $get('role') === 'entrepreneur')->disabled()
                                ->label(__('resource.work_address')),
                            TextInput::make('workplace')->visible(fn ($get) => $get('role') === 'manager')->disabled()
                                ->label(__('resource.work_place')),
                            TextInput::make('position')->visible(fn ($get) => $get('role') === 'manager')->disabled()
                                ->label(__('resource.position')),
                            TextInput::make('manager_work_address')->visible(fn ($get) => $get('role') === 'manager')->disabled()
                                ->label(__('resource.work_address')),
                            TextInput::make('phone_number')->visible(fn ($get) => $get('role') === 'manager')->disabled()
                                ->label(__('resource.phone')),
                            TextInput::make('salary')->visible(fn ($get) => $get('role') === 'manager')->disabled()
                                ->label(__('resource.salary')),
                        ]),
                    Step::make('Branch Info')
                        ->label(__('resource.branch_information'))
                        ->schema([
                            TextInput::make('country')->disabled()
                                ->label(__('resource.country')),
                            TextInput::make('branch.name')
                                ->label(__('resource.branch_name'))
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
                    ->label(__('resource.first_name')),
                TextColumn::make('profile.last_name')
                    ->label(__('resource.last_name')),
                TextColumn::make('credit.name')
                    ->label(__('resource.credit_name')),
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
        return in_array(optional(auth()->user())->role, ['super-admin', 'operator', 'loan-viewer']);
    }

    public static function canCreate(): bool
    {
        return optional(auth()->user())->role === 'super-admin';
    }

    public static function canEdit($record): bool
    {
        return in_array(optional(auth()->user())->role, ['super-admin', 'loan-viewer']);
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
            'index' => Pages\ListRejectedLoanOrders::route('/'),
            'create' => Pages\CreateRejectedLoanOrders::route('/create'),
            'edit' => Pages\EditRejectedLoanOrders::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {

        /** @var \App\Models\Admin|null $admin */
        $admin = auth('admin')->user();
        $query = parent::getEloquentQuery()
            ->with(['profile'])
            ->where('status', 'rejected');

        if ($admin && in_array($admin->role, ['loan', 'loan-viewer'])) {
            $query->where('bank_branch_id', $admin->branch_id);
        }

        return $query;
    }
}
