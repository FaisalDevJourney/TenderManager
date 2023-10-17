<?php

use App\Http\Controllers\tenderController;
use App\Http\Controllers\tenderFileController;
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

Route::get('/', [tenderController::class,'index']);
Route::get('/addnewtender', function () {
    return view('addtender');
});
Route::post('/createtender', [tenderController::class,'createTender']);
Route::get('/edit/{id}', [tenderController::class,'show']);
Route::post('/upload/{id}', [tenderController::class,'uploadDocuments']);
Route::post('/update/{id}', [tenderController::class,'update']);
Route::get('/preview/{id}', [tenderController::class,'preview']);
Route::get('/getFile/{file}',[tenderController::class, 'download']);
Route::get('/deleteFile/{id}',[tenderFileController::class, 'DeleteFile']);
Route::get('/deleteTender/{id}',[tenderController::class, 'DeleteTender']);
Route::get('/search',[tenderController::class, 'Search']);
