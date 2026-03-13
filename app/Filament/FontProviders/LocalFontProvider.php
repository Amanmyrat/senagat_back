<?php

namespace App\Filament\FontProviders;

use Filament\FontProviders\Contracts\FontProvider;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Support\HtmlString;

class LocalFontProvider implements FontProvider
{
    public function getHtml(string $family, ?string $url = null): Htmlable
    {
        // Return empty - use system fonts instead
        return new HtmlString('<style>:root { --font-family: system-ui, -apple-system, sans-serif; }</style>');
    }
}
