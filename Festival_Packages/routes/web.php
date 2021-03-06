<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\PDFViewController;
use App\Http\Controllers\QRCodeController;
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

Route::get('/', function () {
    return view('welcome');
});

Route::get('generate-pdf-from-view', [PDFViewController::class, 'index']);

Route::get('simple-qr-code', [QRCodeController::class, 'simpleQr']);
Route::get('color-qr-code', [QRCodeController::class, 'colorQr']);