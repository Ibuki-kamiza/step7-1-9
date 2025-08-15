{{-- resources/views/products/index.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h2 class="mb-4 text-center">商品一覧画面</h2>

    <!-- フラッシュメッセージ -->
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <!-- 検索フォーム -->
    <form method="GET" action="{{ route('products.index') }}" class="search-form mb-4 d-flex gap-2">
        <input type="text" name="keyword" value="{{ request('keyword') }}" class="form-control" placeholder="検索キーワード">
        <select name="company_id" class="form-control">
            <option value="">メーカー</option>
            @foreach ($companies as $company)
                <option value="{{ $company->id }}" {{ request('company_id') == $company->id ? 'selected' : '' }}>
                    {{ $company->company_name }}
                </option>
            @endforeach
        </select>
        <button type="submit" class="btn btn-secondary">検索</button>
    </form>

    <!-- 新規登録ボタン -->
    <div class="text-end mb-3">
        <a href="{{ route('products.create') }}" class="btn btn-warning">新規登録</a>
    </div>

    <!-- 商品一覧テーブル -->
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>商品画像</th>
                <th>商品名</th>
                <th>価格</th>
                <th>在庫数</th>
                <th>メーカー名</th>
                <th>操作</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($products as $product)
            <tr>
                <td>{{ $product->id }}</td>
                <td>
                    @if ($product->img_path)
                        <img src="{{ asset('storage/' . $product->img_path) }}" width="50">
                    @else
                        -
                    @endif
                </td>
                <td>{{ $product->product_name }}</td>
                <td>¥{{ number_format($product->price) }}</td>
                <td>{{ $product->stock }}</td>
                <td>{{ $product->company->company_name ?? '-' }}</td>
                <td>
                    <a href="{{ route('products.show', $product->id) }}" class="btn btn-info btn-sm">詳細</a>
                    <a href="{{ route('products.edit', $product->id) }}" class="btn btn-primary btn-sm">更新</a>
                    <form action="{{ route('products.destroy', $product->id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('削除しますか？')">削除</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <!-- ページネーション -->
    <div class="d-flex justify-content-center mt-4">
        {{ $products->links() }}
    </div>
</div>
@endsection
@if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif
