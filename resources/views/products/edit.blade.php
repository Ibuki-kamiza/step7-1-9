@extends('layouts.app')

@section('content')
<div class="container">
    <h1>商品編集</h1>

    <form action="{{ route('products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label>商品名</label>
            <input type="text" name="name" value="{{ old('name', $product->name) }}" class="form-control">
        </div>

        <div class="mb-3">
            <label>メーカー名</label>
            <input type="text" name="maker_name" value="{{ old('maker_name', $product->maker_name) }}" class="form-control">
        </div>

        <div class="mb-3">
            <label>価格</label>
            <input type="number" name="price" value="{{ old('price', $product->price) }}" class="form-control">
        </div>

        <div class="mb-3">
            <label>在庫数</label>
            <input type="number" name="stock" value="{{ old('stock', $product->stock) }}" class="form-control">
        </div>

        <div class="mb-3">
            <label>コメント</label>
            <textarea name="comment" class="form-control">{{ old('comment', $product->comment) }}</textarea>
        </div>

        <div class="mb-3">
            <label>現在の画像</label><br>
            @if ($product->img_path)
                <img src="{{ asset('storage/' . $product->img_path) }}" width="200">
            @else
                <p>画像なし</p>
            @endif
        </div>

        <div class="mb-3">
            <label>新しい画像（変更する場合のみ）</label>
            <input type="file" name="image" class="form-control">
        </div>

        <button type="submit" class="btn btn-primary">更新する</button>
        <a href="{{ route('products.show', $product->id) }}" class="btn btn-secondary">戻る</a>
    </form>
</div>
@endsection
