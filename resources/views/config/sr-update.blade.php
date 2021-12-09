@extends('adminlte::page')

@section('title', 'Storemap Cockpit：スマレジAPI連携(在庫価格更新)')

@section('content_header')
<div class="container-fluid">
  <div class="row mb-2">
    <div class="col-sm-6">
      <h1 class="m-0">スマレジAPI連携(在庫価格更新)</h1>
    </div><!-- /.col -->
    <div class="col-sm-6">
      <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"><a href="/home">Home</a></li>
        <li class="breadcrumb-item active">スマレジAPI連携(在庫価格更新)</li>
      </ol>
    </div><!-- /.col -->
  </div><!-- /.row -->
</div>
@stop

@section('content')
<section class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-6">
        <div class="card card-outline card-primary">
          <div class="card-header ui-sortable-handle" style="cursor: move;">
            <h3 class="card-title">
              <i class="fas fa-handshake mr-1"></i>
              連携用情報
            </h3>
          </div>
          <div class="card-body">
            <div class="row">
              <p class="col-sm-4">契約ID</p>
              <p class="col-sm-8">{{$company_code}}</p>
              <p class="col-sm-4">アクセストークン</p>
              @if(is_null($api_token))
              <p class="col-sm-8"><a href="/config/import">こちら</a>でアクセストークンを作成してください。</p>
              @else
              <p class="col-sm-8">{{$api_token}}</p>
              @endif
              <p class="col-sm-4">在庫情報受信用URL</p>
              <p class="col-sm-8">https://storemap.jp/api/sregi/receive_stock</p>
              <p class="col-sm-4">商品情報受信用URL</p>
              <p class="col-sm-8">https://storemap.jp/api/sregi/receive_item</p>
            </div>
          </div><!-- /.card-body -->
        </div>
      </div>
      <div class="col-sm-6">
        <div class="card card-outline card-warning">
          <div class="card-header">
            <h3 class="card-title"><i class="fa fa-download"></i> 登録用テンプレートファイル</h3>
          </div>
          <!-- /.card-header -->
          <div class="card-body">
            <p>商品連携用CSVのテンプレートファイルをダウンロードできます。</p>
            <form id="downloadCSV" method="get" action="{{ action('SmaregiUpdateController@SmarejiTempFileDownload') }}" class="h-adr" enctype="multipart/form-data">
              @csrf
              @method('get')
              <button form="downloadCSV" type="submit" class="btn btn-warning"><i class="fas fa-file-download"></i> @lang('csv.template')</button>
            </form>
          </div>
          <!-- /.card-body -->
        </div>
        <!-- /.card -->
      </div>
      <!-- /.nav-tabs-custom -->
      <div class="col-sm-12">
        <div class="card card-outline card-primary">
          <div class="card-header">
            <h3 class="card-title">
              <i class="fa fa-upload mr-1"></i>
              商品連携用CSVのアップロード
            </h3>
          </div>
          <!-- /.card-header -->
          <div class="card-body">
            @include('partials.danger')
            @include('partials.success')
            <p><strong>スマレジと価格及び在庫数の連携が可能です。</strong>
              <br>・スマレジの商品IDを、ストアマップの外部商品ID(ext_product_code)に登録する必要があります
              <br>・ストアマップの商品コード、外部商品ID(ext_product_code)を入力したcsvをアップロードしてください。
              <br>@lang('csv.upload_size')
            </p>

            <form id="importCSV" method="post" action="{{route('sr.importCSV')}}" class="h-adr" enctype="multipart/form-data">
              @csrf
              @method('post')
              <div class="custom-file">
                <input form="importCSV" type="file" class="custom-file-input" id="file" name="file">
                <label class="custom-file-label" for="file">ファイルを選択</label>
              </div>
              <small id="fileHelp" class="form-text text-muted mb-2">@lang('category.data.upload_small')</small>
              <br>
              <button form="importCSV" type="submit" class="btn btn-block btn-primary btn-lg"><i class="fa fa-upload"></i> @lang('csv.upload')</button>
            </form>
          </div>
          <!-- /.card-body -->
        </div>
        <!-- /.card -->
      </div>

      <div class="col-12">
        <div class="card card-outline card-info">
          <div class="card-header">
            <h3 class="card-title"><i class="fa fa-download"></i> 登録について</h3>
          </div>
          <!-- /.card-header -->
          <div class="card-body">
            <dl class="paragraph-1">
              <dt>1.連携設定</dt>
              <dd>スマレジAPIと連携するために、契約IDとアクセストークンが必要になります。アクセストークンは、[設定 ＞ API設定 ＞ 受信用API]から作成できます。
              </dd>
              <dt>2.連携店舗の準備</dt>
              <dd>
                店舗コードをスマレジ側と同じにする必要があります。
                <ul>
                  <li>連携したい店舗の店舗コードをスマレジと同じにする必要があります。ストアマップの[店舗管理 > 店舗一覧] に記載のある店舗コードと、スマレジ側の[店舗 > 店舗一覧] に記載のある店舗コードを同じにする必要があります。違う場合はストアマップの[店舗管理 > 店舗一覧 > 詳細 > 店舗情報を編集する] と進み、店舗コードを修正してください。</li>
                </ul>
              </dd>
              <dt>3.スマレジ側設定</dt>
              <dd>
                <ul>
                  <li class="mb-3">スマレジ側の管理画面を開いて、[設定 > システム連携 > スマレジAPI設定]をクリックします。
                    <div><img src="{{asset('img/smareji/srejiapi-1.gif')}}" style="max-width:100%;"></div>
                  </li>
                  <li class="mb-3">スマレジAPI設定画面内の、API送信設定ボタンをクリックして、送信機能を利用するを選択します。
                    <div><img src="{{asset('img/smareji/srejiapi-2.gif')}}" style="max-width:100%;"></div>
                  </li>
                  <li class="mb-3">画面を下にスクロールして、商品情報送信と、在庫情報送信を利用するにチェックを入れて個別設定をクリックします。
                    <div><img src="{{asset('img/smareji/srejiapi-3.gif')}}" style="max-width:100%;"></div>
                  </li>
                  <li class="mb-3">商品情報送信では、送信URLに「https://storemap.jp/api/sregi/receive_item」を入力。ヘッダ情報に[設定 > API設定 > 受信用API]で作成したアクセストークンと、契約IDを入力してください。
                    <div><img src="{{asset('img/smareji/srejiapi-4.gif')}}" style="max-width:100%;"></div>
                  </li>
                  <li class="mb-3">在庫情報送信では、送信URLに「https://storemap.jp/api/sregi/receive_stock」を入力。ヘッダ情報に[設定 > API設定 > 受信用API]で作成したアクセストークンと、契約IDを入力してください。
                    <div><img src="{{asset('img/smareji/srejiapi-5.gif')}}" style="max-width:100%;"></div>
                  </li>
                </ul>
                最後に更新ボタンをクリックしてください。
              </dd>
              <dt>4. 商品連携用CSVのアップロード</dt>
              <dd>スマレジの商品IDをストアマップのデータベースに登録する必要があります。ストアマップの商品コードを、スマレジ商品IDを入力したcsvをアップロードしてください。
                <ul>
                  <li class="mb-3">スマレジ側の管理画面を開いて、[商品 > 商品一覧 > CSVダウンロード]をクリックして、csvをダウンロードします。
                    <div><img src="{{asset('img/smareji/srejiapi-6.gif')}}" style="max-width:100%;"></div>
                  </li>
                  <li class="mb-3">ストアマップの管理画面を開いて、[設定 > システム連携 > スマレジAPI設定]をクリック後、登録用テンプレートファイル欄にある「テンプレートファイルをダウンロード」をクリックしてcsvファイルをダウンロードしてください。
                  </li>
                  <li class="mb-3">ストアマップ側でダウンロードしたファイルのbarcode欄と、スマレジ側でダウンロードしたファイルの商品コード欄を照らし合わせて、ストアマップ側のcsvファイルのext_product_code欄に、スマレジ側の商品IDの値を入力してください。
                  </li>
                  <li class="mb-3">入力が完了したら保存して、商品連携用CSVのアップロードより、アップロードしてください。
                  </li>
                </ul>
                以上の項目が設定できれば、連携が始まります。
              </dd>

            </dl>
          </div>
          <!-- /.card-body -->
        </div>
        <!-- /.card -->
      </div>
      <!-- /.nav-tabs-custom -->
    </div>
  </div>
