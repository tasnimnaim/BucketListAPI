<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\BucketListController;

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


Route::get('/', [BucketListController::class, 'allList']);
Route::get('/AllList', [BucketListController::class, 'allList']);
Route::get('/MyList', [BucketListController::class, 'getMyList']);
Route::post('/MyList/Added', [BucketListController::class, 'addMyList'])->name('myList.add');
Route::post('/MyList/Updated/{id}', [BucketListController::class, 'updateMyList'])->name('myList.update');
Route::post('/MyList/Deleted/', [BucketListController::class, 'deleteMyList'])->name('myList.delete');
Route::post('/MyList/Edited/{id}', [BucketListController::class, 'editMyItem'])->name('myList.editItem');
Route::post('/MyList/DeletedItem/{id}', [BucketListController::class, 'deleteMyItem'])->name('myList.deleteItem');

Auth::routes();

//Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
