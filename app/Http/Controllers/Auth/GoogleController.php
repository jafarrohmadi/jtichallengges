<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Laravel\Socialite\Facades\Socialite;

class GoogleController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return \Illuminate\Http\RedirectResponse|\Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function redirectToGoogle(): \Symfony\Component\HttpFoundation\RedirectResponse|RedirectResponse
    {
        return Socialite::driver('google')->redirect();
    }

    /**
     * Create a new controller instance.
     *
     * @return Application|RedirectResponse|Redirector
     */
    public function handleGoogleCallback(): Redirector|RedirectResponse|Application
    {
        DB::beginTransaction();
        try {
            $user = Socialite::driver('google')->user();
            $finduser = User::where('google_id', $user->id)->first();
            if ($finduser) {
                Auth::login($finduser);

                return redirect('/home');
            } else {
                $newUser = User::create([
                    'name' => $user->name,
                    'email' => $user->email,
                    'google_id' => $user->id,
                    'password' => encrypt(rand(999999, 9999999999)),
                ]);

                Auth::login($newUser);
            }
        } catch (Exception $e) {
            DB::rollBack();
        }

        DB::commit();
        return redirect('/home');
    }
}
