<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class SsoController extends Controller
{
    public function __invoke(String $token)
    {
        
        $getUser = Http::withHeaders([
            'Authorization' => 'Bearer ' . urldecode($token),
        ])->get('http://192.168.222.111:8000/api/user');

        
        $user = User::updateorCreate([
            'email' => $getUser->json()['email'],
        ], [
            'name' => $getUser->json()['name'],
            'password' => bcrypt('password'),
        ]);

        auth()->login($user);

        return redirect()->route('home');
    }
}
