@extends('adminlte::page')

@section('title', 'Storemap Cockpit：ストアマップコックピット')

@section('content_header')
<div class="container-fluid">
  <div class="row mb-2">
    <div class="col-12">
      <h1 class="m-0">Home</h1>
    </div><!-- /.col -->
  </div><!-- /.row -->
</div>
@stop

@section('content')
<section class="content">
  <div class="container-fluid">
    <h5 class="mt-4 mb-2">登録情報<code> -status- </code></h5>
    <div class="row">
      <!-- /.col -->
      <div class="col-md-3 col-sm-6 col-12">
        <div class="info-box bg-success">
          <span class="info-box-icon"><i class="fas fa-file-signature"></i></span>
          <div class="info-box-content">
            <span class="info-box-text">現在のプラン</span>
            <span class="info-box-number">{{ $plan }}</span>
            <div class="progress">
              <div class="progress-bar" style="width: 0%"></div>
            </div>
            @empty($trial_ends)
            <span class="progress-description">
              &nbsp;
            </span>
            @else
            <span class="progress-description">
              試用期間：{{$trial_ends}} まで
            </span>
            @endif
          </div>
          <!-- /.info-box-content -->
        </div>
        <!-- /.info-box -->
      </div>
      <div class="col-md-3 col-sm-6 col-12">
        <div class="info-box bg-info">
          <span class="info-box-icon"><i class="fas fa-shopping-basket"></i></span>
          <div class="info-box-content">
            <span class="info-box-text">商品数</span>
            <span class="info-box-number">{{ $nowItems }} / {{ $maxItems }}</span>
            <div class="progress">
              <div class="progress-bar" style="width: {{ $pgsItems }}%"></div>
            </div>
            <span class="progress-description">
              残枠数：<b>{{ $maxItems - $nowItems }}</b>
            </span>
          </div>
          <!-- /.info-box-content -->
        </div>
        <!-- /.info-box -->
      </div>

      <!-- /.col -->
      <div class="col-md-3 col-sm-6 col-12">
        <div class="info-box bg-warning">
          <span class="info-box-icon"><i class="fas fa-store-alt"></i></span>
          <div class="info-box-content">
            <span class="info-box-text">店舗数</span>
            <span class="info-box-number">{{ $nowStores }} / {{ $maxStores }}</span>
            <div class="progress">
              <div class="progress-bar" style="width: {{ $pgsStores }}%"></div>
            </div>
            <span class="progress-description">
              残枠数：<b>{{ $maxStores - $nowStores }}</b>
            </span>
          </div>
          <!-- /.info-box-content -->
        </div>
        <!-- /.info-box -->
      </div>
      <!-- /.col -->
      <div class="col-md-3 col-sm-6 col-12">
        <div class="info-box bg-danger">
          <span class="info-box-icon"><i class="far fa-images"></i></span>
          <div class="info-box-content">
            <span class="info-box-text">画像容量</span>
            <span class="info-box-number">{{ $nowImagesTxt }} / {{ $storageTxt }}</span>
            <div class="progress">
              <div class="progress-bar" style="width: {{ $pgsImages }}%"></div>
            </div>
            <span class="progress-description">
              残容量：<b>{{ $zanTxt }}</b>
            </span>
          </div>
          <!-- /.info-box-content -->
        </div>
        <!-- /.info-box -->
      </div>
      <!-- /.col -->
    </div>

    <h5 class="mt-4 mb-2">お知らせ <code>-Information-</code></h5>
    <div class="row">
      <div class="col-md-7">
        <div class="card">
          <div class="card-header p-2">
            <ul class="nav nav-pills">
              <li class="nav-item"><a class="nav-link active" href="#topics" data-toggle="tab">トピックス</a></li>
              <li class="nav-item"><a class="nav-link" href="#feature" data-toggle="tab">機能情報</a></li>
              <li class="nav-item"><a class="nav-link" href="#promotion" data-toggle="tab">販促情報</a></li>
              <li class="nav-item"><a class="nav-link" href="#maintenance" data-toggle="tab">メンテ・障害</a></li>
              <li class="nav-item"><a class="nav-link" href="#other" data-toggle="tab">その他</a></li>
            </ul>
          </div><!-- /.card-header -->
          <div class="card-body">
            <div class="tab-content">
              <div class="tab-pane active" id="topics">
                @isset($topics)
                <ul class="nav flex-column">
                  @foreach ($topics as $topic)
                  <li class="nav-item">
                    <a href="{{ route('topics.show' , $topic->id ) }}" class="nav-link">
                      [{{ $topic->created_at->format('Y.m.d') }}] {{ $topic->title }}
                      @switch($topic->info)
                      @case(0)
                      <h6 class="float-right"><span class="badge badge-info">機能情報</span></h6>
                      @break
                      @case(1)
                      <h6 class="float-right"><span class="badge badge-success">販促情報</span></h6>
                      @break
                      @case(2)
                      <h6 class="float-right"><span class="badge badge-warning">メンテナンス</span></h6>
                      @break
                      @case(3)
                      <h6 class="float-right"><span class="badge badge-danger">障害情報</span></h6>
                      @break
                      @case(4)
                      <h6 class="float-right"><span class="badge badge-secondary">お知らせ</span></h6>
                      @break
                      @case(5)
                      <h6 class="float-right"><span class="badge badge-primary">その他</span></h6>
                      @break
                      @default
                      <h6 class="float-right"><span class="badge badge-danger">エラー</span></h6>
                      @endswitch
                    </a>
                  </li>
                  @endforeach
                </ul>
                {{ $topics->links() }}
                @endisset
              </div>
              <!-- /.tab-pane -->
              <div class="tab-pane" id="feature">
                @isset($features)
                <ul class="nav flex-column">
                  @foreach ($features as $feature)
                  <li class="nav-item">
                    <a href="{{ route('topics.show' , $feature->id ) }}" class="nav-link">
                      [{{ $feature->created_at->format('Y.m.d') }}] {{ $feature->title }}
                      <h6 class="float-right"><span class="badge badge-info">機能情報</span></h6>
                    </a>
                  </li>
                  @endforeach
                </ul>
                @endisset
              </div>
              <!-- /.tab-pane -->
              <div class="tab-pane" id="promotion">
                @isset($promotions)
                <ul class="nav flex-column">
                  @foreach ($promotions as $promotion)
                  <li class="nav-item">
                    <a href="{{ route('topics.show' , $promotion->id ) }}" class="nav-link">
                      [{{ $promotion->created_at->format('Y.m.d') }}] {{ $promotion->title }}
                      <h6 class="float-right"><span class="badge badge-success">販促情報</span></h6>
                    </a>
                  </li>
                  @endforeach
                </ul>
                @endisset
              </div>
              <!-- /.tab-pane -->
              <div class="tab-pane" id="maintenance">
                @isset($maintenances)
                <ul class="nav flex-column">
                  @foreach ($maintenances as $maintenance)
                  <li class="nav-item">
                    <a href="{{ route('topics.show' , $maintenance->id ) }}" class="nav-link">
                      [{{ $maintenance->created_at->format('Y.m.d') }}] {{ $maintenance->title }}
                      @switch($maintenance->info)
                      @case(2)
                      <h6 class="float-right"><span class="badge badge-warning">メンテナンス</span></h6>
                      @break
                      @case(3)
                      <h6 class="float-right"><span class="badge badge-danger">障害情報</span></h6>
                      @break
                      @default
                      <h6 class="float-right"><span class="badge badge-danger">エラー</span></h6>
                      @endswitch
                    </a>
                  </li>
                  @endforeach
                </ul>
                @endisset
              </div>
              <!-- /.tab-pane -->
              <!-- /.tab-pane -->
              <div class="tab-pane" id="other">
                @isset($others)
                <ul class="nav flex-column">
                  @foreach ($others as $other)
                  <li class="nav-item">
                    <a href="{{ route('topics.show' , $other->id ) }}" class="nav-link">
                      [{{ $other->created_at->format('Y.m.d') }}] {{ $other->title }}
                      @switch($other->info)
                      @case(4)
                      <h6 class="float-right"><span class="badge badge-secondary">お知らせ</span></h6>
                      @break
                      @case(5)
                      <h6 class="float-right"><span class="badge badge-primary">その他</span></h6>
                      @break
                      @default
                      <h6 class="float-right"><span class="badge badge-danger">エラー</span></h6>
                      @endswitch
                    </a>
                  </li>
                  @endforeach
                </ul>
                @endisset
              </div>
              <!-- /.tab-pane -->
            </div>
            <!-- /.tab-content -->
          </div><!-- /.card-body -->
          @can('isAdmin')
          <div class="card-footer"><a href="{{ route('topics.create') }}" class="btn btn-primary">
              投稿を新規作成する
            </a></div>
          @endcan
        </div>
        <!-- /.nav-tabs-custom -->
      </div>


    </div>
  </div>
</section>
@stop

@section('right-sidebar')
<div class="os-padding text-sm">
  <div class="os-viewport os-viewport-native-scrollbars-invisible" style="overflow-y: scroll;">
    <div class="os-content" style="padding: 16px; height: 100%; width: 100%;">
      <h5>マニュアル/ヘルプ</h5>
      <hr class="mb-2">
      <p class="mb-5">この画面にはヘルプが表示されます。</p>
      <h6>お知らせ</h6>
      <p class="mb-5">ストアマップからのお知らせや、機能情報、販促情報、メンテナンス、障害情報などは表示されます。</p>
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
  .info-box .info-box-content {
    line-height: 1.8;
  }
</style>
@stop

@section('js')
<script>
  console.log('Hi!');
</script>
@stop