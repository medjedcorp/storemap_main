@extends('adminlte::page')

@section('title', '会社情報の登録 - Storemap Cockpit')

@section('content_header')
<h1>@lang('company.register.title')</h1>
@stop

@section('content')
<section class="content">
  <div class="container-fluid">
    <div class="row">
      <!-- left column -->
      <div class="col-12 col-md-10 col-xl-8">
        <!-- Horizontal Form -->
        <div class="card card-outline card-primary">
          <div class="card-header">
            <h3 class="card-title"><i class="far fa-building"></i> @lang('company.register.card_title')</h3>
          </div>
          <!-- /.card-header -->
          @include('partials.errors')
          @include('partials.warning')
          <!-- form start -->
          <form method="POST" action="{{route('company.store')}}" enctype="multipart/form-data" class="h-adr">
            <span class="p-country-name" style="display:none;">Japan</span>
            @csrf
            @method('POST')
            <div class="card-body">
              <div class="form-group row">
                <label for="company_name" class="col-sm-2 col-form-label">@lang('company.register.c_name') @include('partials.required')</label>
                <div class="col-sm-10">
                  @if($errors->has('company_name'))
                  <input type="text" class="form-control is-invalid" name="company_name" id="company_name" placeholder="@lang('company.register.c_name_pholder')" value="{{old('company_name')}}" aria-describedby="company_name-error" aria-invalid="true">
                  <span id="company_name-error" class="error invalid-feedback">{{$errors->first('company_name')}}</span>
                  @else
                  <input type="text" class="form-control" id="company_name" name="company_name" placeholder="@lang('company.register.c_name_pholder')" value="{{old('company_name')}}">
                  @endif
                </div>
              </div>
              @if (App::isLocale('ja')) {{-- 日本語のときだけ表示 --}}
              <div class="form-group row">
                <label for="company_kana" class="col-sm-2 col-form-label">会社名かな</label>
                <div class="col-sm-10">
                  @if($errors->has('company_kana'))
                  <input type="text" class="form-control is-invalid" name="company_kana" id="company_kana" placeholder="会社名をひらがなで入力してください" value="{{old('company_kana')}}" aria-describedby="company_kana-error" aria-invalid="true">
                  <span id="company_kana-error" class="error invalid-feedback">{{$errors->first('company_kana')}}</span>
                  @else
                  <input type="text" class="form-control" id="company_kana" name="company_kana" placeholder="会社名をひらがなで入力してください" value="{{old('company_kana')}}">
                  @endif
                </div>
              </div>
              @endif
              <div class="form-group row">
                <label for="company_postcode" class="col-sm-2 col-form-label">@lang('common.add_postcode')
                  @include('partials.required')</label>
                <div class="col-sm-10">
                  @if($errors->has('company_postcode'))
                  <input type="text" class="form-control is-invalid p-postal-code" name="company_postcode" id="company_postcode" value="{{old('company_postcode')}}" aria-describedby="company_postcode-error" aria-invalid="true">
                  <span id="company_postcode-error" class="error invalid-feedback">{{$errors->first('company_postcode')}}</span>
                  @else
                  <input type="text" class="form-control p-postal-code" id="company_postcode" name="company_postcode" value="{{old('company_postcode')}}">
                  @endif
                </div>
              </div>
              <div class="form-group row">
                <label for="prefecture" class="col-sm-2 col-form-label">@lang('common.prefecture')
                  @include('partials.required')</label>
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
                <label for="company_city" class="col-sm-2 col-form-label">@lang('common.city')
                  @include('partials.required')</label>
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
                <label for="company_adnum" class="col-sm-2 col-form-label">@lang('common.adnum')
                  @include('partials.required')</label>
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
                <label for="company_apart" class="col-sm-2 col-form-label">@lang('common.apart')</label>
                <div class="col-sm-10">
                  @if($errors->has('company_apart'))
                  <input type="text" class="form-control is-invalid p-extended-address" name="company_apart" id="company_apart" value="{{old('company_apart')}}" aria-describedby="company_apart-error" aria-invalid="true">
                  <span id="company_apart-error" class="error invalid-feedback">{{$errors->first('company_apart')}}</span>
                  @else
                  <input type="text" class="form-control p-extended-address" id="company_apart" name="company_apart" value="{{old('company_apart')}}">
                  @endif
                </div>
              </div>
              <div class="form-group row">
                <label for="company_phone_number" class="col-sm-2 col-form-label">@lang('common.add_phone_number')
                  @include('partials.required')</label>
                <div class="col-sm-10">
                  @if($errors->has('company_phone_number'))
                  <input type="tel" class="form-control is-invalid" name="company_phone_number" id="company_phone_number" value="{{old('company_phone_number')}}" aria-describedby="company_phone_number-error" aria-invalid="true">
                  <span id="company_phone_number-error" class="error invalid-feedback">{{$errors->first('company_phone_number')}}</span>
                  @else
                  <input type="tel" class="form-control" id="company_phone_number" name="company_phone_number" value="{{old('company_phone_number')}}">
                  @endif
                </div>
              </div>
              <div class="form-group row">
                <label for="company_fax_number" class="col-sm-2 col-form-label">@lang('common.add_fax_number')</label>
                <div class="col-sm-10">
                  @if($errors->has('company_fax_number'))
                  <input type="tel" class="form-control is-invalid" name="company_fax_number" id="company_fax_number" value="{{old('company_fax_number')}}" aria-describedby="company_fax_number-error" aria-invalid="true">
                  <span id="company_fax_number-error" class="error invalid-feedback">{{$errors->first('company_fax_number')}}</span>
                  @else
                  <input type="tel" class="form-control" id="company_fax_number" name="company_fax_number" value="{{old('company_fax_number')}}">
                  @endif
                </div>
              </div>
              <div class="form-group row">
                <label for="company_email" class="col-sm-2 col-form-label">@lang('company.register.company_email')
                  @include('partials.required')</label>
                <div class="col-sm-10">
                  @if($errors->has('company_email'))
                  <input type="email" class="form-control is-invalid" name="company_email" id="company_email" value="{{old('company_email')}}" aria-describedby="company_email-error" aria-invalid="true">
                  <span id="company_email-error" class="error invalid-feedback">{{$errors->first('company_email')}}</span>
                  @else
                  <input type="email" class="form-control" id="company_email" name="company_email" value="{{old('company_email')}}">
                  @endif
                </div>
              </div>
              <div class="form-group row">
                <label for="manager_name" class="col-sm-2 col-form-label">@lang('company.register.manager_name')
                  @include('partials.required')</label>
                <div class="col-sm-10">
                  @if($errors->has('manager_name'))
                  <input type="text" class="form-control is-invalid" name="manager_name" id="manager_name" value="{{old('manager_name')}}" aria-describedby="manager_name-error" aria-invalid="true">
                  <span id="manager_name-error" class="error invalid-feedback">{{$errors->first('manager_name')}}</span>
                  @else
                  <input type="text" class="form-control" id="manager_name" name="manager_name" value="{{old('manager_name')}}">
                  @endif
                </div>
              </div>
              @if (App::isLocale('ja'))
              <div class="form-group row">
                <label for="manager_kana" class="col-sm-2 col-form-label">管理責任者名かな</label>
                <div class="col-sm-10">
                  @if($errors->has('manager_kana'))
                  <input type="text" class="form-control is-invalid" name="manager_kana" id="manager_kana" value="{{old('manager_kana')}}" aria-describedby="manager_kana-error" aria-invalid="true">
                  <span id="manager_kana-error" class="error invalid-feedback">{{$errors->first('manager_kana')}}</span>
                  @else
                  <input type="text" class="form-control" id="manager_kana" name="manager_kana" value="{{old('manager_kana')}}">
                  @endif
                </div>
              </div>
              @endif
              <div class="form-group row">
                <label for="site_url" class="col-sm-2 col-form-label">@lang('company.register.site_url')</label>
                <div class="col-sm-10">
                  @if($errors->has('site_url'))
                  <input type="text" class="form-control is-invalid" name="site_url" id="site_url" value="{{old('site_url')}}" aria-describedby="site_url-error" aria-invalid="true">
                  <span id="site_url-error" class="error invalid-feedback">{{$errors->first('site_url')}}</span>
                  @else
                  <input type="text" class="form-control" id="site_url" name="site_url" value="{{old('site_url')}}">
                  @endif
                </div>
              </div>
              <div class="form-group row">
                <label class="col-sm-2 col-form-label">@lang('company.register.maker_flag') <i type="button" class="fas fa-question-circle text-warning" data-toggle="tooltip" data-placement="right" title="" data-original-title="GS1事業者コードをお持ちの場合、メーカー設定をすることで、小売店が御社の商品情報を参照できるカタログ機能が利用できるようになります"></i>@include('partials.required')</label>
                <div class="col-sm-10">
                  <div class="btn-group btn-group-toggle" data-toggle="buttons">
                    <label class="btn btn-outline-info">
                      <input type="radio" name="maker_flag" id="maker_flag1" onclick="maker_flaga('gs1_prefix',this.checked); img_flaga();" value="1" {{ old( 'maker_flag' , old( 'maker_flag')) == '1' ? 'checked' : '' }}>メーカー
                    </label>
                    <label class="btn btn-outline-info active">
                      <input type="radio" name="maker_flag" id="maker_flag0" onclick="maker_flagb('gs1_prefix',this.checked); img_flagb();" value="0" {{ old( 'maker_flag' , old( 'maker_flag')) == '0' ? 'checked' : '' }}>その他
                    </label>
                  </div>
                  @if($errors->has('maker_flag'))
                  <div class="small text-danger">{{$errors->first('maker_flag')}}</div>
                  @endif
                </div>
              </div>
              <div class="form-group row">
                <label class="col-sm-2 col-form-label">@lang('company.edit.img_flag_title') <i type="button" class="fas fa-question-circle text-warning" data-toggle="tooltip" data-placement="right" title="" data-original-title="メーカーの場合、他社が御社の商品画像を利用することを「許可する」か、「許可しない」かを選択できます。チェックを入れた場合、他社がカタログ機能を利用して御社の商品情報をコピーしたときに、商品画像もコピーされます。"></i></label>
                <div class="col-sm-10">
                  <div class="form-group clearfix">
                    <input id="img_flag0" name="img_flag" type="hidden" value="0">
                    <div class="icheck-info d-inline">
                      <input id="img_flag1" name="img_flag" type="checkbox" value="1" {{ old( 'img_flag' ,  old('img_flag')) == '1' ? 'checked' : '' }}>
                      <label for="img_flag1" class="form-check-label">@lang('company.edit.img_flag')</label>
                      @if($errors->has('img_flag'))
                      <div class="small text-danger">{{$errors->first('img_flag')}}</div>
                      @endif
                    </div>
                  </div>
                </div>
              </div>
              <div class="form-group row">
                <label for="gs1_company_prefix" class="col-sm-2 col-form-label">@lang('company.register.gs1_company_prefix') <i type="button" class="fas fa-question-circle text-warning" data-toggle="tooltip" data-placement="right" title="" data-original-title="JANコードの前7桁または9桁の値です。"></i></label>
                <div class="col-sm-10">
                  @if($errors->has('gs1_company_prefix'))
                  <input type="text" class="form-control is-invalid" name="gs1_company_prefix" id="gs1_prefix" value="{{old('gs1_company_prefix')}}" aria-describedby="gs1_company_prefix-error" aria-invalid="true">
                  <span id="gs1_company_prefix-error" class="error invalid-feedback">{{$errors->first('gs1_company_prefix')}}</span>
                  @else
                  <input type="text" class="form-control" id="gs1_prefix" name="gs1_company_prefix" value="{{old('gs1_company_prefix')}}" placeholder="※メーカー登録の場合必須。JANコードの前7桁または9桁の値です">
                  @endif
                </div>
              </div>
              <div class="form-group row">
                <label class="col-sm-2 col-form-label">@lang('company.register.certificate') <i type="button" class="fas fa-question-circle text-warning" data-toggle="tooltip" data-placement="right" title="" data-original-title="必須ではありませんが、問題があったときに解決が早くなるので登録しておくことをおすすめします"></i></label>
                <div class="col-sm-10">
                  <div class="custom-file">
                    <input type="file" class="custom-file-input" id="certificate" name="certificate" accept=".jpg, .jpeg, .png, .pdf, .gif">
                    <label class="custom-file-label" for="certificate">選択してください</label>
                  </div>
                  @if($errors->has('certificate'))
                  <div class="small text-danger">{{$errors->first('certificate')}}</div>
                  @endif
                </div>
              </div>

            </div>
            <!-- /.card-body -->
            <div class="card-footer">
              <button type="submit" class="btn btn-primary"><i class="fa fa-check-square"></i>
                @lang('company.register.submit')</button>
            </div>
            <!-- /.card-footer -->
          </form>
        </div>
        <!-- /.card -->
      </div>
      <!-- /.row -->
    </div>
  </div><!-- /.container-fluid -->
