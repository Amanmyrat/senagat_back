<x-filament-panels::page>
    <div class="space-y-6" wire:loading.class="opacity-60">
        <div>
            {{ $this->form }}

            <div class="mt-4 flex justify-end">
                <x-filament::button wire:click="download" icon="heroicon-o-arrow-down-tray">
                    {{ __('resource.download_excel') }}
                </x-filament::button>
            </div>
        </div>

        @php
            $summary = $this->summary;
            $cards = [
                ['label' => __('resource.payments_count'), 'value' => number_format($summary['count'])],
                ['label' => __('resource.total_amount'), 'value' => \App\Services\PaymentReportService::formatMoney($summary['amount'])],
                ['label' => __('resource.confirmed').' ('.__('resource.status').')', 'value' => \App\Services\PaymentReportService::formatMoney($summary['confirmed_amount'])],
                ['label' => __('resource.average_amount'), 'value' => \App\Services\PaymentReportService::formatMoney($summary['average'])],
            ];
            $tables = [
                ['title' => __('resource.by_status'), 'rows' => $summary['by_status']],
                ['title' => __('resource.by_type'), 'rows' => $summary['by_type']],
                ['title' => __('resource.by_payment_status'), 'rows' => $summary['by_payment_status']],
                ['title' => __('resource.by_day'), 'rows' => $summary['by_day']],
            ];
        @endphp

        <div class="grid gap-4 md:grid-cols-2 xl:grid-cols-4">
            @foreach ($cards as $card)
                <div class="rounded-xl border border-gray-200 bg-white px-5 py-4 text-center dark:border-gray-700 dark:bg-gray-900">
                    <p class="text-sm text-gray-500 dark:text-gray-400">{{ $card['label'] }}</p>
                    <p class="mt-1 text-2xl font-semibold text-gray-950 dark:text-white">{{ $card['value'] }}</p>
                </div>
            @endforeach
        </div>

        <div class="space-y-4">
            @foreach ($tables as $table)
                <x-filament::section :heading="$table['title']">
                    <div @class(['overflow-x-auto', 'max-h-80 overflow-y-auto' => $table['title'] === __('resource.by_day')])>
                        <table class="w-full text-sm">
                            <thead>
                                <tr class="border-b border-gray-200 text-left text-gray-500 dark:border-gray-700 dark:text-gray-400">
                                    <th class="py-2 pr-3 font-medium">{{ __('resource.name') }}</th>
                                    <th class="py-2 pr-3 text-right font-medium">{{ __('resource.count') }}</th>
                                    <th class="py-2 pr-3 text-right font-medium">{{ __('resource.amount') }}</th>
                                    <th class="py-2 text-right font-medium">{{ __('resource.share') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($table['rows'] as $row)
                                    <tr class="border-b border-gray-100 dark:border-gray-800">
                                        <td class="py-2 pr-3 text-gray-950 dark:text-white">{{ $row['label'] }}</td>
                                        <td class="py-2 pr-3 text-right tabular-nums">{{ number_format($row['count']) }}</td>
                                        <td class="py-2 pr-3 text-right tabular-nums">{{ \App\Services\PaymentReportService::formatMoney($row['amount']) }}</td>
                                        <td class="py-2 text-right tabular-nums">{{ \App\Services\PaymentReportService::formatShare($row['share']) }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="py-4 text-gray-500 dark:text-gray-400">{{ __('resource.no_payments') }}</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </x-filament::section>
            @endforeach
        </div>
    </div>
</x-filament-panels::page>
