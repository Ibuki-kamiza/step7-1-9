<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    // ✅ fillableはこの中に書きます（クラスの外ではなく中）
    protected $fillable = [
        'name',
        'maker_name',
        'price',
        'stock',
        'comment',
        'image_path',
    ];
}