</section>
@stop

@section('right-sidebar')
<div class="os-padding text-sm">
  <div class="os-viewport os-viewport-native-scrollbars-invisible" style="overflow-y: scroll;">
    <div class="os-content" style="padding: 16px; height: 100%; width: 100%;">
      <h5>スマレジ連携について</h5>
      <hr class="mb-2">
      <p class="mb-5">スマレジ連携設定をすることで、在庫情報、価格情報、商品の表示設定を連携することが可能です。連携することで、スマレジを更新した場合、自動でストアマップ上のデータが更新されます。</p>
      <h6>商品連携ID設定</h6>
      <p class="mb-5">[スマレジ管理画面＞システム連携＞スマレジAPI設定]より、API受信設定にある「契約ID」と「アクセストークン」の値を、ストアマップ上の当画面内「スマレジ契約ID」、「アクセストークン」欄にコピーしてください。</p>
      <h6>店舗連携設定</h6>
      <p class="mb-5">[スマレジ管理画面＞店舗＞店舗一覧]より、店舗IDの値を、ストアマップ上の当画面内[店舗連携設定]にある「スマレジ店舗ID」欄にコピーしてください。</p>
      <h6>商品連携設定</h6>
      <p class="mb-5">スマレジに登録されている商品と、ストアマップに登録されている商品を紐づける必要があります。登録用テンプレートファイルをダウンロードして、「product_code」にストアマップ上に登録した商品コードを入力してください。「ext_product_code」には対応したスマレジ側の商品IDを入力してください。</p>
      <h6>商品情報送信設定</h6>
      <p class="mb-5">スマレジ側に商品情報を送信する設定をします。[スマレジ管理画面＞システム連携＞スマレジAPI設定]画面より、API送信設定のタブを選びます。「商品情報送信」と「在庫情報送信」の利用するにチェックを入れます。個別設定を押し設定画面を開きます。「商品情報送信」の送信URLに【https://storemap.jp/api/sregi/receive_item】を入力、「在庫情報送信」の送信URLに【https://storemap.jp/api/sregi/receive_stock】を入力します。両方のヘッダ情報欄の追加を２回押します。１行目に[id]=[契約ID]と、２行目に[token]=[アクセストークン]となるように値を入力してください。</p>
    </div>
  </div>
</div>
@stop

@section('footer')
<div class="float-right d-none d-sm-block">{!! config('const.manage.version') !!}</div>
{!! config('const.manage.footer') !!}
@stop

@section('css')
<link rel="stylesheet" href="/css/admin_custom.css">
<style>
  .paragraph-1 dd {
    margin-bottom: 1.5rem;
  }

  .paragraph-2 {
    margin-top: .5rem;
    margin-left: 1rem;
  }

  .paragraph-2 dd {
    margin-bottom: 1.5rem;
  }
</style>
@stop

@section('js')
<script src="{{ asset('js/bs-custom-file-input.min.js') }}"></script>
<script>
  $(document).ready(function() {
    bsCustomFileInput.init()
  })
</script>
@stop