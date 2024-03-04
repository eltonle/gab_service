<header id="page-topbar">
    <div class="navbar-header">
        <div class="d-flex">
            <!-- LOGO -->

            <div class="navbar-brand-box">
                <!-- <a href="index.html" class="logo logo-dark">
                    <span class="logo-sm">
                        <img src="{{asset('assets/images/logo-sm.png')}}" alt="logo-sm" height="17">
                    </span>
                    <span class="logo-lg">
                        <img src="{{asset('assets/images/logo-dark.png')}}" alt="logo-dark" height="15">
                    </span>
                </a> -->

                <a href="index.html" class="logo logo-ligh ">
                    <!-- <span class="logo-sm">
                        <img src="{{asset('assets/images/logo-sm.png')}}" alt="logo-sm-light" height="17">
                    </span> -->
                    <!-- <span class="logo-lg">
                        <img src="{{asset('assets/images/logo-light.png')}}" alt="logo-light" height="10">
                    </span> -->
                </a>
            </div>

            <button type="button" class="btn btn-sm px-3 font-size-24 header-item waves-effect" id="vertical-menu-btn">
                <i class="ri-menu-2-line align-middle"></i>
            </button>

        </div>

        <div class="d-flex">





            <div class="dropdown d-none d-lg-inline-block ms-1">
                <button type="button" class="btn header-item noti-icon waves-effect" data-toggle="fullscreen">
                    <i class="ri-fullscreen-line"></i>
                </button>
            </div>


            @php
            $id = Auth::user()->id;
            $adminData = App\Models\User::find($id);
            @endphp
            <div class="dropdown d-inline-block user-dropdown">
                <button type="button" class="btn header-item waves-effect" id="page-header-user-dropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <img class="rounded-circle header-profile-user" src="{{ (!empty($adminData->profile_image))? url('upload/admin_images/'.$adminData->profile_image):url('upload/no_image.jpg')}}" alt="Header Avatar">
                    <span class="d-none d-xl-inline-block ms-1">{{ $adminData->name }}</span>
                    <i class="mdi mdi-chevron-down d-none d-xl-inline-block"></i>
                </button>
                <div class="dropdown-menu dropdown-menu-end">
                    <!-- item-->
                    <a class="dropdown-item" href="{{route('admin.profile')}}"><i class=" fas fa-user-cog align-middle me-1"></i> Profil</a>
                    <a class="dropdown-item" href="{{ route('change.password') }}"><i class="fas fa-user-lock align-middle me-1"></i> Changer mot de pass</a>
                    <div class="dropdown-divider"></div>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="dropdown-item text-danger" href=""><i class="fas fa-power-off align-middle me-1 text-danger"></i> Se Deconnecter</button>
                    </form>
                </div>
            </div>


        </div>
    </div>
</header>