<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\PostController;
use Illuminate\Support\Facades\Log;

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
    $filteredUser = [
        'id' => $request->user()->id,
        'name' => $request->user()->name
    ];

    return json_encode($filteredUser);
    // return $request->user();
});

Route::middleware('auth:sanctum')->get('/authenticated', function (Request $request) {
    return true;
});

Route::resource('posts', PostController::class);