<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Models\User;
use App\Models\Child;
use App\Models\Daycare;

Route::get('/', function () {
    //$users = User::with('profile', 'daycares.children.guardians', 'children')->get();
    $child = Child::with([ 'health' => ['illnesses', 'allergies', 'medications'], 'guardians', 'daycare'])->get();
    return Inertia::render('Welcome', [ 
        'child' => $child,
    ]);
})->name('home');

Route::get('dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

require __DIR__.'/settings.php';
require __DIR__.'/auth.php';
