<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AdminResource\Pages;
use App\Models\Admin;
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

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

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
                    ->label('Username')

                    ->visible(fn ($record) => $record?->role !== 'super-admin'),
                TextInput::make('password')
                    ->label(__('resource.password'))
                    ->password()
                    ->required(fn ($record) => ! $record)
                    ->dehydrated(fn ($state) => filled($state))
                    ->autocomplete('new-password')
                    ->placeholder(fn ($record) => $record ? __('resource.leave blank to keep current password') : null)
                    ->minLength(8),
                Select::make('roles')
                    ->label('Role')
                    ->relationship('roles', 'name')
                    ->required()
                    ->preload()
                    ->searchable()
                    ->multiple(false)
                    ->helperText('Select the user role'),

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label(__('resource.name')),
                TextColumn::make('roles.name')
                    ->label(__('resource.role')),
                Tables\Columns\BadgeColumn::make('roles.name')
                    ->colors([
                        'success' => 'super-admin',
                        'warning' => 'admin',
                        'danger' => 'operator',
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

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListAdmins::route('/'),
            'create' => Pages\CreateAdmin::route('/create'),
            'edit' => Pages\EditAdmin::route('/{record}/edit'),
        ];
    }
}
