@extends('layouts.app')

@section('content')
<h2>商品新規登録画面</h2>

<form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
    @csrf

    <table class="table table-bordered" style="max-width: 600px;">
        <tr>
            <th>商品名 <span class="text-danger">*</span></th>
            <td><input type="text" name="name" class="form-control" required></td>
        </tr>
        <tr>
            <th>メーカー名 <span class="text-danger">*</span></th>
            <td>
                <select name="maker_name" class="form-control" required>
                    <option value="">選択してください</option>
                    <option value="Coca-Cola">Coca-Cola</option>
                    <option value="サントリー">サントリー</option>
                    <option value="キリン">キリン</option>
                </select>
            </td>
        </tr>
        <tr>
            <th>価格 <span class="text-danger">*</span></th>
            <td><input type="number" name="price" class="form-control" required></td>
        </tr>
        <tr>
            <th>在庫数 <span class="text-danger">*</span></th>
            <td><input type="number" name="stock" class="form-control" required></td>
        </tr>
        <tr>
            <th>コメント</th>
            <td><textarea name="comment" class="form-control"></textarea></td>
        </tr>
        <tr>
            <th>商品画像</th>
            <td><input type="file" name="image" class="form-control-file"></td>
        </tr>
    </table>

    <div class="mt-3">
        <button type="submit" class="btn btn-warning">新規登録</button>
        <a href="{{ route('products.index') }}" class="btn btn-info text-white">戻る</a>
    </div>
</form>
@endsection
