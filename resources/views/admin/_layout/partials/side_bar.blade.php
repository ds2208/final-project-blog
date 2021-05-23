<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="{{route('admin.index.index')}}" class="brand-link">
        <img src="{{url('themes/admin/dist/img/AdminLTELogo.png')}}" alt="Cubes School Logo" class="brand-image img-circle elevation-3"
             style="opacity: .8">
        <span class="brand-text font-weight-light">Cubes School</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <!-- Add icons to the links using the .nav-icon class
                     with font-awesome or any other icon font library -->
                <li class="nav-item has-treeview">
                    <a href="#" class="nav-link">
                        <i class="nav-icon far fa-plus-square"></i>
                        <p>
                            @lang('Blogs')
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{route('admin.blogs.index')}}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>@lang('Blogs')</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('admin.blogs.add')}}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>@lang('Add Blog')</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item has-treeview">
                    <a href="#" class="nav-link">
                        <i class="nav-icon far fa-plus-square"></i>
                        <p>
                            @lang('Tags')
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{route('admin.tags.index')}}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>@lang('Tags')</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('admin.tags.add')}}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>@lang('Add Tag')</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item has-treeview">
                    <a href="#" class="nav-link">
                        <i class="nav-icon far fa-plus-square"></i>
                        <p>
                            @lang('Categories')
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{route('admin.categories.index')}}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>@lang('Categories')</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('admin.categories.add')}}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>@lang('Add Category')</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item has-treeview">
                    <a href="#" class="nav-link">
                        <i class="nav-icon far fa-plus-square"></i>
                        <p>
                            @lang('Ads')
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{route('admin.ads.index')}}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>@lang('Ads')</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('admin.ads.add')}}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>@lang('Add Ad')</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item has-treeview">
                    <a href="#" class="nav-link">
                        <i class="nav-icon far fa-plus-square"></i>
                        <p>
                            @lang('Authors')
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{route('admin.users.index')}}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>@lang('Authors')</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('admin.users.add')}}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>@lang('Add Author')</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a href="{{route('admin.comments.index')}}" class="nav-link">
                        <i class="nav-icon far fa-plus-square"></i>
                        <p>
                            @lang('Comments')
                        </p>
                    </a>
                </li>
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>