<?php

use App\Http\Controllers\Backend\AdminController;
use App\Http\Controllers\Backend\CategoryController;
use App\Http\Controllers\Backend\CustomerController;
use App\Http\Controllers\Backend\DefaultController;
use App\Http\Controllers\Backend\InvoiceController;
use App\Http\Controllers\Backend\ProductController;
use App\Http\Controllers\Backend\PurchaseController;
use App\Http\Controllers\Backend\ServiceController;
use App\Http\Controllers\Backend\ServiceControllerrr;
use App\Http\Controllers\Backend\StockController;
use App\Http\Controllers\Backend\SupplierController;
use App\Http\Controllers\Backend\TaskController;
use App\Http\Controllers\Backend\TechnicalController;
use App\Http\Controllers\Backend\UnitController;
use App\Http\Controllers\Backend\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::get('/dashboard', function () {
    return view('layouts.index');
})->middleware(['auth', 'verified'])->name('dashboard');

// Route::middleware('auth')->group(function () {
//     Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
//     Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
//     Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
// });
Route::middleware('auth')->group(function () {

    // ESSAI CHARJS DATA
    Route::get('/home/{year}', [App\Http\Controllers\Backend\DashboardController::class, 'getDatajs']);

    Route::prefix('user')->controller(AdminController::class)->group(function () {
        Route::get('/profile/view', 'profile')->name('admin.profile');
        Route::get('/edit/profile', 'editProfile')->name('edit.profile');
        Route::post('/store/profile', 'storeProfile')->name('store.profile');
        Route::get('/change/password', 'changePassword')->name('change.password');
        Route::post('/update/password', 'updatePassword')->name('update.password');
    });

    // fournisseurs
    Route::prefix('supplier')->controller(SupplierController::class)->group(function () {
        Route::get('/view', 'index')->name('suppliers.index');
        Route::get('/create', 'create')->name('suppliers.create');
        Route::post('/store', 'store')->name('suppliers.store');
        Route::get('/edit/{id}', 'edit')->name('suppliers.edit');
        Route::post('/update/{id}', 'update')->name('suppliers.update');
        Route::get('/delete/{id}', 'delete')->name('suppliers.delete');
    });
    // clients
    Route::prefix('customers')->controller(CustomerController::class)->group(function () {
        Route::get('/view', 'index')->name('customers.index');
        Route::get('/create', 'create')->name('customers.create');
        Route::post('/store', 'store')->name('customers.store');
        Route::get('/edit/{id}', 'edit')->name('customers.edit');
        Route::post('/update/{id}', 'update')->name('customers.update');
        Route::get('/delete/{id}', 'delete')->name('customers.delete');
        Route::get('/credit', 'creditCustomer')->name('customers.credit');
        Route::get('/credit/pdf', 'creditCustomerPdf')->name('customers.credit.pdf');
        Route::get('/details/pdf/{id}', 'invoiceDetailsPdf')->name('invoices.details.pdf');
        Route::get('/paiement', 'paidCustomer')->name('customers.paid');
        Route::get('/paid/pdf', 'paidCustomerPdf')->name('customers.paid.pdf');
        Route::get('/bilan_client/rapport', 'wiseReport')->name('customers.wise.report');
        Route::get('/bilan_client/rapport_credit/pdf', 'wiseCredit')->name('customers.wise.credit.report');
        Route::get('/bilan_client/rapport_paye/pdf', 'wisePaid')->name('customers.wise.paid.report');

        Route::post('/payment', 'payment')->name('customers.payment.invoice');
    });

    // utilisateurs
    Route::prefix('utilisateurs')->controller(UserController::class)->group(function () {
        Route::get('/view', 'index')->name('users.index');
        Route::get('/create', 'create')->name('users.create');
        Route::post('/store', 'store')->name('users.store');
        Route::get('/edit/{id}', 'edit')->name('users.edit');
        Route::post('/update/{id}', 'update')->name('users.update');
        Route::get('/delete/{id}', 'delete')->name('users.delete');
    });

    // units
    Route::prefix('units')->controller(UnitController::class)->group(function () {
        Route::get('/view', 'index')->name('units.index');
        Route::get('/create', 'create')->name('units.create');
        Route::post('/store', 'store')->name('units.store');
        Route::get('/edit/{id}', 'edit')->name('units.edit');
        Route::post('/update/{id}', 'update')->name('units.update');
        Route::get('/delete/{id}', 'delete')->name('units.delete');
    });

    // category
    Route::prefix('category')->controller(CategoryController::class)->group(function () {
        Route::get('/view', 'index')->name('categories.index');
        Route::get('/create', 'create')->name('categories.create');
        Route::post('/store', 'store')->name('categories.store');
        Route::get('/edit/{id}', 'edit')->name('categories.edit');
        Route::post('/update/{id}', 'update')->name('categories.update');
        Route::get('/delete/{id}', 'delete')->name('categories.delete');
    });
    // Product
    Route::prefix('product')->controller(ProductController::class)->group(function () {
        Route::get('/view', 'index')->name('products.index');
        Route::get('/create', 'create')->name('products.create');
        Route::post('/store', 'store')->name('products.store');
        Route::get('/edit/{id}', 'edit')->name('products.edit');
        Route::post('/update/{id}', 'update')->name('products.update');
        Route::get('/delete/{id}', 'delete')->name('products.delete');
    });

    // Achat
    Route::prefix('achats')->controller(PurchaseController::class)->group(function () {
        Route::get('/view', 'index')->name('purchase.index');
        Route::get('/create', 'create')->name('purchase.create');
        Route::post('/store', 'store')->name('purchase.store');
        Route::get('/en attente', 'pendingList')->name('purchase.pending');
        Route::get('/approve/{id}', 'approveList')->name('purchase.approve');
        Route::get('/report', 'purchaseReport')->name('purchase.report');
        Route::get('/report/pdf', 'purchaseReportPdf')->name('purchase.report.pdf');


        Route::get('/edit/{id}', 'edit')->name('purchase.edit');
        // Route::post('/update/{id}', 'update')->name('purchase.update');
        // Route::get('/delete/{id}', 'delete')->name('purchase.delete');
    });


    // Facturation
    Route::prefix('facturation')->controller(InvoiceController::class)->group(function () {
        Route::get('/view', 'index')->name('invoice.index');
        Route::get('/create', 'create')->name('invoice.create');
        Route::post('/store', 'store')->name('invoice.store');
        Route::get('/en_attente', 'pendingList')->name('invoice.pending');
        Route::get('/approve/{id}', 'approveList')->name('invoice.approve');
        Route::post('/approve/store/{id}', 'approveStore')->name('invoice.approve.store');
        Route::get('/delete/{id}', 'delete')->name('invoice.delete');
        Route::get('/print/{id}', 'printInvoice')->name('invoice.print');
        Route::get('/rapport/quotidien', 'dailyReport')->name('invoice.daily.report');
        Route::get('/rapport/quotidien/pdf', 'dailyReportPdf')->name('invoice.daily.pdf');


        // Route::get('/edit/{id}', 'edit')->name('purchase.edit');
        // Route::post('/update/{id}', 'update')->name('purchase.update');
    });

    // Stock
    Route::prefix('stock')->controller(StockController::class)->group(function () {
        Route::get('/rapport', 'stockReport')->name('stock.report');
        Route::get('/rapport/pdf', 'stockReportPdf')->name('stock.report.pdf');
        Route::get('/rapport/fournisseur_prod', 'supplierProductWise')->name('stock.report.supplier_prod');
        Route::get('/rapport/fournisseur/pdf', 'supplierWisePdf')->name('stock.report.supplier.pdf');
        Route::get('/rapport/produit/pdf', 'productWisePdf')->name('stock.report.product.pdf');
    });

    // techniciens
    Route::prefix('techniciens')->controller(TechnicalController::class)->group(function () {
        Route::get('/view', 'index')->name('technical.index');
        Route::get('/create', 'create')->name('technical.create');
        Route::post('/store', 'store')->name('technical.store');
        Route::get('/edit/{id}', 'edit')->name('technical.edit');
        Route::post('/update/{id}', 'update')->name('technical.update');
        Route::get('/delete/{id}', 'delete')->name('technical.delete');
    });






    // SERVICE
    Route::prefix('service')->controller(ServiceController::class)->group(function () {
        Route::get('/view', 'index')->name('service.index');
        Route::get('/create', 'create')->name('service.create');
        Route::post('/store', 'store')->name('service.store');
        Route::get('/en_attente', 'pendingList')->name('service.pending');
        Route::get('/approve/{id}', 'approveList')->name('service.approve');
        Route::post('/approve/store/{id}', 'approveStore')->name('service.approve.store');
        Route::get('/delete/{id}', 'delete')->name('service.delete');
        Route::get('/print/{id}', 'printInvoice')->name('service.print');
        Route::get('/rapport/quotidien', 'dailyReport')->name('service.daily.report');
        Route::get('/rapport/quotidien/pdf', 'dailyReportPdf')->name('service.daily.pdf');


        // Route::get('/edit/{id}', 'edit')->name('purchase.edit');
        // Route::post('/update/{id}', 'update')->name('purchase.update');

        Route::get('/delete/{id}', 'delete')->name('service.delete');
    });




    // units
    Route::prefix('taches')->controller(TaskController::class)->group(function () {
        Route::get('/view', 'index')->name('task.index');
        Route::get('/create', 'create')->name('task.create');
        Route::post('/store', 'store')->name('task.store');
        Route::get('/edit/{id}', 'edit')->name('task.edit');
        Route::post('/update/{id}', 'update')->name('task.update');
        Route::get('/delete/{id}', 'delete')->name('task.delete');
    });

    //DefaultController
    Route::get('/get-category', [DefaultController::class, 'getCategory'])->name('get-category');
    Route::get('/get-product', [DefaultController::class, 'getProduct'])->name('get-product');
    Route::get('/get-stock', [DefaultController::class, 'getStock'])->name('check-product-stock');
    Route::get('payments', [DefaultController::class, 'getPayment'])->name('modalDetails');
    Route::post('/update-payment', [DefaultController::class, 'updatePayment'])->name('update-payment');


    // services
    Route::get('service_payments', [DefaultController::class, 'service_getPayment'])->name('service_modalDetails');
    Route::post('service/update-payment', [DefaultController::class, 'service_updatePayment'])->name('service_update-payment');
});








require __DIR__ . '/auth.php';
