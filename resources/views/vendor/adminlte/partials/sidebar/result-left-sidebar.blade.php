<aside class="main-sidebar {{ config('resultadminlte.classes_sidebar', 'sidebar-light-pink elevation-4') }}">

    {{-- Sidebar brand logo --}}
    @if(config('resultadminlte.logo_img_xl'))
    @include('adminlte::partials.common.result-brand-logo-xl')
    @else
    @include('adminlte::partials.common.result-brand-logo-xs')
    @endif

    {{-- Sidebar menu --}}
    <div class="sidebar">
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column {{ config('resultadminlte.classes_sidebar_nav', '') }} text-sm"
                data-widget="treeview" role="menu" @if(config('resultadminlte.sidebar_nav_animation_speed') !=300)
                data-animation-speed="{{ config('resultadminlte.sidebar_nav_animation_speed') }}" @endif
                @if(!config('resultadminlte.sidebar_nav_accordion')) data-accordion="false" @endif>
                {{-- Configured sidebar links --}}
                {{-- @each('adminlte::partials.sidebar.result-menu-item', $adminlte->menu('sidebar'), 'item') --}}
                {{-- <li class="nav-item">
                    <a href="../widgets.html" class="nav-link">
                      <i class="nav-icon fas fa-th"></i>
                      <p>
                        Widgets
                        <span class="right badge badge-danger">New</span>
                      </p>
                    </a>
                </li> --}}
                <li class="nav-header mw-100">カテゴリ一覧</li>
                @isset($sm_name->smcategory_name)
                {{-- <li class="nav-header">{{$sm_name->smcategory_name}}</li> --}}
                <li class="nav-item no-wrap mw-100">
                    <a href="javascript:form_back.submit()" class="nav-link">
                        <i class="fas fa-arrow-circle-left nav-icon"></i>
                            <p>上のカテゴリに戻る</p>
                    <form action="/result" method="GET" name="form_back" id="form_back">
                        @csrf
                        <input type="hidden" value="{{$psmid}}" name="id">
                        <input type="hidden" value="{{$keyword}}" class="set-keyword" name="keyword">
                        <input type="hidden" value="{{$req_pref}}" name="pref">
                        <input type="hidden" value="{{$req_city}}" name="city">
                        <input type="hidden" value="{{$req_ward}}" name="ward">
                        <input type="hidden" value="{{$lat}}" name="lat">
                        <input type="hidden" value="{{$lng}}" name="lng">
                    </form>
                    </a>
                </li>
                <li class="nav-item active mw-100">
                    <a href="#"" class="nav-link active">
                        {{-- <i class="fas fa-circle nav-icon"></i><p>{{$sm_name->smcategory_name}}</p> --}}
                        <i class="far fa-check-circle nav-icon"></i><p>{{$sm_name->smcategory_name}}</p>
                    </a>
                </li>
                @endisset
                @isset($low_cates)
                @foreach($low_cates as $low_cate)
                <li class="nav-item no-wrap mw-100">
                    <a class="nav-link" href="javascript:form1[{{$loop->index}}].submit()">
                        <i class="far fa-circle nav-icon"></i>
                        <p>{{$low_cate->smcategory_name}}</p>
                    <form action="/result" method="GET" name="form1">
                        @csrf
                        <input type="hidden" value="{{$low_cate->id}}" name="id">
                        <input type="hidden" value="{{$keyword}}" class="set-keyword" name="keyword">
                        <input type="hidden" value="{{$req_pref}}" name="pref">
                        <input type="hidden" value="{{$req_city}}" name="city">
                        <input type="hidden" value="{{$req_ward}}" name="ward">
                        <input type="hidden" value="{{$lat}}" name="lat">
                        <input type="hidden" value="{{$lng}}" name="lng">
                    </form>
                    </a>
                </li>
                @endforeach
                @endisset
                <li class="nav-header mw-100">都道府県を選択</li>
                @foreach($prefectures as $pref=>$cities)
                <li class="nav-item has-treeview mw-100 @isset($req_pref) @if($pref == $req_pref) menu-open @endif @endisset">
                    <a href="#" class="nav-link @isset($req_pref) @if($pref == $req_pref) active @endif @endisset">
                    <i class="nav-icon fas fa-circle"></i>
                    <p>
                        {{$pref}}
                        <i class="right fas fa-angle-left"></i>
                    </p>
                    </a>
                    <ul class="nav nav-treeview" @isset($req_pref) @if($pref == $req_pref) style="display: block;" @endif @endisset>
                    @foreach($cities as $city=>$wards)
                        @if(count($wards) > 1)
                            <li class="nav-item has-treeview mw-100 @isset($req_city) @if($city == $req_city) menu-open @endif @endisset">
                                <a href="#" class="nav-link @isset($req_city) @if($city == $req_city) active @endif @endisset">
                                <i class="far fa-circle nav-icon"></i>
                                <p>
                                    {{$city}}
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                                </a>
                                <ul class="nav nav-treeview" @isset($req_city) @if($city == $req_city) style="display: block;" @endif @endisset>
                                    @foreach($wards as $ward)
                                    <li class="nav-item mw-100">
                                        <a class="nav-link @isset($req_ward) @if($ward['ward'] == $req_ward) active @endif @endisset" href="javascript:form2{{$loop->depth}}{{$loop->parent->parent->index}}{{$loop->parent->index}}[{{$loop->index}}].submit()">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>{{$ward['ward']}}</p>
                                        <form action="/result" method="GET" name="form2{{$loop->depth}}{{$loop->parent->parent->index}}{{$loop->parent->index}}">
                                            @csrf
                                            <input type="hidden" value="{{$pref}}" name="pref">
                                            <input type="hidden" value="{{$city}}" name="city">
                                            <input type="hidden" value="{{$ward['ward']}}" name="ward">
                                            <input type="hidden" value="{{$keyword}}" class="set-keyword" name="keyword">
                                            <input type="hidden" value="{{$smid}}" name="id">
                                        </form>
                                        </a>
                                    </li>
                                    @endforeach
                                </ul>
                            </li>
                        @else
                        <li class="nav-item mw-100">
                            <a class="nav-link  @isset($req_city) @if($city == $req_city) active @endif @endisset" href="javascript:form3{{$loop->parent->index}}[{{$loop->index}}].submit()">
                                <i class="far fa-circle nav-icon"></i>
                                <p>{{$city}}</p>
                            <form action="/result" method="GET" name="form3{{$loop->parent->index}}">
                                @csrf
                                <input type="hidden" value="{{$pref}}" name="pref">
                                <input type="hidden" value="{{$city}}" name="city">
                                <input type="hidden" value="{{$keyword}}" class="set-keyword" name="keyword">
                                <input type="hidden" value="{{$smid}}" name="id">
                            </form>
                            </a>
                        </li>
                        @endif
                    @endforeach
                    </ul>
                </li>
                @endforeach
            </ul>
        </nav>
    </div>

</aside>