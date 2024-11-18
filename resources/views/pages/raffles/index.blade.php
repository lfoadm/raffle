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
                        <h1 class="page-heading d-flex text-gray-900 fw-bold fs-3 flex-column justify-content-center my-0">Minhas rifas</h1>
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
                            <li class="breadcrumb-item text-muted">minhas rifas</li>
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
                    @include('components.alert')
                    <!--begin::Products-->
                    <div class="card card-flush">
                        <!--begin::Card header-->
                        <div class="card-header align-items-center py-5 gap-2 gap-md-5">
                           <!--begin::Card header-->
                        
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
                                <div class="w-100 mw-150px">
                                    <!--begin::Select2-->
                                    <select class="form-select form-select-solid" data-control="select2" data-hide-search="true" data-placeholder="Status" data-kt-ecommerce-product-filter="status">
                                        <option></option>
                                        <option value="all">Todos</option>
                                        <option value="active">Em andamento</option>
                                        <option value="closed">Finalizado</option>
                                        <option value="inactive">Inativo</option>
                                    </select>
                                    <!--end::Select2-->
                                </div>
                                <!--begin::Add product-->
                                <a href="{{ route('raffles.create') }}" class="btn btn-primary">Adicionar</a>
                                <!--end::Add product-->
                            </div>
                            <!--end::Card toolbar-->
                        
                        <!--end::Card header-->
                          
                        </div>
                        
                        <!--end::Card header-->
                        <!--begin::Card body-->
                        <div class="card-body pt-0">
                            
                            <!--begin::Table-->
                            @if($raffles->count() > 0)
                            <table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_ecommerce_products_table">
                                <thead>
                                    <tr class="text-start text-gray-500 fw-bold fs-7 text-uppercase gs-0">
                                        <th class="min-w-200px">Título</th>
                                        <th class="text-center min-w-100px">Código</th>
                                        <th class="text-center min-w-100px">Categoria</th>
                                        <th class="text-center min-w-70px">Qtde. cotas</th>
                                        <th class="text-center min-w-70px">Cotas vendidas</th>
                                        <th class="text-center min-w-70px">Cotas restantes</th>
                                        <th class="text-center min-w-100px">Valor cota</th>
                                        <th class="text-center min-w-150px">Valor Total</th>
                                        <th class="text-center min-w-100px">Status</th>
                                        <th class="text-center min-w-70px">Ações</th>
                                    </tr>
                                </thead>
                                <tbody class="fw-semibold text-gray-600">
                                    @foreach ($raffles as $raffle)
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <!--begin::Thumbnail-->
                                                <a href="apps/ecommerce/catalog/edit-product.html" class="symbol symbol-50px">
                                                    <span class="symbol-label" style="background-image:url({{ asset('assets/media/products') }}/{{ $raffle->image }});"></span>
                                                </a>
                                                <!--end::Thumbnail-->
                                                <div class="ms-5">
                                                    <!--begin::Title-->
                                                    <a href="{{ route('raffles.show', ['raffle' => $raffle->id]) }}"
                                                        class="text-gray-800 text-hover-primary fs-5 fw-bold"
                                                        data-kt-ecommerce-product-filter="product_name">{{ $raffle->title }}</a>
                                                    <!--end::Title-->
                                                </div>
                                            </div>
                                        </td>
                                        <td class="text-center pe-0">
                                            <span class="fw-bold">{{ $raffle->id }}</span>
                                        </td>
                                        <td class="text-center pe-0">
                                            <span class="fw-bold">{{ $raffle->category->name }}</span>
                                        </td>
                                        <td class="text-center pe-0" data-order="3">
                                            <span class="fw-bold text-success ms-3">{{ number_format($raffle->quota_count, 0, ',', '.') }}</span>
                                        </td>
                                        <td class="text-center pe-0" data-order="3">
                                            <span class="fw-bold text-primary ms-3">{{ number_format($raffle->quota_sold, 0, ',', '.') }}</span>
                                        </td>
                                        <td class="text-center pe-0" data-order="3">
                                            <span class="fw-bold text-info ms-3">{{ number_format($raffle->quota_balance, 0, ',', '.') }}</span>
                                        </td>
                                        <td class="text-center pe-0">R$ {{ number_format($raffle->quota_price, 2, ',', '.') }}</td>
                                        <td class="text-center ">R$ {{ number_format($raffle->total_value, 2, ',', '.') }}</td>
                                        <td class="text-center pe-0" data-order="Inactive">
                                            <!--begin::Badges-->
                                            <div class="badge badge-light-danger">
                                                @if($raffle->status === 'active')
                                                <span class="badge badge-light-success">Em andamento</span>
                                                @elseif($raffle->status === 'closed')
                                                <span class="badge badge-light-secondary">Finalizada</span>
                                                @else
                                                <span class="badge badge-light-danger">Inativa</span>
                                                @endif
                                            </div>
                                            <!--end::Badges-->
                                        </td>
                                        <td class="text-end">
                                            <a href="#" class="btn btn-sm btn-light btn-flex btn-center btn-active-light-primary"
                                                data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">Ações
                                                <i class="ki-duotone ki-down fs-5 ms-1"></i></a>
                                            <!--begin::Menu-->
                                            <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-125px py-4"
                                                data-kt-menu="true">
                                                <!--begin::Menu item-->
                                                <div class="menu-item px-3">
                                                    <a href="{{ route('raffles.edit', ["raffle" => $raffle->id]) }}" class="menu-link px-3">Editar</a>
                                                </div>
                                                <!--end::Menu item-->
                                                <!--begin::Menu item-->

                                                <div class="menu-item px-3">
                                                    <a href="#" class="menu-link px-3" onclick="event.preventDefault(); confirmDelete('{{ $raffle->id }}');">
                                                        Apagar
                                                    </a>
                                                
                                                    <form id="deactivate-form-{{ $raffle->id }}" action="{{ route('raffles.disable', $raffle->id) }}" 
                                                          method="POST" 
                                                          style="display: none;">
                                                        @csrf
                                                        @method('PATCH')
                                                    </form>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            @else
                            <p>Você ainda não possui nenhuma rifa!</p>
                            @endif
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
        <!--begin::Footer-->
        <div id="kt_app_footer" class="app-footer">
            <!--begin::Footer container-->
            <div class="app-container container-fluid d-flex flex-column flex-md-row flex-center flex-md-stack py-3">
                <!--begin::Copyright-->
                <div class="text-gray-900 order-2 order-md-1">
                    <span class="text-muted fw-semibold me-1">2024&copy;</span>
                    <a href="https://keenthemes.com" target="_blank" class="text-gray-800 text-hover-primary">Keenthemes</a>
                </div>
                <!--end::Copyright-->
                <!--begin::Menu-->
                <ul class="menu menu-gray-600 menu-hover-primary fw-semibold order-1">
                    <li class="menu-item">
                        <a href="https://keenthemes.com" target="_blank" class="menu-link px-2">About</a>
                    </li>
                    <li class="menu-item">
                        <a href="https://devs.keenthemes.com" target="_blank" class="menu-link px-2">Support</a>
                    </li>
                    <li class="menu-item">
                        <a href="https://1.envato.market/Vm7VRE" target="_blank" class="menu-link px-2">Purchase</a>
                    </li>
                </ul>
                <!--end::Menu-->
            </div>
            <!--end::Footer container-->
        </div>
        <!--end::Footer-->
    </div>
    <!--end:::Main-->
@endsection

@push('scripts')
<script>
    function confirmDelete(raffleId) {
        const confirmAction = confirm("Tem certeza que deseja desativar esta rifa?");
        if (confirmAction) {
            document.getElementById(`deactivate-form-${raffleId}`).submit();
        }
    }
</script>    
@endpush