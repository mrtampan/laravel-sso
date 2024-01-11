<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Laravel\Sanctum\PersonalAccessToken;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        //
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        if (Cookie::has('ssotoken') && !Auth::check()) {

            $accessToken = PersonalAccessToken::findToken(Cookie::get('ssotoken'));

            if ($accessToken) {
                Auth::loginUsingId($accessToken->tokenable_id);
            }
        }else{
            Auth::logout();
        }
    }
}
