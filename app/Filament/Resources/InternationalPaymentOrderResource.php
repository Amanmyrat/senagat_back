<?php

namespace App\Filament\Resources;

use App\Filament\Resources\InternationalPaymentOrderResource\Pages;

use App\Forms\Components\ProfileInfo;
use App\Models\InternationalPaymentOrder;
use Filament\Forms;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Wizard;
use Filament\Forms\Components\Wizard\Step;
use Filament\Forms\Form;
use Filament\Resources\Concerns\Translatable;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;


class InternationalPaymentOrderResource extends Resource
{
    protected static ?string $model = InternationalPaymentOrder::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
               Wizard::make([
                    Step::make('International Payment Information')
                    ->schema([
                        TextInput::make('type.title.'. app()->getLocale())
                            ->label(__('resource.title'))
                            ->disabled()
                            ->afterStateHydrated(fn ($component, $state, $record) => $component->state($record->type?->title)
                            ),
                        TextInput::make('branch.name.'. app()->getLocale())
                            ->label(__('resource.branch_name'))
                            ->disabled()
                            ->afterStateHydrated(fn ($component, $state, $record) => $component->state($record->branch?->name)
                            ),

                        Section::make('Uploaded Files')
                            ->schema([
                                FileUpload::make('uploaded_files')
                                    ->multiple()
                                    ->downloadable()
                                    ->disabled()

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
            'index' => Pages\ListInternationalPaymentOrders::route('/'),
            'create' => Pages\CreateInternationalPaymentOrder::route('/create'),
            'edit' => Pages\EditInternationalPaymentOrder::route('/{record}/edit'),
        ];
    }
}
