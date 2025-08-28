<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\ProductController;

// ✅ Laravel認証ルート
Auth::routes();

// ✅ 非ログイン時トップ（任意）
Route::get('/', function () {
    return view('welcome');
})->name('welcome');

// ✅ 認証後のみアクセス可
Route::middleware(['auth'])->group(function () {

    // --- Products: resourceを使わず個別定義 ---
    Route::get   ('/products',                 [ProductController::class, 'index' ])->name('products.index');
    Route::get   ('/products/create',          [ProductController::class, 'create'])->name('products.create');
    Route::post  ('/products',                 [ProductController::class, 'store' ])->name('products.store');

    // ルートモデルバインディングを使うなら {product} 推奨
    Route::get   ('/products/{product}',       [ProductController::class, 'show'  ])->name('products.show')->whereNumber('product');
    Route::get   ('/products/{product}/edit',  [ProductController::class, 'edit'  ])->name('products.edit')->whereNumber('product');
    Route::put   ('/products/{product}',       [ProductController::class, 'update'])->name('products.update')->whereNumber('product');
    // 部分更新を使うなら PATCH でもOK（どちらか片方にする）
    // Route::patch('/products/{product}',      [ProductController::class, 'update'])->name('products.update')->whereNumber('product');

    Route::delete('/products/{product}',       [ProductController::class, 'destroy'])->name('products.destroy')->whereNumber('product');

    // ✅ ダッシュボード（ログイン後トップページ）
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});

// ❌ 重複/衝突する定義は削除してください
// Route::get('/products/{id}', [ProductController::class, 'show'])->name('products.show');
// Route::resource('products', ProductController::class);
