<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Resources\ProductResource;

class ProductApiController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::with('company');

        // パラメータ取得・正規化
        $keyword    = trim((string) $request->input('keyword', ''));
        $companyId  = $request->input('company_id');

        $priceMin   = $request->filled('price_min') ? (int)$request->input('price_min') : null;
        $priceMax   = $request->filled('price_max') ? (int)$request->input('price_max') : null;

        $stockMin   = $request->filled('stock_min') ? (int)$request->input('stock_min') : null;
        $stockMax   = $request->filled('stock_max') ? (int)$request->input('stock_max') : null;

        $perPage    = max(1, min((int)$request->input('per_page', 10), 50));

        // キーワード
        if ($keyword !== '') {
            $query->where('product_name', 'like', '%' . $keyword . '%');
        }

        // メーカー
        if ($companyId !== null && $companyId !== '' && ctype_digit((string)$companyId)) {
            $query->where('company_id', (int)$companyId);
        }

        // 価格レンジ
        if ($priceMin !== null && $priceMax !== null) {
            if ($priceMin > $priceMax) { [$priceMin, $priceMax] = [$priceMax, $priceMin]; }
            $query->whereBetween('price', [$priceMin, $priceMax]);
        } elseif ($priceMin !== null) {
            $query->where('price', '>=', $priceMin);
        } elseif ($priceMax !== null) {
            $query->where('price', '<=', $priceMax);
        }

        // 在庫レンジ
        if ($stockMin !== null && $stockMax !== null) {
            if ($stockMin > $stockMax) { [$stockMin, $stockMax] = [$stockMax, $stockMin]; }
            $query->whereBetween('stock', [$stockMin, $stockMax]);
        } elseif ($stockMin !== null) {
            $query->where('stock', '>=', $stockMin);
        } elseif ($stockMax !== null) {
            $query->where('stock', '<=', $stockMax);
        }

        $products = $query->orderBy('created_at', 'desc')->paginate($perPage);

        return ProductResource::collection($products);
    }
}
