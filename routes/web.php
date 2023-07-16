<?php

use App\Http\Controllers\DiscordController;
use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Laravel\Socialite\Facades\Socialite;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    //$user = Socialite::driver('discord')->user();
    dump(Auth::user(), Auth::check());
    $req = Illuminate\Support\Facades\Request::get('https://cdn.discordapp.com/avatars/'. Auth::user()->discord_id.'/'.Auth::user()->id .'.png');
    dd($req);
    //$user = Socialite::driver('discord')->user();
    //return Inertia::render('Welcome', [
    //    'canLogin' => Route::has('login'),
    //    'canRegister' => Route::has('register'),
    //    'laravelVersion' => Application::VERSION,
    //    'phpVersion' => PHP_VERSION,
    //    //'token' => $user->token,
    //]);
});

Route::get('/login', [DiscordController::class, 'redirectToProvider'])->name('discord.redirect');
Route::get('/discord/callback', [DiscordController::class, 'handleProviderCallback'])->name('discord.callback');

Route::get('test', function () {
    return dump(Auth::user(), Auth::check());
})->name('test');

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
