@extends('adminlte::top-page')

@section('title', 'Storemap：ストアマップ')

{{-- @section('content_header')
<h1>Dashboard</h1>
@stop --}}

@section('content_top_nav_left')
{{-- <ul class="navbar-nav">
  <li class="nav-item">
    <a href="index3.html" class="nav-link">Home</a>
  </li>
  <li class="nav-item">
    <a href="#" class="nav-link">Contact</a>
  </li>
  <li class="nav-item dropdown">
    <a id="dropdownSubMenu1" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="nav-link dropdown-toggle">Dropdown</a>
    <ul aria-labelledby="dropdownSubMenu1" class="dropdown-menu border-0 shadow">
      <li><a href="#" class="dropdown-item">Some action </a></li>
      <li><a href="#" class="dropdown-item">Some other action</a></li>

      <li class="dropdown-divider"></li>

      <!-- Level two dropdown-->
      <li class="dropdown-submenu dropdown-hover">
        <a id="dropdownSubMenu2" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="dropdown-item dropdown-toggle">Hover for action</a>
        <ul aria-labelledby="dropdownSubMenu2" class="dropdown-menu border-0 shadow">
          <li>
            <a tabindex="-1" href="#" class="dropdown-item">level 2</a>
          </li>

          <!-- Level three dropdown-->
          <li class="dropdown-submenu">
            <a id="dropdownSubMenu3" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="dropdown-item dropdown-toggle">level 2</a>
            <ul aria-labelledby="dropdownSubMenu3" class="dropdown-menu border-0 shadow">
              <li><a href="#" class="dropdown-item">3rd level</a></li>
              <li><a href="#" class="dropdown-item">3rd level</a></li>
            </ul>
          </li>
          <!-- End Level three -->

          <li><a href="#" class="dropdown-item">level 2</a></li>
          <li><a href="#" class="dropdown-item">level 2</a></li>
        </ul>
      </li>
      <!-- End Level two -->
    </ul>
  </li>
</ul> --}}
{{-- <form class="form-inline ml-0 ml-md-3">
  <div class="input-group input-group-sm">
    <input class="form-control form-control-navbar" type="search" placeholder="Search" aria-label="Search">
    <div class="input-group-append">
      <button class="btn btn-navbar" type="submit">
        <i class="fas fa-search"></i>
      </button>
    </div>
  </div>
</form> --}}
@stop

@section('content_top_nav_right')
{{-- ヘッダー右エリア --}}
@stop

{{-- @section('content_header')

@stop --}}

@section('content')

