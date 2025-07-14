@extends('layouts.app')

@section('content')
<div class="container">
    <h1>商品詳細</h1>

    <div class="mb-3">
        <strong>ID：</strong> {{ $product->id }}
    </div>

    <div class="mb-3">
        <strong>商品名：</strong> {{ $product->name }}
    </div>

    <div class="mb-3">
        <strong>メーカー名：</strong> {{ $product->maker_name }}
    </div>

    <div class="mb-3">
        <strong>価格：</strong> ¥{{ number_format($product->price) }}
    </div>

    <div class="mb-3">
        <strong>在庫数：</strong> {{ $product->stock }} 個
    </div>

    <div class="mb-3">
        <strong>コメント：</strong><br>
        <textarea readonly style="width:100%">{{ $product->comment }}</textarea>
    </div>

    <div class="mb-3">
        <strong>商品画像：</strong><br>
        @if ($product->img_path ?? $product->image_path)
            <img src="{{ asset('storage/' . ($product->img_path ?? $product->image_path)) }}" width="300">
        @else
            <p>画像なし</p>
        @endif
    </div>

    <a href="{{ route('products.edit', $product->id) }}" class="btn btn-warning">編集する</a>
    <a href="{{ route('products.index') }}" class="btn btn-secondary">一覧へ戻る</a>
</div>
@endsection
