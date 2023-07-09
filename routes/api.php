<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\HomeController;
use App\Http\Controllers\Api\ProductController;


Route::get('/', HomeController::class);

//products list
Route::get('/products', [ProductController::class, 'index']);

Route::prefix('/product')->group( function () {

        //add product
        Route::post('/add', [ProductController::class, 'store'])->name('api.product.add');

        //update product
        Route::put('/update/{id}', [ProductController::class, 'update'])->name('api.product.update');

        //remove product
        Route::delete('remove/{id}', [ProductController::class, 'destroy']);

        //get product detail
        Route::get('/{id}', [ProductController::class, 'getDetail']);
    }
);

Route::get('/{product}/edit', [HomeController::class, 'edit'])->name('edit');
Route::get('/{product}/delete', [ProductController::class, 'destroy'])->name('delete');