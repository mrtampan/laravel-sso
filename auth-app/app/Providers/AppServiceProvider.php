<?php

namespace App\Providers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\ServiceProvider;
use Laravel\Sanctum\PersonalAccessToken;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        if (Cookie::has('ssotoken') && !Auth::check()) {

            $accessToken = PersonalAccessToken::findToken(Cookie::get('ssotoken'));

            if ($accessToken) {
                Auth::loginUsingId($accessToken->tokenable_id);
            }
        }
    }
}
