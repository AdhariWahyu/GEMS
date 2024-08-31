<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\Presensi;
use App\Http\Controllers\FormController;



Route::get('preview-form/{id}', [FormController::class, 'preview'])->name('preview-form');
Route::get('download-form/{id}', [FormController::class, 'download'])->name('download-form');

// Route::group(['middleware' => 'auth'], function() {
//     Route::get('presensi', Presensi::class)->name('presensi');
// })  COMING SOON!;

Route::get('/login', function() {
    return redirect('admin/login');
})->name('login');

Route::get('/', function () {
    return redirect('/admin/login');
});
