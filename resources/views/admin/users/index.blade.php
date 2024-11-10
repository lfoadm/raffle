@extends('layouts.admin')
@section('content')

<!--begin::Main-->
<div class="app-main flex-column flex-row-fluid" id="kt_app_main">
    <!--begin::Content wrapper-->
    <div class="d-flex flex-column flex-column-fluid">
        <!--begin::Toolbar-->
        <div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
            <!--begin::Toolbar container-->
            <div id="kt_app_toolbar_container" class="app-container container-xxl d-flex flex-stack">
                <!--begin::Page title-->
                <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
                    <!--begin::Title-->
                    <h1 class="page-heading d-flex text-gray-900 fw-bold fs-3 flex-column justify-content-center my-0">Lista de usuários</h1>
                    <!--end::Title-->
                    <!--begin::Breadcrumb-->
                    <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
                        <!--begin::Item-->
                        <li class="breadcrumb-item text-muted">
                            <a href="{{ route('home') }}" class="text-muted text-hover-primary">Home</a>
                        </li>
                        <!--end::Item-->
                        <!--begin::Item-->
                        <li class="breadcrumb-item">
                            <span class="bullet bg-gray-500 w-5px h-2px"></span>
                        </li>
                        <!--end::Item-->
                        <!--begin::Item-->
                        <li class="breadcrumb-item text-muted">Usuários</li>
                        <!--end::Item-->
                    </ul>
                    <!--end::Breadcrumb-->
                </div>
                <!--end::Page title-->
            </div>
            <!--end::Toolbar container-->
        </div>
        <!--end::Toolbar-->
        <!--begin::Content-->
        <div id="kt_app_content" class="app-content flex-column-fluid">
            <!--begin::Content container-->
            <div id="kt_app_content_container" class="app-container container-xxl">
                <!--begin::Products-->
                <div class="card card-flush">
                    <!--begin::Card header-->
                    <div class="card-header align-items-center py-5 gap-2 gap-md-5">
                        <!--begin::Card title-->
                        <div class="card-title">
                            <!--begin::Search-->
                            <div class="d-flex align-items-center position-relative my-1">
                                <i class="ki-duotone ki-magnifier fs-3 position-absolute ms-4">
                                    <span class="path1"></span>
                                    <span class="path2"></span>
                                </i>
                                <input type="text" data-kt-ecommerce-order-filter="search" class="form-control form-control-solid w-250px ps-12" placeholder="Buscar..." />
                            </div>
                            <!--end::Search-->
                        </div>
                        <!--end::Card title-->
                        </div>
                    <!--end::Card header-->
                    <!--begin::Card body-->
                    <div class="card-body pt-0">
                        <!--begin::Table-->
                        <table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_ecommerce_sales_table">
                            <thead>
                                <tr class="text-start text-gray-500 fw-bold fs-7 text-uppercase gs-0">
                                    <th class="text-start w-10px pe-2">
                                        <div class="form-check form-check-sm form-check-custom form-check-solid me-3">
                                            <input class="form-check-input" type="checkbox" data-kt-check="true" data-kt-check-target="#kt_ecommerce_sales_table .form-check-input" value="1" />
                                        </div>
                                    </th>
                                    <th class="min-w-100px">Cód usuário</th>
                                    <th class="min-w-175px">Nome</th>
                                    <th class="text-end min-w-70px">E-mail</th>
                                    <th class="text-end min-w-100px">Celular</th>
                                    <th class="text-end min-w-100px">Data Cadastro</th>
                                    <th class="text-end min-w-100px">Ações</th>
                                </tr>
                            </thead>
                            <tbody class="fw-semibold text-gray-600">
                                @foreach ($users as $user)
                                <tr>
                                    <td class="text-start">
                                        <div class="form-check form-check-sm form-check-custom form-check-solid">
                                            <input class="form-check-input" type="checkbox" value="1" />
                                        </div>
                                    </td>
                                    <td class="text-start" data-kt-ecommerce-order-filter="order_id">
                                        <a href="#" class="text-gray-800 text-hover-primary fw-bold">{{ $user->id }}</a>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <!--begin:: Avatar -->
                                            <div class="symbol symbol-circle symbol-50px overflow-hidden me-3">
                                                <a href="#">
                                                    <div class="symbol-label">
                                                        <img src="{{ $user->image ? asset('assets/media/avatars/' . $user->image) : asset('assets/media/avatars/blank.png') }}" alt="Max Smith" class="w-100" />
                                                    </div>
                                                </a>
                                            </div>
                                            <!--end::Avatar-->
                                            <div class="ms-5">
                                                <!--begin::Title-->
                                                <a href="#" class="text-gray-800 text-hover-primary fs-5 fw-bold">{{ $user->name }}</a>
                                                <!--end::Title-->
                                            </div>
                                        </div>
                                    </td>
                                    <td class="text-end pe-0">
                                        <span class="fw-bold">{{ $user->email }}</span>
                                    </td>
                                    <td class="text-end" data-order="2024-10-20">
                                        <span class="fw-bold">{{ $user->mobile }}</span>
                                    </td>
                                    <td class="text-end" data-order="2024-10-21">
                                        <span class="fw-bold">{{ $user->created_at->format('d/m/Y') }}</span>
                                    </td>
                                    <td class="text-end">
                                        <a href="#" class="btn btn-sm btn-light btn-flex btn-center btn-active-light-primary" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">Ações 
                                        <i class="ki-duotone ki-down fs-5 ms-1"></i></a>
                                        <!--begin::Menu-->
                                        <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-125px py-4" data-kt-menu="true">
                                            <!--begin::Menu item-->
                                            <div class="menu-item px-3">
                                                <a href="apps/ecommerce/sales/details.html" class="menu-link px-3">Ver</a>
                                            </div>
                                            <!--end::Menu item-->
                                            <!--begin::Menu item-->
                                            <div class="menu-item px-3">
                                                <a href="apps/ecommerce/sales/edit-order.html" class="menu-link px-3">Editar</a>
                                            </div>
                                            <!--end::Menu item-->
                                            <!--begin::Menu item-->
                                            {{-- <div class="menu-item px-3">
                                                <a href="#" class="menu-link px-3" data-kt-ecommerce-order-filter="delete_row">Delete</a>
                                            </div> --}}
                                            <!--end::Menu item-->
                                        </div>
                                        <!--end::Menu-->
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <!--end::Table-->
                    </div>
                    <!--end::Card body-->
                </div>
                <!--end::Products-->
            </div>
            <!--end::Content container-->
        </div>
        <!--end::Content-->
    </div>
    <!--end::Content wrapper-->
    @include('partials.footerAdmin')
</div>
<!--end:::Main-->

@endsection

