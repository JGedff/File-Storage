<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\formController;

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

Route::get('/', [formController::class, 'form']);

Route::post('/', [formController::class, 'redoForm']);

Route::post('/form/saveInfo', [formController::class, 'saveInfo']);

Route::get('/form/notSaved', [formController::class, 'infoNotSaved']);

Route::get('/getXML', [formController::class, 'showXMLInfo']);

Route::get('/getXML/{user}', [formController::class, 'showXMLInfoUser']);

Route::get('/getJSON', [formController::class, 'showJSONInfo']);

Route::get('/getJSON/{user}', [formController::class, 'showJSONInfoUser']);