<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AwardsResource\Pages;
use App\Filament\Resources\AwardsResource\RelationManagers;
use App\Models\Award;
use Filament\Forms;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Concerns\Translatable;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class AwardsResource extends Resource
{
    use Translatable;

    public static function getTranslatableLocales(): array
    {
        return ['tk', 'en', 'ru'];
    }
    protected static ?string $model = Award::class;
    public static function getNavigationLabel(): string
    {
        return __('resource.awards');
    }

    public static function getPluralModelLabel(): string
    {
        return __('resource.awards');
    }

    public static function getModelLabel(): string
    {
        return __('resource.awards');
    }

    public static function getRecordTitle(?object $record = null): string
    {
        return $record ? (string) $record->name : __('resource.awards');
    }
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('title')->label(__('resource.title'))
                ->required()                ,
                TextInput::make('sub_title')->label(__('resource.sub_title'))
                    ->required(),
                Forms\Components\RichEditor::make('description')
                    ->label(__('resource.description')),
                FileUpload::make('image_url')
->required()
                    ->label(__('resource.main_image'))
                    ->image()
                    ->directory('awards'),
                FileUpload::make('description_images')
                    ->label(__('resource.description_image'))
                    ->multiple()
                        ->image()
                        ->directory('awards/description')


            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->label(__('resource.title'))
                    ->limit(30),
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
            'index' => Pages\ListAwards::route('/'),
            'create' => Pages\CreateAwards::route('/create'),
            'edit' => Pages\EditAwards::route('/{record}/edit'),
        ];
    }
}
