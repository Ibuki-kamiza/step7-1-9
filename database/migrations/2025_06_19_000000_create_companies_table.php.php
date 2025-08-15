<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * マイグレーションの実行：companies テーブルの作成
     */
    public function up(): void
    {
        Schema::create('companies', function (Blueprint $table) {
            $table->id();                            // ID（主キー）
            $table->string('company_name');          // 会社名
            $table->timestamps();                    // created_at / updated_at
        });
    }

    /**
     * マイグレーションのロールバック：companies テーブルの削除
     */
    public function down(): void
    {
        Schema::dropIfExists('companies');
    }
};
