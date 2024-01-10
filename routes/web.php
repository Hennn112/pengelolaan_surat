<?php

use App\Http\Controllers\LetterController;
use App\Http\Controllers\LetterTypeController;
use App\Http\Controllers\ResultController;
use App\Http\Controllers\UserController;
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
Route::middleware(['IsGuest'])->group(function(){
    Route::get('/',function (){
        return view('login');
    })->name('login');
    Route::post('/login', [UserController::class, 'loginAuth'])->name('login.auth');
});

Route::middleware(['IsLogin'])->group(function(){
    Route::get('/home',[LetterController::class,'index'])->name('home.page');
    Route::get('/logout', [UserController::class, 'logout'])->name('logout');
});

Route::middleware(['IsLogin', 'IsStaff'])->group(function(){
    Route::prefix('/admin')->name('admin.')->group(function(){
        Route::get('/',[UserController::class,'index'])->name('home');

        Route::prefix('/staff')->name('staff.')->group(function(){
            Route::get('/',[UserController::class,'indexStaff'])->name('index');
            Route::get('/create',[UserController::class,'createStaff'])->name('create');
            Route::post('/store',[UserController::class,'storeStaff'])->name('store');
            Route::get('/{id}',[UserController::class,'editStaff'])->name('edit');
            Route::patch('/{id}',[UserController::class,'updateStaff'])->name('update');
            Route::delete('/{id}', [UserController::class, 'destroy'])->name('delete');
        });

        Route::prefix('/guru')->name('guru.')->group(function(){
            Route::get('/',[UserController::class,'indexGuru'])->name('index');
            Route::get('/create',[UserController::class,'createGuru'])->name('create');
            Route::post('/store',[UserController::class,'storeGuru'])->name('store');
            Route::get('/{id}',[UserController::class,'editGuru'])->name('edit');
            Route::patch('/{id}',[UserController::class,'updateGuru'])->name('update');
            Route::delete('/{id}', [UserController::class, 'destroy'])->name('delete');
        });

        Route::prefix('/klasifikasi')->name('klasifikasi.')->group(function(){
            Route::get('/',[LetterTypeController::class,'index'])->name('index');
            Route::get('/create',[LetterTypeController::class,'create'])->name('create');
            Route::post('/store',[LetterTypeController::class,'store'])->name('store');
            Route::get('/edit/{id}',[LetterTypeController::class,'edit'])->name('edit');
            Route::patch('/update/{id}',[LetterTypeController::class,'update'])->name('update');
            Route::delete('/delete/{id}', [LetterTypeController::class, 'destroy'])->name('delete');
            Route::get('/export-excel/data',[LetterTypeController::class, 'exportExcel'])->name('export-excel');
            Route::get('/detail/{id}',[LetterTypeController::class, 'show'])->name('print');
            Route::get('/pdf/{id}',[LetterTypeController::class,'pdf'])->name('pdf');
            Route::get('/download/{id}',[LetterTypeController::class, 'downloadPDF'])->name('download');
        });

        Route::prefix('/surat')->name('surat.')->group(function(){
            Route::get('/',[LetterController::class,'indexSurat'])->name('index');
            Route::get('/create',[LetterController::class,'create'])->name('create');
            Route::post('/store',[LetterController::class,'store'])->name('store');
            Route::get('/{id}', [LetterController::class, 'show'])->name('detail');
            Route::get('/edit/{id}',[LetterController::class,'edit'])->name('edit');
            Route::patch('/update/{id}',[LetterController::class,'update'])->name('update');
            Route::delete('/delete/{id}', [LetterController::class, 'destroy'])->name('delete');
            Route::get('/export-excel/data',[LetterController::class, 'exportExcel'])->name('export-excel');
        });

        Route::prefix('/restore')->name('restore.')->group(function(){
            Route::get('/surat',[LetterController::class,'surat'])->name('surat');
            Route::get('/surat/{id}',[LetterController::class,'surats'])->name('surats');
            Route::delete('/surat/{id}',[LetterController::class,'deletesurat'])->name('deletesurat');
            Route::get('/klasifikasi',[LetterTypeController::class,'klasifikasi'])->name('klasifikasi');
            Route::get('/klasifikasi/{id}',[LetterTypeController::class,'klasifikasis'])->name('klasifikasis');
            Route::delete('/klasifikasi/{id}',[LetterTypeController::class,'deletetype'])->name('deletetype');
            Route::get('/user',[UserController::class,'user'])->name('user');
            Route::get('/user/{id}',[UserController::class,'users'])->name('users');
            Route::delete('/user/{id}',[UserController::class,'deleteuser'])->name('deleteuser');
        });
    });
});

Route::middleware(['IsLogin','IsGuru'])->group(function(){
    Route::prefix('/guru')->name('guru.')->group(function(){
        Route::prefix('/data')->name('data.')->group(function(){
            Route::get('/detail/{id}', [LetterController::class,'show'])->name('detail');
            Route::get('/',[LetterController::class,'indexSurat'])->name('index');
            Route::get('/surat',[LetterController::class,'indexGuru'])->name('index');
            Route::get('/edit/{id}',[ResultController::class,'edit'])->name('edit');
            Route::post('/store',[ResultController::class,'store'])->name('store');
        });
    });
});



Route::get('/error-permission',function (){
    return view('errors.permission');
})->name('error.permission');
