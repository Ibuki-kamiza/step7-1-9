<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\ProductController;

// ✅ Laravel認証ルート
Auth::routes();

// ✅ 認証後しかアクセスできないルート
Route::middleware(['auth'])->group(function () {
    // 商品操作（一覧・登録・編集など）
    Route::resource('products', ProductController::class);

    // ダッシュボード（ログイン後トップページ）
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});

// ✅ 非ログイン状態のトップページ（任意）
Route::get('/', function () {
    return view('welcome');
});
//商品の詳細画面を表示
Route::get('/products/{id}', [ProductController::class, 'show'])->name('products.show');
Route::resource('products', ProductController::class);
