<?php

use App\Http\Controllers\ContactController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\UserController;

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

Route::get('/', [ContactController::class, 'index']);
Route::get('/confirm',[ContactController::class, 'confirm']);
Route::get('/contacts/confirm', [ContactController::class, 'thanks']);
Route::get('/admin', [ContactController::class, 'admin']);
Route::get('/auth/login', [ContactController::class, 'login']);
Route::get('/auth/register', [ContactController::class, 'register']);


Route::post('contacts/confirm', [ContactController::class, 'confirm']);
Route::post('/contacts', [ContactController::class, 'store']);