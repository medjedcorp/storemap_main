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
    <div id="header" class="container">
      @component('components.header')
      @endcomponent
    </div>
  </header>
  <div id="app">
    <main id="main" class="py-4">
      <div class="container">
        @yield('content')
      </div>
    </main>
  </div>
  <footer id="footer">
      @component('components.footer')
      @endcomponent
  </footer>
  @yield('script')
</body>

</html>