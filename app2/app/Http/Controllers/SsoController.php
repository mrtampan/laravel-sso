<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class SsoController extends Controller
{
    public function Index(String $token, Request $request)
    {

        try {
            $this->AuthSso(urldecode($token));
        } catch (\Exception $e) {
            return redirect()->route('login');
        }

        return redirect()->route('home');
    }

    public function AuthSso($token)
    {
        $getUser = Http::withHeaders([
            'Authorization' => 'Bearer ' . $token,
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
