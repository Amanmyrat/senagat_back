<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Providers\Filament\AdminPanelProvider;

class RedirectIfNotSuperAdmin
{
    public function handle(Request $request, Closure $next)
    {
        $user = auth('admin')->user();

        if ($request->routeIs('filament.admin.pages.dashboard') && $user?->role !== 'super-admin') {
            return redirect(AdminPanelProvider::getHomeUrlForRole($user?->role));
        }

        return $next($request);
    }
}
