@extends('adminlte::top-page')

@section('title', 'Storemap：ストアマップ / 掲載について')

@section('content_header')
{{-- <h1>ストアマップ / 掲載について</h1> --}}
@stop

@section('content_top_nav_left')

@stop

@section('content_top_nav_right')
{{-- ヘッダー右エリア --}}
@stop

{{-- @section('content_header')

@stop --}}

@section('content')

<section class="content">
  <div class="container">
    <div class="row">
      <div class="col-6">
        <div class="info-box mb-3 bg-warning">
          <span class="info-box-icon"><i class="fas fa-map-marked-alt"></i></span>
          <div class="info-box-content">
            <h3 class="h5 mb-0"><strong>掲載について</strong></h3>
            <span class="info-box-text">Publish on the site</span>
          </div>
          <!-- /.info-box-content -->
        </div>
      </div>
      <div class="col-6">
        <a href="/pricelist" class="text-dark">
          <div class="info-box mb-3">
            <span class="info-box-icon"><i class="far fa-credit-card"></i></span>
            <div class="info-box-content">
              <h3 class="h5 mb-0"><strong>料金表</strong></h3>
              <span class="info-box-text">Price list</span>
            </div>
            <!-- /.info-box-content -->
          </div>
        </a>
      </div>

      <!-- left column -->
      <div class="col-12">
        <div class="card">
          <div class="card-body">
            <div class="row">
              <h2 class="card-title col-12 mb-5"><img src="{{ asset('img/info_img01.jpg') }}" alt="ストアマップに掲載して、あなたのお店の商品をPRしませんか？" style="max-width:100%;""></h2>
              <h3 class=" text-center col-12 text-danger mb-2"><strong>実店舗で販売中の商品がわかる</strong></h3>
                <p class="col-sm-6">
                  ストアマップは実店舗で販売中の商品を、インターネットを通じて表示するサービスです。<br>位置情報及び、地図アプリを利用することで、近隣ユーザーに対してお店の商品や価格、セール情報などを効率的にアピールすることが出来ます。
                </p>
                <div class="col-sm-6"><img src="{{ asset('img/info_img02-2.gif') }}" style="max-width: 100%;"></div>
                <h3 class=" text-center col-12 text-danger mt-5"><strong>ネットで調べてお店で買う</strong></h3>
                <p class="col-sm-6">
                  ネットショッピングで調べた商品を、手に取って確認してみたいと思ったことはありませんか？<br>服のサイズや靴の大きさをなど試着してみたいと思ったことありませんか？<br>ストアマップでは商品名及び価格や在庫情報を登録することで、ピンポイントでユーザーに商品情報を届けることが可能です。ネットで調べて店舗へ誘導することが可能な、「ウェブルーミング」ツールとして非常に有用です。
                </p>
                <div class="col-sm-6"><img src="{{ asset('img/info_img02.jpg') }}" style="max-width: 100%;"></div>
                <h3 class=" text-center col-12 text-danger mt-5"><strong>価格比較が簡単！</strong></h3>
                <p class="col-sm-6">
                  「お店で買った商品が、他の店舗に行ったらもっと安くで売っていた！」そんな経験ありませんか？<br>ストアマップでは、商品価格をピンポイで訴求可能なため、エンドユーザーが効率的に商品を探すことが出来ます。特に普段の買い物を上手に工夫されている主婦層にも、ダイレクトにアプローチが可能です。
                </p>
                <div class="col-sm-6"><img src="{{ asset('img/info_img04.jpg') }}" style="max-width: 100%;"></div>
                <h3 class=" text-center col-12 text-danger mt-5"><strong>今すぐ欲しい！何処に売ってるの？</strong></h3>
                <p class="col-sm-6">
                  あなたが使っているこだわりの商品、何処に売っているかわからない事がありませんか？ネットショッピングだと簡単に調べて手に入る商品も、実店舗だと何処に売っているかわからない。そんな経験ありませんか？<br>
                  ストアマップでは商品名やJANコードから、取扱店舗を簡単に調べることが可能です。またネットショップでは送料が必要なことが多々ありますが、直接エンドユーザーに来店して頂くので送料がかからないといったメリットもあります。
                </p>
                <div class="col-sm-6"><img src="{{ asset('img/info_img03.jpg') }}" style="max-width: 100%;"></div>
                <h3 class=" text-center col-12 text-danger mt-5"><strong>あなたの会社の商品が何処に売っているかご存知ですか？</strong></h3>
                <p class="col-sm-6">
                  あなたの会社で作られた商品が、何処の店舗で売られているか詳細を把握されていますか？<br>卸問屋さんを通して流通されている商品は、最終的に何処の小売店さんで売っているかわからないことが多々あります。ストアマップでは小売店さんに直接商品を登録して頂くシステムなので、メーカー様にも流通経路や、販売場所についての情報を知ることができる大きなメリットがあります。弊社独自のカタログ機能があるので、商品登録だけでも行って頂ければ、小売店さんが簡単に商品情報をコピーして使用可能になり、販売促進につながります。<br>※現在調整中ですが、メーカーさまによる商品をセグメントした、エンドユーザーにダイレクトに訴求可能な広告も実装予定です。
                </p>
                <div class="col-sm-6"><img src="{{ asset('img/info_img05.jpg') }}" style="max-width: 100%;"></div>
                {{-- <div class="col-12 mb-5">
                  <div class="row">
                    <dl class="col-sm-6">
                      <dt>実店舗で販売中の商品がわかる</dt>
                      <dd>ストアマップは実店舗で販売中の商品を、インターネットを通じて表示するサービスです。<br>位置情報及び、地図アプリを利用することで、近隣ユーザーに対してお店の商品や価格、セール情報などを効率的にアピールすることが出来ます。</dd>
                    </dl>
                    <div class="col-sm-6"><img src="{{ asset('img/info_img02-2.gif') }}" style="max-width: 100%;">
            </div>
          </div>
        </div> --}}
        {{-- <div class="col-12 mb-5">
          <div class="row">
            <div class="col-sm-6"><img src="{{ asset('img/info_img02.jpg') }}" style="max-width: 100%;"></div>
            <dl class="col-sm-6">
              <dt>ネットで調べてお店で買う</dt>
              <dd>ネットショッピングで調べた商品を、手に取って確認してみたいと思ったことはありませんか？<br>服のサイズや靴の大きさをなど試着してみたいと思ったことありませんか？<br>ストアマップでは商品名及び価格や在庫情報を登録することで、ピンポイントでユーザーに商品情報を届けることが可能です。ネットで調べて店舗へ誘導することが可能な、「ウェブルーミング」ツールとして非常に有用です。
              </dd>
            </dl>
          </div>
        </div> --}}
        {{-- <div class=" col-12 mb-5">
          <div class="row">
            <dl class="col-sm-6">
              <dt>価格比較が簡単！</dt>
              <dd>「お店で買った商品が、他の店舗に行ったらもっと安くで売っていた！」そんな経験ありませんか？<br>ストアマップでは、商品価格をピンポイで訴求可能なため、エンドユーザーが効率的に商品を探すことが出来ます。特に普段の買い物を上手に工夫されている主婦層にも、ダイレクトにアプローチが可能です。</dd>
            </dl>
            <div class="col-sm-6"><img src="{{ asset('img/info_img04.jpg') }}" style="max-width: 100%;"></div>
          </div>
        </div> --}}
        {{-- <div class="col-12 mb-5">
          <div class="row">
            <div class="col-sm-6"><img src="{{ asset('img/info_img03.jpg') }}" style="max-width: 100%;"></div>
            <dl class="col-sm-6">
              <dt>今すぐ欲しい！何処に売ってるの？</dt>
              <dd>あなたが使っているこだわりの商品、何処に売っているかわからない事がありませんか？ネットショッピングだと簡単に調べて手に入る商品も、実店舗だと何処に売っているかわからない。そんな経験ありませんか？<br>
                ストアマップでは商品名やJANコードから、取扱店舗を簡単に調べることが可能です。またネットショップでは送料が必要なことが多々ありますが、直接エンドユーザーに来店して頂くので送料がかからないといったメリットもあります。
              </dd>
            </dl>
          </div>
        </div> --}}
        {{-- <div class=" col-12 mb-5">
          <div class="row">
            <dl class="col-sm-6">
              <dt>あなたの会社の商品が何処に売っているかご存知ですか？</dt>
              <dd>あなたの会社で作られた商品が、何処の店舗で売られているか詳細を把握されていますか？<br>卸問屋さんを通して流通されている商品は、最終的に何処の小売店さんで売っているかわからないことが多々あります。ストアマップでは小売店さんに直接商品を登録して頂くシステムなので、メーカー様にも流通経路や、販売場所についての情報を知ることができる大きなメリットがあります。弊社独自のカタログ機能があるので、商品登録だけでも行って頂ければ、小売店さんが簡単に商品情報をコピーして使用可能になり、販売促進につながります。<br>※現在調整中ですが、メーカーさまによる商品をセグメントした、エンドユーザーにダイレクトに訴求可能な広告も実装予定です。</dd>
            </dl>
            <div class="col-sm-6"><img src="{{ asset('img/info_img05.jpg') }}" style="max-width: 100%;"></div>
          </div>
        </div> --}}
        <h3 class=" text-center col-12 text-danger mt-5"><strong>その他の項目について</strong></h3>
        <div class=" col-12 mb-5">
          <div class="row">
            <dl class="col-sm-6">
              <dt>まだまだあります。使える便利機能！</dt>
              <dd>
                <ul>
                  <li>商品の棚番号を表示</li>
                  <li>チラシ画像の掲載</li>
                  <li>イベントカレンダーの作成</li>
                  <li>OPENからCLOSDEまでお店の営業日時の掲載</li>
                </ul>
              </dd>
            </dl>
            <dl class="col-sm-6">
              <dt>今後の実装予定について</dt>
              <dd>
                <ul>
                  <li>APIによる価格・在庫連動機能</li>
                  <li>予約・取置機能</li>
                  <li>OPEN及びCLOSED時間中のバッジ表示</li>
                  <li>ユーザー会員登録機能とそれに付随する機能</li>
                  <li>その他随時開発中</li>
                </ul>
              </dd>
            </dl>
          </div>
        </div>

        <div class="col-12 callout callout-info mb-5">
          <h3>※特許申請中</h3>
          <p>出願番号:2020-47238。地図とお店情報の連携部分や、APIによるPOSレジなどとの価格・在庫連携について出願中です。
          </p>
        </div>

        <div class="col-md-4">
          <a href="/contact" class="btn btn-block btn-primary btn-lg mb-2">お問い合わせ</a>
        </div>
        <div class="col-md-4">
          <a href="/pricelist" class="btn btn-block btn-primary btn-lg mb-2">価格について</a>
        </div>
        <div class="col-md-4">
          <a href="/seller-registe" class="btn btn-block btn-primary btn-lg mb-2">新規登録はこちら</a>
        </div>

      </div>
    </div>
  </div>
  <div class="col-12">
    @include('partials.footerlink')
  </div>
  <!-- /.row -->
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
<style>
  .info-box-content{
      font-size: 0.7rem;
    }
  .info-box-content h3{
      font-size: 0.8rem;
    }
    .card-body h3{
      font-size: 1.1rem;
    }

  @media (min-width: 576px) {
    .info-box-content{
      font-size: 0.75rem;
    }
    .info-box-content h3{
      font-size: 0.85rem;
    }
    .card-body h3{
      font-size: 1.35rem;
    }

  }

  @media (min-width: 768px) {
    .info-box-content{
      font-size: 1rem;
    }
    .info-box-content h3{
      font-size: 1rem;
    }
    .card-body h3{
      font-size: 1.75rem;
    }
  }

  @media (min-width: 992px) {}

  @media (min-width: 1200px) {}
</style>
@stop

@section('js')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
@stop