<x-filament-widgets::widget>
    <x-filament::section>
        <div class="space-y-2">
            <div class="flex items-center justify-between">
                <h3 class="text-lg font-semibold leading-6">
                    ⚠️ {{ __('resource.pending_approvals_action_required') }}
                </h3>
            </div>

            <div class="grid gap-4 md:grid-cols-2 lg:grid-cols-{{ count($this->getPendingData()) }}">
                @foreach($this->getPendingData() as $item)
                    <a 
                        href="{{ $item['url'] }}"
                        class="relative flex items-center space-x-3 rounded-lg border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-800 px-6 py-5 shadow-sm hover:border-gray-400 dark:hover:border-gray-600 transition-all hover:shadow-md"
                    >
                        <div class="flex-shrink-0">
                            <span class="inline-flex h-10 w-10 items-center justify-center rounded-lg
                                @if($item['color'] === 'warning') bg-yellow-100 dark:bg-yellow-900
                                @elseif($item['color'] === 'primary') bg-blue-100 dark:bg-blue-900
                                @elseif($item['color'] === 'success') bg-green-100 dark:bg-green-900
                                @elseif($item['color'] === 'info') bg-purple-100 dark:bg-purple-900
                                @endif
                            ">
                                <x-filament::icon 
                                    :icon="$item['icon']"
                                    class="h-6 w-6
                                        @if($item['color'] === 'warning') text-yellow-600 dark:text-yellow-400
                                        @elseif($item['color'] === 'primary') text-blue-600 dark:text-blue-400
                                        @elseif($item['color'] === 'success') text-green-600 dark:text-green-400
                                        @elseif($item['color'] === 'info') text-purple-600 dark:text-purple-400
                                        @endif
                                    "
                                />
                            </span>
                        </div>
                        <div class="min-w-0 flex-1">
                            <p class="text-sm font-medium text-gray-900 dark:text-gray-100">
                                {{ $item['label'] }}
                            </p>
                            <p class="text-2xl font-bold
                                @if($item['color'] === 'warning') text-yellow-600 dark:text-yellow-400
                                @elseif($item['color'] === 'primary') text-blue-600 dark:text-blue-400
                                @elseif($item['color'] === 'success') text-green-600 dark:text-green-400
                                @elseif($item['color'] === 'info') text-purple-600 dark:text-purple-400
                                @endif
                            ">
                                {{ $item['count'] }}
                            </p>
                        </div>
                        @if($item['count'] > 0)
                            <div class="flex-shrink-0">
                                <span class="inline-flex h-6 w-6 items-center justify-center rounded-full bg-red-500 text-xs font-medium text-white">
                                    !
                                </span>
                            </div>
                        @endif
                    </a>
                @endforeach
            </div>
        </div>
    </x-filament::section>
</x-filament-widgets::widget>

