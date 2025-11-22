<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AdminResource\Pages;
use App\Models\Admin;
use App\Models\Location;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class AdminResource extends Resource
{
    protected static ?string $model = Admin::class;

    public static function getNavigationLabel(): string
    {
        return __('resource.admins');
    }

    public static function getPluralModelLabel(): string
    {
        return __('resource.admins');
    }

    public static function getModelLabel(): string
    {
        return __('resource.admins');
    }

    public static function getRecordTitle(?object $record = null): string
    {
        return $record ? (string) $record->name : __('resource.admins');
    }

    protected static ?string $navigationIcon = 'heroicon-o-shield-check';

    protected static ?int $navigationSort = 30;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                    ->label(__('resource.name'))
                    ->required()
                    ->maxLength(255),
                TextInput::make('email')
                    ->label(__('resource.email'))
                    ->email()
                    ->required(fn ($record, $get) => $get('role') === 'super-admin')
                    ->maxLength(255),
                TextInput::make('username')
                    ->unique(ignoreRecord: true)
                    ->maxLength(255)
                    ->required(fn ($record, $get) => in_array($get('role'), ['admin', 'operator']))
                    ->label(__('resource.user_name'))

                    ->visible(fn ($record) => $record?->role !== 'super-admin'),
                TextInput::make('password')
                    ->label(__('resource.password'))
                    ->password()
                    ->required(fn ($record) => ! $record)
                    ->dehydrated(fn ($state) => filled($state))
                    ->autocomplete('new-password')
                    ->placeholder(fn ($record) => $record ? __('resource.leave blank to keep current password') : null)
                    ->minLength(8),
                Select::make('role')
                    ->label(__('resource.role'))
                    ->required()

                    ->options([
                        'operator' => __('resource.operator'),
                        'certificate-viewer' => __('resource.certificate'),
                        'credit-card-viewer' => __('resource.card'),
                        'loan-viewer' => __('resource.loan'),
                    ]

                    ),

                Select::make('branch_id')
                    ->label(__('resource.branch'))
                    ->options(function () {
                        return Location::all()->mapWithKeys(function ($branch) {

                            return [$branch->id => $branch->getTranslation('name', 'tk')];
                        })->toArray();
                    })
                    ->default(function () {
                        return Location::first()?->id;
                    }),

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label(__('resource.name')),

                Tables\Columns\BadgeColumn::make('role')
                    ->label(__('resource.role'))
                    ->formatStateUsing(function ($state) {
                        return match ($state) {
                            'operator' => __('resource.operator'),
                            'certificate-viewer' => __('resource.certificate'),
                            'credit-card-viewer' => __('resource.card'),
                            'loan-viewer' => __('resource.loan'),
                            default => $state,
                        };
                    })
                    ->colors([
                        'success' => 'operator',
                        'info' => 'certificate-viewer',
                        'warning' => 'credit-card-viewer',
                        'danger' => 'loan-viewer',
                    ]),
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

    public static function canViewAny(): bool
    {

        return optional(auth()->user())->role === 'super-admin';

    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListAdmins::route('/'),
            'create' => Pages\CreateAdmin::route('/create'),
            'edit' => Pages\EditAdmin::route('/{record}/edit'),
        ];
    }
}
