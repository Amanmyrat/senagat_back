<?php

namespace App\Filament\Resources\ApprovedCardOrderResource\Pages;

use App\Filament\Resources\ApprovedCardOrderResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditApprovedCardOrder extends EditRecord
{
    protected static string $resource = ApprovedCardOrderResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
            Actions\Action::make('print')
                ->label(__('resource.print'))
                ->icon('heroicon-o-printer')
                ->action(function ($record) {
                    $url = route('approved-card-orders.print', $record->id);

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
