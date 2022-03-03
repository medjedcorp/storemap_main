@extends('adminlte::top-page')

@section('title', 'ストアマップへの企業登録申請 - StoreMap')

@section('content_header')
<h1 class="text-center mt-3">StoreMapへ企業登録申請をする</h1>
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

      <div class="col-12">
        <p>StoreMapの利用を希望される方は、以下のフォームより企業登録申請を行ってください。当社所定の基準に従った登録審査を実施した後に、アカウント開設となります。審査には約2営業日程お時間をいただいております。<br>
          サービスの詳細については各サービスページ、料金ページをご確認ください。<br>
          ※企業登録申請は料金が発生いたしません。アカウント開設後、プラン変更により料金が発生いたします。</p>
      </div>

      <div class="col-12 mt-3 mb-5">
        <ul class="bootstrapWizard form-wizard">
          <li class="active""> <span class=" step">1</span> <span class="title">必須項目を入力</span></li>
           <li class=""> <span class="step">2</span> <span class="title">完了</span> </li>
        </ul>
      </div>

      <div class="col-12">
        <!-- general form elements -->
        <div class="card card-primary">
          <div class="card-header">
            <h3 class="card-title">企業情報</h3>
          </div>
          <!-- /.card-header -->
          <!-- form start -->
          <form method="post" action="{{ route('regicom.confirm') }}" enctype="multipart/form-data" class="inline_form h-adr">
            @csrf
            @method('POST')
            <span class="p-country-name" style="display:none;">Japan</span>
            <div class="card-body">
            @include('partials.errors')
              <div class="form-group row">
                <label for="company_name" class="col-sm-2 col-form-label">会社名 @include('partials.required')</label>
                <div class="col-sm-10">
                  @if($errors->has('company_name'))
                  <input type="text" class="form-control is-invalid" id="company_name" name="company_name" placeholder="会社名" value="{{old('company_name')}}" aria-describedby="company_name_code-error" aria-invalid="true">
                  <span id="company_name_code-error" class="error invalid-feedback">{{$errors->first('company_name')}}</span>
                  @else
                  <input type="text" class="form-control" id="company_name" name="company_name" placeholder="会社名" value="{{ old('company_name') }}">
                  @endif
                  <small>個人事業主の方は屋号またはサービス名をご入力ください</small>
                </div>
              </div>
              <div class="form-group row">
                <label for="company_kana" class="col-sm-2 col-form-label">会社名かな @include('partials.required')</label>
                <div class="col-sm-10">
                  @if($errors->has('company_kana'))
                  <input type="text" class="form-control is-invalid" id="company_kana" name="company_kana" placeholder="会社名かな" value="{{old('company_kana')}}" aria-describedby="cKana_code-error" aria-invalid="true">
                  <span id="cKana_code-error" class="error invalid-feedback">{{$errors->first('company_kana')}}</span>
                  @else
                  <input type="text" class="form-control" id="company_kana" name="company_kana" placeholder="会社名かな" value="{{ old('company_kana') }}">
                  @endif
                  <small>「株式会社」などの法人格を除いてご入力ください</small>
                </div>
              </div>
              <div class="form-group row">
                <label for="corporate_number" class="col-sm-2 col-form-label">法人番号</label>
                <div class="col-sm-10">
                  @if($errors->has('corporate_number'))
                  <input type="text" class="form-control is-invalid" id="corporate_number" name="corporate_number" placeholder="法人番号" value="{{old('corporate_number')}}" aria-describedby="cNum_code-error" aria-invalid="true">
                  <span id="cNum_code-error" class="error invalid-feedback">{{$errors->first('corporate_number')}}</span>
                  @else
                  <input type="text" class="form-control" id="corporate_number" name="corporate_number" placeholder="法人番号" value="{{ old('corporate_number') }}">
                  @endif
                  <small>不明な場合は国税庁法人番号公表サイトよりお調べください。個人事業主の方は不要です。</small>
                </div>
              </div>
              <div class="form-group row mb-4">
                <label for="president_name" class="col-sm-2 col-form-label">代表者名 @include('partials.required')</label>
                <div class="col-sm-10">
                  @if($errors->has('president_name'))
                  <input type="text" class="form-control is-invalid" id="president_name" name="president_name" placeholder="代表者名" value="{{old('president_name')}}" aria-describedby="pName_code-error" aria-invalid="true">
                  <span id="pName_code-error" class="error invalid-feedback">{{$errors->first('president_name')}}</span>
                  @else
                  <input type="text" class="form-control" id="president_name" name="president_name" placeholder="代表者名" value="{{ old('president_name') }}">
                  @endif
                </div>
              </div>
              <div class="form-group row">
                <label for="company_postcode" class="col-sm-2 col-form-label">郵便番号 @include('partials.required')</label>
                <div class="col-sm-10">
                  @if($errors->has('company_postcode'))
                  <input type="text" class="form-control is-invalid p-postal-code" id="company_postcode" name="company_postcode" placeholder="本社郵便番号(ハイフンあり)" value="{{old('company_postcode')}}" aria-describedby="pcode_code-error" aria-invalid="true">
                  <span id="pcode_code-error" class="error invalid-feedback">{{$errors->first('company_postcode')}}</span>
                  @else
                  <input type="text" class="form-control p-postal-code" id="company_postcode" name="company_postcode" placeholder="本社郵便番号(ハイフンあり)" value="{{ old('company_postcode') }}">
                  @endif
                  <small>本社の郵便番号をハイフンつきで入力してください(例：123-0012)</small>
                </div>
              </div>
              <div class="form-group row">
                <label for="prefecture" class="col-sm-2 col-form-label">都道府県 @include('partials.required')</label>
                <div class="col-sm-10">
                  @if($errors->has('prefecture'))
                  <input type="text" class="form-control is-invalid p-region" name="prefecture" id="prefecture" value="{{old('prefecture')}}" aria-describedby="prefecture-error" aria-invalid="true">
                  <span id="prefecture-error" class="error invalid-feedback">{{$errors->first('prefecture')}}</span>
                  @else
                  <input type="text" class="form-control p-region" id="prefecture" name="prefecture" value="{{old('prefecture')}}">
                  @endif
                </div>
              </div>
              <div class="form-group row">
                <label for="company_city" class="col-sm-2 col-form-label">市区町村 @include('partials.required')</label>
                <div class="col-sm-10">
                  @if($errors->has('company_city'))
                  <input type="text" class="form-control is-invalid p-locality" name="company_city" id="company_city" value="{{old('company_city')}}" aria-describedby="company_city-error" aria-invalid="true">
                  <span id="company_city-error" class="error invalid-feedback">{{$errors->first('company_city')}}</span>
                  @else
                  <input type="text" class="form-control p-locality" id="company_city" name="company_city" value="{{old('company_city')}}">
                  @endif
                </div>
              </div>
              <div class="form-group row">
                <label for="company_adnum" class="col-sm-2 col-form-label">町名・番地 @include('partials.required')</label>
                <div class="col-sm-10">
                  @if($errors->has('company_adnum'))
                  <input type="text" class="form-control is-invalid p-street-address" name="company_adnum" id="company_adnum" value="{{old('company_adnum')}}" aria-describedby="company_adnum-error" aria-invalid="true">
                  <span id="company_adnum-error" class="error invalid-feedback">{{$errors->first('company_adnum')}}</span>
                  @else
                  <input type="text" class="form-control p-street-address" id="company_adnum" name="company_adnum" value="{{old('company_adnum')}}">
                  @endif
                </div>
              </div>
              <div class="form-group row">
                <label for="company_apart" class="col-sm-2 col-form-label">ビル、マンション名</label>
                <div class="col-sm-10">
                  @if($errors->has('company_apart'))
                  <input type="text" class="form-control is-invalid p-extended-address" name="company_apart" id="company_apart" value="{{old('company_apart')}}" aria-describedby="company_apart-error" aria-invalid="true">
                  <span id="company_apart-error" class="error invalid-feedback">{{$errors->first('company_apart')}}</span>
                  @else
                  <input type="text" class="form-control p-extended-address" id="company_apart" name="company_apart" value="{{old('company_apart')}}">
                  @endif
                </div>
              </div>
              <div class="form-group row mb-4">
                <label for="manager_name" class="col-sm-2 col-form-label">担当者名 @include('partials.required')</label>
                <div class="col-sm-10">
                  @if($errors->has('manager_name'))
                  <input type="text" class="form-control is-invalid" id="manager_name" name="manager_name" placeholder="担当者名" value="{{old('managertName')}}" aria-describedby="mName_code-error" aria-invalid="true">
                  <span id="mName_code-error" class="error invalid-feedback">{{$errors->first('manager_name')}}</span>
                  @else
                  <input type="text" class="form-control" id="manager_name" name="manager_name" placeholder="担当者名" value="{{ old('manager_name') }}">
                  @endif
                </div>
              </div>
              <div class="form-group row mb-4">
                <label for="manager_kana" class="col-sm-2 col-form-label">担当者名かな @include('partials.required')</label>
                <div class="col-sm-10">
                  @if($errors->has('manager_kana'))
                  <input type="text" class="form-control is-invalid" id="manager_kana" name="manager_kana" placeholder="担当者名カナ" value="{{old('manager_kana')}}" aria-describedby="mkana_code-error" aria-invalid="true">
                  <span id="mkana_code-error" class="error invalid-feedback">{{$errors->first('manager_kana')}}</span>
                  @else
                  <input type="text" class="form-control" id="manager_kana" name="manager_kana" placeholder="担当者名カナ" value="{{ old('manager_kana') }}">
                  @endif
                </div>
              </div>
              <div class="form-group row">
                <label for="company_email" class="col-sm-2 col-form-label">メールアドレス @include('partials.required')</label>
                <div class="col-sm-10">
                  @if($errors->has('company_email'))
                  <input type="email" class="form-control is-invalid" id="company_email" name="company_email" placeholder="登録用メールアドレス" value="{{old('company_email')}}" aria-describedby="email_code-error" aria-invalid="true">
                  <span id="email_code-error" class="error invalid-feedback">{{$errors->first('company_email')}}</span>
                  @else
                  <input type="email" class="form-control" id="company_email" name="company_email" placeholder="登録用メールアドレス" value="{{ old('company_email') }}">
                  @endif
                  <small>登録用のメールアドレスを入力してください</small>
                </div>
              </div>
              <div class="form-group row">
                <label for="password" class="col-sm-2 col-form-label">パスワード @include('partials.required')</label>
                <div class="col-sm-10">
                  <div class="row">
                    @if($errors->has('password'))
                    <div class="col-sm-10">
                      <input type="password" class="form-control is-invalid" id="password" name="password" placeholder="登録用パスワード" value="{{old('password')}}" aria-describedby="pass_code-error" aria-invalid="true">
                      <span id="pass_code-error" class="error invalid-feedback">{{$errors->first('password')}}</span>
                    </div>
                    <div class="col-sm-2">
                      <button id="btn_passview" class="btn btn-block btn-info">表示</button>
                    </div>
                    @else
                    <div class="col-sm-10">
                      <input type="password" class="form-control" id="password" name="password" placeholder="登録用パスワード" value="{{ old('password') }}">
                    </div>
                    <div class="col-sm-2">
                      <button id="btn_passview" class="btn btn-block btn-info"><i class="far fa-eye"></i> 表示</button>
                    </div>
                    @endif

                  </div>
                  <small>登録用のパスワードを入力してください</small>
                </div>
              </div>
              <div class="form-group row">
                <label for="company_phone_number" class="col-sm-2 col-form-label">担当者電話番号 @include('partials.required')</label>
                <div class="col-sm-10">
                  @if($errors->has('company_phone_number'))
                  <input type="tel" class="form-control is-invalid" id="company_phone_number" name="company_phone_number" placeholder="担当者電話番号(ハイフンあり)" value="{{old('company_phone_number')}}" aria-describedby="tel_code-error" aria-invalid="true">
                  <span id="tel_code-error" class="error invalid-feedback">{{$errors->first('company_phone_number')}}</span>
                  @else
                  <input type="tel" class="form-control" id="company_phone_number" name="company_phone_number" placeholder="担当者電話番号(ハイフンあり)" value="{{ old('company_phone_number') }}">
                  @endif
                  <small>担当者と連絡のつく電話番号をハイフンつきで入力してください</small>
                </div>
              </div>
              <div class="form-group row mb-4">
                <label for="company_fax_number" class="col-sm-2 col-form-label">FAX番号</label>
                <div class="col-sm-10">
                  @if($errors->has('company_fax_number'))
                  <input type="tel" class="form-control is-invalid" id="company_fax_number" name="company_fax_number" placeholder="FAX" value="{{old('company_fax_number')}}" aria-describedby="fax_code-error" aria-invalid="true">
                  <span id="fax_code-error" class="error invalid-feedback">{{$errors->first('company_fax_number')}}</span>
                  @else
                  <input type="tel" class="form-control" id="company_fax_number" name="company_fax_number" placeholder="FAX" value="{{ old('company_fax_number') }}">
                  @endif
                </div>
              </div>
              <div class="form-group row">
                <label for="site_url" class="col-sm-2 col-form-label">サイトURL</label>
                <div class="col-sm-10">
                  @if($errors->has('site_url'))
                  <input type="url" class="form-control is-invalid" id="site_url" name="site_url" placeholder="サイトURL" value="{{old('site_url')}}" aria-describedby="siteurl_code-error" aria-invalid="true">
                  <span id="siteurl_code-error" class="error invalid-feedback">{{$errors->first('site_url')}}</span>
                  @else
                  <input type="url" class="form-control" id="site_url" name="site_url" placeholder="サイトURL" value="{{ old('site_url') }}">
                  @endif
                  <small>ホームページをお持ちでない場合、審査のために公的資料の提出などをご依頼をさせていただくことがございます</small>
                </div>
              </div>
            </div>
            <div class="form-group row">
              <div class="col-sm-12 text-center">
                <div class="form-check">
                  @if($errors->has('p_policy'))
                  <input type="checkbox" class="form-check-input" id="p_policy" name="p_policy" autocomplete="off" readonly="readonly">
                  <label class="form-check-label" for="p_policy"> <a href="/terms" target="_blank">[利用規約」</a>と、<a href="/privacy" target="_blank">[プライバシーポリシー]</a>に同意する</label>
                  <p class="error text-red">{{$errors->first('p_policy')}}</p>
                  @else
                  <input type="checkbox" class="form-check-input" id="p_policy" name="p_policy" autocomplete="off" readonly="readonly">
                  <label class="form-check-label" for="p_policy"><a href="/terms" target="_blank">[利用規約]</a>と、<a href="/privacy" target="_blank">[プライバシーポリシー]</a>に同意する</label>
                  @endif
               </div>
              </div>
            </div>
            <!-- /.card-body -->
            <div class="card-footer">
              <button type="submit" class="btn btn-block btn-primary btn-lg" id="submit" readonly="readonly"><i class="far fa-check-square"></i> 規約に同意して入力内容を送信する</button>
            </div>
          </form>
        </div>
        <!-- /.card -->
      </div>
      <!-- /.row -->
    </div>
  </div><!-- /.container-fluid -->
</section>

@stop

@section('footer')
<div class="footer-area">
  <div class="float-right d-none d-sm-block">{!! config('const.manage.version') !!}</div>
  {!! config('const.manage.footer') !!}
</div>
@stop


@section('css')
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.14.0/css/all.css" integrity="sha384-HzLeBuhoNPvSl5KYnjx0BT+WB0QEEqLprO+NBkkk5gbc67FTaL7XIGa2w1L0Xbgc" crossorigin="anonymous">
<link rel="stylesheet" href="{{ asset('css/admin_custom.css') }}">
<link rel="stylesheet" href="{{ asset('css/stepper.css') }}">
@stop

@section('js')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script src="https://yubinbango.github.io/yubinbango/yubinbango.js" charset="UTF-8"></script>
<script>
  window.addEventListener('DOMContentLoaded', function() {

    // (1)パスワード入力欄とボタンのHTMLを取得
    let btn_passview = document.getElementById("btn_passview");
    let input_pass = document.getElementById("password");

    // (2)ボタンのイベントリスナーを設定
    btn_passview.addEventListener("click", (e) => {

      // (3)ボタンの通常の動作をキャンセル（フォーム送信をキャンセル）
      e.preventDefault();

      // (4)パスワード入力欄のtype属性を確認
      if (input_pass.type === 'password') {

        // (5)パスワードを表示する
        input_pass.type = 'text';
        btn_passview.innerHTML = '<i class="far fa-eye-slash"></i> 非表示';

      } else {

        // (6)パスワードを非表示にする
        input_pass.type = 'password';
        btn_passview.innerHTML = '<i class="far fa-eye"></i> 表示';
      }
    });

  });

  // 同意ボタンの確認チェック
  $(function() {
    $('#submit').prop('disabled', true);

    $('#p_policy').on('click', function() {
        if ($(this).prop('checked') == false) {
            $('#submit').prop('disabled', true);
        } else {
            $('#submit').prop('disabled', false);
        }
    });
});
</script>
@stop