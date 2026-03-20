<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UsersResource\Pages;
use App\Models\User;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
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

class UsersResource extends Resource
{
    public static function getNavigationGroup(): ?string
    {
        return __('navigation.users');
    }

    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';

    protected static ?int $navigationSort = 20;

    public static function getNavigationLabel(): string
    {
        return __('navigation.users');
    }

    public static function getPluralModelLabel(): string
    {
        return __('navigation.users');
    }

    public static function getModelLabel(): string
    {
        return __('navigation.users');
    }

    public static function getRecordTitle(?object $record = null): string
    {
        return $record ? (string) $record->name : __('navigation.users');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Wizard::make([
                   Step::make('Profile Information')
                        ->label(__('resource.profile_information'))
                        ->icon('heroicon-o-user')
                        ->completedIcon('heroicon-o-user')
                        ->schema([
                            TextInput::make('phone')->label(__('resource.phone'))->disabled(),
                            Section::make(__('resource.profile_information'))
                                ->relationship('profile')
                                ->schema([
                                    TextInput::make('first_name')->label(__('resource.first_name'))->disabled(),
                                    TextInput::make('last_name')->label(__('resource.last_name'))->disabled(),
                                    TextInput::make('middle_name')->label(__('resource.middle_name'))->disabled(),
                                    DatePicker::make('birth_date')
                                        ->label(__('resource.birth_date'))
                                        ->disabled()
                                        ->displayFormat('Y-m-d')
                                        ->format('Y-m-d'),
                                    TextInput::make('passport_number')->label(__('resource.passport_number'))->disabled(),
                                    TextInput::make('issued_by')->label(__('resource.issued_by'))->disabled(),
                                    DatePicker::make('issued_date')->disabled()
                                        ->label(__('resource.issued_date'))
                                        ->nullable()
                                        ->displayFormat('Y-m-d')
                                        ->format('Y-m-d'),
                                    TextInput::make('citizenship')->label(__('resource.citizenship'))->disabled(),
                                    TextInput::make('home_phone')->label(__('resource.home_phone_number'))->disabled(),
                                    TextInput::make('home_address')->label(__('resource.home_address'))->disabled(),
                                    TextInput::make('scan_passport')
                                        ->label(__('resource.scan_passport'))
                                        ->disabled()
                                        ->hintActions([
                                            \Filament\Forms\Components\Actions\Action::make(__('resource.open'))
                                                ->icon('heroicon-o-arrow-top-right-on-square')
                                                ->url(fn ($state) => $state ? \Illuminate\Support\Facades\Storage::disk('public')->url($state) : null)
                                                ->openUrlInNewTab()
                                                ->visible(fn ($state) => !empty($state)),
                                            \Filament\Forms\Components\Actions\Action::make(__('resource.download'))
                                                ->icon('heroicon-o-arrow-down-tray')
                                                ->url(fn ($state) => $state ? \Illuminate\Support\Facades\Storage::disk('public')->url($state) : null)
                                                ->visible(fn ($state) => !empty($state)),
                                        ]),
                                ])
                                ->columns(2),
                        ]),
                    Step::make('Approval Status')
                        ->label(__('resource.approval_status'))
                        ->icon('heroicon-o-check-badge')
                        ->completedIcon('heroicon-o-check-badge')
                        ->schema([
                            Section::make(__('resource.approval_status'))
                                ->relationship('profile')
                                ->schema([
                                    ToggleButtons::make('approved')
                                        ->label(__('resource.approval_status'))
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
                ])->skippable()
                    ->columnSpanFull(),

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('phone')->translateLabel()
                    ->label(__('resource.phone')),
                TextColumn::make('profile.first_name')
                    ->label(__('resource.first_name'))
                    ->default('---')
                    ->sortable(),
                TextColumn::make('profile.last_name')
                    ->label(__('resource.last_name'))
                    ->default('---')
                    ->sortable(),
                TextColumn::make('profile.approved')
                    ->label(__('resource.approval_status'))
                    ->default('Pending')
                    ->badge()
                    ->sortable(),

            ])
            ->filters([
                //
            ])
            ->actions([

            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])->defaultSort('created_at', 'desc');
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function canViewAny(): bool
    {

        return optional(auth()->user())->role === 'super-admin';

    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListUsers::route('/'),
            'edit' => Pages\EditUsers::route('/{record}/edit'),
        ];
    }
    public static function getEloquentQuery(): \Illuminate\Database\Eloquent\Builder
    {
        return parent::getEloquentQuery()
            ->whereHas('profile', function ($query) {
                $query->whereIn('approved', ['pending', 'approved', 'rejected']);
            });
    }
}
