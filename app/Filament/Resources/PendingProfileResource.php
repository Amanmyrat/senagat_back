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
    public static function getNavigationGroup(): ?string
    {
        return 'Users';
    }

    protected static ?string $model = UserProfile::class;

    public static function getNavigationLabel(): string
    {
        return __('navigation.pending_profiles');
    }

    public static function getModelLabel(): string
    {
        return __('navigation.pending_profiles');
    }

    public static function getPluralModelLabel(): string
    {
        return __('navigation.pending_profiles');
    }

    public static function getRecordTitle(?object $record = null): string
    {
        return $record ? (string) $record->user?->name : __('navigation.pending_profiles');
    }

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Wizard::make([
                    Step::make('Approval Status')
                        ->label(__('resource.approval_status'))
                        ->icon('heroicon-o-check-badge')
                        ->completedIcon('heroicon-o-check-badge')
                        ->schema([
                            Section::make(__('resource.approval_status'))
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
                    Step::make('Profile Information')
                        ->label(__('resource.profile_information'))
                        ->icon('heroicon-o-user')
                        ->completedIcon('heroicon-o-user')
                        ->schema([
                            Section::make(__('resource.profile_information'))

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
                                    Select::make('gender')->disabled()
                                        ->label(__('resource.gender'))
                                        ->options([
                                            'male' => 'Male',
                                            'female' => 'Female',
                                        ])
                                        ->nullable()
                                        ->searchable()
                                        ->native(false),
                                    TextInput::make('issued_by')->label(__('resource.issued_by'))->disabled(),
                                    DatePicker::make('issued_date')->disabled()
                                        ->label(__('resource.issued_date'))
                                        ->nullable()
                                        ->displayFormat('Y-m-d')
                                        ->format('Y-m-d'),
                                    FileUpload::make('scan_passport')->disabled()
                                        ->label(__('resource.scan_passport'))
                                        ->directory('scans')
                                        ->disk('public')
                                        ->downloadable(),

                                ])
                                ->columns(2),
                        ]),
                    Step::make('Changes')
                        ->label(__('resource.changes'))
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
                                    if ($old !== $new) {
                                        $columns[] = Grid::make()->schema([
                                            Placeholder::make("{$field}_old")
                                                ->label(__('resource.scan_passport'))
                                                ->content($old)
                                                ->view('filament.components.change-field', [
                                                    'value' => $old,
                                                    'color' => 'brown',
                                                    'field' => $field,
                                                    'type' => 'old',
                                                ]),
                                            Placeholder::make("{$field}_new")
                                                ->label(__('resource.scan_passport'))
                                                ->content($new)
                                                ->view('filament.components.change-field', [
                                                    'value' => $new,
                                                    'color' => 'green',
                                                    'field' => $field,
                                                    'type' => 'new',
                                                ]),

                                        ])->columns(1);
                                    }
                                } else {
                                    if ($field === 'approved') {
                                        continue;
                                    }
                                    $columns[] = Placeholder::make("{$field}_old")
                                        ->label(ucwords(str_replace('_', ' ', $field)).' (Old)')
                                        ->content($old)
                                        ->view('filament.components.change-field', [
                                            'value' => $old,
                                            'color' => 'brown',
                                            'field' => $field,
                                            'type' => 'old',
                                        ]);

                                    $columns[] = Placeholder::make("{$field}_new")
                                        ->label(ucwords(str_replace('_', ' ', $field)).' (New)')
                                        ->content($new)
                                        ->view('filament.components.change-field', [
                                            'value' => $new,
                                            'color' => 'green',
                                            'field' => $field,
                                            'type' => 'new',
                                        ]);
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
                TextColumn::make('first_name')->label(__('resource.first_name')),
                TextColumn::make('last_name')->label(__('resource.last_name')),
                TextColumn::make('approved')->label(__('resource.approved'))->badge(),
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
