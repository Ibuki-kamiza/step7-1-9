@extends('layouts.app')

@section('content')
<div class="form-container">
  <h2>商品編集</h2>

  <form action="{{ route('products.update', $product) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')

    {{-- 共通フォーム（入力欄・エラー表示含む） --}}
    @include('products.form')

    <div class="mt-4 d-flex gap-2">
      <button type="submit" class="btn btn-primary">更新する</button>
      <a href="{{ route('products.index') }}" class="btn btn-secondary">戻る</a>
    </div>
  </form>
</div>
@endsection

@push('styles')
<style>
  .form-container {
    max-width: 700px;
    margin: 40px auto;
    padding: 30px;
    background-color: #fff;
    border-radius: 12px;
    box-shadow: 0 4px 12px rgba(0,0,0,0.1);
  }
</style>
@endpush
