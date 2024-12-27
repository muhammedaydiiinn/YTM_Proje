<?php

use App\Http\Controllers\PageController;
use App\Http\Controllers\PlayerController;
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

// ana sayfa route u
Route::get('/', [PageController::class, 'index_home'])->name('index_home');
Route::get('/search', [PageController::class, 'filter_page'])->name('filter_page');
Route::post('/filter-result', [PageController::class, 'filter_result'])->name('filter_result');
Route::get('/search-result', [PageController::class, 'search_result'])->name('search_result');
Route::get('/get-option', [PageController::class, 'get_option'])->name('get_option');
Route::get('player/{id}', [PlayerController::class, 'player_detail'])->name('player_detail');
Route::get('/live-search', [PlayerController::class, 'live_search'])->name('live_search');
Route::get('/get-player-view', [PlayerController::class, 'getPlayerView'])->name('players.getPlayerView');

// players routes
Route::prefix('players')->group(function () {
    Route::get('/by-id', [PlayerController::class, 'getPlayerProfilesById'])->name('players.by_id');
    Route::get('/by-name', [PlayerController::class, 'getPlayerProfilesByName'])->name('players.by_name');
    Route::get('/by-age-range', [PlayerController::class, 'getPlayerProfilesByAgeRange'])->name('players.by_age-range');
    Route::get('/by-main-position', [PlayerController::class, 'getPlayerProfileByMainPosition'])->name('players.by_main-position');
    Route::get('/by-nationality', [PlayerController::class, 'getPlayerProfilesByNationality'])->name('players.by_nationality');
    Route::get('/by-club', [PlayerController::class, 'getPlayerProfilesByClub'])->name('players.by_club');
    Route::get('/by-foot', [PlayerController::class, 'getPlayerProfilesByFoot'])->name('players.by_foot');
    Route::get('/by-market-value', [PlayerController::class, 'getPlayerProfilesByMarketValue'])->name('players.by_market-value');
    Route::get('/by_filters', [PlayerController::class, 'getPlayerProfiles'])->name('players.by_filters');
});
