@extends('layouts.app')
@section('content')
<!--begin::Team Section-->
<div class="py-10 py-lg-20">
    <!--begin::Container-->
    <div class="container">

        <div class="card-body pt-0">
            <!--begin::Table-->
            <table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_ecommerce_raffles_table">
                <thead>
                    <tr class="text-start text-gray-500 fw-bold fs-7 text-uppercase gs-0">
                        <th class="text-center min-w-100px">Código</th>
                        <th class="text-center min-w-100px">Nome</th>
                        <th class="text-start min-w-100px">Descrição</th>
                        <th class="text-center min-w-70px">Ações</th>
                    </tr>
                </thead>
                <tbody class="fw-semibold text-gray-600">
                    @foreach ($raffles as $raffle)
                    <tr>
                        <td class="text-center pe-0">
                            <span class="fw-bold">{{ $raffle->id }}</span>
                        </td>
                        <td class="text-center pe-0">
                            <span class="fw-bold">{{ $raffle->title }}</span>
                        </td>
                        <td class="text-start pe-0">
                            <span class="fw-bold">{{ $raffle->description }}</span>
                        </td>
                        <td class="text-center">
                            <a href="#" class="btn btn-sm btn-light btn-flex btn-center btn-active-light-primary"
                                data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">Ação
                                <i class="ki-duotone ki-down fs-5 ms-1"></i></a>
                            <!--begin::Menu-->
                            <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-125px py-4"
                                data-kt-menu="true">
                                <!--begin::Menu item-->
                                <div class="menu-item px-3">
                                    <a href="#"
                                        class="menu-link px-3">Editar</a>
                                </div>
                                <!--end::Menu item-->


                            </div>
                            <!--end::Menu-->
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            <!--end::Card body-->
            <!-- Pagination -->
            <div class="flex items-center justify-between flex-wrap gap10 wgp-pagination">
                {{ $raffles->links('pagination::bootstrap-5') }}
            </div>
            <!--end::Pagination-->
        </div>


    </div>
    <!--end::Container-->
</div>
<!--end::Team Section-->
@endsection