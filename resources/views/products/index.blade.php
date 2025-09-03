{{-- resources/views/products/index.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h2 class="mb-4 text-center">商品一覧画面（非同期検索）</h2>

    {{-- 検索フォーム --}}
    <form id="searchForm" class="search-form mb-4 d-flex flex-wrap gap-2">
        {{-- キーワード --}}
        <input id="keyword" type="text" name="keyword" class="form-control" placeholder="検索キーワード" style="max-width:200px;">

        {{-- メーカー --}}
        <select id="company_id" name="company_id" class="form-control" style="max-width:160px;">
            <option value="">メーカー</option>
            @foreach ($companies as $company)
                <option value="{{ $company->id }}">{{ $company->company_name }}</option>
            @endforeach
        </select>

        {{-- 価格範囲 --}}
        <input id="price_min" type="number" name="price_min" class="form-control" placeholder="価格(下限)" style="max-width:140px;">
        <span class="align-self-center">〜</span>
        <input id="price_max" type="number" name="price_max" class="form-control" placeholder="価格(上限)" style="max-width:140px;">

        {{-- 在庫範囲 --}}
        <input id="stock_min" type="number" name="stock_min" class="form-control" placeholder="在庫(下限)" style="max-width:140px;">
        <span class="align-self-center">〜</span>
        <input id="stock_max" type="number" name="stock_max" class="form-control" placeholder="在庫(上限)" style="max-width:140px;">

        <button type="submit" class="btn btn-secondary">検索</button>
    </form>

    {{-- 新規登録 --}}
    <div class="text-end mb-3">
        <a href="{{ route('products.create') }}" class="btn btn-warning">新規登録</a>
    </div>

    {{-- 一覧テーブル --}}
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
        <tbody id="productTbody">
            {{-- JSで動的に挿入 --}}
        </tbody>
    </table>

    {{-- ページネーション --}}
    <nav id="pager" class="d-flex justify-content-center"></nav>
</div>
@endsection

@push('scripts')
<script>
$(function() {
  const endpoint = '/api/products';
  let lastParams = {};

  // 初回ロード
  lastParams = currentParams();
  fetchProducts(endpoint, lastParams);

  // 検索フォーム送信（非同期）
  $('#searchForm').on('submit', function(e) {
    e.preventDefault();
    lastParams = currentParams();
    fetchProducts(endpoint, lastParams);
  });

  // メーカー変更ですぐ検索（任意）
  $('#company_id').on('change', function() {
    lastParams = currentParams();
    fetchProducts(endpoint, lastParams);
  });

  // 現在のフォーム値をAPIパラメータにまとめる
  function currentParams() {
    return {
      keyword:   $('#keyword').val(),
      company_id:$('#company_id').val(),
      price_min: $('#price_min').val(),
      price_max: $('#price_max').val(),
      stock_min: $('#stock_min').val(),
      stock_max: $('#stock_max').val(),
      per_page:  10
    };
  }

  // API取得
  function fetchProducts(url, params) {
    $('#productTbody').html('<tr><td colspan="7" class="text-center">読み込み中...</td></tr>');
    $.get(url, params)
      .done(function(res) {
        renderTable(res.data || []);
        renderPager(res.links || [], params);
      })
      .fail(function() {
        $('#productTbody').html('<tr><td colspan="7" class="text-center text-danger">読み込みに失敗しました</td></tr>');
        $('#pager').empty();
      });
  }

  // テーブル描画
  function renderTable(items) {
    if (!items.length) {
      $('#productTbody').html('<tr><td colspan="7" class="text-center">データがありません</td></tr>');
      return;
    }
    const rows = items.map(function(p) {
      const img = p.image_url ? `<img src="${p.image_url}" width="50">` : '-';
      const company = p.company && p.company.name ? p.company.name : '-';
      return `
        <tr>
          <td>${p.id}</td>
          <td>${img}</td>
          <td>${escapeHtml(p.product_name || '')}</td>
          <td>¥${Number(p.price ?? 0).toLocaleString()}</td>
          <td>${p.stock ?? 0}</td>
          <td>${escapeHtml(company)}</td>
          <td>
            <a href="/products/${p.id}" class="btn btn-info btn-sm">詳細</a>
            <form action="/products/${p.id}" method="POST" style="display:inline;">
              @csrf
              @method('DELETE')
              <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('削除しますか？')">削除</button>
            </form>
          </td>
        </tr>
      `;
    }).join('');
    $('#productTbody').html(rows);
  }

  // ページネーション描画
  function renderPager(links, baseParams) {
    if (!Array.isArray(links) || !links.length) { $('#pager').empty(); return; }
    const html = links.map(function(l) {
      const disabled = !l.url ? ' disabled' : '';
      const active = l.active ? ' active' : '';
      const label = (l.label || '')
        .replace('&laquo; Previous', '«')
        .replace('Next &raquo;', '»');
      return `<a href="#" class="page-link btn btn-outline-secondary mx-1${disabled}${active}"
                 data-url="${l.url || ''}">${label}</a>`;
    }).join('');
    $('#pager').html(html);

    // クリックでAPI再リクエスト
    $('#pager .page-link').off('click').on('click', function(e) {
      e.preventDefault();
      const url = $(this).data('url');
      if (!url) return;
      fetchProducts(url, baseParams);
    });
  }

  // XSS対策
  function escapeHtml(str) {
    return String(str).replace(/[&<>"'`=\/]/g, function(s) {
      return ({'&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;',"'":'&#39;','/':'&#x2F;','`':'&#x60;','=':'&#x3D;'}[s]);
    });
  }
});
</script>
@endpush