<section class="content">

  <div class="container">

    <div class="alert alert-success alert-dismissible">
      <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
      <h5><i class="icon fas fa-check"></i> ストアマップのアルファ版を公開致しました</h5>
      ストアマップは位置情報を利用して、近隣店舗で販売中の商品や価格を検索できるように設計されたサービスです。掲載を希望される場合は加盟店登録して頂き、商品の在庫や価格情報の登録が必要となります。在庫システムやPOSとの連携を広げることで、更新の手間を省けるように機能を拡張していく予定です。現在加盟店登録キャンペーン実施中で1年間無料でご利用いただけます。
    </div>

    <div class="row">
      <!-- left column -->
      <div class="col-12">
        <div class="card card-info">
          <div class="card-header">
            <h3 class="d-none d-md-block card-title">
              <i class="fas fa-map-marked-alt"></i> ストアマップは、近隣のお店の商品を検索できるサービスです
            </h3>
            <h3 class="d-block d-md-none card-title">
              <i class="fas fa-map-marked-alt"></i> 近隣のお店を検索
            </h3>
          </div>

          <div class="card-body">
            <form action="/result" method="GET" name="form1">
              @csrf
              <div id="search_class" class="input-group input-group-lg">
                <input type="text" class="form-control" placeholder="商品名 / サービス名 / JANコードで検索" name="keyword" value="">
                <input type="hidden" value="" name="id">
                <span class="input-group-append">
                  <button type="button" class="btn btn-primary" id="posSend1"><i class="fas fa-search"></i> 検索</button>
                </span>
              </div>
            </form>
          </div>
          <div class="card-footer search-footer">
            <small class="col-sm-auto">※在庫や価格を保証するものではありません。商品情報の詳細は店舗へ直接お問い合わせください。</small>
          </div>
        </div>
      </div>
      <!-- /.row -->
    </div>

    <div class="row">
      <!-- left column -->
      <div class="col-12">

        <div class="card card-info">
          <div class="card-header">
            <h3 class="card-title">
              <i class="fas fa-th-large"></i> カテゴリ別で探す
            </h3>
          </div>

          <div class="card-body text-sm">
            <div class="row">
              <div class="col-lg-3 col-md-4 col-sm-6 col-12">
                <form action="/result" method="GET" name="form2">
                  @csrf
                  <input type="hidden" value="12" name="id">
                  <a href="javascript:form2.submit()" class="d-flex pointer-set" id="posSend2">
                    <div class="info-box">
                      <span class="info-box-icon bg-pink"><i class="fas fa-tshirt"></i></span>

                      <div class="info-box-content">
                        <span class="info-box-text">ファッション</span>
                        <span class="info-box-number">Fashion</span>
                      </div>
                      <!-- /.info-box-content -->
                    </div>
                  </a>
                </form>
                <!-- /.info-box -->
              </div>
              <div class="col-lg-3 col-md-4 col-sm-6 col-12">
                <form action="/result" method="GET" name="form3">
                  @csrf
                  <input type="hidden" value="21" name="id">
                  <a href="javascript:form3.submit()" class="d-flex pointer-set" id="posSend3">
                    <div class="info-box">
                      <span class="info-box-icon bg-pink"><i class="fas fa-pizza-slice"></i></span>

                      <div class="info-box-content">
                        <span class="info-box-text">食品</span>
                        <span class="info-box-number">Food</span>
                      </div>
                      <!-- /.info-box-content -->
                    </div>
                  </a>
                </form>
              </div>
              <div class="col-lg-3 col-md-4 col-sm-6 col-12">
                <form action="/result" method="GET" name="form4">
                  @csrf
                  <input type="hidden" value="1" name="id">
                  <a href="javascript:form4.submit()" class="d-flex pointer-set" id="posSend4">
                    <div class="info-box">
                      <span class="info-box-icon bg-pink"><i class="fas fa-ticket-alt"></i></span>

                      <div class="info-box-content">
                        <span class="info-box-text">CD、音楽、チケット</span>
                        <span class="info-box-number">CD/Music/Ticket</span>
                      </div>
                      <!-- /.info-box-content -->
                    </div>
                  </a>
                </form>
              </div>
              <div class="col-lg-3 col-md-4 col-sm-6 col-12">
                <form action="/result" method="GET" name="form5">
                  @csrf
                  <input type="hidden" value="2" name="id">
                  <a href="javascript:form5.submit()" class="d-flex pointer-set" id="posSend5">
                    <div class="info-box">
                      <span class="info-box-icon bg-pink"><i class="fas fa-tools"></i></span>

                      <div class="info-box-content">
                        <span class="info-box-text">DIY、工具</span>
                        <span class="info-box-number">DIY/Tool</span>
                      </div>
                      <!-- /.info-box-content -->
                    </div>
                  </a>
                </form>
              </div>
              <div class="col-lg-3 col-md-4 col-sm-6 col-12">
                <form action="/result" method="GET" name="form6">
                  @csrf
                  <input type="hidden" value="3" name="id">
                  <a href="javascript:form6.submit()" class="d-flex pointer-set" id="posSend6">
                    <div class="info-box">
                      <span class="info-box-icon bg-pink"><i class="fas fa-compact-disc"></i></span>

                      <div class="info-box-content">
                        <span class="info-box-text">DVD、映像ソフト</span>
                        <span class="info-box-number">DVD/Soft</span>
                      </div>
                      <!-- /.info-box-content -->
                    </div>
                  </a>
                </form>
              </div>
              <div class="col-lg-3 col-md-4 col-sm-6 col-12">
                <form action="/result" method="GET" name="form7">
                  @csrf
                  <input type="hidden" value="4" name="id">
                  <a href="javascript:form7.submit()" class="d-flex pointer-set" id="posSend7">
                    <div class="info-box">
                      <span class="info-box-icon bg-pink"><i class="fas fa-campground"></i></span>

                      <div class="info-box-content">
                        <span class="info-box-text">アウトドア、釣り、旅行用品</span>
                        <span class="info-box-number">Outdoor</span>
                      </div>
                      <!-- /.info-box-content -->
                    </div>
                  </a>
                </form>
              </div>
              <div class="col-lg-3 col-md-4 col-sm-6 col-12">
                <form action="/result" method="GET" name="form8">
                  @csrf
                  <input type="hidden" value="5" name="id">
                  <a href="javascript:form8.submit()" class="d-flex pointer-set" id="posSend8">
                    <div class="info-box">
                      <span class="info-box-icon bg-pink"><i class="fas fa-pencil-alt"></i></span>

                      <div class="info-box-content">
                        <span class="info-box-text">キッチン、日用品、文具</span>
                        <span class="info-box-number">Kitchen</span>
                      </div>
                      <!-- /.info-box-content -->
                    </div>
                  </a>
                </form>
              </div>
              <div class="col-lg-3 col-md-4 col-sm-6 col-12">
                <form action="/result" method="GET" name="form9">
                  @csrf
                  <input type="hidden" value="6" name="id">
                  <a href="javascript:form9.submit()" class="d-flex pointer-set" id="posSend9">
                    <div class="info-box">
                      <span class="info-box-icon bg-pink"><i class="fas fa-gamepad"></i></span>

                      <div class="info-box-content">
                        <span class="info-box-text">ゲーム、おもちゃ</span>
                        <span class="info-box-number">Game</span>
                      </div>
                      <!-- /.info-box-content -->
                    </div>
                  </a>
                </form>
              </div>
              <div class="col-lg-3 col-md-4 col-sm-6 col-12">
                <form action="/result" method="GET" name="form10">
                  @csrf
                  <input type="hidden" value="7" name="id">
                  <a href="javascript:form10.submit()" class="d-flex pointer-set" id="posSend10">
                    <div class="info-box">
                      <span class="info-box-icon bg-pink"><i class="fas fa-hand-sparkles"></i></span>

                      <div class="info-box-content">
                        <span class="info-box-text">コスメ、美容、ヘアケア</span>
                        <span class="info-box-number">Cosmetic</span>
                      </div>
                      <!-- /.info-box-content -->
                    </div>
                  </a>
                </form>
              </div>
              <div class="col-lg-3 col-md-4 col-sm-6 col-12">
                <form action="/result" method="GET" name="form11">
                  @csrf
                  <input type="hidden" value="8" name="id">
                  <a href="javascript:form11.submit()" class="d-flex pointer-set" id="posSend11">
                    <div class="info-box">
                      <span class="info-box-icon bg-pink"><i class="fas fa-futbol"></i></span>

                      <div class="info-box-content">
                        <span class="info-box-text">スポーツ</span>
                        <span class="info-box-number">Sport</span>
                      </div>
                      <!-- /.info-box-content -->
                    </div>
                  </a>
                </form>
              </div>
              <div class="col-lg-3 col-md-4 col-sm-6 col-12">
                <form action="/result" method="GET" name="form12">
                  @csrf
                  <input type="hidden" value="9" name="id">
                  <a href="javascript:form12.submit()" class="d-flex pointer-set" id="posSend12">
                    <div class="info-box">
                      <span class="info-box-icon bg-pink"><i class="fas fa-mobile-alt"></i></span>

                      <div class="info-box-content">
                        <span class="info-box-text">スマホ、タブレット、パソコン</span>
                        <span class="info-box-number">SmartPhone</span>
                      </div>
                      <!-- /.info-box-content -->
                    </div>
                  </a>
                </form>
              </div>
              <div class="col-lg-3 col-md-4 col-sm-6 col-12">
                <form action="/result" method="GET" name="form13">
                  @csrf
                  <input type="hidden" value="10" name="id">
                  <a href="javascript:form13.submit()" class="d-flex pointer-set" id="posSend13">
                    <div class="info-box">
                      <span class="info-box-icon bg-pink"><i class="fab fa-gratipay"></i></span>

                      <div class="info-box-content">
                        <span class="info-box-text">ダイエット、健康</span>
                        <span class="info-box-number">Healthcare</span>
                      </div>
                      <!-- /.info-box-content -->
                    </div>
                  </a>
                </form>
              </div>
              <div class="col-lg-3 col-md-4 col-sm-6 col-12">
                <form action="/result" method="GET" name="form14">
                  @csrf
                  <input type="hidden" value="11" name="id">
                  <a href="javascript:form14.submit()" class="d-flex pointer-set" id="posSend14">
                    <div class="info-box">
                      <span class="info-box-icon bg-pink"><i class="fas fa-tv"></i></span>

                      <div class="info-box-content">
                        <span class="info-box-text">テレビ、オーディオ、カメラ</span>
                        <span class="info-box-number">TV/Audio</span>
                      </div>
                      <!-- /.info-box-content -->
                    </div>
                  </a>
                </form>
              </div>
              <div class="col-lg-3 col-md-4 col-sm-6 col-12">
                <form action="/result" method="GET" name="form15">
                  @csrf
                  <input type="hidden" value="12" name="id">
                  <a href="javascript:form15.submit()" class="d-flex pointer-set" id="posSend15">
                    <div class="info-box">
                      <span class="info-box-icon bg-pink"><i class="fas fa-cat"></i></span>

                      <div class="info-box-content">
                        <span class="info-box-text">ペット用品、生き物</span>
                        <span class="info-box-number">Pet</span>
                      </div>
                      <!-- /.info-box-content -->
                    </div>
                  </a>
                </form>
              </div>
              <div class="col-lg-3 col-md-4 col-sm-6 col-12">
                <form action="/result" method="GET" name="form16">
                  @csrf
                  <input type="hidden" value="14" name="id">
                  <a href="javascript:form16.submit()" class="d-flex pointer-set" id="posSend16">
                    <div class="info-box">
                      <span class="info-box-icon bg-pink"><i class="fas fa-baby"></i></span>

                      <div class="info-box-content">
                        <span class="info-box-text">ベビー、キッズ、マタニティ</span>
                        <span class="info-box-number">Baby/Kids</span>
                      </div>
                      <!-- /.info-box-content -->
                    </div>
                  </a>
                </form>
              </div>
              <div class="col-lg-3 col-md-4 col-sm-6 col-12">
                <form action="/result" method="GET" name="form17">
                  @csrf
                  <input type="hidden" value="15" name="id">
                  <a href="javascript:form17.submit()" class="d-flex pointer-set" id="posSend17">
                    <div class="info-box">
                      <span class="info-box-icon bg-pink"><i class="fas fa-concierge-bell"></i></span>

                      <div class="info-box-content">
                        <span class="info-box-text">レンタル、各種サービス</span>
                        <span class="info-box-number">Rental</span>
                      </div>
                      <!-- /.info-box-content -->
                    </div>
                  </a>
                </form>
              </div>
              <div class="col-lg-3 col-md-4 col-sm-6 col-12">
                <form action="/result" method="GET" name="form18">
                  @csrf
                  <input type="hidden" value="16" name="id">
                  <a href="javascript:form18.submit()" class="d-flex pointer-set" id="posSend18">
                    <div class="info-box">
                      <span class="info-box-icon bg-pink"><i class="fas fa-couch"></i></span>

                      <div class="info-box-content">
                        <span class="info-box-text">家具、インテリア</span>
                        <span class="info-box-number">Furniture</span>
                      </div>
                      <!-- /.info-box-content -->
                    </div>
                  </a>
                </form>
              </div>
              <div class="col-lg-3 col-md-4 col-sm-6 col-12">
                <form action="/result" method="GET" name="form19">
                  @csrf
                  <input type="hidden" value="17" name="id">
                  <a href="javascript:form19.submit()" class="d-flex pointer-set" id="posSend19">
                    <div class="info-box">
                      <span class="info-box-icon bg-pink"><i class="fas fa-blender"></i></span>

                      <div class="info-box-content">
                        <span class="info-box-text">家電</span>
                        <span class="info-box-number">Appliances</span>
                      </div>
                      <!-- /.info-box-content -->
                    </div>
                  </a>
                </form>
              </div>
              <div class="col-lg-3 col-md-4 col-sm-6 col-12">
                <form action="/result" method="GET" name="form20">
                  @csrf
                  <input type="hidden" value="18" name="id">
                  <a href="javascript:form20.submit()" class="d-flex pointer-set" id="posSend20">
                    <div class="info-box">
                      <span class="info-box-icon bg-pink"><i class="fas fa-tree"></i></span>

                      <div class="info-box-content">
                        <span class="info-box-text">花、ガーデニング</span>
                        <span class="info-box-number">Flower</span>
                      </div>
                      <!-- /.info-box-content -->
                    </div>
                  </a>
                </form>
              </div>
              <div class="col-lg-3 col-md-4 col-sm-6 col-12">
                <form action="/result" method="GET" name="form21">
                  @csrf
                  <input type="hidden" value="19" name="id">
                  <a href="javascript:form21.submit()" class="d-flex pointer-set" id="posSend21">
                    <div class="info-box">
                      <span class="info-box-icon bg-pink"><i class="fas fa-drum"></i></span>

                      <div class="info-box-content">
                        <span class="info-box-text">楽器、手芸、コレクション</span>
                        <span class="info-box-number">Handicraft</span>
                      </div>
                      <!-- /.info-box-content -->
                    </div>
                  </a>
                </form>
              </div>
              <div class="col-lg-3 col-md-4 col-sm-6 col-12">
                <form action="/result" method="GET" name="form22">
                  @csrf
                  <input type="hidden" value="20" name="id">
                  <a href="javascript:form22.submit()" class="d-flex pointer-set" id="posSend22">
                    <div class="info-box">
                      <span class="info-box-icon bg-pink"><i class="fas fa-car-side"></i></span>

                      <div class="info-box-content">
                        <span class="info-box-text">車、バイク、自転車</span>
                        <span class="info-box-number">Car/Bike</span>
                      </div>
                      <!-- /.info-box-content -->
                    </div>
                  </a>
                </form>
              </div>
              <div class="col-lg-3 col-md-4 col-sm-6 col-12">
                <form action="/result" method="GET" name="form23">
                  @csrf
                  <input type="hidden" value="22" name="id">
                  <a href="javascript:form23.submit()" class="d-flex pointer-set" id="posSend23">
                    <div class="info-box">
                      <span class="info-box-icon bg-pink"><i class="fas fa-book-open"></i></span>

                      <div class="info-box-content">
                        <span class="info-box-text">本、雑誌、コミック</span>
                        <span class="info-box-number">Book</span>
                      </div>
                      <!-- /.info-box-content -->
                    </div>
                  </a>
                </form>
              </div>
            </div>
          </div>
          {{-- <div class="card-footer">

                  </div> --}}
        </div>
      </div>
      <!-- /.row -->
    </div>

    <div class="row">
      <!-- left column -->
      <div class="col-12">

        <div class="card card-info">
          <div class="card-header">
            <h3 class="card-title">
              <i class="fas fa-map"></i> 地域から選ぶ
            </h3>
          </div>
          <div class="card-body">
            <div class="row">
              <div class="col-12 col-md-6 col-lg-5 mb-3 mb-md-0 pr-0 pr-md-3">
                <div class="map"></div>
              </div>
              <div class="col-12 col-md-6 col-lg-7">
                <div id="prefArea" class="row">
                  <h4 class="col-12 pb-2 mb-2" style="border-bottom: 1px solid #999;">都道府県別</h4>
                  <h6 class="col-3"><a href="/result?pref=%E5%8C%97%E6%B5%B7%E9%81%93" class="pref-link">北海道</a></h6>
                  <h6 class="col-3"><a href="/result?pref=%E9%9D%92%E6%A3%AE%E7%9C%8C" class="pref-link">青森県</a></h6>
                  <h6 class="col-3"><a href="/result?pref=%E7%A7%8B%E7%94%B0%E7%9C%8C" class="pref-link">秋田県</a></h6>
                  <h6 class="col-3"><a href="/result?pref=%E5%B1%B1%E5%BD%A2%E7%9C%8C" class="pref-link">山形県</a></h6>
                  <h6 class="col-3"><a href="/result?pref=%E7%A6%8F%E5%B3%B6%E7%9C%8C" class="pref-link">福島県</a></h6>
                  <h6 class="col-3"><a href="/result?pref=%E8%8C%A8%E5%9F%8E%E7%9C%8C" class="pref-link">茨城県</a></h6>
                  <h6 class="col-3"><a href="/result?pref=%E6%A0%83%E6%9C%A8%E7%9C%8C" class="pref-link">栃木県</a></h6>
                  <h6 class="col-3"><a href="/result?pref=%E7%BE%A4%E9%A6%AC%E7%9C%8C" class="pref-link">群馬県</a></h6>
                  <h6 class="col-3"><a href="/result?pref=%E5%9F%BC%E7%8E%89%E7%9C%8C" class="pref-link">埼玉県</a></h6>
                  <h6 class="col-3"><a href="/result?pref=%E5%8D%83%E8%91%89%E7%9C%8C" class="pref-link">千葉県</a></h6>
                  <h6 class="col-3"><a href="/result?pref=%E6%9D%B1%E4%BA%AC%E9%83%BD" class="pref-link">東京都</a></h6>
                  <h6 class="col-3"><a href="/result?pref=%E7%A5%9E%E5%A5%88%E5%B7%9D%E7%9C%8C" class="pref-link">神奈川県</a></h6>
                  <h6 class="col-3"><a href="/result?pref=%E6%96%B0%E6%BD%9F%E7%9C%8C" class="pref-link">新潟県</a></h6>
                  <h6 class="col-3"><a href="/result?pref=%E5%AF%8C%E5%B1%B1%E7%9C%8C" class="pref-link">富山県</a></h6>
                  <h6 class="col-3"><a href="/result?pref=%E7%9F%B3%E5%B7%9D%E7%9C%8C" class="pref-link">石川県</a></h6>
                  <h6 class="col-3"><a href="/result?pref=%E7%A6%8F%E4%BA%95%E7%9C%8C" class="pref-link">福井県</a></h6>
                  <h6 class="col-3"><a href="/result?pref=%E5%B1%B1%E6%A2%A8%E7%9C%8C" class="pref-link">山梨県</a></h6>
                  <h6 class="col-3"><a href="/result?pref=%E9%95%B7%E9%87%8E%E7%9C%8C" class="pref-link">長野県</a></h6>
                  <h6 class="col-3"><a href="/result?pref=%E5%B2%90%E9%98%9C%E7%9C%8C" class="pref-link">岐阜県</a></h6>
                  <h6 class="col-3"><a href="/result?pref=%E9%9D%99%E5%B2%A1%E7%9C%8C" class="pref-link">静岡県</a></h6>
                  <h6 class="col-3"><a href="/result?pref=%E6%84%9B%E7%9F%A5%E7%9C%8C" class="pref-link">愛知県</a></h6>
                  <h6 class="col-3"><a href="/result?pref=%E4%B8%89%E9%87%8D%E7%9C%8C" class="pref-link">三重県</a></h6>
                  <h6 class="col-3"><a href="/result?pref=%E6%BB%8B%E8%B3%80%E7%9C%8C" class="pref-link">滋賀県</a></h6>
                  <h6 class="col-3"><a href="/result?pref=%E4%BA%AC%E9%83%BD%E5%BA%9C" class="pref-link">京都府</a></h6>
                  <h6 class="col-3"><a href="/result?pref=%E5%A4%A7%E9%98%AA%E5%BA%9C" class="pref-link">大阪府</a></h6>
                  <h6 class="col-3"><a href="/result?pref=%E5%85%B5%E5%BA%AB%E7%9C%8C" class="pref-link">兵庫県</a></h6>
                  <h6 class="col-3"><a href="/result?pref=%E5%A5%88%E8%89%AF%E7%9C%8C" class="pref-link">奈良県</a></h6>
                  <h6 class="col-3"><a href="/result?pref=%E5%92%8C%E6%AD%8C%E5%B1%B1%E7%9C%8C" class="pref-link">和歌山県</a></h6>
                  <h6 class="col-3"><a href="/result?pref=%E9%B3%A5%E5%8F%96%E7%9C%8C" class="pref-link">鳥取県</a></h6>
                  <h6 class="col-3"><a href="/result?pref=%E5%B3%B6%E6%A0%B9%E7%9C%8C" class="pref-link">島根県</a></h6>
                  <h6 class="col-3"><a href="/result?pref=%E5%B2%A1%E5%B1%B1%E7%9C%8C" class="pref-link">岡山県</a></h6>
                  <h6 class="col-3"><a href="/result?pref=%E5%BA%83%E5%B3%B6%E7%9C%8C" class="pref-link">広島県</a></h6>
                  <h6 class="col-3"><a href="/result?pref=%E5%B1%B1%E5%8F%A3%E7%9C%8C" class="pref-link">山口県</a></h6>
                  <h6 class="col-3"><a href="/result?pref=%E5%BE%B3%E5%B3%B6%E7%9C%8C" class="pref-link">徳島県</a></h6>
                  <h6 class="col-3"><a href="/result?pref=%E9%A6%99%E5%B7%9D%E7%9C%8C" class="pref-link">香川県</a></h6>
                  <h6 class="col-3"><a href="/result?pref=%E6%84%9B%E5%AA%9B%E7%9C%8C" class="pref-link">愛媛県</a></h6>
                  <h6 class="col-3"><a href="/result?pref=%E9%AB%98%E7%9F%A5%E7%9C%8C" class="pref-link">高知県</a></h6>
                  <h6 class="col-3"><a href="/result?pref=%E7%A6%8F%E5%B2%A1%E7%9C%8C" class="pref-link">福岡県</a></h6>
                  <h6 class="col-3"><a href="/result?pref=%E4%BD%90%E8%B3%80%E7%9C%8C" class="pref-link">佐賀県</a></h6>
                  <h6 class="col-3"><a href="/result?pref=%E9%95%B7%E5%B4%8E%E7%9C%8C" class="pref-link">長崎県</a></h6>
                  <h6 class="col-3"><a href="/result?pref=%E7%86%8A%E6%9C%AC%E7%9C%8C" class="pref-link">熊本県</a></h6>
                  <h6 class="col-3"><a href="/result?pref=%E5%A4%A7%E5%88%86%E7%9C%8C" class="pref-link">大分県</a></h6>
                  <h6 class="col-3"><a href="/result?pref=%E5%AE%AE%E5%B4%8E%E7%9C%8C" class="pref-link">宮崎県</a></h6>
                  <h6 class="col-3"><a href="/result?pref=%E9%B9%BF%E5%85%90%E5%B3%B6%E7%9C%8C" class="pref-link">鹿児島県</a></h6>
                  <h6 class="col-3"><a href="/result?pref=%E6%B2%96%E7%B8%84%E7%9C%8C" class="pref-link">沖縄県</a></h6>
                </div>
              </div>
            </div>
          </div>
          {{-- <div class="card-footer"></div> --}}
        </div>
      </div>
      <!-- /.row -->

      <div class="col-12">
        @include('partials.footerlink')
      </div>

    </div>
  </div><!-- /.container-fluid -->
