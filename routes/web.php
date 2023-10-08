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
Route::get('/', [QueueController::class, 'queueForm'])->name('queueForm');
Route::post('/getQueue', [QueueController::class, 'getQueue'])->name('getQueue');

Route::get('/queue', [QueueController::class, 'index'])->name('queue.index');
Route::post('/queue/next', [QueueController::class, 'serveNext'])->name('queue.next');

Route::get('/customer', [QueueController::class, 'customerView'])->name('customer.view');

Route::get('/queues', [QueueController::class, 'getQueues'])->name('queues.list');

Auth::routes();
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
