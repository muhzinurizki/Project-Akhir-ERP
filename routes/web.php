<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    DashboardController, UserController, ProfileController,
    ProductController, ProductCategoryController, UnitController,
    SupplierController, CustomerController, WarehouseController,
    InventoryController, PurchaseRequestController, PurchaseOrderController,
    GoodsReceiptController, PurchaseInvoiceController, SalesInvoiceController,
    SalesOrderController, DeliveryOrderController, ArPaymentController,
    RoleController
};
use App\Http\Controllers\QC\{QcInspectionController,QcReportController};
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
    Route::middleware(['permission:master.view'])->group(function () {
        Route::resource('products', ProductController::class);
        Route::resource('suppliers', SupplierController::class);
        Route::resource('customers', CustomerController::class);
        Route::resource('warehouses', WarehouseController::class);
        Route::resource('product-categories', ProductCategoryController::class);
        Route::resource('units', UnitController::class);
    });

    // --- 2. INVENTORY MANAGEMENT (Disederhanakan) ---
    Route::prefix('inventory')->name('inventory.')->group(function () {
        Route::get('/stocks', [InventoryController::class, 'index'])->name('index');
        Route::get('/stocks/{id}', [InventoryController::class, 'detail'])->name('detail');
        Route::get('/movements', [InventoryController::class, 'movements'])->name('movements');

        Route::middleware(['role:Admin|Warehouse'])->group(function () {
            Route::get('/entry', [InventoryController::class, 'create'])->name('create');
            Route::post('/entry', [InventoryController::class, 'store'])->name('store');
            Route::get('/transfer', [InventoryController::class, 'transfer'])->name('transfer');
            Route::post('/transfer', [InventoryController::class, 'storeTransfer'])->name('store-transfer');
        });
    });

    // --- 3. PROCUREMENT (PURCHASING) ---
    
    // Purchase Requests
    Route::prefix('purchase-requests')->name('purchase-requests.')->group(function () {
        Route::patch('{id}/update-status', [PurchaseRequestController::class, 'updateStatus'])->name('update-status');
        // Tambahan fitur submit jika diperlukan
        Route::post('{id}/submit', [PurchaseRequestController::class, 'submit'])->name('submit');
    });
    Route::resource('purchase-requests', PurchaseRequestController::class);

    // Purchase Orders (SOLUSI ERROR SIDEBAR)
    Route::resource('purchase-orders', PurchaseOrderController::class);
    Route::resource('goods-receipts', GoodsReceiptController::class);

    // --- 4. SALES & DISTRIBUTION ---
    Route::prefix('sales-orders')->name('sales-orders.')->group(function () {
        Route::middleware(['role:Admin|Manager'])->group(function () {
            Route::post('{id}/confirm', [SalesOrderController::class, 'confirm'])->name('confirm');
            Route::post('{id}/cancel', [SalesOrderController::class, 'cancel'])->name('cancel');
        });
    });
    Route::resource('sales-orders', SalesOrderController::class);
    Route::resource('delivery-orders', DeliveryOrderController::class);

    // --- 5. FINANCE (AP/AR) ---
    Route::middleware(['role:Admin|Finance'])->group(function () {
        Route::resource('purchase-invoices', PurchaseInvoiceController::class);
        Route::resource('sales-invoices', SalesInvoiceController::class);
        Route::resource('ar-payments', ArPaymentController::class);
    });

    // --- 6. ADMINISTRATION ---
    Route::middleware(['role:Admin'])->group(function () {
        Route::resource('users', UserController::class);
        Route::resource('roles', RoleController::class);
    });
     // --- 7. QUALITY CONTROL ---
    Route::middleware(['auth'])->prefix('qc')->group(function () {
        Route::get('/inspections', [QcInspectionController::class, 'index'])
            ->name('qc-inspections.index');

        Route::get('/inspections/{product}/create', [QcInspectionController::class, 'create'])
            ->name('qc-inspections.create');

        Route::post('/inspections', [QcInspectionController::class, 'store'])
            ->name('qc-inspections.store');

        Route::get('/reports', [QcReportController::class, 'index'])
            ->name('qc-reports.index');

        Route::get('/reports/export', [QcReportController::class, 'export'])
            ->name('qc-reports.export');
    });
});

require __DIR__ . '/auth.php';