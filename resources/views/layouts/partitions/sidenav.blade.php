<style>
    .user-panel img {
        height: auto;
        width: 3.1rem;
    }

    .brand-link .brand-image {
        max-height: 44px;
    }

    a#navbarDropdown {
        margin-top: 13%;
    }
</style>
<aside class="main-sidebar sidebar-dark-primary elevation-4" oncontextmenu="return false";>
    <!-- Brand Logo -->
    <a href="" class="brand-link">
        <img src="{{ URL::asset('assets/dist/img/adminlogo.png') }}" alt="AdminLTE Logo"
            class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light">Quiz</span>
    </a>

    <!-- Sidebar -->
    <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
            <img src="{{ URL::asset('assets/dist/img/user.webp') }}" class="img-circle elevation-2"
                alt="User Image">
        </div>
        <div class="info">
            <a style="color: white" id="navbarDropdown" class="d-block" href="#" role="button"
                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>

                @if (isset($participator->name))
                    {{ $participator->name }}
                @else
                    {{ Auth::user()->name }}
                @endif
            </a>
            {{-- <a href="#" class="d-block"> <?php echo isset($_SESSION['name']) ? $_SESSION['name'] : header('Location:login/login.php'); ?> </a> --}}

        </div>
    </div>

    <!-- Sidebar Menu -->
    <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
            <!-- Add icons to the links using the .nav-icon class
             with font-awesome or any other icon font library -->
            @if (isset($participator->type) && $participator->type == 'participate')
                {{-- <li class="nav-item menu-open">
          <a href="{{ url('/quiz') }}" class="nav-link highlight">
            <i class="nav-icon fas fa-tachometer-alt"></i>
            <p>
              Dashboard
            </p>
          </a>
        </li> --}}
            @else
                <li class="nav-item menu-open">
                    <a href="{{ url('user') }}" class="nav-link highlight <?php if ($page == 'profile') {
                        echo 'active';
                    } ?>">
                        <i class="far fa fa-user-alt nav-icon"></i>
                        <p>Profile</p>
                    </a>

                </li>
                @if (Auth::user()->role == 'admin')
                    <li class="nav-item menu-open">
                        <a
                            href="{{ url('/subadmin') }}"class="nav-link highlight {{ (Request::is('subadmin')||Request::is('subadmin/*'))? 'active': '' }}">
                            <i class="nav-icon fa fa-address-book" aria-hidden="true"></i> 
                            <p>
                                Admin List
                            </p>
                        </a>
                    </li>
                

                <li class="nav-item menu-open">
                        <a
                            href="{{ url('/subadminnew') }}"class="nav-link highlight {{ (Request::is('subadminnew')||Request::is('subadminnew/*'))? 'active': '' }}">
                            <i class="nav-icon fa fa-address-book" aria-hidden="true"></i> 
                            <p>
                                Sub Admin List
                            </p>
                        </a>
                    </li>
                @endif
                @if (Auth::user()->role == 'admin' || Auth::user()->role == 'subadmin' || Auth::user()->role == 'subadminnew')
                <li class="nav-item menu-open">
                    <a href="{{ url('/home') }}" class="nav-link highlight  <?php if ($page == 'dashboard') {
                        echo 'active';
                    } ?>">
                        <i class="nav-icon fas fa fa-list"></i>
                        <p>
                            Quiz Main Dashboard
                        </p>
                    </a>
                </li>
                @endif

                <li class="nav-item menu-open">
                    <a href="{{ url('participantList') }}" class="nav-link highlight <?php if ($page == 'participant') {
                        echo 'active';
                    } ?>">
                        <i class="nav-icon fa fa-users "></i>
                        <p>Quiz Participant</p>
                    </a>

                </li>
                @if (Auth::user()->role == 'admin')
                    <li class="nav-item menu-open">
                        <a href="{{ url('/department') }}" class="nav-link highlight <?php if ($page == 'department') {
                            echo 'active';
                        } ?>">
                            <i class="nav-icon fas fa-copy"></i>
                            <p>Quiz Department</p>
                        </a>

                    </li>

                    <li class="nav-item menu-open">
                        <a href="{{ url('/category') }}" class="nav-link highlight <?php if ($page == 'category') {
                            echo 'active';
                        } ?>">
                            <i class="nav-icon fas fa-th "></i>
                            <p>Quiz Category</p>
                        </a>
                    </li>
					@endif
					@if (Auth::user()->role == 'admin' || Auth::user()->role == 'subadmin')
                    <li class="nav-item menu-open">
                        <a href="{{url('/import')}}" class="nav-link highlight  <?php if ($page == 'import') {
                            echo 'active';
                        } ?>">
                            <i class="far fa fa-download nav-icon"></i>
                            <p>Quiz import</p>
                        </a>
                    </li>
                    @endif
                    @if (Auth::user()->role == 'admin')
                  <li class="nav-item menu-open">
                        <a href="{{ url('/test_request') }}" class="nav-link highlight  <?php if ($page == 'test_request') {
                            echo 'active';
                        } ?>">
                           <i class="fa fa-paper-plane nav-icon" aria-hidden="true"></i>
                            <p>Test Request</p>
                        </a>
                    </li>          
                @endif

                <li class="nav-item menu-open">
                    <a href="{{ url('/result') }}" class="nav-link highlight <?php if ($page == 'result') {
                        echo 'active';
                    } ?>">
                        <i class="far fa fa-list-alt nav-icon"></i>
                        <p>Quiz Result</p>
                    </a>

                </li>

                <li class="nav-item menu-open">
                    <a class="nav-link highlight" href="{{ route('clogout') }}"
                        onclick="event.preventDefault();
                               document.getElementById('logout-form').submit();">
                        <i class="nav-icon fas fa-sign-out-alt"></i>
                        <p> {{ __('Logout') }} </p>
                    </a>

                    <form id="logout-form" action="{{ route('clogout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                </li>
            @endif
    </nav>
    <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>

<aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
</aside>
