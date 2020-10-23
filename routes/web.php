<?php

use App\Http\Controllers\Album\CreateController as AlbumCreateController;
use App\Http\Controllers\Album\ShowController as AlbumShowController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Dashboard\IndexController as DashboardIndexController;
use App\Http\Controllers\Family\CreateController as FamilyCreateController;
use App\Http\Controllers\IndexController;
use App\Mail\InviteToFamily;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;

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

// index
Route::get('/', [IndexController::class, 'index'])->name('index');

// guest
Route::group(['as' => 'auth.', 'middleware' => 'guest'], function() {
	// register
	Route::get('/register', [RegisterController::class, 'index'])->name('register');
	Route::post('/register', [RegisterController::class, 'create'])->name('register');
	// login
	Route::get('/login', [LoginController::class, 'index'])->name('login');
	Route::post('/login', [LoginController::class, 'create'])->name('login');
});

// auth
Route::group(['middleware' => 'auth'], function() {
	// dashboard
	Route::get('/dashboard', DashboardIndexController::class)->name('dashboard');
	// families
	Route::group(['as' => 'family.', 'prefix' => 'family'], function() {
		// create
		Route::get('/create', FamilyCreateController::class)->name('create');
	});
	// albums
	Route::group(['as' => 'album.', 'prefix' => 'album'], function() {
		Route::get('/create', AlbumCreateController::class)->name('create');
		Route::get('/{album_slug}', AlbumShowController::class)->name('show');
	});
});

Route::get('/mailable', function () {
	return new InviteToFamily('The Jones Family', Str::random(15));
});
