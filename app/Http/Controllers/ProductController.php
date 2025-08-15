<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

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
        $companies = $this->getCompanies();

        return view('products.index', compact('products', 'companies'));
    }

    /**
     * 商品新規作成画面
     */
    public function create()
    {
        $companies = $this->getCompanies(); // セレクトボックス用のメーカー一覧
        return view('products.create', compact('companies'));
    }

    /**
     * 商品を保存（登録）
     */
    public function store(Request $request)
    {
        $validated = $this->validateProduct($request);

        try {
            // 画像があれば保存
            if ($request->hasFile('image')) {
                $imagePath = $request->file('image')->store('images', 'public');
                $validated['img_path'] = $imagePath;
            }

            // データベースへ保存
            Product::create($validated);

            return redirect()->route('products.index')->with('success', '商品を登録しました。');
        } catch (\Exception $e) {
            Log::error('【商品登録エラー】' . $e->getMessage());

            return back()
                ->withErrors(['error' => '商品の登録に失敗しました。システム管理者に連絡してください。'])
                ->withInput();
        }
    }

    /**
     * 商品詳細画面
     */
    public function show($id)
    {
        $product = Product::with('company')->findOrFail($id); // 関連会社名も取得
        return view('products.show', compact('product'));
    }

    /**
     * 商品編集画面
     */
    public function edit($id)
    {
        $product   = Product::findOrFail($id);
        $companies = $this->getCompanies(); // メーカー一覧も渡す

        return view('products.edit', compact('product', 'companies'));
    }

    /**
     * 商品を更新
     */
    public function update(Request $request, $id)
    {
        // バリデーション（storeと合わせる）
        $validated = $request->validate([
            'product_name' => 'required|string|max:255',
            'company_id'   => 'required|exists:companies,id',
            'price'        => 'required|numeric|min:0',
            'stock'        => 'required|integer|min:0',
            'comment'      => 'nullable|string|max:1000',
            'image'        => 'nullable|image|max:2048',
        ]);

        $product = Product::findOrFail($id);

        // データ更新
        $product->product_name = $validated['product_name'];
        $product->company_id   = $validated['company_id'];
        $product->price        = $validated['price'];
        $product->stock        = $validated['stock'];
        $product->comment      = $validated['comment'] ?? null;

        // 画像がアップロードされた場合
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('images', 'public');
            $product->img_path = $path;
        }

        $product->save();

        return redirect()->route('products.index')->with('success', '商品を更新しました。');
    }

    /**
     * バリデーションルール
     */
    protected function validateProduct(Request $request): array
    {
        return $request->validate([
            'product_name' => 'required|string|max:255',
            'company_id'   => 'required|exists:companies,id',
            'price'        => 'required|numeric|min:0',
            'stock'        => 'required|integer|min:0',
            'comment'      => 'nullable|string|max:1000',
            'image'        => 'nullable|image|max:2048',
        ]);
    }

    /**
     * メーカー一覧を取得（セレクトボックス用）
     */
    protected function getCompanies()
    {
        return Company::orderBy('company_name')->get();
    }
}
