<?php

namespace App\Filament\Resources;

use App\Filament\Clusters\InternationalPayment;
use App\Filament\Resources\InternationalPaymentOrderResource\Pages;
use App\Forms\Components\ProfileInfo;
use App\Models\InternationalPaymentOrder;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Wizard;
use Filament\Forms\Components\Wizard\Step;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class InternationalPaymentOrderResource extends Resource
{
    protected static ?string $model = InternationalPaymentOrder::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $cluster = InternationalPayment::class;

    protected static ?int $navigationSort = 2;

    public static function getNavigationLabel(): string
    {
        return __('resource.international_payment_order');
    }

    public static function getPluralModelLabel(): string
    {
        return __('resource.international_payment_order');
    }

    public static function getModelLabel(): string
    {
        return __('resource.international_payment_order');
    }

    public static function getRecordTitle(?object $record = null): string
    {
        return $record ? (string) $record->name : __('resource.international_payment_order');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Wizard::make([
                    Step::make('International Payment Information')
                        ->label(__('resource.international_payment_order'))
                        ->schema([
                            TextInput::make('type.title.'.app()->getLocale())
                                ->label(__('resource.title'))
                                ->disabled()
                                ->afterStateHydrated(fn ($component, $state, $record) => $component->state($record->type?->title)
                                ),
                            TextInput::make('branch.name.'.app()->getLocale())
                                ->label(__('resource.branch_name'))
                                ->disabled()
                                ->afterStateHydrated(fn ($component, $state, $record) => $component->state($record->branch?->name)
                                ),

                            Section::make(__('resource.required_files'))

                                ->schema([
                                    FileUpload::make('uploaded_files')
                                        ->label(__('resource.required_files'))
                                        ->multiple()
                                        ->downloadable()
                                        ->disabled(),

                                ]),

                        ]),
                    Step::make('Profile Information')
                        ->label(__('resource.profile_information'))
                        ->schema([
                            ProfileInfo::make(),
                        ]),

                ])
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
                TextColumn::make('type.title')
                    ->label(__('resource.title')),
                TextColumn::make('created_at')
                    ->label(__('resource.created_at'))
                    ->dateTime()
                    ->sortable(),

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

    public static function canViewAny(): bool
    {
        return optional(auth()->user())->role === 'super-admin';
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
            'index' => Pages\ListInternationalPaymentOrders::route('/'),
            'create' => Pages\CreateInternationalPaymentOrder::route('/create'),
            'edit' => Pages\EditInternationalPaymentOrder::route('/{record}/edit'),
        ];
    }
}
