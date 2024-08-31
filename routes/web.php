<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\Presensi;

// Route::group(['middleware' => 'auth'], function() {
//     Route::get('presensi', Presensi::class)->name('presensi');
// })  COMING SOON!;

Route::get('/login', function() {
    return redirect('admin/login');
})->name('login');

Route::get('/', function () {
    return redirect('/admin/login');
});
