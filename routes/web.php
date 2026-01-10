<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
  UserController,
  ProfileController,
  ProductController,
  SupplierController,
  CustomerController,
  WarehouseController,
  InventoryController,
  PurchaseRequestController,
  PurchaseOrderController,
  GoodsReceiptController,
  PurchaseInvoiceController,
  SalesInvoiceController,
  ArPaymentController,
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
  Route::resource('customers', CustomerController::class); // TAMBAHKAN INI
  Route::resource('warehouses', WarehouseController::class);

  // --- INVENTORY & STOCK ---
  Route::prefix('inventory')->name('inventory.')->group(function () {
    Route::get('/stocks', [InventoryController::class, 'index'])->name('index');
    Route::get('/stock-in', [InventoryController::class, 'createIn'])->name('create-in');
    Route::post('/stock-in', [InventoryController::class, 'storeIn'])->name('store-in');
    Route::get('/stock-out', [InventoryController::class, 'createOut'])->name('create-out');
    Route::post('/stock-out', [InventoryController::class, 'storeOut'])->name('store-out');
    Route::get('/movements', [InventoryController::class, 'movements'])->name('movements');
  });

  // --- PROCUREMENT (Alur Pembelian) ---
  Route::prefix('purchase-requests')->name('purchase-requests.')->group(function () {
    Route::post('{purchaseRequest}/submit', [PurchaseRequestController::class, 'submit'])->name('submit');
    Route::post('{purchaseRequest}/approve', [PurchaseRequestController::class, 'approve'])->name('approve');
    Route::post('{purchaseRequest}/reject', [PurchaseRequestController::class, 'reject'])->name('reject');
    Route::patch('{purchase_request}/update-status', [PurchaseRequestController::class, 'updateStatus'])->name('update-status');
  });
  Route::resource('purchase-requests', PurchaseRequestController::class)->only(['index', 'create', 'store', 'show']);

  Route::resource('purchase-orders', PurchaseOrderController::class)->only(['index', 'create', 'store', 'show']);
  Route::post('purchase-orders/{purchaseOrder}/submit', [PurchaseOrderController::class, 'submit'])->name('purchase-orders.submit');
  Route::post('purchase-orders/{purchaseOrder}/approve', [PurchaseOrderController::class, 'approve'])->name('purchase-orders.approve');

  Route::resource('goods-receipts', GoodsReceiptController::class)->only(['index', 'create', 'store', 'show']);

  // --- FINANCE (Hutang & Piutang) ---
  // Account Payable (Hutang)
  Route::resource('purchase-invoices', PurchaseInvoiceController::class);
  Route::resource('sales-invoices', SalesInvoiceController::class);

  // Account Receivable (Piutang)
  Route::post('/ar-payments', [ArPaymentController::class, 'store'])->name('ar-payments.store');
  Route::delete('/ar-payments/{arPayment}', [ArPaymentController::class, 'destroy'])->name('ar-payments.destroy');

  // Route::resource('sales-invoices', SalesInvoiceController::class);

  // --- ADMINISTRATION ---
  Route::middleware(['role:Admin'])->group(function () {
    Route::resource('users', UserController::class);
  });
});

require __DIR__ . '/auth.php';
