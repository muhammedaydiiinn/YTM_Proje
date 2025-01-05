<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\PlayerAnalysisController;
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
Route::get('/get-player-like', [PlayerController::class, 'getPlayerLike'])->name('players.getPlayerLike');
Route::get('player/analyze-player/{id}', [PlayerAnalysisController::class, 'analyzePlayer']);
Route::post('/player/{playerId}/like', [PlayerController::class, 'likePlayer'])->name('player.like');
Route::get('like-count/{playerId}', [PlayerController::class, 'getLikeCount']); // Beğeni sayısını al
Route::get('/player/{playerId}/getComments', [PlayerController::class, 'getPlayerComments'])->name('comments.get');
Route::post('/player/{playerId}/comment', [PlayerController::class, 'storeComment'])->name('comment.store');
Route::post('/player/comment/{commentId}/delete', [PlayerController::class, 'deleteComment'])->name('comment.delete');

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
    Route::get('/top-players', [PlayerController::class, 'getTopPlayers'])->name('players.top_players');
});


// admin routes
Route::prefix('admin')->group(function () {
    Route::get('/user_list', [AdminController::class, 'user_list'])->name('admin.user_list');
    Route::get('/role_list', [AdminController::class, 'role_list'])->name('admin.role_list');
    Route::get('/user_fetch', [AdminController::class, 'user_fetch'])->name('admin.user_fetch');
    Route::get('/role_fetch', [AdminController::class, 'role_fetch'])->name('admin.role_fetch');
    Route::get('/role_create', [AdminController::class, 'role_create'])->name('admin.role_create');
    Route::post('/role_store', [AdminController::class, 'role_store'])->name('admin.role_store');
    Route::post('/role_delete/{id}', [AdminController::class, 'role_delete'])->name('admin.role_delete');
    Route::post('/users/status/{id}', [AdminController::class, 'user_status'])->name('admin.user_status');
    Route::post('/users/delete/{id}', [AdminController::class, 'user_delete'])->name('admin.user_delete');
});


// Yorumları getirme (auth gerektirmez)
Route::get('/player/{playerId}/comments', [PlayerController::class, 'getPlayerComments'])
    ->name('player.comments.index');

// Beğeni işlemleri için route'lar
Route::middleware('auth')->group(function () {
    Route::post('/player/{playerId}/like', [PlayerController::class, 'likePlayer'])
        ->name('player.like');
});

// Beğeni sayısını getirme (auth gerektirmez)
Route::get('/like-count/{playerId}', [PlayerController::class, 'getLikeCount'])
    ->name('player.like.count');

// Yorum işlemleri için route'lar
Route::prefix('player')->group(function () {
    // Auth gerektiren route'lar
    Route::middleware('auth')->group(function () {
        // Yorum ekleme
        Route::post('{playerId}/comments', [PlayerController::class, 'storeComment'])
            ->name('player.comments.store');
        
        // Yorum silme
        Route::post('comment/{commentId}/delete', [PlayerController::class, 'deleteComment'])
            ->name('player.comments.delete');
            
        // Beğeni işlemi
        Route::post('{playerId}/like', [PlayerController::class, 'likePlayer'])
            ->name('player.like');
    });

    // Auth gerektirmeyen route'lar
    Route::get('{playerId}/comments', [PlayerController::class, 'getPlayerComments'])
        ->name('player.comments.index');
        
    Route::get('like-count/{playerId}', [PlayerController::class, 'getLikeCount'])
        ->name('player.like.count');
});
