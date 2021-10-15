<nav class="main-header navbar navbar-expand-md navbar-light navbar-white">

    <div class="container">

        {{-- Navbar brand logo --}}
        @include('adminlte::partials.common.top-brand-logo-xs')

        {{-- 追加 --}}
        <span>ストアマップは近隣のお店で取扱中の商品や価格を、検索・比較できるサービスです</span>

        {{-- Navbar toggler button --}}
        <button class="navbar-toggler order-1" type="button" data-toggle="collapse" data-target="#navbarCollapse"
                aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation" hidden>
            <span class="navbar-toggler-icon"></span>
        </button>

        {{-- Navbar collapsible menu --}}
        <div class="collapse navbar-collapse order-3" id="navbarCollapse">
            {{-- Navbar left links --}}
            <ul class="nav navbar-nav">
                {{-- Configured left links --}}
                {{-- @each('adminlte::partials.navbar.menu-item', $adminlte->menu('navbar-left'), 'item') --}}

                {{-- Custom left links --}}
                @yield('content_top_nav_left')
            </ul>
        </div>

        {{-- Navbar right links --}}
        <ul class="navbar-nav ml-auto order-1 order-md-3 navbar-no-expand">
            {{-- Custom right links --}}
            @yield('content_top_nav_right')

            {{-- Configured right links --}}
            {{-- @each('adminlte::partials.navbar.menu-item', $adminlte->menu('navbar-right'), 'item') --}}

            {{-- User menu link --}}
            {{-- @if(Auth::user())
                @if(config('adminlte.usermenu_enabled'))
                    @include('adminlte::partials.navbar.menu-item-dropdown-user-menu')
                @else
                    @include('adminlte::partials.navbar.menu-item-logout-link')
                @endif
            @endif --}}

            {{-- Right sidebar toggler link --}}
            {{-- @if(config('adminlte.right_sidebar'))
                @include('adminlte::partials.navbar.menu-item-right-sidebar-toggler')
            @endif --}}
        </ul>

    </div>

</nav>
