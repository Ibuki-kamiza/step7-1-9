{{-- resources/views/products/index.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h2 class="mb-4 text-center">商品一覧画面（非同期検索・ソート・削除対応）</h2>

    {{-- 🔍 検索フォーム --}}
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

    {{-- 📝 新規登録 --}}
    <div class="text-end mb-3">
        <a href="{{ route('products.create') }}" class="btn btn-warning">新規登録</a>
    </div>

    {{-- 📋 商品一覧テーブル --}}
    <table class="table table-bordered">
        <thead>
            <tr>
                <th class="sortable" data-sort="id">ID <span class="sort-indicator"></span></th>
                <th>商品画像</th>
                <th class="sortable" data-sort="product_name">商品名 <span class="sort-indicator"></span></th>
                <th class="sortable" data-sort="price">価格 <span class="sort-indicator"></span></th>
                <th class="sortable" data-sort="stock">在庫数 <span class="sort-indicator"></span></th>
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
<style>
  th.sortable { cursor: pointer; user-select: none; }
  th.sortable .sort-indicator { opacity: 0.6; margin-left: 4px; }
</style>

<script>
$(function() {
  const endpoint = '/api/products';
  let lastParams = { sort_by: 'id', sort_order: 'desc' };

  // 初回ロード
  fetchProducts(endpoint, currentParams());
  updateSortIndicators();

  // 🔍 検索フォーム送信
  $('#searchForm').on('submit', function(e) {
    e.preventDefault();
    fetchProducts(endpoint, currentParams());
  });

  // メーカー変更ですぐ検索
  $('#company_id').on('change', function() {
    fetchProducts(endpoint, currentParams());
  });

  // 🔽 ソートクリック
  $(document).on('click', 'th.sortable', function() {
    const col = $(this).data('sort');
    if (lastParams.sort_by === col) {
      lastParams.sort_order = (lastParams.sort_order === 'asc') ? 'desc' : 'asc';
    } else {
      lastParams.sort_by = col;
      lastParams.sort_order = 'asc';
    }
    updateSortIndicators();
    fetchProducts(endpoint, currentParams());
  });

  // 現在のフォーム値
  function currentParams() {
    return {
      keyword:    $('#keyword').val(),
      company_id: $('#company_id').val(),
      price_min:  $('#price_min').val(),
      price_max:  $('#price_max').val(),
      stock_min:  $('#stock_min').val(),
      stock_max:  $('#stock_max').val(),
      per_page:   10,
      sort_by:    lastParams.sort_by,
      sort_order: lastParams.sort_order
    };
  }

  // 商品取得
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
      const company = p.company?.name ?? '-';
      return `
        <tr id="row-${p.id}">
          <td>${p.id}</td>
          <td>${img}</td>
          <td>${escapeHtml(p.product_name || '')}</td>
          <td>¥${Number(p.price ?? 0).toLocaleString()}</td>
          <td>${p.stock ?? 0}</td>
          <td>${escapeHtml(company)}</td>
          <td>
            <a href="/products/${p.id}" class="btn btn-info btn-sm">詳細</a>
            <button type="button" class="btn btn-danger btn-sm js-delete" data-id="${p.id}">削除</button>
          </td>
        </tr>
      `;
    }).join('');
    $('#productTbody').html(rows);
  }

  // ページネーション
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

    $('#pager .page-link').off('click').on('click', function(e) {
      e.preventDefault();
      const url = $(this).data('url');
      if (!url) return;
      fetchProducts(url, baseParams);
    });
  }

  // ✅ 非同期削除
  $(document).on('click', '.js-delete', function () {
    const id = $(this).data('id');
    if (!confirm('削除しますか？')) return;

    const $btn = $(this).prop('disabled', true);

    $.ajax({
      url: `/api/products/${id}`,
      type: 'DELETE',
      // headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
    })
    .done(function(res) {
      if (res && res.ok) {
        $(`#row-${id}`).remove();
        if ($('#productTbody tr').length === 0) {
          fetchProducts(endpoint, currentParams());
        }
      } else {
        alert(res?.message || '削除に失敗しました');
      }
    })
    .fail(function() {
      alert('削除に失敗しました');
    })
    .always(function() {
      $btn.prop('disabled', false);
    });
  });

  // ソートインジケータ
  function updateSortIndicators() {
    $('th.sortable .sort-indicator').text('');
    const th = $(`th.sortable[data-sort="${lastParams.sort_by}"]`).find('.sort-indicator');
    th.text(lastParams.sort_order === 'asc' ? '▲' : '▼');
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
