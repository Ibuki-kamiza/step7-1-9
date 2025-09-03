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
Route::get('/products', [ProductApiController::class, 'index'])->name('api.products.index');
