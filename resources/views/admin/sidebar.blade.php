<div class="left side-menu">
    <div class="sidebar-inner slimscrollleft">

        <!-- User -->
        <div class="user-box">
            <div class="user-img">
                <img style="    width: 100%;
    height: 100%;
    object-fit: cover;" src="{{ url('storage/profiles/'.Auth::user()->profile) ?? asset('admin/assets/images/users/avatar-1.jpg') }}" alt="user-img" title="{{ Auth::user()->name }}" class="img-circle img-thumbnail img-responsive">
                <div class="user-status offline"><i class="zmdi zmdi-dot-circle"></i></div>
            </div>
            <h5><a href="#">{{ Auth::user()->name }}</a> </h5> <!-- نام کاربر -->
            <ul class="list-inline">
{{--                <li>--}}
{{--                    <a href="{{ route('profile.settings') }}" title="تنظیمات پروفایل"> <!-- لینک به تنظیمات پروفایل -->--}}
{{--                        <i class="zmdi zmdi-settings"></i>--}}
{{--                    </a>--}}
{{--                </li>--}}
                <li>
                    <a href="{{ route('admin.logout') }}" class="text-custom" title="خروج" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <i class="zmdi zmdi-power"></i> خروج
                    </a>
                    <form id="logout-form" action="{{ route('admin.logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </li>

            </ul>
        </div>

        <!-- End User -->

        <!-- Sidebar -->
        <div id="sidebar-menu">
            <ul>
                <li class="text-muted menu-title">منوی اصلی</li>

                <li>
                    <a href="{{ url('/admin/dashboard') }}" class="waves-effect">
                        <i class="zmdi zmdi-view-dashboard"></i> <span> داشبورد </span>
                    </a>
                </li>

                <li>
                    <a href="{{ url('/admin/users') }}" class="waves-effect">
                        <i class="zmdi zmdi-accounts"></i> <span> کاربران </span>
                    </a>
                </li>

                <li>
                    <a href="{{ url('/admin/posts') }}" class="waves-effect">
                        <i class="zmdi zmdi-view-list"></i> <span> پست ها </span>
                    </a>
                </li>

                <li>
                    <a href="{{ url('/admin/stories') }}" class="waves-effect">
                        <i class="zmdi zmdi-view-list-alt"></i> <span> استوری ها </span>
                    </a>
                </li>

                <li class="has_sub">
                    <a href="javascript:void(0);" class="waves-effect">
                        <i class="zmdi zmdi-comment"></i> <span>نظرات </span> <span class="menu-arrow"></span>
                    </a>
                    <ul class="list-unstyled">
                        <li><a href="{{ url('/admin/comments') }}">همه نظرات</a></li>
                        <li><a href="{{ url('/admin/comments?status=1') }}">تایید شده</a></li>
                        <li><a href="{{ url('/admin/comments?status=0') }}">در انتظار تایید</a></li>
                        <li><a href="{{ url('/admin/comments?status=2') }}">تایید نشده</a></li>
                    </ul>
                </li>

                <li>
                    <a href="{{ url('/admin/adverts') }}" class="waves-effect">
                        <i class="zmdi zmdi-assignment"></i> <span> تبلیغات </span>
                    </a>
                </li>

                <li>
                    <a href="{{ url('/admin/settings') }}" class="waves-effect">
                        <i class="zmdi zmdi-settings"></i> <span> تنظیمات </span>
                    </a>
                </li>


            </ul>
        </div>
        <!-- Sidebar -->

        <div class="clearfix"></div>

    </div>
</div>
