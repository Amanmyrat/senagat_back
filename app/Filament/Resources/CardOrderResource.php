<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CardOrderResource\Pages;
use App\Forms\Components\ProfileInfo;
use App\Models\CardOrder;
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

class CardOrderResource extends Resource
{
    public static function getNavigationGroup(): ?string
    {
        return 'Card';
    }

    protected static ?string $model = CardOrder::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([

                Wizard::make([
                    Step::make('Card Order Status')
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
                        ]),
                    Step::make('Profile Information')
                        ->schema([
                            ProfileInfo::make(),
                        ]),
                    Step::make('Card Information')
                        ->schema([
                            TextInput::make('cardType.title')
                                ->afterStateHydrated(fn ($component, $state, $record) => $component->state($record->cardType?->title)

                                )
                                ->disabled(),
                            TextInput::make('phone_number')
                                ->disabled(),
                            TextInput::make('bank_branch')->disabled(),
                            TextInput::make('home_phone_number')->disabled(),
                            TextInput::make('cardType.price')
                                ->afterStateHydrated(fn ($component, $state, $record) => $component->state($record->cardType?->price)
                                )
                                ->disabled(),
                        ]),

                ])->skippable()
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('profile.first_name'),
                TextColumn::make('profile.last_name'),
                TextColumn::make('cardType.title'),

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
            'index' => Pages\ListCardOrders::route('/'),
            'create' => Pages\CreateCardOrder::route('/create'),
            'edit' => Pages\EditCardOrder::route('/{record}/edit'),
        ];
    }
}
