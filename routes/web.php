<?php

use App\Http\Controllers\API\OrderController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\ChartController;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\SaleController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\StoreController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\TransferController;
use App\Http\Controllers\WroteOffController;
use App\Models\Inventory;
use App\Models\Item;
use App\Models\Product;
use App\Models\Purchase;
use App\Models\Sale;
use App\Models\Store;
use App\Models\Supplier;
use App\Models\Transaction;
use App\Models\Transfer;
use App\Models\User;
use App\Models\WroteOff;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Razorpay\Api\Order;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

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
Route::get('/products', function () {
    $products = in_array('admin', Auth::user()->roles->pluck('name')->toArray()) ? Product::with(['inventory.item'])->paginate(20) : Store::where('name', Auth::user()->permissions[0]->name)->first()->products->load(['inventory.item'])->paginate(20); 
    $transfers = in_array('admin', Auth::user()->roles->pluck('name')->toArray()) ? Transfer::with(['destination', 'inventory.item'])->paginate(20) : Transfer::whereHas('destination', function($q)
    {
        $q->where('name',  Auth::user()->permissions[0]->name)->where('type', 'toproduct');
    })->with(['inventory.item', 'destination'])->paginate(20);
    
    return Inertia::render('Products',['products' => $products,'stores' => Store::all(), 'transfers' => $transfers]);
})->middleware(['auth', 'verified'])->name('products');

Route::get('/orders', function () {
    return Inertia::render('Orders', ['orders' => Sale::paginate(20)]);
})->middleware(['auth', 'verified'])->name('orders');

Route::get('/users', function () {
    $users = User::whereHas('roles', function($q){
        $q->where('name', '!=', 'customer');
    })->with('roles')->paginate(20);
    return Inertia::render('Users', ['users' => $users, 'roles' => Role::all(), 'permissions' => Permission::all()]);
})->middleware(['auth', 'verified'])->name('users');

Route::get('/customers', function () {
    $users = User::whereHas('roles', function($q){
        $q->where('name', 'customer');
    })->with('roles')->paginate(20);
    return Inertia::render('Customers', ['users' => $users, 'roles' => Role::all(), 'permissions' => Permission::all()]);
})->middleware(['auth', 'verified'])->name('customers');

Route::get('/', function () {
    return Inertia::render('Statistics');
})->middleware(['auth', 'verified'])->name('statistics');

Route::get('/transactions', function () {
    return Inertia::render('Transactions', ['transactions' => Transaction::paginate(20)]);
})->middleware(['auth', 'verified'])->name('transactions');


Route::get('/suppliers', function () {
    return Inertia::render('Suppliers', ['suppliers' => Supplier::paginate(20)]);
})->middleware(['auth', 'verified'])->name('suppliers');

Route::get('/items', function () {
    return Inertia::render('Items', ['items' => Item::paginate(20)]);
})->middleware(['auth', 'verified'])->name('items');

Route::get('/purchase', function () {
    return Inertia::render('Purchase', ['purchases' => Purchase::paginate(20), 'suppliers' => Supplier::all(), 'items' => Item::all()]);
})->middleware(['auth', 'verified'])->name('purchase');

Route::get('/inventories', function () {
    $transfers = Transfer::whereHas('destination', function($q)
    {
        $q->where('type', 'toinventory');
    })->with(['destination', 'inventory', 'inventory.item']);
    return Inertia::render('Inventory', ['inventories' => Inventory::with(['item'])->paginate(20), 'stores' => Store::all(), 'transfers' => Transfer::with(['destination', 'inventory.item'])->paginate(20)]);
})->middleware(['auth', 'verified'])->name('inventories');

Route::get('/store', function () {
    return Inertia::render('Store', ['stores' => Store::paginate(20)]);
})->middleware(['auth', 'verified'])->name('store');

Route::get('/writeoff', function (){
    return Inertia::render('WriteOff', ['inventories' => Inventory::all()->load('item'), 'products' => Product::all()->load(['inventory.item']), 'stores' => Store::all()]);
})->middleware(['auth', 'verified'])->name('writeoff');

Route::controller(PurchaseController::class)->group(function (){
    Route::post('admin/purchase/add', 'create');
    Route::post('admin/purchase/{purchase:id}/delete', 'delete');
});

Route::controller(StoreController::class)->group(function (){
    Route::post('admin/store/add', 'create');
    Route::post('admin/store/{store:id}/update', 'update');
    Route::post('admin/store/{store:id}/delete', 'delete');
});

Route::controller(InventoryController::class)->group(function (){
    Route::post('admin/inventory/{inventory:id}/update', 'update');
    Route::post('admin/inventory/{inventory:id}/delete', 'delete');
});

Route::controller(ProductController::class)->group(function (){
    Route::post('/product/transfer', 'transfer');
    Route::post('admin/product/{product:id}/update', 'update');
    Route::post('admin/product/{product:id}/delete', 'delete');
});

Route::controller(TransferController::class)->group(function (){
    Route::post('admin/transfer', 'create');
    Route::post('admin/transfer/{transfer:id}/accept', 'accept');
});

Route::controller(WroteOffController::class)->group(function (){
    Route::post('admin/writeoff', 'create');
    Route::post('admin/writeoff/{wroteoff:id}/update', 'update');
    Route::post('admin/writeoff/{wroteoff:id}/delete', 'delete');
    Route::get('admin/wroteoff/items', 'wroteoffs');
});

Route::controller(RegisteredUserController::class)->group(function (){
    Route::post('admin/users/{user:id}/update', 'update');
    Route::post('admin/users/{user:id}/delete', 'delete');
    Route::post('admin/users/new', 'store');
});

Route::controller(SupplierController::class)->group(function (){
    Route::post('admin/supplier/{supplier:id}/update', 'update');
    Route::post('admin/supplier/{supplier:id}/delete', 'delete');
    Route::post('admin/supplier/add', 'create');
});

Route::controller(ItemController::class)->group(function (){
    Route::post('admin/items/{item:id}/update', 'update');
    Route::post('admin/items/{item:id}/delete', 'delete');
    Route::post('admin/items/add', 'create');
});

Route::controller(SaleController::class)->middleware(['auth', 'verified'])->group(function (){
    // Route::post('admin/sales/{sale:id}/update', 'update');
    Route::post('admin/sales/{sale:id}/delete', 'delete');
});

Route::controller(SearchController::class)->middleware(['auth', 'verified'])->group(function (){
    Route::get('admin/search', 'search');
});

Route::controller(OrderController::class)->middleware(['auth', 'verified'])->group(function (){
    Route::get('admin/export/sale', 'export');
});

Route::controller(ChartController::class)->middleware(['auth', 'verified'])->group(function (){
    Route::get('admin/chart/sales/month', 'orderMonth');
    Route::get('admin/chart/sales/revenue', 'orderRevenue');
    Route::get('admin/chart/sales/daily', 'orderDaily');
});
require __DIR__.'/auth.php';
