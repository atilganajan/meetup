<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\ConsultantController;
use App\Http\Controllers\Admin\ClientController;
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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth', 'verified')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');


    Route::middleware('admin')->prefix('admin')->name('admin.')->group(function () {

        Route::prefix("consultant")->name('consultant.')->group(function (){
            Route::match(["GET","POST"],'/', [ConsultantController::class, 'index'])->name('index');
            Route::post('/approve', [ConsultantController::class, 'approve'])->name('approve');
        });

        Route::prefix("client")->name('client.')->group(function (){
            Route::match(["GET","POST"],'/', [ClientController::class, 'index'])->name('index');
            Route::post('/approve', [ClientController::class, 'approve'])->name('approve');
        });

    });

});





require __DIR__.'/auth.php';
