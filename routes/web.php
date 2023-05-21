<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AccountsController;
use App\Http\Controllers\ContactsController;
use App\Http\Controllers\PropertyController;
use App\Http\Controllers\VendorController;
use App\Http\Controllers\ProductController;
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

// Route::get('/', function () {
//     return view('welcome');
// });
Route::get('/', [AuthController::class, 'login'])->name('login');
Route::get('actionlogin', [AuthController::class, 'login'])->name('login');
Route::post('actionlogin', [AuthController::class, 'actionlogin'])->name('actionlogin');


Route::group(['middleware' => 'auth'], function () {
    Route::get('home', [AuthController::class, 'index'])->name('home');//Dashboard
    Route::get('actionlogout', [AuthController::class, 'actionlogout'])->name('actionlogout');//Logouts
    
    //Account Part
    Route::get('accounts', [AccountsController::class, 'index'])->name('index');
    Route::get('accounts', [AccountsController::class, 'index'])->name('accounts.index');
    Route::get('accounts/contact/{id}', [AccountsController::class, 'contact'])->name('accounts.contact');
    Route::get('accounts/create', [AccountsController::class, 'create'])->name('create');
    Route::post('accounts/store', [AccountsController::class, 'store'])->name('accounts.store');
    Route::get('accounts/view/{id}', [AccountsController::class, 'view'])->name('view');
    Route::get('accounts/view/{id}', [AccountsController::class, 'contact'])->name('accounts.contact');
    Route::get('accounts/edit/{id}', [AccountsController::class, 'edit'])->name('edit');
    Route::post('accounts/update/', [AccountsController::class, 'update'])->name('accounts.update');
    
    //Contacts
    Route::get('contacts', [ContactsController::class, 'index'])->name('contacts.index');
    Route::get('contacts/create/{aid?}', [ContactsController::class, 'create'])->name('contacts.create');
    Route::post('contacts/store', [ContactsController::class, 'store'])->name('contacts.store');
    Route::get('contacts/view/{id}', [ContactsController::class, 'view'])->name('contacts.view');
    Route::get('contacts/edit/{id}', [ContactsController::class, 'edit'])->name('edit');
    Route::post('contacts/update/', [ContactsController::class, 'update'])->name('contacts.update');

    //Properties
    Route::get('properties', [PropertyController::class, 'index'])->name('properties.index');
    Route::get('properties/create/{pid?}', [PropertyController::class, 'create'])->name('properties.create');
    Route::get('properties/getcontact/{id}', [PropertyController::class, 'getcontact'])->name('getcontact');
    Route::post('properties/store', [PropertyController::class, 'store'])->name('properties.store');
    Route::get('properties/view/{id}', [PropertyController::class, 'view'])->name('properties.view');
    Route::get('properties/edit/{id}', [PropertyController::class, 'edit'])->name('edit');
    Route::post('properties/update/', [PropertyController::class, 'update'])->name('properties.update');


    //Vendors
    Route::get('vendors', [VendorController::class, 'index'])->name('vendors.index');
    Route::get('vendors/create', [VendorController::class, 'create'])->name('vendors.create');
    Route::post('vendors/store', [VendorController::class, 'store'])->name('vendors.store');
    Route::get('vendors/view/{id}', [VendorController::class, 'view'])->name('vendors.view');
    Route::get('vendors/edit/{id}', [VendorController::class, 'edit'])->name('edit');
    Route::post('vendors/update/', [VendorController::class, 'update'])->name('vendors.update');

    //Products => Perangkat
    Route::get('products', [ProductController::class, 'index'])->name('products.index');
    Route::get('products/create', [ProductController::class, 'create'])->name('products.create');
    Route::post('products/store', [ProductController::class, 'store'])->name('products.store');
    Route::get('products/view/{id}', [ProductController::class, 'view'])->name('products.view');
    Route::get('products/edit/{id}', [ProductController::class, 'edit'])->name('edit');
    Route::post('products/update/', [ProductController::class, 'update'])->name('products.update');
    
    //Products => Layanan
    Route::get('services', [ProductController::class, 'sindex'])->name('services.index');
    Route::get('services', [ProductController::class, 'sindex'])->name('services.index');
    Route::get('services/create', [ProductController::class, 'screate'])->name('services.create');
    Route::post('services/store', [ProductController::class, 'sstore'])->name('services.store');
    Route::get('services/view/{id}', [ProductController::class, 'sview'])->name('services.view');
    Route::get('services/edit/{id}', [ProductController::class, 'sedit'])->name('edit');
    Route::post('services/update/', [ProductController::class, 'supdate'])->name('services.update');

});
