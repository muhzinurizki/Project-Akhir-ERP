<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
  UserController,
  ProfileController,
  ProductController,
  SupplierController,
  WarehouseController,
  InventoryController,
  StockController,
  PurchaseRequestController,
  PurchaseOrderController,
  GoodsReceiptController,
  AccountsPayableController,
  ApPaymentController, // Pastikan ini sudah dibuat
  RoleController
};

Route::get('/', function () {
  return redirect()->route('dashboard');
});

Route::middleware(['auth'])->group(function () {

  // --- DASHBOARD ---
  Route::get('/dashboard', fn() => view('dashboard.index'))->name('dashboard');

  // --- PROFILE ---
  Route::prefix('profile')->name('profile.')->group(function () {
    Route::get('/', [ProfileController::class, 'edit'])->name('edit');
    Route::patch('/', [ProfileController::class, 'update'])->name('update');
    Route::delete('/', [ProfileController::class, 'destroy'])->name('destroy');
  });

  // --- MASTER DATA ---
  Route::resource('products', ProductController::class);
  Route::resource('suppliers', SupplierController::class);
  Route::resource('warehouses', WarehouseController::class);

  // Inventory & Stock
  Route::prefix('inventory')->name('inventory.')->group(function () {
    // Dashboard Saldo
    Route::get('/stocks', [InventoryController::class, 'index'])->name('index');

    // Stock In (Barang Masuk)
    Route::get('/stock-in', [InventoryController::class, 'createIn'])->name('create-in'); // FIX: Tambahkan name ini
    Route::post('/stock-in', [InventoryController::class, 'storeIn'])->name('store-in');

    // Stock Out (Barang Keluar)
    Route::get('/stock-out', [InventoryController::class, 'createOut'])->name('create-out'); // FIX: Tambahkan name ini
    Route::post('/stock-out', [InventoryController::class, 'storeOut'])->name('store-out');

    // Histori / Movements (Jika ada)
    Route::get('/movements', [InventoryController::class, 'movements'])->name('movements');
  });

  // --- PROCUREMENT (Alur Pembelian) ---
  // Purchase Request
  Route::resource('purchase-requests', PurchaseRequestController::class)->only(['index', 'create', 'store', 'show']);
  Route::post('purchase-requests/{purchaseRequest}/submit', [PurchaseRequestController::class, 'submit'])->name('purchase-requests.submit');
  Route::post('purchase-requests/{purchaseRequest}/approve', [PurchaseRequestController::class, 'approve'])->name('purchase-requests.approve');
  Route::post('purchase-requests/{purchaseRequest}/reject', [PurchaseRequestController::class, 'reject'])->name('purchase-requests.reject');

  // Purchase Order
  Route::resource('purchase-orders', PurchaseOrderController::class)->only(['index', 'create', 'store', 'show']);
  Route::post('purchase-orders/{purchaseOrder}/submit', [PurchaseOrderController::class, 'submit'])->name('purchase-orders.submit');
  Route::post('purchase-orders/{purchaseOrder}/approve', [PurchaseOrderController::class, 'approve'])->name('purchase-orders.approve');

  // Goods Receipt (Penerimaan Barang)
  Route::resource('goods-receipts', GoodsReceiptController::class)->only(['index', 'create', 'store', 'show']);

  // --- FINANCE (Hutang & Pembayaran) ---
  Route::resource('accounts-payables', AccountsPayableController::class)->only(['index', 'show']);
  Route::resource('ap-payments', ApPaymentController::class);

  // --- ADMINISTRATION (Khusus Admin) ---
  Route::middleware(['role:Admin'])->group(function () {
    Route::resource('users', UserController::class);
    Route::resource('roles', RoleController::class);
  });

});

require __DIR__ . '/auth.php';