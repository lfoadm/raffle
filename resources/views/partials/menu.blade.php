<!--begin::User menu-->
<div class="app-navbar-item ms-1 ms-md-4" id="kt_header_user_menu_toggle">
    <!--begin::Menu wrapper-->
    <div class="cursor-pointer symbol symbol-35px" data-kt-menu-trigger="{default: 'click', lg: 'hover'}" data-kt-menu-attach="parent" data-kt-menu-placement="bottom-end">
        <img src="{{ Auth::user()->image ? asset('assets/media/avatars/' . Auth::user()->image) : asset('assets/media/avatars/blank.png') }}" class="rounded-3" alt="user" />
    </div>
    <!--begin::User account menu-->
    <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg menu-state-color fw-semibold py-4 fs-6 w-275px" data-kt-menu="true">
        <!--begin::Menu item-->
        <div class="menu-item px-3">
            <div class="menu-content d-flex align-items-center px-3">
                <!--begin::Avatar-->
                <div class="symbol symbol-50px me-5">
                    <img alt="Logo" src="{{ Auth::user()->image ? asset('assets/media/avatars/' . Auth::user()->image) : asset('assets/media/avatars/blank.png') }}" />
                </div>
                <!--end::Avatar-->
                <!--begin::Username-->
                <div class="d-flex flex-column">
                    <div class="fw-bold d-flex align-items-center fs-5">{{ Auth::user()->name }} 
                    <span class="badge badge-light-success fw-bold fs-8 px-2 py-1 ms-2">{{ Auth::user()->role }}</span></div>
                    <a href="#" class="fw-semibold text-muted text-hover-primary fs-7">{{ Auth::user()->email }}</a>
                </div>
                <!--end::Username-->
            </div>
        </div>
        <!--end::Menu item-->
        <!--begin::Menu separator-->
        <div class="separator my-2"></div>
        <!--end::Menu separator-->
        <!--begin::Menu item-->
        <div class="menu-item px-5">
            <a href="{{ route('user.profile') }}" class="menu-link px-5">Meu perfil</a>
        </div>
        <!--end::Menu item-->
        
        <!--begin::Menu item-->
        <div class="menu-item px-5 my-1">
            <a href="account/settings.html" class="menu-link px-5">Configurações</a>
        </div>
        <!--end::Menu item-->
        <!--begin::Menu item-->
        <div class="menu-item px-5">
            <form action="{{ route('logout') }}" method="POST" id="logout-form">
                @csrf
                <a href="{{ route('logout') }}" class="menu-link px-5" onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                    <span class="badge badge-light-danger badge fw-bold fs-7">Sair</span></h6>
                </a>
            </form>
        </div>
        <!--end::Menu item-->
    </div>
    <!--end::User account menu-->
    <!--end::Menu wrapper-->
</div> 
<!--end::User menu-->