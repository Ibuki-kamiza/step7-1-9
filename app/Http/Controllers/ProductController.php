<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class ProductController extends Controller
{
    /**
     * 商品一覧画面
     */
    public function index()
    {
        $products = Product::all();
        return view('products.index', compact('products'));
    }

    /**
     * 商品新規作成画面を表示
     */
    public function create()
    {
        return view('products.create');
    }

    /**
     * 商品を新規登録
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'maker_name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'comment' => 'nullable|string|max:1000',
            'image' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('products', 'public');
            $validated['image_path'] = $path;
        }

        Product::create($validated);

        return redirect()->route('products.index')->with('success', '商品を登録しました');
    }

    /**
     * 商品詳細画面
     */
    public function show(Product $product)
    {
        return view('products.show', compact('product'));
    }

    /**
     * 商品編集画面
     */
    public function edit(Product $product)
    {
        return view('products.edit', compact('product'));
    }

    /**
     * 商品更新処理
     */
    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'maker_name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'comment' => 'nullable|string|max:1000',
            'image' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('products', 'public');
            $validated['image_path'] = $path;
        }

        $product->update($validated);

        return redirect()->route('products.show', $product->id)->with('success', '商品を更新しました');
    }

    /**
     * 商品削除処理
     */
    public function destroy(Product $product)
    {
        $product->delete();
        return redirect()->route('products.index')->with('success', '商品を削除しました');
    }
}
