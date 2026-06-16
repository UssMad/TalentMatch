<?php

use App\Http\Controllers\AnalysisController;
use App\Http\Controllers\CandidateController;
use App\Http\Controllers\JobOfferController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::resource('job-offers', JobOfferController::class);

    Route::resource('job-offers.candidates', CandidateController::class);

    Route::post('job-offers/{jobOffer}/candidates/{candidate}/analyze', [AnalysisController::class, 'trigger'])
        ->name('job-offers.candidates.analyze');
});

require __DIR__.'/auth.php';
