@extends('layouts.app')
@section('content')
<div class="app-main flex-column flex-row-fluid" id="kt_app_main">
    <div class="d-flex flex-column flex-column-fluid">
        <div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
            <div id="kt_app_toolbar_container" class="app-container container-xxl d-flex flex-stack">
                <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
                    <h1 class="page-heading d-flex text-gray-900 fw-bold fs-3 flex-column justify-content-center my-0">Meu carrinho</h1>
                    <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
                        <li class="breadcrumb-item text-muted">
                            <a href="{{ route('home') }}" class="text-muted text-hover-primary">Home</a>
                        </li>
                        <li class="breadcrumb-item">
                            <span class="bullet bg-gray-500 w-5px h-2px"></span>
                        </li>
                        <li class="breadcrumb-item text-muted">Resumo de compras</li>
                    </ul>
                </div>
            </div>
        </div>
        <div id="kt_app_content" class="app-content flex-column-fluid">
            <div id="kt_app_content_container" class="app-container container-xxl">
                @include('components.alert')
                <div class="card card-flush">
                        <div class="card-body pt-0">
                        {{-- $cartItemsGrouped --}}
                        @if($cartItemsGrouped && count($cartItemsGrouped) > 0)
                            <table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_ecommerce_products_table">
                                <thead>
                                    <tr class="text-start text-gray-500 fw-bold fs-7 text-uppercase gs-0">
                                        <th class="text-center min-w-70px">#</th>
                                        <th class="min-w-200px">Nome da Rifa</th>
                                        <th class="text-center min-w-70px">Qtde. cotas</th>
                                        <th class="text-center min-w-70px">Nº da cota</th>
                                        <th class="text-center min-w-70px">Valor cota</th>
                                        <th class="text-center min-w-70px">Valor Total</th>
                                        <th class="text-center min-w-70px">Remover item</th>
                                    </tr>
                                </thead>
                                <tbody class="fw-semibold text-gray-600">
                                    @foreach($cartItemsGrouped as $index => $group)
                                    <tr>
                                        <td class="text-center pe-0"><span class="fw-bold">{{ $loop->iteration }}</span></td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <a href="#" class="symbol symbol-50px">
                                                    {{-- <span class="symbol-label" style="background-image:url({{ asset('assets/media/products') }}/{{ $item->raffleQuota->raffle->image }});"></span> --}}
                                                    <span class="symbol-label" style="background-image:url({{ asset('assets/media/products') }}/{{ $group['raffle_image'] }});"></span>
                                                </a>
                                                <div class="ms-5">
                                                    <a href="#" class="text-gray-800 text-hover-primary fs-5 fw-bold" data-kt-ecommerce-product-filter="product_name">{{ $group['raffle_name'] }}</a>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="text-center pe-0" data-order="3"><span class="badge badge-light-info">{{ $group['quota_count'] }}</span></td>
                                        <td class="text-center pe-0" data-order="3"><span class="badge badge-light-info">{{ implode(', ', $group['quota_numbers']) }}</span></td>
                                        <td class="text-center pe-0">R$ {{ number_format($group['unit_price'], 2, ',', '.') }}</td>
                                        <td class="text-center pe-0">R$ {{ number_format($group['total_price'], 2, ',', '.') }}</td>
                                        
                                        <td class="text-center pe-0">
                                            {{-- <form id="remove-cart-{{ $loop->index }}" action="{{ route('cart.removeRaffle') }}" method="post">
                                                @csrf
                                                @method('DELETE')
                                                <!-- Campo hidden para enviar os IDs -->
                                                <input type="hidden" name="raffle_ids[]" value="{{ implode(',', $group['items']->pluck('raffle_quota_id')->toArray()) }}">
                                                <a href="javascript:void(0);" class="remove-cart" data-form-id="remove-cart-{{ $loop->index }}">
                                                    <svg width="14" height="14" viewBox="0 0 10 10" fill="#767676" xmlns="http://www.w3.org/2000/svg">
                                                        <path d="M0.259435 8.85506L9.11449 0L10 0.885506L1.14494 9.74056L0.259435 8.85506Z" />
                                                        <path d="M0.885506 0.0889838L9.74057 8.94404L8.85506 9.82955L0 0.97449L0.885506 0.0889838Z" />
                                                    </svg>
                                                </a>
                                            </form> --}}

                                            <form id="remove-cart-{{ $loop->index }}" action="{{ route('cart.removeRaffle') }}" method="post">
                                                @csrf
                                                @method('DELETE')
                                                <!-- Campos hidden individuais para enviar os IDs -->
                                                @foreach ($group['items'] as $item)
                                                    <input type="hidden" name="raffle_ids[]" value="{{ $item['raffle_quota_id'] }}">
                                                @endforeach
                                                <a href="javascript:void(0);" class="remove-cart" data-form-id="remove-cart-{{ $loop->index }}">
                                                    <svg width="14" height="14" viewBox="0 0 10 10" fill="#767676" xmlns="http://www.w3.org/2000/svg">
                                                        <path d="M0.259435 8.85506L9.11449 0L10 0.885506L1.14494 9.74056L0.259435 8.85506Z" />
                                                        <path d="M0.885506 0.0889838L9.74057 8.94404L8.85506 9.82955L0 0.97449L0.885506 0.0889838Z" />
                                                    </svg>
                                                </a>
                                            </form>

                                            
                                            
                                        </td>

                                    </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="5" class="text-end"><strong>Total Geral:</strong></td>
                                        <td colspan="2">
                                            <strong>
                                                R$ {{ number_format($cartItemsGrouped->sum('total_price'), 2, ',', '.') }}
                                            </strong>
                                        </td>
                                    </tr>
                                </tfoot>
                            </table>
                            <div class="d-flex justify-content-between mt-4">
                                <a href="{{ route('home') }}" class="btn btn-secondary">Continuar Comprando</a>
                                <a href="{{ route('home') }}" class="btn btn-primary">Finalizar Compra</a>
                            </div>
                        @else
                        <p>Você ainda não possui nenhuma rifa!</p>
                        @endif
                        <!--end::Table-->
                    </div>
                    <!--end::Card body-->
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.querySelectorAll('.remove-cart').forEach(button => {
        button.addEventListener('click', function (event) {
            event.preventDefault();

            const formId = this.getAttribute('data-form-id');
            const form = document.getElementById(formId);

            if (form) {
                form.submit(); // Envia o formulário
            }
        });
    });
</script>
@endpush