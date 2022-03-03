@extends('adminlte::page')

@section('title', '店舗一覧 - Storemap Cockpit')

@section('content_header')
<div class="container-fluid">
    <div class="row mb-2">
        <div class="col-sm-7">
            <h1 class="m-0">{{$c_name}} / @lang('store.index.title')</h1>
        </div><!-- /.col -->
        <div class="col-sm-5">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="/home">Home</a></li>
                <li class="breadcrumb-item active">店舗一覧</li>
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
                            <i class="fas fa-store"></i> @lang('store.index.card_title')
                        </h3>

                        <div class="card-tools">
                            <form id="storeSearch" action="/stores" class="" method="GET">
                                @csrf
                                @method('get')
                                <div class="input-group input-group-sm" style="width: 150px;">
                                    <input form="storeSearch" type="text" name="keyword" class="form-control float-right" placeholder="Search" value="{{$keyword}}">
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
                        @include('partials.warning')
                        <table class="table table-bordered">
                            <!-- <table class="table table-hover"> -->
                            <thead>
                                <tr>
                                    @can('isAdmin')
                                    <th class="text-nowrap">company_id
                                    </th>
                                    @endcan
                                    <th class="text-nowrap">@sortablelink('store_code', trans('store.index.store_code'))</th>
                                    <th>@sortablelink('store_name', trans('store.register.store_name'))</th>
                                    <th class="text-nowrap">@sortablelink('store_phone_number', trans('common.phone_num'))</th>
                                    <th class="text-nowrap">@sortablelink('pause_flag', trans('store.pause_flag'))</th>
                                    <th class="text-nowrap">@lang('common.calendar')</th>
                                    @can('isFree')
                                    <th class="text-nowrap">@lang('common.info')</th>
                                    <th class="text-nowrap">@lang('common.delete')</th>
                                    @endcan
                                </tr>
                            </thead>
                            <tbody>
                                @if(count($stores) > 0)
                                @foreach($stores as $store)
                                <tr>
                                    @can('isAdmin')
                                    <td>{{($store->company_id)}}</td>
                                    @endcan
                                    <td>{{($store->store_code)}}</td>
                                    <td>{{($store->store_name)}}</td>
                                    <td class="text-nowrap">{{($store->store_phone_number)}}</td>
                                    <td class="text-nowrap">
                                        @if($store->pause_flag == 0)
                                        @lang('store.hide')
                                        @elseif($store->pause_flag == 1)
                                        @lang('store.show')
                                        @endif
                                    </td>
                                    <td class="text-nowrap">
                                        <button class="btn btn-block btn-warning btn-sm" onclick="location.href='{{ route('calendar.index' , $store->id ) }}'">
                                            <i class="far fa-calendar-alt"></i>
                                            @lang('common.calendar')</button>
                                    </td>
                                    <td class="text-nowrap">
                                        <button class="btn btn-block btn-info btn-sm" onclick="location.href='{{ route('stores.show' , $store->id ) }}'">
                                            <i class="fas fa-info-circle"></i>
                                            @lang('common.info')</button>
                                    </td>
                                    @can('isFree')
                                    <td class="text-nowrap">
                                        <form method="POST" action="{{ route('stores.destroy' , $store->id ) }}" class="h-adr">
                                            @method('DELETE')
                                            @csrf
                                            <button type="submit" class="btn btn-block btn-danger btn-sm" value="削除" onclick="delete_alert(event);return false;">
                                                <i class="fas fa-trash"></i>
                                                削除</button>
                                        </form>
                                    </td>
                                    @endcan
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
                        {{$stores->appends(request()->query())->links()}}
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
            <h5>店舗一覧</h5>
            <hr class="mb-2">
            <p>登録中の店舗情報を一覧表示できます。</p>
            <p>店舗の削除は管理者ユーザーのみが利用可能です。管理権限の設定は、担当者管理＞担当者一覧より設定できます。</p>
            <p>店舗コードや店舗名の項目をクリックすることで、並び替えが可能です。</p>
            <p>検索ウィンドウに店舗名を入力するこで、登録済みの店舗が検索出来ます。</p>
            <p>詳細を押すことで、店舗情報の詳細が閲覧できます。編集画面へは詳細画面より遷移できます。</p>
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