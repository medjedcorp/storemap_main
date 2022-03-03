@extends('adminlte::page')

@section('title', '商品価格情報の編集 - Storemap Cockpit')

@section('content_header')
<div class="container-fluid">
  <div class="row mb-2">
    <div class="col-sm-7">
      <h1 class="m-0"><span class="h4"><i class="fas fa-edit"></i> {{$item->product_name}}/<span class="h5">{{$item->product_code}} の
      @lang('item.price.title')</span></span></h1>
    </div><!-- /.col -->
    <div class="col-sm-5">
      <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"><a href="/home">Home</a></li>
        <li class="breadcrumb-item"><a href="/items">商品一覧</a></li>
        <li class="breadcrumb-item active">@lang('item.main.price')</li>
      </ol>
    </div><!-- /.col -->
  </div><!-- /.row -->
</div>
@stop

@section('content')
<section class="content">
  <div class="container-fluid">
    <div class="row">
      <!-- left column -->
      <div class="col-12">
        <div class="card card-primary card-tabs">
          <div class="card-header p-0 pt-1">
            <ul class="nav nav-tabs" id="custom-tabs-two-tab" role="tablist">
              <li class="pt-2 px-3">
                <h3 class="card-title"><i class="far fa-list-alt"></i> @lang('item.price.card_title')</h3>
              </li>
              <li class="nav-item">
                <a class="nav-link" id="custom-tabs-two-base-tab" data-toggle="pill" role="tab" aria-controls="custom-tabs-two-base" aria-selected="false" onclick="location.href='{{ route('items.edit' , $item->id ) }}'">@lang('item.main.base')</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" id="custom-tabs-two-store-tab" data-toggle="pill" role="tab" aria-controls="custom-tabs-two-store" aria-selected="false" onclick="location.href='{{ route('items.seller.edit' , $item->id ) }}'">@lang('item.main.store')</a>
              </li>
              <li class="nav-item">
                <a class="nav-link active" id="custom-tabs-two-price-tab" data-toggle="pill" href="price" role="tab" aria-controls="custom-tabs-two-price" aria-selected="true">@lang('item.main.price')</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" id="custom-tabs-two-stock-tab" data-toggle="pill" href="stock" role="tab" aria-controls="custom-tabs-two-stock" aria-selected="false" onclick="location.href='{{ route('items.stock.edit' , $item->id ) }}'">@lang('item.main.stock')</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" id="custom-tabs-two-comment-tab" data-toggle="pill" href="comment" role="tab" aria-controls="custom-tabs-two-comment" aria-selected="false" onclick="location.href='{{ route('items.comment.edit' , $item->id ) }}'">@lang('item.main.comment')</a>
              </li>
            </ul>
          </div>
          <div class="card-body">
          @include('partials.errors')
          @include('partials.success')
            <table class="table">
              <thead>
                <tr>
                  <th>@lang('item.store_name')</th>
                  <th style="width:140px;">@lang('item.price.price_info')</th>
                  <th style="width:140px;">@lang('item.price.store_price')</th>
                  <th style="width:140px;">@lang('item.price.value_price')</th>
                  <th style="width:220px;">@lang('item.price.sale_start')</th>
                  <th style="width:220px;">@lang('item.price.sale_end')</th>
                </tr>
              </thead>
              <tbody>
                @foreach($itemprice as $itemprice)
                <tr>
                  <td> <input form="price_form" type="hidden" class="form-control" name="store_id[]" value="{{ $itemprice->pivot->store_id }}">{{ $itemprice->store_name }}</td>
                  <td>
                    <div class="form-group">
                      <select id="price_select{{ $loop->iteration }}" form="price_form" class="form-control" name="price_type[]">
                        <option value="0" {{ old('price_type[$i]', $itemprice->pivot->price_type) == 1 ? 'selected' : '' }}>
                          @lang('item.price.normal')</option>
                        <option value="1" {{ old('price_type[$i]', $itemprice->pivot->price_type) == 2 ? 'selected' : '' }}>
                          @lang('item.price.low')</option>
                        <option value="2" {{ old('price_type[$i]', $itemprice->pivot->price_type) == 3 ? 'selected' : '' }}>
                          @lang('item.price.high')</option>
                      </select>
                    </div>
                  </td>
                  <td>
                    <div class="form-group">
                      @if (isset($item->original_price) && !isset($itemprice->pivot->price))
                      <input form="price_form" type="number" class="form-control disa{{ $loop->iteration }}" name="price[]" value="{{ $item->original_price }}">
                      @elseif (isset($item->original_price) && isset($itemprice->pivot->price))
                      <input form="price_form" type="number" class="form-control disa{{ $loop->iteration }}" name="price[]" value="{{ old('price.[]', isset($itemprice->pivot->price) ? $itemprice->pivot->price : '') }}">
                      @else
                      <input form="price_form" class="form-control disa{{ $loop->iteration }}" name="price[]" value="{{ old('price.[]', isset($itemprice->pivot->price) ? $itemprice->pivot->price : '') }}">
                      @endif
                    </div>
                  </td>
                  <td>
                    <div class="form-group">
                      <input form="price_form" type="number" class="form-control disa{{ $loop->iteration }}" name="value[]" value="{{ old('value.[$i]', $itemprice->pivot->value) }}">
                    </div>
                  </td>
                  <td>
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text"><i class="far fa-clock"></i></span>
                        </div>
                        <input form="price_form" type="text" class="form-control float-right dateTime disa{{ $loop->iteration }}" name="start_date[]" value="{{ old('start_date.[]->format(Y-m-d H:i)', isset($itemprice->pivot->start_date) ? $itemprice->pivot->start_date->format('Y/m/d H:i') : '') }}" autocomplete="off">
                      </div>
                    </div>
                  </td>
                  <td>
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text"><i class="far fa-clock"></i></span>
                        </div>
                        <input form="price_form" type="text" class="form-control float-right dateTime disa{{ $loop->iteration }}" name="end_date[]" value="{{ old('end_date.[]->format(Y-m-d H:i)', isset($itemprice->pivot->end_date) ? $itemprice->pivot->end_date->format('Y/m/d H:i') : '') }}" autocomplete="off">
                      </div>
                    </div>
                  </td>
                </tr>
                <!-- {{--
                                                        これで非表示にできるけど、配列が送信されないからエラーになります。
                                                        空の配列を送る方法があればＯＫ。
                                                        {{ $loop->iteration }}入れてるのは、↓これ使うためだけで現状不要
                                                        <script>
                                                        document.addEventListener("DOMContentLoaded", function(){
                                                          $(function() {
                                                            var $children = $('.disa{{ $loop->iteration }}');
                                                            var original = $children.html();

                                                            $('#price_select{{ $loop->iteration}}').change(function() {
                                                              var val1 = $(this).val();

                                                              if ($(this).val() === '0') {
                                                                $children.attr('disabled', 'disabled');
                                                              } else {
                                                                $children.removeAttr('disabled');
                                                              }
                                                            });
                                                          });
                                                        }, false);

                                                        </script> --}} -->
                @endforeach
              </tbody>
            </table>
            <ul>
              @foreach ($errors->all() as $error)
              <li class="text-danger">{{ $error }}</li>
              @endforeach
            </ul>
          </div>
          <!-- /.card -->
          <!-- /.card-body -->
          <div class="card-footer">
            <form id="price_form" method="POST" action="{{ route('items.price.update', $item->id) }}" enctype="multipart/form-data" class="h-adr inline_form">
              @csrf
              @method('PATCH')
              <button form="price_form" type="submit" class="btn btn-primary" value="登録"><i class="fa fa-check-square"></i>
                @lang('item.price.submit')</button>
            </form>
            <button class="btn btn-default float-right" onclick="location.href='{{ route('items.index') }}'"><i class="fa fa-reply"></i> @lang('common.back')</button>
          </div>
          <!-- /.card-footer -->
        </div>

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
      <h5>価格設定</h5>
      <hr class="mb-2">
      <p>店舗ごとに商品価格を設定できます。</p>
      <dl>
        <dt>価格設定</dt>
        <dd>サイト上に表示される価格が、通常販売価格なのか、最高価格なのか、最低価格なのかを設定できます。</dd>
        <dt>販売価格</dt>
        <dd>店舗ごとに表示される価格を入力してください。価格設定を元に、最低価格の場合は「〇〇〇円～」、最高価格の場合は「～〇〇〇円」、通常価格の場合は「〇〇〇円」と表示されます。販売価格が未入力の場合は、定価が表示されます。定価設定のない場合はオープン価格と表示されます。</dd>
        <dt>セール価格</dt>
        <dd>セール開始日時とセール終了日時の間は、セール価格と表示されます。</dd>
        <dt>セール開始日時</dt>
        <dd>セール開始日時を入力してください。</dd>
        <dt>セール終了日時</dt>
        <dd>セール終了日時を入力してください。</dd>
      </dl>
    </div>
  </div>
