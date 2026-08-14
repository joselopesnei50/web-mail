<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\EmailController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/privacidade', function () {
    $content = \App\Models\Setting::where('key', 'privacy_policy')->value('value');
    return view('legal', ['title' => 'Política de Privacidade', 'content' => $content]);
})->name('legal.privacy');

Route::get('/termos', function () {
    $content = \App\Models\Setting::where('key', 'terms_of_use')->value('value');
    return view('legal', ['title' => 'Termos de Uso', 'content' => $content]);
})->name('legal.terms');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', [EmailController::class, 'inbox'])->name('dashboard');
    Route::post('/compose', [EmailController::class, 'send'])
        ->middleware('throttle:20,1')
        ->name('emails.send');

    // Settings (Super Admin)
    Route::get('/settings', [\App\Http\Controllers\SettingsController::class, 'index'])->name('settings.index');
    Route::post('/settings', [\App\Http\Controllers\SettingsController::class, 'update'])->name('settings.update');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
