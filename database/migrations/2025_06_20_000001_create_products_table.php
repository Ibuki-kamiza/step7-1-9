<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('product_name');         // 商品名
            $table->foreignId('company_id')         // 外部キー（自動で unsignedBigInteger & index）
                  ->constrained('companies')        // companies テーブルの id に外部キー制約
                  ->onDelete('cascade');            // 削除時に関連商品も削除
            $table->integer('price');
            $table->integer('stock');
            $table->text('comment')->nullable();
            $table->string('img_path')->nullable(); // 画像パス
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
