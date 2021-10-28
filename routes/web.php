<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AnimeController;
use App\Http\Controllers\GenreController;
use App\Http\Controllers\VideoController;
use App\Http\Controllers\CountryController;
use App\Http\Controllers\EpisodeController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\ProducerController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfilePhotoController;


Route::get('/', function () {
    return redirect('admin/dashboard');
});

Route::middleware(['auth'])->prefix('admin')->group(function () {
    Route::get('/', function () {
        return redirect('admin/dashboard');
    });
    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('anime', [AnimeController::class, 'index'])->name('anime');
    Route::get('anime/new', [AnimeController::class, 'create'])->name('anime.create');
    Route::post('anime/new', [AnimeController::class, 'store'])->name('anime.store');
    Route::get('anime/{id}', [AnimeController::class, 'edit'])->name('anime.edit');
    Route::put('anime/{id}/update', [AnimeController::class, 'update'])->name('anime.update');
    Route::delete('anime/{id}', [AnimeController::class, 'destroy'])->name('anime.destroy');

    Route::get('anime/{id}/episodes', [EpisodeController::class, 'index'])->name('episodes');
    Route::get('anime/episode/{id}/edit', [EpisodeController::class, 'edit'])->name('episode.edit');
    Route::put('anime/episode/{id}/update', [EpisodeController::class, 'update'])->name('episode.update');
    Route::get('anime/{id}/episode/new', [EpisodeController::class, 'create'])->name('episode.create');
    Route::post('anime/{id}/episode/store', [EpisodeController::class, 'store'])->name('episode.store');
    Route::delete('anime/episode/{id}', [EpisodeController::class, 'destroy'])->name('episode.destroy');

    Route::post('anime/{animeId}/episode/{eps}', [VideoController::class, 'store'])->name('episode.video.store');
    Route::delete('video/{id}', [VideoController::class, 'destroy'])->name('video.destroy');

    Route::get('genres', [GenreController::class, 'index'])->name('genres');
    Route::post('genres', [GenreController::class, 'store'])->name('genres.store');
    Route::delete('genres/{id}', [GenreController::class, 'destroy'])->name('genres.destroy');

    Route::get('country', [CountryController::class, 'index'])->name('country');
    Route::post('country', [CountryController::class, 'store'])->name('country.store');
    Route::delete('country/{id}', [CountryController::class, 'destroy'])->name('country.destroy');

    Route::get('producer', [ProducerController::class, 'index'])->name('producer');
    Route::post('producer', [ProducerController::class, 'store'])->name('producer.store');
    Route::delete('producer/{id}', [ProducerController::class, 'destroy'])->name('producer.destroy');

    Route::get('services', [ServiceController::class, 'index'])->name('services');
    Route::post('service', [ServiceController::class, 'store'])->name('service.store');
    Route::delete('service/{id}', [ServiceController::class, 'destroy'])->name('service.destroy');

    Route::get('user', [UserController::class, 'index'])->name('user.index');
    Route::get('user/create', [UserController::class, 'create'])->name('user.create');
    Route::post('user/create', [UserController::class, 'store'])->name('user.store');
    Route::get('user/edit/{id}', [UserController::class, 'edit'])->name('user.edit');
    Route::put('user/edit/{id}', [UserController::class, 'update'])->name('user.update');
    Route::post('user/status/{id}', [UserController::class, 'status'])->name('user.status');
});

Route::middleware(['auth'])->group(function () {
    Route::delete('/user/{id}/profile-photo', [ProfilePhotoController::class, 'destroy'])
        ->name('current-user-photo.destroy');
    Route::put('user/{id}/password', [UserController::class, 'updatePassword'])->name('user.password.update');
    Route::delete('user/{id}', [UserController::class, 'destroy'])->name('user.destroy');
});