</div>
@stop

@section('footer')
<div class="footer-area">
  <div class="float-right d-none d-sm-block">{!! config('const.manage.version') !!}</div>
  {!! config('const.manage.footer') !!}
</div>
@stop

@section('css')
<link rel="stylesheet" href="{{ asset('css/daterangepicker.css') }}">
<link rel="stylesheet" href="{{ asset('css/admin_custom.css') }}">

@stop

@section('js')
<script src="{{ asset('js/moment.min.js') }}"></script>
<script src="{{ asset('js/daterangepicker.js') }}"></script>

<script type="text/javascript">
  $(function() {

    $('.dateTime').daterangepicker({
      "autoUpdateInput": false,
      "singleDatePicker": true,
      "timePicker": true,
      "timePicker24Hour": true,
      "locale": {
        "cancelLabel": 'Clear',
        "format": "YYYY/MM/DD HH:mm",
        "separator": " - ",
        "applyLabel": "登録",
        "cancelLabel": "キャンセル",
        "fromLabel": "From",
        "toLabel": "To",
        "customRangeLabel": "Custom",
        "weekLabel": "W",
        "daysOfWeek": [
          "日",
          "月",
          "火",
          "水",
          "木",
          "金",
          "土"
        ],
        "monthNames": [
          "1月",
          "2月",
          "3月",
          "4月",
          "5月",
          "6月",
          "7月",
          "8月",
          "9月",
          "10月",
          "11月",
          "12月"
        ],
        "autoUpdateInput": false,
      }
    });

    $('.dateTime').on('apply.daterangepicker', function(ev, picker) {
      $(this).val(picker.startDate.format('YYYY/MM/DD HH:mm'));
    });

    $('.dateTime').on('cancel.daterangepicker', function(ev, picker) {
      $(this).val('');
    });

  });
</script>

@stop