<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class DiscordController extends Controller
{
    /**
     * Redirect the user to the Discord authentication page.
     *
     */
    public function redirectToProvider(): RedirectResponse
    {
        return Socialite::driver('discord')->redirect();
    }

    /**
     * Obtain the user information from Discord.
     *
     */
    public function handleProviderCallback()
    {
        $user = Socialite::driver('discord')->stateless()->user();

        $user = User::query()->updateOrCreate([
            'name' => $user->name,
            'discord_id' => $user->id,
            'discord_token' => $user->token,
            'avatar' => $user->avatar,
        ]);

        Auth::login($user, true);

        return redirect()->route('dashboard');
    }
}
