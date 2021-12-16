@extends('adminlte::page')

@section('title', 'ユーザ一覧 - Storemap Cockpit')

@section('content_header')
<div class="container-fluid">
  <div class="row mb-2">
    <div class="col-sm-7">
      <h1 class="m-0">{{$c_name}} の @lang('user.index.title')</h1>
    </div><!-- /.col -->
    <div class="col-sm-5">
      <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"><a href="/home">Home</a></li>
        <li class="breadcrumb-item active">@lang('user.index.title')</li>
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
                            <i class="fas fa-users"></i>@lang('user.index.title')
                        </h3>

                        <div class="card-tools">
                            <form id="userSearch" action="/users" class="" method="GET">
                                @csrf
                                @method('get')
                                <div class="input-group input-group-sm" style="width: 150px;">
                                    <input form="userSearch" type="text" name="keyword" class="form-control float-right" placeholder="Search" value="{{$keyword}}">
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
                    <!-- <div class="card-body table-responsive p-0"> -->
                        @include('partials.success')
                        @include('partials.warning')
                        @include('partials.danger')
                        <table class="table table-bordered">
                        <!-- <table class="table table-hover"> -->
                            <thead>
                                <tr>
                                    <th>@sortablelink('name', trans('user.index.name'))</th>
                                    <th>@sortablelink('email',trans('user.index.e_mail'))</th>
                                    <th class="text-nowrap">@sortablelink('role', trans('user.index.role'))</th>
                                    @can('isSeller')
                                    <th class="text-nowrap">@lang('user.index.edit')</th>
                                    <th class="text-nowrap">@lang('user.index.delete')</th>
                                    @endcan
                                </tr>
                            </thead>
                            <tbody>
                                @if(count($users) > 0)
                                @foreach($users as $user)
                                <tr>
                                    <td>{{($user->name)}}</td>
                                    <td>{{($user->email)}}</td>
                                    <td class="text-nowrap">
                                        @if($user->role == 'seller')
                                        管理者
                                        @elseif($user->role == 'staff')
                                        担当者
                                        @elseif($user->role == 'admin')
                                        システム
                                        @endif
                                    </td>
                                    @can('isSeller')
                                    <td class="text-nowrap">
                                        <button class="btn btn-block btn-primary btn-sm" onclick="location.href='{{ route('users.edit' , $user->id ) }}'">
                                            <i class="fas fa-edit"></i>
                                            編集</button>
                                    </td>
                                    <td class="text-nowrap">
                                        <form method="POST" action="{{ route('users.destroy' , $user->id ) }}" class="h-adr">
                                            @method('DELETE')
                                            @csrf
                                            <button type="submit" class="btn btn-block btn-danger btn-sm" value="削除" onclick="delete_alert(event);return false;"> <i class="fas fa-trash"></i> 削除</button>
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
                        {{$users->appends(request()->query())->links()}}
                    </div>
                </div>
                <!-- /.card -->
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