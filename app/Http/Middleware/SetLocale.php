<?php

namespace App\Http\Middleware;

use Closure;

class SetLocale
{
    public function handle($request, Closure $next)
    {
        
        if (request('change_language')) {
            session()->put('language', request('change_language'));
            $language = request('change_language');
        } elseif (session('language')) {
            $language = session('language');
        } elseif (config('panel.primary_language')) {
            $language = config('panel.primary_language');
        }
        // dd($language);
        if (isset($language)) {
            app()->setLocale($language);
        }

        $tenant = tenancy()->tenant->id;
        $tenantLangPath = resource_path("lang/{$tenant}");
        
        if (is_dir($tenantLangPath)) {
            Lang::setLoader(new \Illuminate\Translation\FileLoader(
                App::make('files'), $tenantLangPath
            ));
        }
        
        // dd($next($request));
        return $next($request);
    }
}
