@inject('layoutHelper', \JeroenNoten\LaravelAdminLte\Helpers\LayoutHelper)

@php( $dashboard_url = View::getSection('dashboard_url') ?? config('resultadminlte.dashboard_url', 'index') )

@if (config('resultadminlte.use_route_url', false))
    @php( $dashboard_url = $dashboard_url ? route($dashboard_url) : '' )
@else
    @php( $dashboard_url = $dashboard_url ? url($dashboard_url) : '' )
@endif

<a href="{{ $dashboard_url }}"
    @if($layoutHelper->isLayoutTopnavEnabled())
        class="navbar-brand {{ config('resultadminlte.classes_brand') }}"
    @else
        class="brand-link {{ config('resultadminlte.classes_brand') }}"
    @endif>

    {{-- Small brand logo --}}
    <img src="{{ asset(config('resultadminlte.logo_img', 'vendor/adminlte/dist/img/AdminLTELogo.png')) }}"
         alt="{{ config('resultadminlte.logo_img_alt', 'AdminLTE') }}"
         class="{{ config('resultadminlte.logo_img_class', 'brand-image img-circle elevation-3') }}"
         style="opacity:.8">
         
    {{-- Brand text --}}
    <span class="brand-text font-weight-light {{ config('resultadminlte.classes_brand_text') }}">
        {!! config('resultadminlte.logo', '<b>Store</b>Map') !!}
    </span>

</a>
