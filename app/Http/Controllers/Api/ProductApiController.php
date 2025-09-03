<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Resources\ProductResource;
use Illuminate\Support\Facades\Storage;

class ProductApiController extends Controller
{
    /**
     * 商品一覧・検索・ソートAPI
     */
    public function index(Request $request)
    {
        $query = Product::with('company');

        // 🔍 検索条件
        if ($request->filled('keyword')) {
            $query->where('product_name', 'like', '%' . $request->keyword . '%');
        }
        if ($request->filled('company_id')) {
            $query->where('company_id', $request->company_id);
        }
        if ($request->filled('price_min')) {
            $query->where('price', '>=', (int)$request->price_min);
        }
        if ($request->filled('price_max')) {
            $query->where('price', '<=', (int)$request->price_max);
        }
        if ($request->filled('stock_min')) {
            $query->where('stock', '>=', (int)$request->stock_min);
        }
        if ($request->filled('stock_max')) {
            $query->where('stock', '<=', (int)$request->stock_max);
        }

        // 🔽 ソート処理
        $sortBy    = $request->input('sort_by', 'id');         // デフォルトはid
        $sortOrder = $request->input('sort_order', 'desc');    // デフォルトは降順

        // ホワイトリストで安全に
        $sortableColumns = ['id', 'product_name', 'price', 'stock', 'created_at'];
        if (!in_array($sortBy, $sortableColumns, true)) {
            $sortBy = 'id';
        }
        if (!in_array(strtolower($sortOrder), ['asc', 'desc'], true)) {
            $sortOrder = 'desc';
        }

        $query->orderBy($sortBy, $sortOrder);

        // 🔢 ページネーション
        $perPage  = max(1, min((int)$request->input('per_page', 10), 50));
        $products = $query->paginate($perPage);

        // JSON返却
        return ProductResource::collection($products);
    }

    /**
     * 商品削除API（非同期削除対応）
     */
    public function destroy(Product $product)
    {
        try {
            // 画像ファイル削除（あれば）
            if (!empty($product->img_path)) {
                Storage::disk('public')->delete($product->img_path);
            }

            $productId = $product->id;
            $product->delete();

            return response()->json([
                'ok'  => true,
                'id'  => $productId,
                'msg' => '削除しました'
            ]);
        } catch (\Throwable $e) {
            return response()->json([
                'ok'      => false,
                'message' => '削除に失敗しました',
                'error'   => $e->getMessage()
            ], 500);
        }
    }
}
