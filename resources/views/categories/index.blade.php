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
                        <h1 class="page-heading d-flex text-gray-900 fw-bold fs-3 flex-column justify-content-center my-0">Categorias</h1>
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
                            <li class="breadcrumb-item text-muted">categorias</li>
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
                    @include('partials.alerts.success')
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
                                    <input type="text" data-kt-ecommerce-product-filter="search" class="form-control form-control-solid w-250px ps-12" placeholder="Buscar..." />
                                </div>
                                <!--end::Search-->
                            </div>
                            <!--end::Card title-->
                            <!--begin::Card toolbar-->
                            <div class="card-toolbar flex-row-fluid justify-content-end gap-5">
                                <!--begin::Add product-->
                                <a href="{{ route('admin.categories.create') }}" class="btn btn-primary">Adicionar</a>
                                <!--end::Add product-->
                            </div>
                            <!--end::Card toolbar-->
                        </div>
                        <!--end::Card header-->
                        <!--begin::Card body-->
                        <div class="card-body pt-0">
                            <!--begin::Table-->
                            <table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_ecommerce_products_table">
                                <thead>
                                    <tr class="text-start text-gray-500 fw-bold fs-7 text-uppercase gs-0">
                                        <th class="text-center min-w-100px">Código</th>
                                        <th class="text-center min-w-100px">Nome</th>
                                        <th class="text-start min-w-100px">Descrição</th>
                                        <th class="text-center min-w-70px">Ações</th>
                                    </tr>
                                </thead>
                                <tbody class="fw-semibold text-gray-600">
                                    @foreach ($categories as $category)
                                    <tr>
                                        <td class="text-center pe-0">
                                            <span class="fw-bold">{{ $category->id }}</span>
                                        </td>
                                        <td class="text-center pe-0">
                                            <span class="fw-bold">{{ $category->name }}</span>
                                        </td>
                                        <td class="text-start pe-0">
                                            <span class="fw-bold">{{ $category->description }}</span>
                                        </td>
                                        <td class="text-center">
                                            <a href="#" class="btn btn-sm btn-light btn-flex btn-center btn-active-light-primary" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">Ação 
                                            <i class="ki-duotone ki-down fs-5 ms-1"></i></a>
                                            <!--begin::Menu-->
                                            <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-125px py-4" data-kt-menu="true">
                                                <!--begin::Menu item-->
                                                <div class="menu-item px-3">
                                                    <a href="{{ route('admin.categories.edit', ['category' => $category->id]) }}" class="menu-link px-3">Editar</a>
                                                </div>
                                                <!--end::Menu item-->
                                                <!--begin::Menu item-->
                                                
                                                <div class="menu-item px-3">
                                                    <a href="#" type="submit" class="menu-link px-3" data-kt-ecommerce-product-filter="delete_row" onclick="event.preventDefault(); if(confirm('Tem certeza que deseja deletar?')) { document.getElementById('delete-form-{{ $category->id }}').submit(); }">
                                                        Deletar
                                                    </a>
                                                    <form id="delete-form-{{ $category->id }}" action="{{ route('admin.categories.destroy', ['category' => $category->id]) }}" method="POST" style="display: none;">
                                                        @csrf
                                                        @method('DELETE')
                                                    </form>
                                                </div>
                                                
                                                {{-- <form action="{{ route('admin.categories.destroy', ) }}" method="POST"> --}}
                                                    
                                                
                                                <!-- Formulário escondido para envio do DELETE -->




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