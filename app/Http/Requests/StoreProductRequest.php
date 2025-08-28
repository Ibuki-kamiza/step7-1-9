<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // 認可を別でやるならここはtrue
    }

    public function rules(): array
    {
        return [
            'product_name' => ['required','string','max:255'],
            'company_id'   => ['required','integer','exists:companies,id'],
            'price'        => ['required','integer','min:0'],
            'stock'        => ['required','integer','min:0'],
            'comment'      => ['nullable','string','max:1000'],
            'image'        => ['nullable','file','mimes:jpg,jpeg,png,webp','max:5120'], // 5MB
        ];
    }

    public function attributes(): array
    {
        // エラーメッセージに出す項目名（日本語化）
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
