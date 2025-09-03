<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ProductApiController;
use App\Http\Controllers\Api\PurchaseApiController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| APIルートは自動で "/api" プレフィックスが付与されます。
| 例: http://127.0.0.1:8000/api/products
|
*/

// 🔍 商品一覧・検索API
Route::get('/products', [ProductApiController::class, 'index'])
    ->name('api.products.index');

// 🗑 商品削除API（非同期削除）
Route::delete('/products/{product}', [ProductApiController::class, 'destroy'])
    ->name('api.products.destroy');

// 🛒 購入処理API
Route::post('/purchase', [PurchaseApiController::class, 'store'])
    ->name('api.purchase.store');
