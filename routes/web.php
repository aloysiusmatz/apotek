<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ItemsController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\ExportController;
use App\Http\Controllers\VendorsController;
use App\Http\Controllers\CompaniesController;
use App\Http\Controllers\DeveloperController;
use App\Http\Controllers\LocationsController;
use App\Http\Controllers\CategoriesController;
use App\Http\Controllers\SalesOrderController;
use App\Http\Controllers\SetCompanyController;
use App\Http\Controllers\MovementKeyController;
use App\Http\Controllers\ItemsMovementController;
use App\Http\Controllers\PurchaseOrderController;
use App\Http\Controllers\SalesOrderListController;
use App\Http\Controllers\RolesPermissionController;
use App\Http\Controllers\PurchaseOrderListController;
use App\Http\Controllers\PrintPurchaseOrderController;
use App\Http\Controllers\ReportItemsSummaryController;
use App\Http\Controllers\ReportItemsMovementController;

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
Route::middleware(['auth:sanctum', 'verified'])->get('/items', [ItemsController::class, 'index'])->name('items');
Route::middleware(['auth:sanctum', 'verified'])->get('/categories', [CategoriesController::class, 'index'])->name('categories');
Route::middleware(['auth:sanctum', 'verified'])->get('/locations', [LocationsController::class, 'index'])->name('locations');
Route::middleware(['auth:sanctum', 'verified'])->get('/vendors', [VendorsController::class, 'index'])->name('vendors');  
Route::middleware(['auth:sanctum', 'verified'])->get('/itemsmovement', [ItemsMovementController::class, 'index'])->name('itemsmovement');
Route::middleware(['auth:sanctum', 'verified'])->get('/purchaseorder', [PurchaseOrderController::class, 'index'])->name('purchaseorder');
Route::middleware(['auth:sanctum', 'verified'])->get('/purchaseorder_list', [PurchaseOrderListController::class, 'index'])->name('po_list');
Route::middleware(['auth:sanctum', 'verified'])->get('/purchaseorder/print/{po_show_id}', [PrintPurchaseOrderController::class, 'POPrint'])->name('po_print');
Route::middleware(['auth:sanctum', 'verified'])->get('/salesorder', [SalesOrderController::class, 'index'])->name('salesorder');
Route::middleware(['auth:sanctum', 'verified'])->get('/salesorder_list', [SalesOrderListController::class, 'index'])->name('so_list');
Route::middleware(['auth:sanctum', 'verified'])->get('/report/itemsmovement', [ReportItemsMovementController::class, 'index'])->name('report.itemsmovement');
Route::middleware(['auth:sanctum', 'verified'])->get('/report/itemssummary', [ReportItemsSummaryController::class, 'index'])->name('report.itemssummary');
// Route::middleware(['auth:sanctum', 'verified'])->get('/export', [ExportController::class, 'index'])->name('export');
Route::middleware(['auth:sanctum', 'verified'])->get('/setcompany', [SetCompanyController::class, 'index'])->name('setcompany');
Route::middleware(['auth:sanctum', 'verified'])->get('/developer', [DeveloperController::class, 'index'])->name('developer');
Route::middleware(['auth:sanctum', 'verified'])->get('/developer/companies', [CompaniesController::class, 'index'])->name('developer.companies');
Route::middleware(['auth:sanctum', 'verified'])->get('/developer/users', [UsersController::class, 'index'])->name('developer.users');
Route::middleware(['auth:sanctum', 'verified'])->get('/developer/rolespermission', [RolesPermissionController::class, 'index'] )->name('developer.rolespermission');
Route::middleware(['auth:sanctum', 'verified'])->get('/developer/movementkey', [MovementKeyController::class, 'index'] )->name('developer.movementkey');
// Route::resource('developer/companies', CompaniesController::class);
// Route::get('/developer/companies', \App\Http\Livewire\CompaniesView::class);

