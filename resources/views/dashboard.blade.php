@extends('layouts.app')

@section('content')
<div class="container">
    <h1>ダッシュボード</h1>
    <p>ログインに成功しました。</p>
    <a href="{{ route('products.index') }}" class="btn btn-primary">商品一覧へ</a>
</div>
@endsection
