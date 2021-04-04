<nav class="main-header navbar
    {{ config('resultadminlte.classes_topnav_nav', 'navbar-expand') }}
    {{ config('resultadminlte.classes_topnav', 'navbar-white navbar-light') }}">

    {{-- Navbar left links --}}
    <ul class="navbar-nav">
        {{-- Left sidebar toggler link --}}
        @include('adminlte::partials.navbar.result-menu-item-left-sidebar-toggler')

        {{-- Configured left links --}}
        {{-- @each('adminlte::partials.navbar.result-menu-item', $adminlte->menu('navbar-left'), 'item') --}}

        {{-- Custom left links --}}
        @yield('content_top_nav_left')

    </ul>
    <form id="search-form" action="/result" class="form-inline ml-3 flex-form-area" method="GET">
      @csrf
        <div class="input-group input-group-sm flex-form">
          <input class="form-control form-control-navbar" id="keyword-area" type="search" placeholder="商品名 / サービス名 / JANコードで検索" aria-label="Search" name="keyword" @isset($keyword) value="{{$keyword}}" @endisset>
          <div class="input-group-append">
            <button class="btn btn-navbar" type="submit" id="keyword">
              <i class="fas fa-search"></i>
            </button>
          </div>
          <input type="hidden" name="lat" id="lat" value="">
          <input type="hidden" name="lng" id="lng" value="">
          <input type="hidden" name="smid" id="smid" @isset($smid) value="{{$smid}}" @endisset>
        </div>
      </form>
    {{-- Navbar right links --}}
    <ul class="navbar-nav ml-auto">
        {{-- Custom right links --}}
        @yield('content_top_nav_right')

        {{-- Configured right links --}}
        @each('adminlte::partials.navbar.result-menu-item', $adminlte->menu('navbar-right'), 'item')

        {{-- <ul class="navbar-nav ml-auto">
          <li class="nav-item">
            <a class="nav-link" data-widget="control-sidebar" data-slide="true" href="#" role="button"><i class="fas fa-th-large"></i></a>
          </li>
        </ul> --}}

        {{-- User menu link --}}
        @if(Auth::user())
            @if(config('resultadminlte.usermenu_enabled'))
                @include('adminlte::partials.navbar.menu-item-dropdown-user-menu')
            @else
                @include('adminlte::partials.navbar.menu-item-logout-link')
            @endif
        @endif

        {{-- Right sidebar toggler link --}}
        @if(config('resultadminlte.right_sidebar'))
            @include('adminlte::partials.navbar.result-menu-item-right-sidebar-toggler')
        @endif
    </ul>

</nav>
