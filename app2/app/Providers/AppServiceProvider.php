<?php

namespace App\Providers;

use App\Http\Controllers\SsoController;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\ServiceProvider;

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

            $getUser = Http::withHeaders([
                'Authorization' => 'Bearer ' . Cookie::get('ssotoken'),
            ])->get('http://' . \request()->ip() . ':8000/api/user');


            $user = User::updateorCreate([
                'email' => $getUser->json()['email'],
            ], [
                'name' => $getUser->json()['name'],
                'password' => bcrypt('password'),
            ]);

            auth()->login($user);
        }
    }
}
