<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\InwardController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\OutwardController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\SessionController;
use App\Http\Controllers\StockController;
use App\Http\Middleware\WarehouseAuth;
use App\Livewire\LoginForm;
use Illuminate\Auth\Authenticatable;
use Illuminate\Support\Facades\Route;


// Route::middleware(['auth:admin'])->prefix('admin')
// ->name("admin.")->group(function () {


// Route::middleware('auth')->prefix('/inventory')->name('inventory.')->group(function () {
//     Route::get('/items',[InventoryController::class,'items'])->name('items');
//  });

Route::middleware('auth')->group(function () {
Route::get('/', function () {
    return view('welcome');
})->name('home');





Route::prefix('/inventory')->name('inventory.')->group(function () {

   Route::get('/items',[InventoryController::class,"items"])->name('items');
    
    Route::get('/items/create',[ItemController::class,"create"])->name('items.create');
    Route::post('/items/store',[ItemController::class,"store"])->name('items.store');
        Route::delete('/items/delete',[ItemController::class,"delete"])->name('items.delete');

  Route::get('/categories',[InventoryController::class,"categories"])->name('categories');
  Route::get('/categories/create',[CategoryController::class,'create'])->name('categories.create');
  Route::post('/categories/store',[CategoryController::class,'store'])->name('categories.store');
  Route::delete('/categories/destroy',[CategoryController::class,"destroy"])->name('categories.destroy');

  Route::put('/categories/{category}',[CategoryController::class,'update'])->name('categories.update');

    
  Route::get('/movements',[CategoryController::class,'movements'])->name('movements');


});


Route::prefix('/inward')->name('inward.')->group(function () {

    Route::get('/items',[InwardController::class,'items'])->name('items');
     Route::get('/ledgers',[InwardController::class,'ledgers'])->name('ledgers');

});





Route::prefix('/outward')->name('outward.')->group(function () {

    Route::get('/items',[OutwardController::class,'items'])->name('items');
    
    Route::get('/ledgers',[OutwardController::class,'ledgers'])->name('ledgers');
});













});



Route::get("/login",[SessionController::class,'login'])->name('login');
Route::post("/logout",[SessionController::class,'destroy'])->name('logout');