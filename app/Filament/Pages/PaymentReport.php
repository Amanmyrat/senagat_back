<?php

namespace App\Filament\Pages;

use App\Exports\PaymentReportExport;
use App\Services\PaymentReportService;
use Carbon\Carbon;
use Filament\Actions;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Pages\Page;
use Illuminate\Contracts\Support\Htmlable;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class PaymentReport extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-document-chart-bar';

    protected static ?int $navigationSort = 7;

    protected static string $view = 'filament.pages.payment-report';

    protected ?string $maxContentWidth = 'full';

    /**
     * @var array<string, mixed>
     */
    public ?array $data = [];

    public function mount(): void
    {
        $this->form->fill([
            'from' => now()->startOfMonth()->toDateString(),
            'to' => now()->toDateString(),
            'types' => [],
            'statuses' => [],
        ]);
    }

    public function getTitle(): string|Htmlable
    {
        return __('resource.payment_report');
    }

    public function getSubheading(): string|Htmlable|null
    {
        return __('resource.payment_report_description');
    }

    public static function getNavigationLabel(): string
    {
        return __('navigation.payment_report');
    }

    public static function canAccess(): bool
    {
        return optional(auth()->user())->role === 'super-admin';
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make(__('resource.filters'))
                    ->schema([
                        DatePicker::make('from')
                            ->label(__('resource.date_from'))
                            ->required()
                            ->maxDate(fn (Get $get) => $get('to'))
                            ->live(),
                        DatePicker::make('to')
                            ->label(__('resource.date_to'))
                            ->required()
                            ->minDate(fn (Get $get) => $get('from'))
                            ->live(),
                        Select::make('types')
                            ->label(__('resource.type'))
                            ->multiple()
                            ->searchable()
                            ->options(fn () => PaymentReportService::typeOptions())
                            ->placeholder(__('resource.all'))
                            ->live(),
                        Select::make('statuses')
                            ->label(__('resource.status'))
                            ->multiple()
                            ->options(PaymentReportService::statusOptions())
                            ->placeholder(__('resource.all'))
                            ->live(),
                    ])
                    ->columns(2),
            ])
            ->statePath('data');
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('download')
                ->label(__('resource.download_excel'))
                ->icon('heroicon-o-arrow-down-tray')
                ->action('download'),
        ];
    }

    /**
     * @return array<string, mixed>
     */
    public function getSummaryProperty(): array
    {
        return app(PaymentReportService::class)->summarize($this->filters());
    }

    public function download(): BinaryFileResponse
    {
        $state = $this->form->getState();
        $filters = [
            'from' => $state['from'],
            'to' => $state['to'],
            'types' => $state['types'] ?? [],
            'statuses' => $state['statuses'] ?? [],
        ];

        $from = Carbon::parse($filters['from'])->toDateString();
        $to = Carbon::parse($filters['to'])->toDateString();

        return Excel::download(
            new PaymentReportExport($filters),
            "payment-report_{$from}_{$to}.xlsx",
        );
    }

    /**
     * @return array{from: mixed, to: mixed, types: mixed, statuses: mixed}
     */
    private function filters(): array
    {
        return [
            'from' => $this->data['from'] ?? null,
            'to' => $this->data['to'] ?? null,
            'types' => $this->data['types'] ?? [],
            'statuses' => $this->data['statuses'] ?? [],
        ];
    }
}
