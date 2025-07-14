<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sales', function (Blueprint $table) {
            $table->id();

            // ユーザーが削除されたとき、NULL に設定される
            $table->foreignId('user_id')
                  ->nullable()
                  ->constrained()
                  ->onDelete('set null');

            // 商品が削除されたとき、このレコードも削除
            $table->foreignId('product_id')
                  ->constrained('products') // ← 明示的に 'products' テーブルを指定
                  ->onDelete('cascade');

            $table->timestamps(); // created_at, updated_at
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sales');
    }
};
