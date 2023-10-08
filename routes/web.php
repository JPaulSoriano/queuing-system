<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\QueueController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::get('/queue', [QueueController::class, 'index'])->name('queue.index');
Route::post('/queue/next', [QueueController::class, 'serveNext'])->name('queue.next');
Route::post('/queue/create', [QueueController::class, 'create'])->name('queue.create');
Auth::routes();
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
