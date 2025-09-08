<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PendingProfileResource\Pages;
use App\Models\UserProfile;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Placeholder;
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

class PendingProfileResource extends Resource
{
    protected static ?string $model = UserProfile::class;

    public static function getNavigationLabel(): string
    {
        return __('Pending Profiles');
    }

    public static function getModelLabel(): string
    {
        return __('Pending Profile');
    }

    public static function getPluralModelLabel(): string
    {
        return __('Pending Profiles');
    }

    public static function getRecordTitle(?object $record = null): string
    {
        return $record ? (string) $record->user?->name : __('Pending Profile');
    }

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Wizard::make([
                    Step::make('Approval Status')
                        ->icon('heroicon-o-check-badge')
                        ->schema([
                            Section::make('Approval Status')
                                ->schema([
                                    ToggleButtons::make('approved')
                                        ->label('Approval Status')
                                        ->options([
                                            'approved' => 'Approved',
                                            'rejected' => 'Rejected',
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
                        ->icon('heroicon-o-user')

                        ->schema([
                            Section::make('Profile')

                                ->schema([
                                    TextInput::make('first_name')->label('First Name')->disabled(),
                                    TextInput::make('last_name')->label('Last Name')->disabled(),
                                    TextInput::make('middle_name')->label('Middle Name')->disabled(),
                                    DatePicker::make('birth_date')
                                        ->label('Birth Date')
                                        ->disabled()
                                        ->displayFormat('Y-m-d')
                                        ->format('Y-m-d'),
                                    TextInput::make('passport_number')->label('Passport Number')->disabled(),
                                    Select::make('gender')->disabled()
                                        ->label('Gender')
                                        ->options([
                                            'male' => 'Male',
                                            'female' => 'Female',
                                        ])
                                        ->nullable()
                                        ->searchable()
                                        ->native(false),
                                    TextInput::make('issued_by')->label('Issued By')->disabled(),
                                    DatePicker::make('issued_date')->disabled()
                                        ->label('Issued Date')
                                        ->nullable()
                                        ->displayFormat('Y-m-d')
                                        ->format('Y-m-d'),
                                    FileUpload::make('scan_passport')->disabled()
                                        ->label('Passport Scan')
                                        ->directory('scans')
                                        ->disk('public')
                                        ->downloadable(),

                                ])
                                ->columns(2),
                        ]),
                    Step::make('Changes')
                        ->icon('heroicon-o-arrow-path')
                        ->schema(function ($record) {
                            if (! $record || ! $record->latestChangeLog) {
                                return [
                                    Placeholder::make('no_changes')
                                        ->content('No changes logged.'),
                                ];
                            }

                            $columns = [];

                            foreach ($record->latestChangeLog->changes as $field => $values) {
                                $old = $values['old'] ?? '-';
                                $new = $values['new'] ?? '-';

                                if (in_array($field, ['birth_date', 'issued_date'])) {
                                    try {
                                        $old = $old ? \Carbon\Carbon::parse($old)->format('d-m-Y') : '-';
                                        $new = $new ? \Carbon\Carbon::parse($new)->format('d-m-Y') : '-';
                                    } catch (\Exception $e) {
                                    }
                                }
                                if ($field === 'scan_passport') {
                                    $old = $old ? asset('storage/'.$old) : '-';
                                    $new = $new ? asset('storage/'.$new) : '-';

                                }
                                if ($field === 'scan_passport') {
                                    $columns[] = Grid::make()->schema([
                                        Placeholder::make("{$field}_old")
                                            ->label('Scan Passport (Old)')
                                            ->content($old),
                                        Placeholder::make("{$field}_new")
                                            ->label('Scan Passport (New)')
                                            ->content($new),

                                    ])->columns(1);
                                } else {
                                    $columns[] = Placeholder::make("{$field}_old")
                                        ->label(ucwords(str_replace('_', ' ', $field)).' (Old)')
                                        ->content($old);

                                    $columns[] = Placeholder::make("{$field}_new")
                                        ->label(ucwords(str_replace('_', ' ', $field)).' (New)')
                                        ->content($new);
                                }

                            }

                            return [
                                Grid::make(2)
                                    ->schema($columns)
                                    ->columnSpanFull(),
                            ];
                        }),

                ])->skippable()
                    ->columnSpanFull(),

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
            'index' => Pages\ListPendingProfiles::route('/'),
            'edit' => Pages\EditPendingProfile::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): \Illuminate\Database\Eloquent\Builder
    {

        return parent::getEloquentQuery()->whereIn('approved', ['pending', 'rejected']);
    }
}
