<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\InwardController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\LedgerController;
use App\Http\Controllers\MovementController;
use App\Http\Controllers\OutwardController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\SessionController;
use App\Http\Controllers\TestController;
use App\Models\Item;
use Illuminate\Support\Facades\Route;


Route::get('/search', [SearchController::class, 'index'])->name('search');


Route::middleware('auth')->group(function () {
Route::get('/', function () {
  return view('welcome');
})->name('home');





Route::prefix('/inventory')->name('inventory.')->group(function () {

Route::get('/items',[InventoryController::class,"items"])->name('items');
  
Route::get('/items/show/{item}',[InventoryController::class,"show"])->name('items.show');
  
Route::get('/items/create',[ItemController::class,"create"])->name('items.create');
  Route::post('/items/store',[ItemController::class,"store"])->name('items.store');
      Route::delete('/items/delete',[ItemController::class,"delete"])->name('items.delete');
      

Route::get('/categories',[InventoryController::class,"categories"])->name('categories');
Route::post('/categories/store',[CategoryController::class,'store'])->name('categories.store');
Route::put('/categories/{category}',[CategoryController::class,'update'])->name('categories.update');

Route::delete('/categories/destroy/{category}',[CategoryController::class,"destroy"])->name('categories.destroy');



});

Route::prefix('/inwards')->group(function(){

Route::get('/',[InwardController::class,'index'])->name('inwards');
  Route::get('/create',[InwardController::class,'create'])->name('inwards.create');
  Route::post('/store',[InwardController::class,'store'])->name('inwards.store');
  Route::get('/show/{inward}',[InwardController::class,'show'])->name('inwards.show');

});

Route::prefix('/outwards')->group(function(){
Route::get('/',[OutwardController::class,'index'])->name('outwards');
Route::get('/create',[OutwardController::class,'create'])->name('outwards.create');
Route::post('/store',[OutwardController::class,'store'])->name('outwards.store');
Route::get('/show/{outward}',[OutwardController::class,'show'])->name('outwards.show');

});

Route::prefix("/ledgers")->group(function(){

  Route::get('/',[LedgerController::class,'index'])->name('ledgers');
  
  Route::get('/create',[LedgerController::class,'create'])->name('ledgers.create');
  Route::post('/store',[LedgerController::class,'store'])->name('ledgers.store');
  Route::get("edit/{ledger}",[LedgerController::class,"edit"])->name("ledgers.edit");
  Route::put("update/{ledger}",[LedgerController::class,'update'])->name('ledgers.update');
  Route::delete("destory/{ledger}",[LedgerController::class,'destory'])->name('ledgers.destory');
  });




Route::prefix('/movements')->group(function(){

Route::get("/",[MovementController::class,"index"])->name("movements");
Route::get("/create",[MovementController::class,"create"])->name("movements.create");
Route::post("/store",[MovementController::class,"store"])->name("movements.store");
Route::get("/show/{movement}",[MovementController::class,"show"])->name("movements.show");
      
});

});



Route::get("/login",[SessionController::class,'login'])->name('login');
Route::post("/logout",[SessionController::class,'destroy'])->name('logout');



Route::get('/test', function () {
    // return response()->json(['message' => 'API is working!']);
    $items = Item::all();
    return view("test",compact('items'));
});


// Route::get('/item-by-barcode/{barcode}', [ItemController::class, 'getByBarcode']);
// Route::get('/ledger/{ledger}', [ItemController::class, 'getbyledger']);

// Route::get('/ledger/{ledger}', [LedgerController::class, 'search']); // Ledger search API
// Route::get('/barcode/{barcode}', [ItemController::class, 'searchByBarcode']);


Route::get('/ledger/{ledger}', [LedgerController::class, 'search']);
Route::get('/items/{barcode}', [ItemController::class, 'findByBarcode']);




Route::get('/supplier/{ledger}', [LedgerController::class, 'search']);
Route::get('/inward/{barcode}', [InwardController::class, 'findByBarcode']);


Route::get('/outward/{barcode}', [OutwardController::class, 'findByBarcode']);


Route::get('/customer/{query}', [OutwardController::class, 'search']);

Route::get('/test/create', [TestController::class, 'create'])->name('test.create');
Route::post('/test/store', [TestController::class, 'store'])->name('test.store');



// Route::get('/item-by-barcode/{barcode}', [ItemController::class, 'getByBarcode']);
// Route::get('/items', [\App\Http\Controllers\Api\ItemController::class, 'showByBarcode']); 
// Route::get('/ledgers', [\App\Http\Controllers\Api\LedgerController::class, 'search']); 