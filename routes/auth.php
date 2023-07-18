<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\DiscordController;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function () {
    Route::group(['prefix' => 'discord'], function () {
        Route::get('/login', [DiscordController::class, 'redirectToProvider'])->name('discord.login');
        Route::get('/callback', [DiscordController::class, 'handleProviderCallback'])->name('discord.callback');
    });
});

Route::middleware('auth')->group(function () {
    Route::get('logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');
});
