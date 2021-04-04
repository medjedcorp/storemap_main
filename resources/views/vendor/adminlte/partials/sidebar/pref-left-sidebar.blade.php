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
            <ul class="nav nav-pills nav-sidebar flex-column {{ config('resultadminlte.classes_sidebar_nav', '') }} text-sm nav-compact"
                data-widget="treeview" role="menu" @if(config('resultadminlte.sidebar_nav_animation_speed') !=300)
                data-animation-speed="{{ config('resultadminlte.sidebar_nav_animation_speed') }}" @endif
                @if(!config('resultadminlte.sidebar_nav_accordion')) data-accordion="false" @endif>
                {{-- Configured sidebar links --}}
                {{-- @each('adminlte::partials.sidebar.result-menu-item', $adminlte->menu('sidebar'), 'item') --}}
                <li class="nav-header" style="padding: 0rem 1rem .5rem;">都道府県別</li>
                <li class="nav-item has-treeview menu-open">
                    <a href="#" class="nav-link active">
                        <i class="nav-icon fas fa-circle"></i>
                        <p>
                            {{$pname}}
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview" style="display: block;">
                        @foreach($pgroups as $group=>$value)
                            @if(count($value) > 1)
                            {{-- @if(!empty($value[$loop->index]['ward'])) --}}
                            <li class="nav-item has-treeview @isset($pcity) @if($group == $pcity) menu-open @endif @endisset">
                                <a href="#" class="nav-link @isset($pcity) @if($group == $pcity) active @endif @endisset">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>
                                        {{$group}}
                                        <i class="right fas fa-angle-left"></i>
                                    </p>
                                </a>
                                <ul class="nav nav-treeview">
                                    @foreach($value as $v)
                                    @if(!empty($v['ward']))
                                    {{-- // wardが空じゃない場合はwardを入れる --}}
                                    <li class="nav-item">
                                        <a href="/pref/{{$pname}}/{{$group}}/{{$v['ward']}}" class="nav-link @isset($pward) @if($v['ward'] == $pward) active @endif @endisset">
                                            <i class="far fa-dot-circle nav-icon"></i>
                                            <p>{{$v['ward']}}</p>
                                        </a>
                                    </li>
                                    @endif
                                    @endforeach
                                </ul>
                            </li>
                            @else
                            <li class="nav-item">
                                <a href="/pref/{{$pname}}/{{$group}}" class="nav-link @isset($pcity) @if($pcity == $group) active @endif @endisset">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>{{$group}}</p>
                                </a>
                            </li>
                            @endif
                        @endforeach
                        
                    </ul>
                </li>

                <li class="nav-header">その他の方法</li>
                <li class="nav-item">
                    <a href="/result" class="nav-link">
                      <i class="nav-icon fas fa-th"></i>
                      <p>
                        カテゴリから探す
                      </p>
                    </a>
                </li>


            </ul>
        </nav>
    </div>

</aside>