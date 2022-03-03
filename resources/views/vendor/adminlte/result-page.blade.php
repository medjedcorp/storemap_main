@extends('adminlte::master')

@inject('layoutHelper', \JeroenNoten\LaravelAdminLte\Helpers\LayoutHelper)

@if($layoutHelper->isLayoutTopnavEnabled())
    @php( $def_container_class = 'container' )
@else
    @php( $def_container_class = 'container-fluid' )
@endif

@section('adminlte_css')
    @stack('css')
    @yield('css')
@stop

@section('classes_body', $layoutHelper->makeBodyClasses())

@section('body_data', $layoutHelper->makeBodyData())

@section('body')
    <div class="wrapper">

        {{-- Top Navbar --}}
        @include('adminlte::partials.navbar.result-navbar')

        {{-- Left Main Sidebar --}}
        @include('adminlte::partials.sidebar.result-left-sidebar')

        {{-- Content Wrapper --}}
        <div class="gmap content-wrapper {{ config('resultadminlte.classes_content_wrapper') ?? '' }}">

            {{-- Content Header --}}
            {{-- <div class="content-header">
                <div class="{{ config('resultadminlte.classes_content_header') ?: $def_container_class }}">
                    @yield('content_header')
                </div>
            </div> --}}

            {{-- Main Content --}}
            <div class="content" style="width: 100%;">
                <div class="{{ config('resultadminlte.classes_content') ?: $def_container_class }}">
                    @yield('content')
                </div>
            </div>

        </div>

        {{-- Footer --}}
        @hasSection('footer')
            @include('adminlte::partials.footer.footer')
        @endif

        {{-- Right Control Sidebar --}}
        @if(config('resultadminlte.right_sidebar'))
            @include('adminlte::partials.sidebar.result-right-sidebar')
        @endif
    </div>
@stop

@section('adminlte_js')
    @stack('js')
    @yield('js')
@stop
