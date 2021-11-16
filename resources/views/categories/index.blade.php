@extends('adminlte::page')

@section('title', 'カテゴリ一覧 - Storemap Cockpit')

@section('content_header')
<div class="container-fluid">
  <div class="row mb-2">
    <div class="col-sm-6">
      <h1 class="m-0">{{$c_name}} / @lang('category.index.title')</h1>
    </div><!-- /.col -->
    <div class="col-sm-6">
      <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"><a href="/home">Home</a></li>
        <li class="breadcrumb-item active">カテゴリ一覧</li>
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
                            <i class="fas fa-folder"></i> @lang('category.index.card_title')
                        </h3>

                        <div class="card-tools">
                            <form id="categorySearch" action="/categories" class="" method="GET">
                                @csrf
                                @method('get')
                                <div class="input-group input-group-sm" style="width: 150px;">
                                    <input form="categorySearch" type="text" name="keyword" class="form-control float-right" placeholder="Search" value="{{$keyword}}">
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
                    <div class="card-body table-responsive p-0">
                        @include('partials.success')
                        @include('partials.warning')
                        @include('partials.danger')
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th class="text-nowrap">@sortablelink('category_code', trans('category.register.cate_code'))
                                    </th>
                                    <th>@sortablelink('category_name', trans('category.register.cate_name'))</th>
                                    <th class="text-nowrap">@sortablelink('display_flag', trans('category.index.display'))</th>
                                    @can('isFree')
                                    <th class="text-nowrap">@lang('common.edit')</th>
                                    <th class="text-nowrap">@lang('common.delete')</th>
                                    @endcan
                                </tr>
                            </thead>
                            <tbody>
                                @if(count($categories) > 0)
                                @foreach($categories as $category)
                                <tr>
                                    <td>{{($category->category_code)}}</td>
                                    <td>{{($category->category_name)}}</td>
                                    <td class="text-nowrap">
                                        @if($category->display_flag == '0')
                                        @lang('common.private')
                                        @elseif($category->display_flag == '1')
                                        @lang('common.public')
                                        @endif
                                    </td>
                                    @can('isFree')
                                    <td class="text-nowrap">
                                        <button class="btn btn-block btn-primary btn-sm" onclick="location.href='{{ route('categories.edit' , $category->id ) }}'">
                                            <i class="fas fa-edit"></i>
                                            編集</button>
                                    </td>
                                    <td class="text-nowrap">
                                        <form method="POST" action="{{ route('categories.destroy' , $category->id ) }}" class="h-adr">
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
                        {{$categories->appends(request()->query())->links()}}
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
                <h5>カテゴリ一覧</h5>
                <hr class="mb-2">
                <p>登録されている自社カテゴリの一覧が表示されます。店舗内ページで取り扱いのある商品カテゴリが一覧表示されます。</p>
                <p>カテゴリの削除は管理者ユーザーのみが利用可能です。管理権限の設定は、担当者管理＞担当者一覧より設定できます。</p>
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