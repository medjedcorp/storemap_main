<aside class="main-sidebar {{ config('resultadminlte.classes_sidebar', 'sidebar-light-pink elevation-4') }}">

  {{-- Sidebar brand logo --}}
  @if(config('resultadminlte.logo_img_xl'))
  @include('adminlte::partials.common.result-brand-logo-xl')
  @else
  @include('adminlte::partials.common.result-brand-logo-xs')
  @endif

  {{-- Sidebar menu --}}
  <div class="sidebar">
    <div class="user-panel mt-3 pb-3 mb-3 d-flex">
      {{-- <div class="image">
              <img src="{{ asset('storage/'. $store_info->company_id . '/stores/' . $store_info->store_img1) }}" class="img-circle elevation-2" alt="{{ $store_info->store_name }}">
    </div> --}}
    <div class="info">
      <a href="#" class="d-block"><i class="nav-icon fas fa-store"></i> {{ $store_info->store_name }}</a>
    </div>
  </div>
  <nav class="mt-2">
    <ul class="nav nav-pills nav-sidebar flex-column {{ config('resultadminlte.classes_sidebar_nav', '') }} text-sm" data-widget="treeview" role="menu" @if(config('resultadminlte.sidebar_nav_animation_speed') !=300) data-animation-speed="{{ config('resultadminlte.sidebar_nav_animation_speed') }}" @endif @if(!config('resultadminlte.sidebar_nav_accordion')) data-accordion="false" @endif>
      {{-- <li class="nav-item">
                    <a class="nav-link" href="#calendar" data-toggle="tab">
                      <i class="nav-icon far fa-calendar-alt"></i>
                      <p>
                        店舗カレンダー
                      </p>
                    </a>
                </li> --}}
      <li class="nav-header">商品カテゴリ一覧</li>
      <li class="nav-item">
        <a href="/store/{{$store_info->id}}/" class="nav-link">
          <i class="nav-icon far fa-circle"></i>
          <p>商品一覧</p>
        </a>
      </li>
      @foreach($catelist as $cate)
      <li class="nav-item">
        <a href="/store/{{$store_info->id}}/{{$cate->id}}" class="nav-link">
          <i class="nav-icon far fa-circle"></i>
          <p>
            {{$cate->category_name}}
          </p>
        </a>
      </li>
      @endforeach
      <li class="nav-item"><a href="/" class="nav-link"><i class="nav-icon fas fa-reply"></i>
          <p> サイトトップへ戻る</p>
        </a></li>

    </ul>
  </nav>

  </div>

</aside>