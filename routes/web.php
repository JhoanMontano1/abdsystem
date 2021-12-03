<?php
use App\Http\Controllers\factura_proveedorController;
use App\Http\Controllers\factura_clienteController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\pdfController;
use App\Http\Controllers\entradaController;
use App\Http\Controllers\salidaController;
use App\Http\Controllers\marcaController;
use App\Http\Controllers\forma_entradaController;
use App\Http\Controllers\forma_salidaController;
use App\Http\Controllers\forma_pagoController;
use App\Http\Controllers\proveedorController;
use App\Http\Controllers\clienteController;
use App\Http\Controllers\categoriaController;
use App\Http\Controllers\articuloController;
use App\Http\Controllers\userController;
use Illuminate\Support\Facades\Route;

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

// Route::get('/', 'HomeController@index');
Route::get('/home', [HomeController::class, 'index']);
Route::get('invoice_prov', [factura_proveedorController::class, 'generateInvoice'])->middleware('auth');
Route::get('cancel_invoice_prov', [factura_proveedorController::class, 'cancelInvoice'])->middleware('auth');
Route::get('cancel_invoice_client', [factura_clienteController::class, 'cancelInvoice'])->middleware('auth');
Route::get('invoice_client', [factura_clienteController::class, 'generateInvoice'])->middleware('auth');
Route::get('report', [pdfController::class, 'view'])->middleware('auth');
Route::get('search', [entradaController::class, 'search'])->middleware('auth');
Route::get('searchArt', [articuloController::class, 'search'])->middleware('auth');
Route::get('searchCat', [categoriaController::class, 'search'])->middleware('auth');
Route::get('searchEnt', [entradaController::class, 'searchEnt'])->middleware('auth');
Route::get('searchSal', [salidaController::class, 'search'])->middleware('auth');
Route::get('searchCli', [clienteController::class, 'search'])->middleware('auth');
Route::get('searchPro', [proveedorController::class, 'search'])->middleware('auth');
Route::get('searchForSal', [forma_salidaController::class, 'search'])->middleware('auth');
Route::get('searchForEnt', [forma_entradaController::class, 'search'])->middleware('auth');
Route::get('searchForPag', [forma_pagoController::class, 'search'])->middleware('auth');
Route::get('searchFacEnt', [factura_proveedorController::class, 'search'])->middleware('auth');
Route::get('searchFacSal', [factura_clienteController::class, 'search'])->middleware('auth');
// Route::get('/', function () {
//     return view('auth.login');
  
// });

Route::resource('factura_proveedor',factura_proveedorController::class)->middleware('auth');
Route::resource('factura_cliente',factura_clienteController::class)->middleware('auth');
Route::resource('cliente',clienteController::class)->middleware('auth');
Route::resource('articulo',articuloController::class)->middleware('auth');
Route::resource('categoria',categoriaController::class)->middleware('auth');
Route::resource('marca',marcaController::class)->middleware('auth');
Route::resource('proveedor',proveedorController::class)->middleware('auth');
Route::resource('forma_entrada',forma_entradaController::class)->middleware('auth');
Route::resource('forma_salida',forma_salidaController::class)->middleware('auth');
Route::resource('forma_pago',forma_pagoController::class)->middleware('auth');
Route::resource('entrada',entradaController::class)->middleware('auth');
Route::resource('salida',salidaController::class)->middleware('auth');
Route::resource('user',userController::class)->middleware('auth');
Auth::routes();

Route::group(['middleware'=>'auth'],function(){
        return view('index');

});

Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');