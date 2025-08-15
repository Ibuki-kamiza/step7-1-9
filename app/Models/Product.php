<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Company;

class Product extends Model
{
    use HasFactory;

    /**
     * 一括代入可能なカラム
     */
    protected $fillable = [
        'product_name',
        'company_id',
        'price',
        'stock',
        'comment',
        'img_path',
    ];

    /**
     * 型キャスト
     */
    protected $casts = [
        'price' => 'integer',  // 必要に応じて float に
        'stock' => 'integer',
    ];

    /**
     * 会社（メーカー）とのリレーション
     */
    public function company()
    {
        return $this->belongsTo(Company::class, 'company_id');
    }
}