</section>

@stop

@section('footer')
<div class="float-right d-none d-sm-block">{!! config('const.manage.version') !!}</div>
{!! config('const.manage.footer') !!}
@stop

@section('css')
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.14.0/css/all.css" integrity="sha384-HzLeBuhoNPvSl5KYnjx0BT+WB0QEEqLprO+NBkkk5gbc67FTaL7XIGa2w1L0Xbgc" crossorigin="anonymous">
<link rel="stylesheet" href="/css/admin_custom.css">
<style type="text/css">
  .pointer-set {
    cursor: pointer;
    color: #212529;
  }

  .pref-link {
    color: #212529;
  }

  .info-box .info-box-text,
  .info-box .progress-description {
    white-space: normal;
  }

  .info-box {
    min-height: 60px;
    margin-bottom: 0.75rem;
  }

  .info-box .info-box-icon {
    flex: 0 0 40px;
    font-size: 1rem;
    width: 40px;
  }

  .info-box-number {
    font-family: Arial, Helvetica, sans-serif;
  }

  .search-footer {
    line-height: 1.2;
  }

  /* div.jmap-container {
    padding: 0rem !important;
  } */

  .geolonia-svg-map {
    width: 100%;
  }

  .geolonia-svg-map .prefecture {
    fill: #f7f7f7;
    stroke: #666666;
    cursor: pointer;
  }

  .geolonia-svg-map .boundary-line {
    stroke: #999999;
  }

  #prefArea h6 {
    line-height: 1.2rem;
    font-size: 0.85rem;
  }

  #prefArea h6::before {
    font-family: "Font Awesome 5 Free";
    font-weight: 900;
    content: "\f105";
    margin-right: .25rem;
  }

  @media (min-width: 576px) {
    .info-box .info-box-icon {
      flex: 0 0 50px;
      font-size: 1.25rem;
      width: 50px;
    }
    #prefArea h6 {
      line-height: 1.35rem;
      font-size: 0.9rem;
    }
  }

  @media (min-width: 768px) {
    .info-box {
      min-height: 70px;
    }

    .info-box .info-box-icon {
      flex: 0 0 60px;
      font-size: 1.5rem;
      width: 60px;
    }
    #prefArea h6 {
      line-height: 1.5rem;
      font-size: 1rem;
    }
  }

  @media (min-width: 992px) {
    .info-box {
      min-height: 80px;
    }

    .info-box .info-box-icon {
      flex: 0 0 70px;
      font-size: 1.875rem;
      width: 70px;
    }
  }

  @media (min-width: 1200px) {}
