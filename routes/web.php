<?php

use App\Http\Controllers\Album\CreateController as AlbumCreateController;
use App\Http\Controllers\Album\IndexController as AlbumIndexController;
use App\Http\Controllers\Album\ShowController as AlbumShowController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Dashboard\IndexController as DashboardIndexController;
use App\Http\Controllers\Family\CreateController as FamilyCreateController;
use App\Http\Controllers\Family\IndexController as FamilyIndexController;
use App\Http\Controllers\Family\UpdateController as FamilyUpdateController;
use App\Http\Controllers\IndexController;
use App\Http\Controllers\Member\CreateController as MemberCreateController;
use App\Http\Controllers\Member\IndexController as MemberIndexController;
use App\Http\Controllers\Member\ShowController as MemberShowController;
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
	Route::get('/dashboard', DashboardIndexController::class)->middleware(['has-permission:view'])->name('dashboard');
	// logout
	Route::post('/logout', [LoginController::class, 'delete'])->name('logout');
	// family
	Route::group(['as' => 'family.', 'prefix' => 'family'], function() {
		Route::get('/', FamilyIndexController::class)->middleware(['has-permission:admin'])->name('index');
		Route::get('/create', FamilyCreateController::class)->name('create');
		Route::patch('/{family_id}', [FamilyUpdateController::class, 'update'])->name('update');
	});
	// album
	Route::group(['as' => 'album.', 'prefix' => 'album'], function() {
		Route::get('/', AlbumIndexController::class)->middleware(['has-permission:view'])->name('index');
		Route::get('/create', AlbumCreateController::class)->middleware(['has-permission:upload'])->name('create');
		Route::get('/{album_slug}', AlbumShowController::class)->middleware(['has-permission:view'])->name('show');
	});
	// member
	Route::group(['as' => 'member.', 'prefix' => 'member'], function() {
		Route::get('/', MemberIndexController::class)->middleware(['has-permission:view'])->name('index');
		Route::get('/create', MemberCreateController::class)->middleware(['has-permission:upload'])->name('create');
		Route::get('/{member_id}', MemberShowController::class)->middleware(['has-permission:view'])->name('show');
	});
});

Route::get('/mailable', function () {
	return new \App\Mail\InviteToFamily('The Jones Family', 'test');
});
