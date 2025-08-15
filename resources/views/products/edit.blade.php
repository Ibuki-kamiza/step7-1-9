@extends('layouts.app')

@section('content')
<div class="container">
    <h2>商品編集</h2>

    <form action="{{ route('products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        {{-- 商品名 --}}
        <div class="mb-3">
            <label class="form-label">商品名</label>
            <input type="text" name="product_name" class="form-control" 
                   value="{{ old('product_name', $product->product_name) }}">
        </div>

        {{-- メーカー名 --}}
        <div class="mb-3">
            <label class="form-label">メーカー</label>
            <select name="company_id" class="form-select">
                <option value="">選択してください</option>
                @foreach($companies as $company)
                    <option value="{{ $company->id }}"
                        {{ old('company_id', $product->company_id) == $company->id ? 'selected' : '' }}>
                        {{ $company->company_name }}
                    </option>
                @endforeach
            </select>
        </div>

        {{-- 価格 --}}
        <div class="mb-3">
            <label class="form-label">価格</label>
            <input type="number" name="price" class="form-control" 
                   value="{{ old('price', $product->price) }}">
        </div>

        {{-- 在庫 --}}
        <div class="mb-3">
            <label class="form-label">在庫</label>
            <input type="number" name="stock" class="form-control" 
                   value="{{ old('stock', $product->stock) }}">
        </div>

        {{-- コメント --}}
        <div class="mb-3">
            <label class="form-label">コメント</label>
            <textarea name="comment" class="form-control">{{ old('comment', $product->comment) }}</textarea>
        </div>

        {{-- 画像 --}}
        <div class="mb-3">
            <label class="form-label">商品画像</label><br>
            @if($product->img_path)
                <img src="{{ asset('storage/' . $product->img_path) }}" 
                     style="max-width:150px;" class="mb-2"><br>
            @endif
            <input type="file" name="image">
        </div>

        <button type="submit" class="btn btn-primary">更新する</button>
        <a href="{{ route('products.index') }}" class="btn btn-secondary">戻る</a>
    </form>
</div>
@endsection
