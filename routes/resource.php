<?php

use App\Http\Controllers\PostController;

/*
|--------------------------------------------------------------------------
| Resource Routes
|--------------------------------------------------------------------------
| Routes that are built with the "resource" function and just have the 
| middleware be created inside the controller itself
*/

use Illuminate\Support\Facades\Route;

Route::resource("post", PostController::class);