</section>
@stop

@section('right-sidebar')
    <div class="os-padding text-sm">
        <div class="os-viewport os-viewport-native-scrollbars-invisible" style="overflow-y: scroll;">
            <div class="os-content" style="padding: 16px; height: 100%; width: 100%;">
                <h5>会社情報の登録</h5>
                <hr class="mb-2">
                <p>ご利用前に会社情報を登録する必要があります。</p>
                <dl>
                  <dt>会社名</dt>
                  <dd>会社名を入力してください。</dd>
                  <dt>会社名かな</dt>
                  <dd>会社名をひらがなで入力してください。</dd>
                  <dt>郵便番号</dt>
                  <dd>会社所在地の郵便番号をハイフンありで入力してください。</dd>
                  <dt>都道府県</dt>
                  <dd>会社所在地の都道府県名を入力してください。</dd>
                  <dt>市区町村</dt>
                  <dd>会社所在地の市区町村を入力してください。</dd>
                  <dt>町名・番地</dt>
                  <dd>会社所在地の町名・番地を入力してください。</dd>
                  <dt>ビル、マンション名</dt>
                  <dd>会社所在地のビル、マンション名を入力してください。</dd>
                  <dt>電話番号</dt>
                  <dd>担当者へ連絡のつく電話番号を入力してください。</dd>
                  <dt>FAX番号</dt>
                  <dd>担当者へ連絡のつくFAX番号を入力してください。</dd>
                  <dt>管理責任者名</dt>
                  <dd>サイトを管理する責任者名を入力してください。</dd>
                  <dt>管理責任者名かな</dt>
                  <dd>サイトを管理する責任者名の読み仮名を入力してください</dd>
                  <dt>サイトURL</dt>
                  <dd>会社のサイトURLがあれば入力してください。</dd>
                  <dt>メーカー設定</dt>
                  <dd>会社がGS1事業者コード(JANコード)を取得しているメーカーの場合は、「メーカー」を選んでください。</dd>
                  <dt>他社画像利用</dt>
                  <dd>メーカーの場合、他社が御社の商品画像を利用することを「許可する」か、「許可しない」かを選択できます。チェックを入れた場合、他社がカタログ機能を利用して商品情報をコピーしたときに、商品画像もコピーされます。</dd>
                  <dt>GS1事業者コード</dt>
                  <dd>JANコードの前7桁または9桁の値です。メーカー設定を選択している場合は必須項目となりまｓ。</dd>
                  <dt>会社証明</dt>
                  <dd>トラブルがあった場合、会社証明をアップロードしていると、素早く問題解決に結びつくことがあります。</dd>
                </dl>
            </div>
        </div>
    </div>
