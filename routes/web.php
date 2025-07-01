<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AssetController;
use App\Http\Controllers\PrintController;
use App\Http\Controllers\LabelController;

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

// Home/Dashboard Route
Route::get('/', [HomeController::class, 'index'])->name('home');

// Assets Management Routes
Route::prefix('assets')->name('assets.')->group(function () {
    Route::get('/', [AssetController::class, 'index'])->name('index');
    Route::get('/create', [AssetController::class, 'create'])->name('create');
    Route::post('/', [AssetController::class, 'store'])->name('store');
    Route::get('/{asset}/edit', [AssetController::class, 'editAsset'])->name('edit');
    Route::get('/{asset}', [AssetController::class, 'show'])->name('show');
    Route::put('/{asset}', [AssetController::class, 'update'])->name('update');
    Route::delete('/{asset}', [AssetController::class, 'destroy'])->name('destroy');
    
    // Bulk operations
    Route::post('/bulk-delete', [AssetController::class, 'bulkDelete'])->name('bulk-delete');
    Route::get('/export', [AssetController::class, 'export'])->name('export');
    
    // Search API
    Route::get('/search', [AssetController::class, 'search'])->name('search');
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


// API Routes for AJAX requests
Route::prefix('api')->name('api.')->group(function () {
    Route::get('/assets/search', [AssetController::class, 'apiSearch'])->name('assets.search');
    Route::get('/assets/{asset}', [AssetController::class, 'apiShow'])->name('assets.show');
    Route::post('/assets', [AssetController::class, 'apiStore'])->name('assets.store');
    Route::put('/assets/{asset}', [AssetController::class, 'apiUpdate'])->name('assets.update');
    Route::delete('/assets/{asset}', [AssetController::class, 'apiDestroy'])->name('assets.destroy');
    
    // Print API
    Route::post('/print/single', [PrintController::class, 'apiSingle'])->name('print.single');
    Route::post('/print/bulk', [PrintController::class, 'apiBulk'])->name('print.bulk');
    Route::post('/print/qr', [PrintController::class, 'apiQr'])->name('print.qr');
});

// Additional utility routes
Route::get('/dashboard', [HomeController::class, 'index'])->name('dashboard');
Route::get('/reports', [HomeController::class, 'reports'])->name('reports');
Route::get('/settings', [HomeController::class, 'settings'])->name('settings');

// Fallback route for 404
Route::fallback(function () {
    return view('errors.404');
}); 