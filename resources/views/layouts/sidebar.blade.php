<!-- ============================================================== -->
<!-- Left Sidebar - style you can find in sidebar.scss  -->
<!-- ============================================================== -->
<aside class="left-sidebar">
    <!-- Sidebar scroll-->
    <div class="scroll-sidebar">
        <!-- User Profile-->
    {{--<div class="user-profile">--}}
    {{--<div class="user-pro-body">--}}
    {{--<div><img src="/assets/images/users/2.jpg" alt="user-img" class="img-circle"></div>--}}
    {{--<div class="dropdown">--}}
    {{--<a href="javascript:void(0)" class="dropdown-toggle u-dropdown link hide-menu"--}}
    {{--data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Steave--}}
    {{--Gection <span class="caret"></span></a>--}}
    {{--<div class="dropdown-menu animated flipInY">--}}
    {{--<!-- text-->--}}
    {{--<a href="javascript:void(0)" class="dropdown-item"><i class="ti-user"></i> My Profile</a>--}}
    {{--<!-- text-->--}}
    {{--<a href="javascript:void(0)" class="dropdown-item"><i class="ti-wallet"></i> My Balance</a>--}}
    {{--<!-- text-->--}}
    {{--<a href="javascript:void(0)" class="dropdown-item"><i class="ti-email"></i> Inbox</a>--}}
    {{--<!-- text-->--}}
    {{--<div class="dropdown-divider"></div>--}}
    {{--<!-- text-->--}}
    {{--<a href="javascript:void(0)" class="dropdown-item"><i class="ti-settings"></i> Account--}}
    {{--Setting</a>--}}
    {{--<!-- text-->--}}
    {{--<div class="dropdown-divider"></div>--}}
    {{--<!-- text-->--}}
    {{--<a href="pages-login.html" class="dropdown-item"><i class="fas fa-power-off"></i> Logout</a>--}}
    {{--<!-- text-->--}}
    {{--</div>--}}
    {{--</div>--}}
    {{--</div>--}}
    {{--</div>--}}
    <!-- Sidebar navigation-->
        <nav class="sidebar-nav">
            <ul id="sidebarnav">
                @php
                    $menu = \App\Models\Menu::join('role_menus','menus.menu_id','role_menus.menu_id')
                    ->where('parent_id',0)
                    ->where('menus.is_active', true)
                    ->where('role_menus.is_active', true)
                    ->whereIn('role_uuid', \Illuminate\Support\Facades\Auth::user()->roles->pluck('role_uuid')->toArray())
                    ->orderBy('order_num')->get();
                @endphp
                @foreach($menu as $i)
                    <li>
                        <a class="@if(count($i->childMenus)!=0)has-arrow @endif waves-effect waves-dark"
                           href="{{$i->url}}"
                           aria-expanded="false"><i
                                    class="{{$i->icon}}"></i><span class="hide-menu">{{$i->label}}</span></a>
                        <ul aria-expanded="false" class="collapse">
                            @php
                                $menu2 = \App\Models\Menu::join('role_menus','menus.menu_id','role_menus.menu_id')
                                ->where('parent_id',$i->menu_id)
                                ->where('menus.is_active', true)
                                ->where('role_menus.is_active', true)
                                ->whereIn('role_uuid', \Illuminate\Support\Facades\Auth::user()->roles->pluck('role_uuid')->toArray())
                                ->orderBy('order_num')->get();
                            @endphp
                            @foreach($menu2 as $i2)
                                <li><a href="{{$i2->url}}">{{$i2->label}}</a></li>
                            @endforeach
                        </ul>
                    </li>
                @endforeach
            </ul>
        </nav>
        <!-- End Sidebar navigation -->
    </div>
    <!-- End Sidebar scroll-->
</aside>
<!-- ============================================================== -->
<!-- End Left Sidebar - style you can find in sidebar.scss  -->
<!-- ============================================================== -->