@extends('adminlte::page')

@section('title', 'トピックスの詳細 - Storemap Cockpit')

@section('content_header')
<h1>{{ $topic->title }}の詳細</h1>
@stop

@section('content')
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-9">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">
                            @switch($topic->info)
                                @case(0)
                                    <h4><span class="badge badge-info">機能情報</span></h4>
                                    @break
                                @case(1)
                                    <h4><span class="badge badge-success">販促情報</span></h4>
                                    @break
                                @case(2)
                                    <h4><span class="badge badge-warning">メンテナンス</span></h4>
                                    @break
                                @case(3)
                                    <h4><span class="badge badge-danger">障害情報</span></h4>
                                    @break
                                @case(4)
                                    <h4><span class="badge badge-secondary">お知らせ</span></h4>
                                    @break
                                @case(5)
                                    <h4><span class="badge badge-primary">その他</span></h4>
                                    @break
                                @default
                                    <h4><span class="badge badge-danger">エラー</span></h4>
                            @endswitch
                            <strong>[{{ $topic->updated_at->format('Y.m.d') }}] {{ $topic->title }}</strong>
                        </h3>
                    </div>
                  <div class="card-body">
                    <p class="mb-3">
                        {!! nl2br(e($topic->content)) !!}
                    </p>
                  </div><!-- /.card-body -->
                  @can('isAdmin')
                  <div class="card-footer">
                        <div class="text-right">
                        <a class="btn btn-primary" href="{{ route('topics.edit', $topic->id) }}">
                            編集する
                        </a>
                        <form style="display: inline-block;" method="POST" action="{{ route('topics.destroy', $topic->id) }}">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger">削除する</button>
                        </form>
                        </div>

                    </div>
                  @endcan
                </div>
                <!-- /.nav-tabs-custom -->
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
<link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')
<script>
    console.log('Hi!');
</script>
@stop