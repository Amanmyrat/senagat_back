<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AuditReportResource\Pages;
use App\Models\AuditReport;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Concerns\Translatable;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class AuditReportResource extends Resource
{
    use Translatable;

    protected static ?string $model = AuditReport::class;

    protected static ?string $cluster = \App\Filament\Clusters\ContentManagement::class;

    protected static ?int $navigationSort = 1;

    protected static ?string $navigationIcon = 'heroicon-o-clipboard-document-list';

    public static function getTranslatableLocales(): array
    {
        return ['tk', 'en', 'ru'];
    }

    public static function getNavigationLabel(): string
    {
        return __('resource.audit_reports');
    }

    public static function getPluralModelLabel(): string
    {
        return __('resource.audit_reports');
    }

    public static function getModelLabel(): string
    {
        return __('resource.audit_report');
    }

    public static function getRecordTitle(?object $record = null): string
    {
        return $record ? (string) $record->title : __('resource.audit_report');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('title')
                    ->label(__('resource.title'))
                    ->required(),
                FileUpload::make('pdf_file_tk')
                    ->label(__('resource.pdf_file_tk'))
                    ->acceptedFileTypes(['application/pdf'])
                    ->maxSize(10240)
                    ->helperText(__('resource.pdf_file_helper'))
                    ->translateLabel(false),
                FileUpload::make('pdf_file_en')
                    ->label(__('resource.pdf_file_en'))
                    ->acceptedFileTypes(['application/pdf'])
                    ->maxSize(10240)
                    ->helperText(__('resource.pdf_file_helper'))
                    ->translateLabel(false),
                FileUpload::make('pdf_file_ru')
                    ->label(__('resource.pdf_file_ru'))
                    ->acceptedFileTypes(['application/pdf'])
                    ->maxSize(10240)
                    ->helperText(__('resource.pdf_file_helper'))
                    ->translateLabel(false),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title')
                    ->label(__('resource.title'))
                    ->searchable(),
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
            ])
            ->defaultSort('created_at', 'desc');
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
            'index' => Pages\ListAuditReports::route('/'),
            'create' => Pages\CreateAuditReport::route('/create'),
            'edit' => Pages\EditAuditReport::route('/{record}/edit'),
        ];
    }
}
