<div class="d-flex header-border justify-content-lg-between flex-lg-nowrap flex-wrap pt-3 pb-3">
  <h1 class="header_logo order-0 flex-lg-grow-0 flex-grow-1 mr-2"><a href="/"><img src="{{ asset('img/header_logo.png') }}"
        alt="Storemap(ストアマップ)"></a></h1>
  <div class="order-lg-1 order-2">
    <div class="row">
      <h2 class="h6 col-sm-auto">実店舗で販売中の商品・サービス・価格を比較</h2>
      <small class="col-sm-auto">※必ずしも在庫や価格を保証するものではありません</small>
    </div>
    <form id="search-form" action="/smcate" method="GET">
      @csrf
      <div class="input-group text-center">
        <input type="text" class="form-control form-control" placeholder="商品名 / サービス名 / JANコードで検索" name="keyword" value="{{$keyword}}">
        <input type="hidden" name="lat" id="lat" value="">
        <input type="hidden" name="lng" id="lng" value="">
        <input type="hidden" name="smid" id="smid" value="{{$smid}}">
        <span class="input-group-append">
          <button type="submit" class="btn btn-search" id="keyword"><i class="fas fa-search"></i>検索</button>
        </span>
      </div>
    </form>
  </div>
  <div class="order-lg-2 order-1">
    <p class="text-right">PR:/ああああああああああああ</p>
  </div>
</div>