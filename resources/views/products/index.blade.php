@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-4">商品一覧画面</h2>

    {{-- フラッシュメッセージ --}}
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    {{-- 検索フォーム --}}
    <form method="GET" action="{{ route('products.index') }}" class="row g-3 mb-4">
        <div class="col-auto">
            <input type="text" name="keyword" value="{{ request('keyword') }}" placeholder="商品名で検索" class="form-control">
        </div>
        <div class="col-auto">
            <input type="text" name="maker" value="{{ request('maker') }}" placeholder="メーカー名" class="form-control">
        </div>
        <div class="col-auto">
            <button type="submit" class="btn btn-secondary">検索</button>
        </div>
        <div class="col-auto">
            <a href="{{ route('products.index') }}" class="btn btn-outline-secondary">リセット</a>
        </div>
    </form>

    {{-- 新規登録ボタン --}}
    <div class="mb-3 text-end">
        <a href="{{ route('products.create') }}" class="btn btn-warning">＋ 新規登録</a>
    </div>

    {{-- 商品一覧テーブル --}}
    <table class="table table-bordered align-middle text-center">
        <thead class="table-light">
            <tr>
                <th>#</th>
                <th>商品画像</th>
                <th>商品名</th>
                <th>価格</th>
                <th>在庫数</th>
                <th>メーカー</th>
                <th>操作</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($products as $index => $product)
                <tr>
                    <td>{{ $index + 1 }}</td>

                    <td>
                        @if ($product->image_path)
                            <img src="{{ asset('storage/' . $product->image_path) }}" alt="商品画像" width="60">
                        @else
                            <span class="text-muted">画像なし</span>
                        @endif
                    </td>

                    <td>{{ $product->name }}</td>
                    <td>¥{{ number_format($product->price) }}</td>
                    <td>{{ $product->stock }}</td>
                    <td>{{ $product->maker_name }}</td>
                    <td>
                        <a href="{{ route('products.show', $product) }}" class="btn btn-sm btn-info text-white">詳細</a>
                        <a href="{{ route('products.edit', $product) }}" class="btn btn-sm btn-primary">編集</a>
                        <form action="{{ route('products.destroy', $product) }}" method="POST" style="display:inline-block;" onsubmit="return confirm('本当に削除しますか？')">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-danger">削除</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7">商品が見つかりません。</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
