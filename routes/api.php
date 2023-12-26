<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Route;





Route::post('/createAdmin', [AdminController::class, 'createAdmin']);
Route::post('/login', [AdminController::class, 'login']);
Route::post('/logout', [AdminController::class, 'logout']);


Route::post('/createCode', [CodeController::class, 'createCode']);
Route::get('/getAllCodes', [CodeController::class, 'getAllCodes']);
Route::post('/checkCode', [CodeController::class, 'checkCode']);
Route::delete('/deleteCode/{id}', [CodeController::class, 'deleteCode']);



Route::post('/createOrder', [OrderController::class, 'createOrder']);
Route::put('/updateOrderStatus/{id}', [OrderController::class, 'updateOrderStatus']);
Route::get('/getAllOrders', [OrderController::class, 'getAllOrders']);
Route::get('/getAllAcceptedOrders', [OrderController::class, 'getAllAcceptedOrders']);
Route::get('/getAllRejectedOrders', [OrderController::class, 'getAllRejectedOrders']);



Route::post('/createProduct', [ProductController::class, 'createProduct']);
Route::put('/EditProductInfo/{id}', [ProductController::class, 'EditProductInfo']);
Route::get('/getProduct/{id}', [ProductController::class, 'getProduct']);
Route::get('/getAllProducts', [ProductController::class, 'getAllProducts']);
Route::delete('/deleteProduct/{id}', [ProductController::class, 'deleteProduct']);

