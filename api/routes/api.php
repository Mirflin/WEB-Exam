<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\User;

Route::get('/user', function (Request $request) {
    $user = User::with('role', 'client')->find($request->user()->id);
    return $user;
})->middleware('auth:sanctum');

Route::post('/user-create', [App\Http\Controllers\User::class, 'create']);

Route::post('/clients', function (Request $request) {
    return \App\Models\Client::with('user')->where('user_id', $request->user()->id)->first();
})->middleware('auth:sanctum');

Route::post('/user-update', [App\Http\Controllers\User::class, 'update'])->middleware('auth:sanctum');

Route::post('/user-delete', [App\Http\Controllers\User::class, 'delete'])->middleware('auth:sanctum');

Route::post('/user-restore', [App\Http\Controllers\User::class, 'restore'])->middleware('auth:sanctum');

Route::post('/policies', [App\Http\Controllers\Policy::class, 'list'])->middleware('auth:sanctum');

Route::post('/policies-create', [App\Http\Controllers\Policy::class, 'create'])->middleware('auth:sanctum');

Route::post('/policies-delete', [App\Http\Controllers\Policy::class, 'delete'])->middleware('auth:sanctum');

Route::post('/policies-pay', [App\Http\Controllers\Policy::class, 'payments'])->middleware('auth:sanctum');

Route::post('/policies-restore', [App\Http\Controllers\Policy::class, 'restore'])->middleware('auth:sanctum');

Route::post('/payments', [App\Http\Controllers\Payment::class, 'list'])->middleware('auth:sanctum');

Route::post('/all-users', [App\Http\Controllers\User::class, 'allUsers'])->middleware('auth:sanctum');

Route::get('/polises-list', [App\Http\Controllers\Policy::class, 'allPolises'])->middleware('auth:sanctum');

Route::post('/polis-delete', [App\Http\Controllers\Policy::class, 'deletePolise'])->middleware('auth:sanctum');
