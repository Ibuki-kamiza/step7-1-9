@extends('layouts.app')

@section('content')
<div class="form-container">
    <h2>商品新規登録画面</h2>

    {{-- ▼ バリデーションエラー表示 --}}
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <table class="table table-bordered">
            <tr>
                <th>商品名 <span class="text-danger">*</span></th>
                <td>
                    <input type="text" name="product_name" value="{{ old('product_name') }}" class="form-control" required>
                    @error('product_name')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </td>
            </tr>

            <tr>
                <th>メーカー名 <span class="text-danger">*</span></th>
                <td>
                    <select name="company_id" class="form-control" required>
                        <option value="">選択してください</option>
                        @foreach ($companies as $company)
                            <option value="{{ $company->id }}"
                                {{ old('company_id') == $company->id ? 'selected' : '' }}>
                                {{ $company->company_name }}
                            </option>
                        @endforeach
                    </select>
                    @error('company_id')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </td>
            </tr>

            <tr>
                <th>価格 <span class="text-danger">*</span></th>
                <td>
                    <input type="number" name="price" value="{{ old('price') }}" class="form-control" required>
                    @error('price')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </td>
            </tr>

            <tr>
                <th>在庫数 <span class="text-danger">*</span></th>
                <td>
                    <input type="number" name="stock" value="{{ old('stock') }}" class="form-control" required>
                    @error('stock')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </td>
            </tr>

            <tr>
                <th>コメント</th>
                <td>
                    <textarea name="comment" class="form-control">{{ old('comment') }}</textarea>
                    @error('comment')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </td>
            </tr>

            <tr>
                <th>商品画像</th>
                <td>
                    <input type="file" name="image" class="form-control">
                    @error('image')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </td>
            </tr>
        </table>

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
