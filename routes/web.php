<?php

use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;

Route::view('/', 'welcome');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

Volt::route('users','pages.users.index')->name('users.index');
Volt::route('users/create','pages.users.create')->name("users.create");
Volt::route('users/{id}','pages.users.edit')->name("users.edit");

require __DIR__.'/auth.php';
