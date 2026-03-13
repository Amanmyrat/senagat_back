<?php

namespace App\Filament\AvatarProviders;

use Filament\AvatarProviders\Contracts\AvatarProvider;
use Illuminate\Database\Eloquent\Model;

class LocalAvatarProvider implements AvatarProvider
{
    public function get(Model $record): string
    {
        // Generate initials from name
        $name = $record->name ?? 'User';
        $initials = collect(explode(' ', $name))
            ->take(2)
            ->map(fn ($part) => strtoupper(substr(trim($part), 0, 1)))
            ->filter()
            ->join('');

        // Generate color based on ID
        $colors = ['E53E3E', 'DD6B20', 'D69E2E', 'F6AD55', '38A169', '38B2AC', '3182CE', '805AD5', 'D6BCFA'];
        $colorIndex = (intval($record->id ?? 0)) % count($colors);
        $backgroundColor = $colors[$colorIndex];

        // Return SVG data URL
        $svg = sprintf(
            '<svg width="40" height="40" xmlns="http://www.w3.org/2000/svg"><rect width="40" height="40" fill="#%s" rx="4"/><text x="50%%" y="50%%" font-size="16" font-weight="600" fill="#FFFFFF" text-anchor="middle" dy="0.35em" font-family="system-ui">%s</text></svg>',
            $backgroundColor,
            htmlspecialchars($initials, ENT_QUOTES, 'UTF-8')
        );

        return 'data:image/svg+xml;base64,'.base64_encode($svg);
    }
}
