<?php

declare(strict_types=1);

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::prefix('auth')->as('auth:')->group(base_path(
    path: 'routes/api/auth.php',
));

Route::get('/user', fn(Request $request) => new App\Http\Resources\UserResource($request->user()))->middleware('auth:sanctum');
