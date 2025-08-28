{{-- エラー表示 --}}
@if ($errors->any())
  <div class="alert alert-danger">
    <ul>
      @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
      @endforeach
    </ul>
  </div>
@endif

{{-- 商品名 --}}
<div>
  <label>商品名</label>
  <input type="text" name="product_name"
         value="{{ old('product_name', $product->product_name ?? '') }}">
</div>

{{-- 価格 --}}
<div>
  <label>価格</label>
  <input type="number" name="price"
         value="{{ old('price', $product->price ?? '') }}">
</div>

{{-- メーカー名（★追加） --}}
<div>
  <label>メーカー名 <span class="text-danger">*</span></label>
  <select name="company_id" required>
    <option value="">選択してください</option>
    @foreach($companies as $company)
      <option value="{{ $company->id }}"
        {{ (string)old('company_id', $product->company_id ?? '') === (string)$company->id ? 'selected' : '' }}>
        {{ $company->company_name }}
      </option>
    @endforeach
  </select>
  @error('company_id')
    <div class="text-danger">{{ $message }}</div>
  @enderror
</div>

{{-- 在庫数 --}}
<div>
  <label>在庫数</label>
  <input type="number" name="stock"
         value="{{ old('stock', $product->stock ?? '') }}">
</div>

{{-- コメント --}}
<div>
  <label>コメント</label>
  <textarea name="comment">{{ old('comment', $product->comment ?? '') }}</textarea>
</div>

{{-- 商品画像 --}}
<div>
  <label>商品画像</label>
  <input type="file" name="image">
  @isset($product->img_path)
    <div>
      <img src="{{ asset('storage/' . $product->img_path) }}" style="max-height:100px;">
    </div>
  @endisset
</div>