@stop


@section('footer')
<div class="float-right d-none d-sm-block">{!! config('const.manage.version') !!}</div>
{!! config('const.manage.footer') !!}
@stop

@section('css')
<link rel="stylesheet" href="{{ asset('css/icheck-bootstrap.min.css') }}">
<link rel="stylesheet" href="{{ asset('css/admin_custom.css') }}">
@stop

@section('js')
<script src="https://yubinbango.github.io/yubinbango/yubinbango.js" charset="UTF-8"></script>
<script>
  $(function() {
    $('[data-toggle="tooltip"]').tooltip()
  })
</script>
<script>
  function maker_flaga(gs1_prefix, ischecked) {
    if (ischecked == true) {
      // チェックが入っていたら有効化
      document.getElementById("gs1_prefix").disabled = false;
    } else {
      // チェックが入っていなかったら無効化
      document.getElementById("gs1_prefix").disabled = true;
    }
  }

  function maker_flagb(gs1_prefix, ischecked) {
    if (ischecked == true) {
      // チェックが入っていたら有効化
      document.getElementById("gs1_prefix").disabled = true;
      document.getElementById("gs1_prefix").value = "";
    } else {
      // チェックが入っていなかったら無効化
      document.getElementById("gs1_prefix").disabled = false;
    }
  }

  function img_flaga() {
    for (const element of document.getElementsByName('img_flag')) {
      element.disabled = false;
    }
    // document.getElementById("img_flag0").element.disabled = false;
  }

  function img_flagb() {
    // for (const element of document.getElementsByName('img_flag')) {
    //   element.checked = false;
    //   element.disabled = true;
    // }
    document.getElementById("img_flag0").checked = false;
    document.getElementById("img_flag1").disabled = true;
    document.getElementById("img_flag1").checked = false;
  }
</script>
<script>
  $('#certificate').on('change', function() {
    //get the file name
    var fileName = $(this).val();
    //replace the "Choose a file" label
    $(this).next('.custom-file-label').html(fileName);
  })
</script>
@stop