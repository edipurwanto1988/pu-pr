<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;

class GoogleController extends Controller
{
    public function redirect(): \Illuminate\Http\RedirectResponse
    {
        return Socialite::driver('google')->redirect();
    }

    public function callback(): \Illuminate\Http\RedirectResponse
    {
        $googleUser = Socialite::driver('google')->stateless()->user();

        $user = User::where('email', $googleUser->email)->first();

        if ($user) {
            if (!$user->google_id) {
                $user->update(['google_id' => $googleUser->id]);
            }
            Auth::login($user);
        } else {
            $umkmRole = \App\Models\Role::where('slug', 'umkm-ikm')->first();

            $user = User::create([
                'name' => $googleUser->name,
                'email' => $googleUser->email,
                'password' => Hash::make(str()->random(32)),
                'google_id' => $googleUser->id,
                'role_id' => $umkmRole?->id,
                'status' => 'active',
            ]);

            Auth::login($user);
        }

        if ($user->hasRole('super-admin') || $user->hasRole('admin') || $user->hasRole('umkm-ikm')) {
            return redirect()->route('admin.dashboard');
        }

        return redirect('/dashboard');
    }
}
