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
        <a href="#pricelist" class="text-dark">
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
              <div class="post">
                <h1 class="card-title col-12 mb-5"><img src="{{ asset('img/keisai.gif') }}" alt="ストアマップ[storemap]に掲載して、あなたのお店の商品をPRしませんか？" style="max-width:100%;""></h1>
              </div>

              <div class=" post">
                  <h2 class=" text-center col-12 text-danger mb-4"><strong>お店で販売中の商品を、地図上に掲載しませんか？</strong></h2>
                  <div class="row">
                    <div class="col-sm-6">
                      <h3 class="mb-3"><strong>■ 近隣の人にアピールしたい</strong></h3>
                      <p>ストアマップは実店舗で販売中の商品や価格を、インターネットを通じて検索可能なサービスです。<br> 位置情報と地図を利用することで、近隣ユーザーに対してお店の商品や価格、セール情報などを効率的にアピールすることが出来ます。</p>
                      <p>在宅中以外にも旅先や通勤・通学時に立ち寄り可能な店舗の検索から、旅行先での物産店探しや、ニッチな商品の探索にも役立ちます。
                      </p>
                    </div>
                    <div class="col-sm-6"><img src="{{ asset('img/info_img01.gif') }}" style="max-width: 100%;"></div>
                  </div>

                  <div class="row border-top pt-4 mt-4">
                    <div class="col-sm-6"><img src="{{ asset('img/info_img02.jpg') }}" style="max-width: 100%;"></div>
                    <div class="col-sm-6">
                      <h3 class="mb-3"><strong>■ 商品を手に取って見て欲しい</strong></h3>
                      <p>ネットでは素材感や、服のサイズ感は写真でしか判断できません。買ってみたけど、色やサイズ、使い心地が想像と異なる。「思っていたのとは違う」は今や常識となっています。品質の高い商品も、写真の技術や加工・説明文次第で魅力が半減します。</p>
                      <p>実店舗では接客を受けながら試着し、触り心地を確かめショッピングを楽しむことが可能です。ストアマップではネットで欲しいと思った商品があったときに、すぐに検索して近隣店舗へ買いに行くことが可能になります。
                      </p>
                    </div>
                  </div>

                  <div class="row border-top pt-4 mt-4">
                    <div class="col-sm-6">
                      <h3 class="mb-3"><strong>■ ネットより安くで売ってるのに...</strong></h3>
                      <p>表示価格が安いからネットで購入したのに、送料を合わせると実店舗のほうが安かったということがあります。敢えて安価に設定し、送料で稼ぐというショップも存在します。</p>
                      <p>ストアマップでは、お手元の端末やPCから、最寄りの複数店舗における商品価格を比較検討することが可能です。しかも、セール情報等も掲載できるから、よりお得にショッピングを楽しめます。ユーザーが直接店舗へ赴いてくれるので、送料の設定など煩わしい負担もありません。</p>
                    </div>
                    <div class="col-sm-6"><img src="{{ asset('img/info_img03.jpg') }}" style="max-width: 100%;"></div>
                  </div>

                  <div class="row border-top pt-4 mt-4">
                    <div class="col-sm-6"><img src="{{ asset('img/info_img04.jpg') }}" style="max-width: 100%;"></div>
                    <div class="col-sm-6">
                      <h3 class="mb-3"><strong>■ 在庫ロスをなくしたい</strong></h3>
                      <p>機会損失をなくすために過剰に仕入れすぎた在庫が、賞味期限切れや損傷などの理由で廃棄するとき損失を生み出します。実店舗ではネットと違い在庫ロス間近の商品などを、効率的に訴求できません。</p>
                      <p>ストアマップでは、ネットを通じてセール情報や販売店舗を訴求できます。在庫情報や価格情報は、POSレジやクラウドレジなどと連携することでリアルタイムに手間をかけず変更が可能です。また将来的にはスマートフォンへのプッシュ通知への対応の他、どの地域で、どういった商品がよく売られているのかといったデータを取得できるように対応を進めていきます。</p>
                    </div>
                  </div>

                  <div class="row border-top pt-4 mt-4">
                    <div class="col-sm-6">
                      <h3 class="mb-3"><strong>■ あなたの会社の商品が何処に売っているかご存知ですか？</strong></h3>
                      <p>あなたの会社で作られた商品が、何処の店舗で売られているか詳細を把握されていますか？<br>卸問屋さんを通して流通されている商品は、最終的に何処の小売店さんで売っているかわからないことが多々あります。ストアマップでは小売店さんに直接商品を登録して頂くシステムなので、メーカー様にも流通経路や、販売場所についての情報を知ることができる大きなメリットがあります。弊社独自のカタログ機能があるので、商品登録だけでも行って頂ければ、小売店さんが簡単に商品情報をコピーして使用可能になり、販売促進につながります。<br>※現在調整中ですが、メーカーさまによる商品をセグメントした、エンドユーザーにダイレクトに訴求可能な広告も実装予定です。</p>
                    </div>
                    <div class="col-sm-6"><img src="{{ asset('img/info_img05.jpg') }}" style="max-width: 100%;"></div>
                  </div>

                  <div class="row border-top pt-4 mt-4">
                    <h3 class=" text-center col-12 text-danger mt-5"><strong>その他の項目について</strong></h3>
                    <div class=" col-12 mb-5">
                      <div class="row">
                        <dl class="col-sm-6">
                          <dt>まだまだあります。使える便利機能！</dt>
                          <dd>
                            <ul>
                              <li>商品の棚番号表示</li>
                              <li>チラシ画像の掲載</li>
                              <li>イベントカレンダー</li>
                              <li>OPENからCLOSDEまでお店の営業日時の掲載</li>
                            </ul>
                          </dd>
                        </dl>
                        <dl class="col-sm-6">
                          <dt>今後の実装予定について</dt>
                          <dd>
                            <ul>
                              <li>APIによる価格・在庫連動機能の追加</li>
                              <li>予約・取置機能</li>
                              <li>OPEN及びCLOSED時間中のバッジ表示</li>
                              <li>ユーザー会員登録機能とそれに付随する機能</li>
                              <li>その他随時開発中</li>
                            </ul>
                          </dd>
                        </dl>
                      </div>
                    </div>
                  </div>

                  <div class="col-12 callout callout-info mb-5">
                    <h3>※特許申請中</h3>
                    <p>出願番号:2020-47238。地図とお店情報の連携部分や、APIによるPOSレジなどとの価格・在庫連携について出願中です。
                    </p>
                  </div>


              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-12">
        <div class="card">
          <div class="card-body">
            <div id="select-course" class="row">
              <div id="pricelist" class="col-12">
                <div class="alert alert-danger alert-dismissible">
                  <h5><i class="icon fas fa-ban"></i> ※ご契約について</h5>
                  ご契約は会社単位でお願い致します。店舗単位で契約されるとAPIによる在庫・価格連動機能や、商品情報や店舗の管理などが利用できません。
                </div>
              </div>
              <div class="col-md-6 col-12">
                <div class="card card-secondary">
                  <div class="card-header">
                    <h5 class="m-0">フリー</h5>
                  </div>
                  <div class="card-body">
                    <div class="callout callout-secondary">
                      <h3><small class="h6 mr-1">月額</small>{{number_format(config('services.stripe.free_price')) }}<small class="h6 ml-1">円</small></h3>
                      <small>※無料で使ってみたいお店向け（※初回登録後１年間はベーシックプランと同じ機能が使えるキャンペーン中）</small>
                    </div>
                    <ul>
                      <li>{{number_format(config('services.stripe.free_item'))}}商品まで登録可能（※初回登録後1年間は{{number_format(config('services.stripe.basic_item'))}}まで登録可能）</li>
                      <li>画像容量{{config('services.stripe.free_storage_domination')}}まで利用可能（※初回登録後1年間は{{config('services.stripe.basic_storage_domination')}}まで利用可能）</li>
                      <li>1店舗は追加課金なしで利用可能</li>
                      <li>※初回登録後1年間はAPIの利用が可能
                      </li>
                      <li>初期費用無料</li>
                    </ul>
                  </div>
                </div>
              </div>
              <div class="col-md-6 col-12">
                <div class="card card-info">
                  <div class="card-header">
                    <h5 class="m-0">ライト</h5>
                  </div>
                  <div class="card-body">
                    <div class="callout callout-info">
                      <h3><small class="h6 mr-1">月額</small>{{number_format(config('services.stripe.light_price')) }}<small class="h6 ml-1">円</small></h3>
                      <small>※商品点数が少なめのお店向け</small>
                    </div>
                    <ul>
                      <li>{{number_format(config('services.stripe.light_item'))}}商品まで登録可能</li>
                      <li>画像容量{{config('services.stripe.light_storage_domination')}}まで利用可能</li>
                      <li>1店舗は追加課金なしで利用可能</li>
                      <li>{{config('services.stripe.trial')}}日の無料お試し期間</li>
                      <li>初期費用無料</li>
                    </ul>
                  </div>
                </div>
              </div>
              <div class="col-md-4 col-sm-6 col-12">
                <div class="card card-warning">
                  <div class="card-header">
                    <h5 class="m-0">ベーシック</h5>
                  </div>
                  <div class="card-body">
                    <div class="callout callout-warning">
                      <h3><small class="h6 mr-1">月額</small>{{number_format(config('services.stripe.basic_price')) }}<small class="h6 ml-1">円</small></h3>
                      <small>※取扱商品点数が多いお店向け</small>
                    </div>
                    <ul>
                      <li>{{number_format(config('services.stripe.basic_item'))}}商品まで登録可能</li>
                      <li>画像容量{{config('services.stripe.basic_storage_domination')}}まで利用可能</li>
                      <li>1店舗は追加課金なしで利用可能</li>
                      <li>{{config('services.stripe.trial')}}日の無料お試し期間</li>
                      <li>API連携が利用可能</li>
                      <li>初期費用無料</li>
                    </ul>
                  </div>
                </div>
              </div>
              <div class="col-md-4 col-sm-6 col-12">
                <div class="card card-success">
                  <div class="card-header">
                    <h5 class="m-0">プレミアム</h5>
                  </div>
                  <div class="card-body">
                    <div class="callout callout-success">
                      <h3><small class="h6 mr-1">月額</small>{{number_format(config('services.stripe.premium_price')) }}<small class="h6 ml-1">円</small></h3>
                      <small>※取扱商品点数が非常に多い大型店舗向け</small>
                    </div>
                    <ul>
                      <li>{{number_format(config('services.stripe.premium_item'))}}商品まで登録可能</li>
                      <li>画像容量{{config('services.stripe.premium_storage_domination')}}まで利用可能</li>
                      <li>1店舗は追加課金なしで利用可能</li>
                      <li>{{config('services.stripe.trial')}}日の無料お試し期間</li>
                      <li>API連携が利用可能</li>
                      <li>初期費用無料</li>
                    </ul>
                  </div>
                </div>
              </div>
              <div class="col-md-4 col-sm-6 col-12">
                <div class="card card-danger">
                  <div class="card-header">
                    <h5 class="m-0">追加店舗
                    </h5>
                  </div>
                  <div class="card-body">
                    <div class="callout callout-danger">
                      <h3><small class="h6 mr-1">月額</small>{{number_format(config('services.stripe.add_store'))}}<small class="h6 ml-1">円 / 1店舗</small></h3>
                      <small>※1店舗追加ごとに+{{number_format(config('services.stripe.add_store'))}}円</small>
                    </div>
                    <ul>
                      <li>1店舗ごとに+{{number_format(config('services.stripe.add_store'))}}円/月</li>
                      <li>{{config('services.stripe.trial')}}日の無料お試し期間</li>
                      <li>最初の1店舗はプラン内の料金に含まれています。2店舗以上運用の場合、必要になります。</li>
                      <li>初期費用無料</li>
                    </ul>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-md-12">
              <a href="/regicom" class="btn btn-block bg-gradient-danger btn-lg mb-3" style="line-height: 3.5rem;"><span class="h2 font-weight-bold" style="vertical-align: middle;"><i class="fas fa-file-signature"></i> 新規登録はこちら</span></a>
            </div>
            <div class="col-md-12">
              <a href="/contact" class="btn btn-block btn-primary btn-lg mb-3"><i class="far fa-envelope"></i> お問い合わせ</a>
            </div>
          </div><!-- /.container-fluid -->
        </div>
      </div>
      <div class="col-12">
        <div class="card">
          <div class="card-header">
            <h3 class="card-title"><i class="fas fa-info-circle"></i> Information</h3>

            <!-- <div class="card-tools">
              <div class="input-group input-group-sm" style="width: 150px;">
                <input type="text" name="table_search" class="form-control float-right" placeholder="Search">

                <div class="input-group-append">
                  <button type="submit" class="btn btn-default">
                    <i class="fas fa-search"></i>
                  </button>
                </div>
              </div>
            </div> -->
          </div>
          <!-- /.card-header -->
          <div class="card-body table-responsive p-0">
            <table class="table table-hover text-nowrap">
              <thead>
                <tr>
                  <th>日付</th>
                  <th>内容</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td>2021-11-18</td>
                  <td>フリープランを追加しました。</td>
                </tr>
                <tr>
                  <td>2021-10-20</td>
                  <td>サイトを公開いたしました。</td>
                </tr>
              </tbody>
            </table>
          </div>
          <!-- /.card-body -->
        </div>
        <!-- /.card -->
      </div>

      <div class="col-12">
        @include('partials.footerlink')
      </div>
    </div>
  </div>

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
  .info-box-content {
    font-size: 0.7rem;
  }

  .info-box-content h3 {
    font-size: 0.8rem;
  }

  .card-body h3 {
    font-size: 1.1rem;
  }

  p {
    text-indent: 1em;
  }

  #select-course{
    display: flex;
    align-items: stretch;
  }
  @media (min-width: 576px) {
    .info-box-content {
      font-size: 0.75rem;
    }

    .info-box-content h3 {
      font-size: 0.85rem;
    }

    .card-body h3 {
      font-size: 1.35rem;
    }

  }

  @media (min-width: 768px) {
    .info-box-content {
      font-size: 1rem;
    }

    .info-box-content h3 {
      font-size: 1rem;
    }

    .card-body h3 {
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