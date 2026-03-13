<?php

namespace App\Http\Middleware;

use App\Providers\Filament\AdminPanelProvider;
use Closure;
use Illuminate\Http\Request;

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
