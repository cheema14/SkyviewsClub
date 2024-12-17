<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\App;
use tenancy;
use File;

class TenantSetup
{
    public function handle($request, Closure $next)
    {
        
        if (tenancy()->initialized) {
            
            // $tenant = tenancy()->tenant->id; // Replace `id` with the field that stores the tenant name
            // $locale = App::getLocale();
            // $tenantLangPath = resource_path("lang/{$locale}/{$tenant}");
            
            // if (File::exists($tenantLangPath)) {
            //     $this->loadTranslationsFrom($tenantLangPath, $tenant);
            // }
        }
        
        return $next($request);
    }
}
