<?php

namespace App\Filament\Resources;

use App\Enum\RequirementType;
use App\Filament\Resources\CreditTypesResource\Pages;
use App\Models\CreditType;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Wizard;
use Filament\Forms\Components\Wizard\Step;
use Filament\Forms\Form;
use Filament\Resources\Concerns\Translatable;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Table;
use mysql_xdevapi\Schema;

class CreditTypesResource extends Resource
{
    protected static ?string $cluster = \App\Filament\Clusters\CreditApplication::class;
    protected static ?int $navigationSort = 1;

    use Translatable;

    public static function getTranslatableLocales(): array
    {
        return ['tk', 'en', 'ru'];
    }

    protected static ?string $model = CreditType::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function getNavigationLabel(): string
    {
        return __('resource.credit_types');
    }

    public static function getPluralModelLabel(): string
    {
        return __('resource.credit_types');
    }

    public static function getModelLabel(): string
    {
        return __('resource.credit_types');
    }

    public static function getRecordTitle(?object $record = null): string
    {
        return $record ? (string) $record->name : __('resource.credit_types');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Wizard::make(
                    [
                        Step::make('Credit Type')
                            ->label(__('resource.credit_types'))
                            ->schema([
                                TextInput::make('name')
                                    ->label(__('resource.credit_type_name'))
                                    ->required(),
                                Textarea::make('description')
                                    ->label(__('resource.description')),
                                Select::make('category')
                                    ->label(__('resource.category'))
                                    ->options([
                                        'individual' => __('resource.individual'),
                                        'legal_entity' => __('resource.for_legal_entities'),
                                    ]),
                                Toggle::make('can_offer_online')
                                    ->label(__('resource.can_offer_online'))
                                    ->default(false)
                                    ->helperText(__('resource.alert_can_offer_online')),
                                TextInput::make('term')
                                    ->label(__('resource.max_term'))
                                    ->numeric()
                                    ->nullable(),
                                TextInput::make('min_amount')
                                    ->label(__('resource.min_amount'))
                                    ->numeric()
                                    ->nullable(),
                                TextInput::make('max_amount')
                                    ->label(__('resource.max_amount'))
                                    ->numeric()

                                    ->nullable(),
                                TextInput::make('term_text')
                                    ->label(__('resource.term_text'))
                                    ->nullable()
                                    ->helperText(__('resource.alert_term_text')),
                                TextInput::make('amount_text')
                                    ->label(__('resource.amount_text'))
                                    ->nullable()
                                    ->helperText(__('resource.alert_amount_text')),
                                TextInput::make('interest')
                                    ->label(__('resource.interest').' %')
                                    ->numeric()
                                    ->suffix('%')
                                    ->step(0.01)
                                    ->required(),
                                FileUpload::make('image_url')->image()
                                    ->label(__('resource.image_url')),
                                TextInput::make('background_color')
                                    ->label(__('resource.background_color') . ' (HEX code)'),
                            ]),
                        Step::make('Requirements Description')
            ->schema([
                RichEditor::make('requirements_description')
                    ->label(__('resource.requirements'))
                    ->columnSpan('full')
            ]),
                        Step::make('Requirments')
                            ->label(__('resource.requirements'))
                            ->schema([
                                Repeater::make('requirements')
                                    ->label(__('resource.requirements'))
                                    ->schema([
                                        TextInput::make('title')->label(__('resource.title')),
                                        Select::make('type')
                                            ->label(__('resource.type'))
                                            ->options([
                                                RequirementType::Borrower->value => RequirementType::Borrower->label(__('resource.borrower')),
                                                RequirementType::Guarantor->value => RequirementType::Guarantor->label(),
                                                RequirementType::DomesticPersons->value => RequirementType::DomesticPersons->label(),
                                                RequirementType::Payer->value => RequirementType::Payer->label(),
                                                RequirementType::PrivateBusinessParties->value => RequirementType::PrivateBusinessParties->label(),
                                            ]),
                                        Repeater::make('rules')
                                            ->label(__('resource.rules'))
                                            ->schema([
                                                TextInput::make('rule')
                                                    ->label(__('resource.rule')),
                                                Repeater::make('subrules')
                                                    ->label(__('resource.subrules'))
                                                    ->schema([
                                                        TextInput::make('subrule')
                                                            ->label(__('resource.subrule')),
                                                    ])
                                                    ->columns(1)
                                                    ->minItems(1),
                                            ])
                                            ->columns(1)
                                            ->minItems(1),

                                    ])
                                    ->columns(1),

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
                TextColumn::make('name')
                    ->label(__('resource.name')),
                ToggleColumn::make('can_offer_online'),

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
            'index' => Pages\ListCreditTypes::route('/'),
            'create' => Pages\CreateCreditTypes::route('/create'),
            'edit' => Pages\EditCreditTypes::route('/{record}/edit'),
        ];
    }
}
