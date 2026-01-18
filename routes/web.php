<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    DashboardController, UserController, ProfileController, ProductController,
    ProductCategoryController, UnitController, SupplierController, CustomerController,
    WarehouseController, InventoryController, PurchaseRequestController,
    PurchaseOrderController, GoodsReceiptController, PurchaseInvoiceController,
    SalesInvoiceController, SalesOrderController, DeliveryOrderController,
    ArPaymentController, RoleController
};

Route::get('/', fn() => redirect()->route('dashboard'));

Route::middleware(['auth'])->group(function () {

    // --- 0. DASHBOARD & PROFILE ---
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    Route::prefix('profile')->name('profile.')->group(function () {
        Route::get('/', [ProfileController::class, 'edit'])->name('edit');
        Route::patch('/', [ProfileController::class, 'update'])->name('update');
        Route::delete('/', [ProfileController::class, 'destroy'])->name('destroy');
    });

    // --- 1. MASTER DATA (Dibatasi permission master.view) ---
    Route::middleware(['permission:master.view'])->group(function () {
        Route::resource('products', ProductController::class);
        Route::resource('suppliers', SupplierController::class);
        Route::resource('customers', CustomerController::class);
        Route::resource('warehouses', WarehouseController::class);
        Route::resource('product-categories', ProductCategoryController::class);
        Route::resource('units', UnitController::class);
    });

    // --- 2. INVENTORY MANAGEMENT ---
    Route::prefix('inventory')->name('inventory.')->group(function () {
        Route::get('/stocks', [InventoryController::class, 'index'])->name('index');
        Route::get('/movements', [InventoryController::class, 'movements'])->name('movements');
        
        // Hanya Admin & Warehouse yang bisa entry/transfer
        Route::middleware(['role:Admin|Warehouse'])->group(function () {
            Route::get('/entry', [InventoryController::class, 'create'])->name('create');
            Route::post('/entry', [InventoryController::class, 'store'])->name('store');
            Route::get('/transfer', [InventoryController::class, 'transfer'])->name('transfer');
            Route::post('/transfer', [InventoryController::class, 'storeTransfer'])->name('store-transfer');
        });
    });

    // --- 3. PROCUREMENT ---
    Route::resource('purchase-requests', PurchaseRequestController::class);
    Route::resource('purchase-orders', PurchaseOrderController::class);
    Route::resource('goods-receipts', GoodsReceiptController::class);

    // --- 4. SALES & DISTRIBUTION ---
    Route::prefix('sales-orders')->name('sales-orders.')->group(function () {
        Route::get('/', [SalesOrderController::class, 'index'])->name('index');
        Route::get('/create', [SalesOrderController::class, 'create'])->name('create');
        Route::post('/store', [SalesOrderController::class, 'store'])->name('store');
        Route::get('/{id}', [SalesOrderController::class, 'show'])->name('show');
        
        // Hanya Admin & Manager yang bisa confirm/cancel
        Route::middleware(['role:Admin|Manager'])->group(function () {
            Route::post('/{id}/confirm', [SalesOrderController::class, 'confirm'])->name('confirm');
            Route::post('/{id}/cancel', [SalesOrderController::class, 'cancel'])->name('cancel');
        });
    });

    Route::resource('delivery-orders', DeliveryOrderController::class);

    // --- 5. FINANCE (AP/AR) ---
    Route::middleware(['role:Admin|Finance'])->group(function () {
        Route::resource('purchase-invoices', PurchaseInvoiceController::class);
        Route::resource('sales-invoices', SalesInvoiceController::class);
        Route::resource('ar-payments', ArPaymentController::class);
    });

    // --- 6. ADMINISTRATION (Hanya Admin) ---
    Route::middleware(['role:Admin'])->group(function () {
        Route::resource('users', UserController::class);
        Route::resource('roles', RoleController::class);
    });
});

require __DIR__ . '/auth.php';