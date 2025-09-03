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
     * 商品一覧画面（初回表示はサーバーサイド、再検索はJSでAPIに委譲）
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

        // 初回描画はSSRでOK（以降はフロントから /api/products を叩く）
        $products  = $query->orderBy('created_at', 'desc')->paginate(10);

        // 検索フォーム用メーカー一覧
        $companies = Company::orderBy('company_name')->get();

        return view('products.index', compact('products', 'companies'));
    }

    /**
     * 商品新規作成画面
     */
    public function create()
    {
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
    public function show(Product $product)
    {
        $product->load('company');
        return view('products.show', compact('product'));
    }

    /**
     * 商品編集画面
     */
    public function edit(Product $product)
    {
        $companies = Company::orderBy('company_name')->get();
        return view('products.edit', compact('product', 'companies'));
    }

    /**
     * 商品を更新
     */
    public function update(UpdateProductRequest $request, Product $product)
    {
        $validated = $request->validated();

        if ($request->hasFile('image')) {
            if (!empty($product->img_path)) {
                Storage::disk('public')->delete($product->img_path);
            }
            $validated['img_path'] = $request->file('image')->store('images', 'public');
        }

        $product->update($validated);

        return redirect()->route('products.show', $product)->with('success', '商品を更新しました');
    }
}
