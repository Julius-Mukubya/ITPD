<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ContentController;
use App\Http\Controllers\PublicCounselingController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Content search suggestions
Route::get('/content/search-suggestions', [ContentController::class, 'searchSuggestions']);

// Session contact sharing
Route::middleware('auth')->post('/sessions/share-contact', [PublicCounselingController::class, 'shareContactInfo']);
