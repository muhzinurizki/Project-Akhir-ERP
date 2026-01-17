<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
  DashboardController,
  UserController,
  ProfileController,
  ProductController,
  ProductCategoryController,
  UnitController,
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
  Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

  // --- PROFILE ---
  Route::prefix('profile')->name('profile.')->group(function () {
    Route::get('/', [ProfileController::class, 'edit'])->name('edit');
    Route::patch('/', [ProfileController::class, 'update'])->name('update');
    Route::delete('/', [ProfileController::class, 'destroy'])->name('destroy');
  });

  // --- MASTER DATA ---
  Route::resource('products', ProductController::class);
  Route::resource('suppliers', SupplierController::class);
  Route::resource('customers', CustomerController::class);
  Route::resource('warehouses', WarehouseController::class);
  Route::resource('product-categories', ProductCategoryController::class);
  Route::resource('units', UnitController::class);

  // --- INVENTORY & STOCK ---
  Route::prefix('inventory')->name('inventory.')->group(function () {
    // Menampilkan Saldo Stok (Index)
    Route::get('/stocks', [InventoryController::class, 'index'])->name('index');

    // Form Input Stok (Single Entry untuk IN/OUT/ADJUST)
    Route::get('/entry', [InventoryController::class, 'create'])->name('create');
    Route::post('/entry', [InventoryController::class, 'store'])->name('store');

    // Histori Pergerakan (Stock Ledger / Kartu Stok)
    // Kita arahkan 'movements' ke detail produk tertentu agar lebih spesifik
    Route::get('/movements/{id}', [InventoryController::class, 'detail'])->name('detail');

    // Jika Anda ingin halaman yang menampilkan SEMUA pergerakan dari SEMUA produk:
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
