<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;

class ProductController extends Controller
{
    /**
     * 商品一覧画面
     */
    public function index(Request $request)
    {
        $query = Product::with('company');

        // キーワード検索
        if ($request->filled('keyword')) {
            $query->where('product_name', 'like', '%' . $request->keyword . '%');
        }

        // メーカーで絞り込み
        if ($request->filled('company_id')) {
            $query->where('company_id', $request->company_id);
        }

        $products = $query->orderBy('created_at', 'desc')->paginate(10);

        // ▼ 検索フォームのセレクトボックス用にメーカー一覧を取得
        $companies = Company::orderBy('company_name')->get();

        return view('products.index', compact('products', 'companies'));
    }

    /**
     * 商品新規作成画面
     */
    public function create()
    {
        // ▼ 新規登録フォームのセレクトボックス用にメーカー一覧を取得
        $companies = Company::orderBy('company_name')->get();

        return view('products.create', compact('companies'));
    }

    /**
     * 商品を保存（登録）
     */
    public function store(StoreProductRequest $request)
    {
        $validated = $request->validated();

        try {
            // 画像があれば保存
            if ($request->hasFile('image')) {
                $validated['img_path'] = $request->file('image')->store('images', 'public'); 
            }

            Product::create($validated);

            return redirect()->route('products.index')->with('success', '商品を登録しました。');
        } catch (\Throwable $e) {
            Log::error('【商品登録エラー】' . $e->getMessage());

            return back()
                ->withErrors(['error' => '商品の登録に失敗しました。システム管理者に連絡してください。'])
                ->withInput();
        }
    }

    /**
     * 商品詳細画面
     */
    public function show(Product $product) // ルートモデルバインディング {product}
    {
        $product->load('company'); // メーカー名を eager load
        return view('products.show', compact('product'));
    }

    /**
     * 商品編集画面
     */
    public function edit(Product $product) // ルートモデルバインディング {product}
    {
        // ▼ 編集フォームのセレクトボックス用にメーカー一覧を取得
        $companies = Company::orderBy('company_name')->get();

        return view('products.edit', compact('product', 'companies'));
    }

    /**
     * 商品を更新
     */
    public function update(UpdateProductRequest $request, Product $product)
    {
        $validated = $request->validated();

        // 画像差し替え処理
        if ($request->hasFile('image')) {
            // 古い画像があれば削除
            if (!empty($product->img_path)) {
                Storage::disk('public')->delete($product->img_path);
            }
            $validated['img_path'] = $request->file('image')->store('images', 'public');
        }

        $product->update($validated);

        return redirect()->route('products.show', $product)->with('success', '商品を更新しました');
    }
}
