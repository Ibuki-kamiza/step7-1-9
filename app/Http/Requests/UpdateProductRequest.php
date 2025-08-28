<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateProductRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $product = $this->route('product'); // ルートモデルバインディング想定

        return [
            'product_name' => [
                'required','string','max:255',
                // 例: 同名不可（現在の商品IDは除外）
                // Rule::unique('products','product_name')->ignore($product->id),
            ],
            'company_id'   => ['required','integer','exists:companies,id'],
            'price'        => ['required','integer','min:0'],
            'stock'        => ['required','integer','min:0'],
            'comment'      => ['nullable','string','max:1000'],
            // 画像は差し替え時のみチェック
            'image'        => ['nullable','file','mimes:jpg,jpeg,png,webp','max:5120'],
        ];
    }

    public function attributes(): array
    {
        return [
            'product_name' => '商品名',
            'company_id'   => 'メーカー名',
            'price'        => '価格',
            'stock'        => '在庫数',
            'comment'      => 'コメント',
            'image'        => '商品画像',
        ];
    }
}
