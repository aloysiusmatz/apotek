<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\DeveloperController;
use App\Http\Controllers\CompaniesController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\RolesPermissionController;
use App\Http\Controllers\ItemsController;

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

Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');

Route::middleware(['auth:sanctum', 'verified'])->get('/home', [HomeController::class, 'index']);
Route::middleware(['auth:sanctum', 'verified'])->get('/items', [ItemsController::class, 'index']);
Route::middleware(['auth:sanctum', 'verified'])->get('/developer', [DeveloperController::class, 'index'])->name('developer');
Route::middleware(['auth:sanctum', 'verified'])->get('/developer/companies', [CompaniesController::class, 'index'])->name('developer.companies');
Route::middleware(['auth:sanctum', 'verified'])->get('/developer/users', [UsersController::class, 'index'])->name('developer.users');
Route::middleware(['auth:sanctum', 'verified'])->get('/developer/rolespermission', [RolesPermissionController::class, 'index'] )->name('developer.rolespermission');
// Route::resource('developer/companies', CompaniesController::class);
// Route::get('/developer/companies', \App\Http\Livewire\CompaniesView::class);

