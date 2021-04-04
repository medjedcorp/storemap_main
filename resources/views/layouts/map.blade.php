<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- CSRF Token -->
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <title>@yield('title')</title>

  <!-- Scripts -->
  <script src="{{ asset('js/app.js') }}" defer></script>
  <script src="https://polyfill.io/v3/polyfill.min.js?features=default"></script>

  <!-- Fonts -->
  <link rel="dns-prefetch" href="//fonts.gstatic.com">
  <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

  <!-- Styles -->
  <link href="{{ asset('css/app.css') }}" rel="stylesheet">
  @yield('css')
</head>

<body>
  <header>
    <div class="container-fluid">
      @component('components.search-header')
        @slot('keyword')
          @if(isset($keyword))
            {{$keyword}}
          @endif
        @endslot

        @slot('smid')
          @if(isset($smid))
            {{$smid}}
          @endif
        @endslot
      @endcomponent
    </div>
  </header>
  <div id="app">
    <main class="py-4">
      <div class="container-fluid">
        @yield('content')
      </div>
    </main>
  </div>
  <footer id="footer">
    <div class="container-fluid footer_bg">
      @component('components.footer')
      @endcomponent
    </div>
  </footer>
  @yield('script')
</body>

</html>