</style>
@stop

@section('js')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script>
  'use strict';

  // 検索時に先に緯度経度情報取得
  function getPosition() {
    return new Promise((res, rej) => {
      navigator.geolocation.getCurrentPosition(res, rej);
    });
  }

  // キーワード検索時に緯度経度を追加
  $(function () {
    for (let i = 0; i < 24; i++) {
      $('#posSend' + i).on('click', function () {
        getPosition()
          .then(function (value) {
            // event.preventDefault();
            var form = $('#posSend' + i).parents('form');
            // console.log(value);
            var lat = value.coords.latitude;
            var lng = value.coords.longitude;

            $('<input>').attr({
              'type': 'hidden',
              'name': 'lat',
              'id': 'lat',
              'value': lat
            }).appendTo(form);
            $('<input>').attr({
              'type': 'hidden',
              'name': 'lng',
              'id': 'lng',
              'value': lng
            }).appendTo(form);
            form.submit();
          })
          .catch(function (value) {
            // 非同期処理が失敗した場合
            window.alert("位置情報の取得に失敗しました");
          });
      });
    }
  })

</script>

<script type="text/javascript">
const maps = [ "/svg/map-mobile.svg"]
const containers = document.querySelectorAll( '.map' )

maps.forEach( async ( map, index ) => {
  const res = await fetch( map )

  if ( res.ok ) {
    const svg = await res.text()
    containers[ index ].innerHTML = svg
    const prefs = document.querySelectorAll( '.geolonia-svg-map .prefecture' )

    prefs.forEach( ( pref ) => {
      pref.addEventListener( 'mouseover', ( event ) => {
        event.currentTarget.style.fill = "#ffc107"
      } )
      pref.addEventListener( 'mouseleave', ( event ) => {
        event.currentTarget.style.fill = ""
      } )
          // マウスクリック時のイベント
      pref.addEventListener( 'click', ( event ) => {
        location.href = `/result/${event.currentTarget.dataset.code}`
      } )
    } )
  }
} )
</script>
<script type="text/javascript">
  // フォームのレスポンシブ対応
  $(function(){
  if(window.matchMedia("(max-width:640px)").matches){
    $('#search_class').addClass('input-group-sm').removeClass('input-group-lg');  //640px以下の場合
   }else{
    $('#search_class').addClass('input-group-lg').removeClass('input-group-sm');  //640px以上の場合
  }
  })
</script>

@stop