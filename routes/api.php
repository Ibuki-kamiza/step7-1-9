<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ProductApiController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| ここではアプリケーションの API ルートを定義します。
| このファイルで定義したルートには自動的に "/api" プレフィックスが付与されます。
| 例: http://127.0.0.1:8000/api/products
|
*/

// 商品一覧・検索API
Route::get('/products', [ProductApiController::class, 'index'])
    ->name('api.products.index');

// 商品削除API（非同期削除対応用）
Route::delete('/products/{product}', [ProductApiController::class, 'destroy'])
    ->name('api.products.destroy');
