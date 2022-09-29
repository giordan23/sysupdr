<?php

use App\Http\Controllers\AdviserController;
use App\Http\Controllers\AuthorController;
use App\Http\Controllers\CertificateController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('welcome');
});


Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Auth::routes();


Route::group(['middleware' => 'auth'], function () {
	Route::resource('user', 'App\Http\Controllers\UserController', ['except' => ['show']]);
	Route::get('profile', ['as' => 'profile.edit', 'uses' => 'App\Http\Controllers\ProfileController@edit']);
	Route::put('profile', ['as' => 'profile.update', 'uses' => 'App\Http\Controllers\ProfileController@update']);
    Route::resource('adviser', AdviserController::class);
    Route::post('adviserImport', [AdviserController::class, 'importAdviser'])->name('adviser.import.excel');

    Route::resource('author', AuthorController::class);
    Route::post('report', [AuthorController::class, 'report'])->name('author.report');
    Route::resource('certificate', CertificateController::class);
    Route::get('reportCertificate', [CertificateController::class, 'reportCertificate'])->name('certificate.report');

	Route::put('profile/password', ['as' => 'profile.password', 'uses' => 'App\Http\Controllers\ProfileController@password']);
});

