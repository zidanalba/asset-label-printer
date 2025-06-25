<?php

use Illuminate\Support\Facades\Route;
// use App\Http\Controllers\HomeController;
use App\Http\Controllers\AssetController;
use App\Http\Controllers\PrintController;

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

// Redirect root to assets index
Route::get('/', function () {
    return redirect()->route('assets.index');
});

// Assets Management Routes
Route::prefix('assets')->name('assets.')->group(function () {
    Route::get('/', [AssetController::class, 'index'])->name('index');
    Route::get('/create', [AssetController::class, 'create'])->name('create');
    Route::post('/', [AssetController::class, 'store'])->name('store');
    Route::get('/{asset}', [AssetController::class, 'show'])->name('show');
    Route::get('/{asset}/edit', [AssetController::class, 'edit'])->name('edit');
    Route::put('/{asset}', [AssetController::class, 'update'])->name('update');
    Route::delete('/{asset}', [AssetController::class, 'destroy'])->name('destroy');
});

// Print Routes
Route::prefix('print')->name('print.')->group(function () {
    Route::get('/', [PrintController::class, 'index'])->name('index');
    Route::get('/single/{asset}', [PrintController::class, 'single'])->name('single');
    Route::get('/bulk', [PrintController::class, 'bulk'])->name('bulk');
    Route::get('/qr', [PrintController::class, 'qr'])->name('qr');
    Route::get('/reprint/{print}', [PrintController::class, 'reprint'])->name('reprint');
    Route::get('/preview/{asset}', [PrintController::class, 'preview'])->name('preview');
    
    // Label routes
    Route::get('/label/{asset}', [PrintController::class, 'label'])->name('label');
});

Route::get('/print', [PrintController::class, 'index'])->name('print.index');
Route::get('/print/assets-table', [PrintController::class, 'assetsTable'])->name('print.assetsTable');
Route::get('/print/single/{asset}', [PrintController::class, 'single'])->name('print.single');
Route::post('/print/send', [PrintController::class, 'sendToPrinter'])->name('print.send');

// Fallback route for 404
Route::fallback(function () {
    return view('errors.404');
}); 
