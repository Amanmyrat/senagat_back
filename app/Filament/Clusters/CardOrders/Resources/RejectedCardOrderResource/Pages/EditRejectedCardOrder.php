<?php

namespace App\Filament\Clusters\CardOrders\Resources\RejectedCardOrderResource\Pages;

use App\Filament\Clusters\CardOrders\Resources\RejectedCardOrderResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditRejectedCardOrder extends EditRecord
{
    protected static string $resource = RejectedCardOrderResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
            Actions\Action::make('print')
                ->label(__('resource.print'))
                ->icon('heroicon-o-printer')
                ->action(function ($record) {
                    $url = route('approved-card-orders.print-view', $record->id);

                    $this->js(<<<JS
            fetch('{$url}')
                .then(res => res.blob())
                .then(blob => {
                    const blobUrl = URL.createObjectURL(blob);
                    const iframe = document.createElement('iframe');
                    iframe.style.display = 'none';
                    iframe.src = blobUrl;
                    document.body.appendChild(iframe);
                    iframe.onload = function() {
                        iframe.contentWindow.print();
                    };
                });
        JS);
                }),
        ];
    }
}
