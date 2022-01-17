@extends('adminlte::page')

@section('title', '商品一覧 - Storemap Cockpit')

@section('content_header')
<div class="container-fluid">
    <div class="row mb-2">
        <div class="col-sm-7">
            <h1 class="m-0">{{$c_name}} / @lang('item.index.title')</h1>
        </div><!-- /.col -->
        <div class="col-sm-5">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="/home">Home</a></li>
                <li class="breadcrumb-item active">@lang('item.index.title')</li>
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
                <!-- Horizontal Form -->
                <div class="card card-info">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="fas fa-store"></i> @lang('item.index.card_title') / <small>現在の登録商品点数{{$count}}件</small>
                        </h3>

                        <div class="card-tools">
                            <form id="itemSearch" action="/items" class="" method="GET">
                                @csrf
                                @method('get')
                                <div class="input-group input-group-sm" style="width: 150px;">
                                    <input form="itemSearch" type="text" name="keyword" class="form-control float-right" placeholder="Search" value="{{$keyword}}">
                                    <div class="input-group-append">
                                        <button type="submit" class="btn btn-default">
                                            <i class="fas fa-search"></i>
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        @include('partials.success')
                        @include('partials.danger')
                        <!-- </div>
                    <div class="card-body table-responsive p-0"> -->
                        <table class="table table-bordered">
                            <!-- <table class="table table-hover"> -->
                            <thead>
                                <tr>
                                    @can('isAdmin')
                                    <th class="text-nowrap">company_id
                                    </th>
                                    @endcan
                                    <th class="text-nowrap">@sortablelink('product_code', trans('item.product_code'))</th>
                                    <th>@sortablelink('product_name', trans('item.product_name'))</th>
                                    <th class="text-nowrap">@sortablelink('original_price', trans('common.original_price'))</th>
                                    <th class="text-nowrap">@sortablelink('barcode', trans('common.barcode'))</th>
                                    <th class="text-nowrap">@lang('item.display_flag')</th>
                                    <th class="text-nowrap">@lang('common.info')</th>
                                    @can('isSeller')
                                    <th class="text-nowrap">@lang('common.delete')</th>
                                    @endcan
                                </tr>
                            </thead>
                            <tbody>
                                @if(count($items) > 0)
                                @foreach($items as $item)
                                <tr>
                                    @can('isAdmin')
                                    <td>{{($item->company_id)}}</td>
                                    @endcan
                                    <td>{{($item->product_code)}}</td>
                                    <td>{{($item->product_name)}}</td>
                                    <td class="text-nowrap">
                                        @isset($item->original_price)
                                        {{($item->original_price)}}
                                        @else
                                        @lang('item.open')
                                        @endif
                                    </td>
                                    <td class="text-nowrap">{{($item->barcode)}}</td>
                                    <td class="text-nowrap">
                                        @if($item->display_flag == 0)
                                        @lang('item.hide')
                                        @elseif($item->display_flag == 1)
                                        @lang('item.show')
                                        @endif
                                    </td>
                                    <td class="text-nowrap">
                                        <button class="btn btn-block btn-primary btn-sm" onclick="location.href='{{ route('items.edit' , $item->id ) }}'">
                                            <i class="fas fa-edit"></i>
                                            @lang('common.edit')</button>
                                    </td>
                                    {{-- @can('isSeller') --}}
                                    <td class="text-nowrap">
                                        <form method="POST" action="{{ route('items.destroy' , $item->id ) }}" class="h-adr">
                                            @method('DELETE')
                                            @csrf
                                            <button type="submit" class="btn btn-block btn-danger btn-sm" value="削除" onclick="delete_alert(event);return false;">
                                                <i class="fas fa-trash"></i>
                                                削除</button>
                                        </form>
                                    </td>
                                    {{-- @endcan --}}
                                </tr>
                                @endforeach
                                @endif
                            </tbody>
                        </table>
                    </div>
                    <!-- /.card-body -->
                    <!-- Loading (remove the following to stop the loading)-->
                    <div id="loading" class="overlay dark">
                        <i class="fas fa-2x fa-sync-alt fa-spin"></i>
                    </div>
                    <!-- end loading -->

                    <div class="card-footer clearfix">
                        {{$items->appends(request()->query())->links()}}
                    </div>
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
            <h5>商品情報一覧</h5>
            <hr class="mb-2">
            <p>現在登録中の商品情報を一覧で表示できます。</p>
            <p>商品情報の削除は管理者ユーザーのみが利用可能です。管理権限の設定は、担当者管理＞担当者一覧より設定できます。</p>
            <p>商品名や商品コードなど項目をクリックすることで、並び替えが可能です。</p>
            <p>検索ウィンドウに商品名や、JANコードを入力するこで、登録商品の検索が出来ます。</p>
            <p>編集画面より、在庫や価格の管理、取扱店舗の設定が可能です。</p>
        </div>
    </div>
</div>
@stop

@section('footer')
<div class="float-right d-none d-sm-block">{!! config('const.manage.version') !!}</div>
{!! config('const.manage.footer') !!}
@stop

@section('css')
<link rel="stylesheet" href="{{ asset('css/admin_custom.css') }}">
@stop

@section('js')
<script src="{{ asset('js/delete_alert.js') }}"></script>
<script>
    jQuery(window).on('load', function() {
        jQuery('#loading').hide();
    });
</script>
@stop