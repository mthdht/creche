<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Models\User;
use App\Models\Child;
use App\Models\Daycare;

Route::get('/', function () {
    return Inertia::render('Welcome', [ 
        'child' => $child,
    ]);
})->name('home');

Route::get('dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

require __DIR__.'/settings.php';
require __DIR__.'/auth.php';
