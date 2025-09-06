<?php

namespace App\Filament\Resources;

use App\Filament\Resources\RejectedProfileResource\Pages;
use App\Models\UserProfile;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class RejectedProfileResource extends Resource
{
    protected static ?string $model = UserProfile::class;

    public static function getNavigationLabel(): string
    {
        return __('Rejected Profiles');
    }

    public static function getModelLabel(): string
    {
        return __('Rejected Profile');
    }

    public static function getPluralModelLabel(): string
    {
        return __('Rejected Profiles');
    }

    public static function getRecordTitle(?object $record = null): string
    {
        return $record ? (string) $record->user?->name : __('Rejected Profile');
    }

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Profile')

                    ->schema([
                        TextInput::make('first_name')->label('First Name'),
                        TextInput::make('last_name')->label('Last Name'),
                        TextInput::make('middle_name')->label('Middle Name'),
                        Select::make('approved')
                            ->label('Approval Status')
                            ->options([
                                'approved' => 'Approved',
                                'rejected' => 'Rejected',
                            ]),

                        DatePicker::make('birth_date')
                            ->label('Birth Date')
                            ->nullable()
                            ->displayFormat('Y-m-d')
                            ->format('Y-m-d'),
                        TextInput::make('passport_number')->label('Passport Number'),
                        Select::make('gender')
                            ->label('Gender')
                            ->options([
                                'male' => 'Male',
                                'female' => 'Female',
                            ])
                            ->nullable()
                            ->searchable()
                            ->native(false),
                        TextInput::make('issued_by')->label('Issued By'),
                        DatePicker::make('issued_date')
                            ->label('Issued Date')
                            ->nullable()
                            ->displayFormat('Y-m-d')
                            ->format('Y-m-d'),
                        FileUpload::make('scan_passport')
                            ->label('Passport Scan')
                            ->directory('scans')
                            ->disk('public')
                            ->downloadable(),

                    ])
                    ->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('first_name')->label('First Name'),
                TextColumn::make('last_name')->label('Last Name'),
                TextColumn::make('approved')->label('Approval Status')->badge(),
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
            'index' => Pages\ListRejectedProfiles::route('/'),
            'create' => Pages\CreateRejectedProfile::route('/create'),
            'edit' => Pages\EditRejectedProfile::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): \Illuminate\Database\Eloquent\Builder
    {

        return parent::getEloquentQuery()->where('approved', 'rejected');
    }
}
