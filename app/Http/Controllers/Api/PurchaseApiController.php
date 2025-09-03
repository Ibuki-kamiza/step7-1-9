// app/Http/Controllers/Api/PurchaseApiController.php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Sale;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PurchaseApiController extends Controller
{
    public function purchase(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity'   => 'required|integer|min:1',
        ]);

        return DB::transaction(function () use ($request) {
            $product = Product::lockForUpdate()->findOrFail($request->product_id);

            // 在庫確認
            if ($product->stock < $request->quantity) {
                return response()->json([
                    'ok' => false,
                    'message' => '在庫が足りません'
                ], 400);
            }

            // 在庫減算
            $product->decrement('stock', $request->quantity);

            // 売上記録
            Sale::create([
                'product_id' => $product->id,
                'quantity'   => $request->quantity,
            ]);

            return response()->json([
                'ok' => true,
                'message' => '購入が完了しました',
                'product' => [
                    'id' => $product->id,
                    'name' => $product->product_name,
                    'remaining_stock' => $product->stock,
                ]
            ]);
        });
    }
}
