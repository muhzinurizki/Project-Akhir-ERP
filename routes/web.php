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

    // --- 1. MASTER DATA ---
    Route::resource('products', ProductController::class);
    Route::resource('suppliers', SupplierController::class);
    Route::resource('customers', CustomerController::class);
    Route::resource('warehouses', WarehouseController::class);
    Route::resource('product-categories', ProductCategoryController::class);
    Route::resource('units', UnitController::class);

    // --- 2. INVENTORY MANAGEMENT ---
    Route::prefix('inventory')->name('inventory.')->group(function () {
        Route::get('/stocks', [InventoryController::class, 'index'])->name('index');
        Route::get('/movements', [InventoryController::class, 'movements'])->name('movements');
        Route::get('/movements/{id}', [InventoryController::class, 'detail'])->name('detail');
        
        // Stock Entry & Transfer (Staff & Admin Only)
        Route::middleware('role:super_admin,staff')->group(function () {
            Route::get('/entry', [InventoryController::class, 'create'])->name('create');
            Route::post('/entry', [InventoryController::class, 'store'])->name('store');
            Route::get('/transfer', [InventoryController::class, 'transfer'])->name('transfer');
            Route::post('/transfer', [InventoryController::class, 'storeTransfer'])->name('store-transfer');
        });
    });

    // --- 3. PROCUREMENT (PURCHASING) ---
    // Purchase Requests
    Route::prefix('purchase-requests')->name('purchase-requests.')->group(function () {
        Route::post('{purchaseRequest}/submit', [PurchaseRequestController::class, 'submit'])->name('submit');
        Route::post('{purchaseRequest}/approve', [PurchaseRequestController::class, 'approve'])->name('approve');
        Route::post('{purchaseRequest}/reject', [PurchaseRequestController::class, 'reject'])->name('reject');
        Route::patch('{purchase_request}/update-status', [PurchaseRequestController::class, 'updateStatus'])->name('update-status');
    });
    Route::resource('purchase-requests', PurchaseRequestController::class)->only(['index', 'create', 'store', 'show']);

    // Purchase Orders
    Route::prefix('purchase-orders')->name('purchase-orders.')->group(function () {
        Route::post('{purchaseOrder}/submit', [PurchaseOrderController::class, 'submit'])->name('submit');
        Route::post('{purchaseOrder}/approve', [PurchaseOrderController::class, 'approve'])->name('approve');
    });
    Route::resource('purchase-orders', PurchaseOrderController::class)->only(['index', 'create', 'store', 'show']);

    // Goods Receipt (Gudang)
    Route::resource('goods-receipts', GoodsReceiptController::class)->only(['index', 'create', 'store', 'show']);

    // --- 4. SALES & DISTRIBUTION ---
    // Sales Orders
    Route::prefix('sales-orders')->name('sales-orders.')->group(function () {
        Route::get('/', [SalesOrderController::class, 'index'])->name('index');
        Route::get('/{id}', [SalesOrderController::class, 'show'])->name('show');

        Route::middleware('role:super_admin,staff')->group(function () {
            Route::get('/create', [SalesOrderController::class, 'create'])->name('create');
            Route::post('/store', [SalesOrderController::class, 'store'])->name('store');
        });

        Route::middleware('role:super_admin,manager')->group(function () {
            Route::post('/{id}/confirm', [SalesOrderController::class, 'confirm'])->name('confirm');
            Route::post('/{id}/cancel', [SalesOrderController::class, 'cancel'])->name('cancel');
        });
    });

    // Delivery Orders
    Route::prefix('delivery-orders')->name('delivery-orders.')->group(function () {
        Route::get('/', [DeliveryOrderController::class, 'index'])->name('index');
        Route::get('/{id}', [DeliveryOrderController::class, 'show'])->name('show');

        Route::middleware('role:super_admin,staff')->group(function () {
            Route::get('/create/{so_id}', [DeliveryOrderController::class, 'create'])->name('create');
            Route::post('/store', [DeliveryOrderController::class, 'store'])->name('store');
        });
    });

    // --- 5. FINANCE (AP/AR) ---
    Route::resource('purchase-invoices', PurchaseInvoiceController::class);
    Route::resource('sales-invoices', SalesInvoiceController::class);
    
    Route::prefix('ar-payments')->name('ar-payments.')->group(function () {
        Route::post('/', [ArPaymentController::class, 'store'])->name('store');
        Route::delete('/{arPayment}', [ArPaymentController::class, 'destroy'])->name('destroy');
    });

    // --- 6. ADMINISTRATION ---
    Route::middleware('role:super_admin')->group(function () {
        Route::resource('users', UserController::class);
    });
});

require __DIR__ . '/auth.php';