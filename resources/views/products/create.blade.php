@extends('layouts.app')

@section('content')
<div class="form-container">
    <h2>商品新規登録画面</h2>

    <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        {{-- 共通フォーム（入力欄・エラー表示含む） --}}
        @include('products.form')

        <div class="text-center mt-4">
            <button type="submit" class="btn btn-primary">登録</button>
        </div>
    </form>
</div>
@endsection

@push('styles')
<style>
    body {
        background-color: #f8f9fa;
        font-family: sans-serif;
    }

    .form-container {
        max-width: 700px;
        margin: 40px auto;
        padding: 30px;
        background-color: white;
        border-radius: 12px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    }

    h2 {
        margin-bottom: 25px;
        text-align: center;
        font-size: 1.6rem;
        font-weight: bold;
    }

    .form-control, select {
        width: 100%;
        padding: 8px;
        font-size: 1rem;
        border: 1px solid #ccc;
        border-radius: 5px;
    }

    .table th {
        width: 30%;
        background-color: #f1f1f1;
    }

    .text-danger {
        color: red;
    }
</style>
@endpush
