@extends('layouts.app')
@section('content')
<!--begin::Team Section-->
<div class="py-10 py-lg-20">
    <!--begin::Container-->
    <div class="container">
        
        
        <div class="shopping-cart">
            @if ($items->count()>0)
                <div class="cart-table__wrapper">
                    <table class="cart-table">
                        <thead>
                            <tr>
                                <th>Candidato</th>
                                <th></th>
                                <th></th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($items as $item)
                                <tr>
                                    <td>
                                        <div class="shopping-cart__product-item">
                                            {{-- <img loading="lazy" src="{{ asset('uploads/candidates/thumbnails') }}/{{ $item->model->image }}" width="120" height="120" alt="{{ $item->name }}" /> --}}
                                        </div>
                                    </td>
                                    <td>
                                        <div class="shopping-cart__product-item__detail">
                                            <h4>{{ $item->id }}</h4>
                                            <h4>{{ $item->raffle_quota_id }}</h4>
                                            <ul class="shopping-cart__product-item__options">
                                                {{ $item->unit_price }}
                                                <li>{{ $item->total_price }}</li>
                                            </ul>
                                        </div>
                                    </td>
                                                                        
                                    <td>
                                        <form action="#" method="post">
                                            @csrf
                                            @method('DELETE')
                                            <a href="javascript:void(0)" class="remove-cart">
                                                <svg width="10" height="10" viewBox="0 0 10 10" fill="#767676" xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M0.259435 8.85506L9.11449 0L10 0.885506L1.14494 9.74056L0.259435 8.85506Z" />
                                                    <path d="M0.885506 0.0889838L9.74057 8.94404L8.85506 9.82955L0 0.97449L0.885506 0.0889838Z" />
                                                </svg>
                                            </a>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <div class="cart-table-footer">
                        <form action="#" method="post">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-light">Limpar bilhete</button>
                        </form>
                    </div>
                    <div>
                        @if(Session::has('success'))
                            <p class="text-success">{{ Session::get('success') }}</p>
                        @elseif(Session::has('error'))
                            <p class="text-danger">{{ Session::get('error') }}</p>
                        @endif
                    </div>
                </div>
                <div class="shopping-cart__totals-wrapper">
                    <div class="sticky-content">
                        <div class="shopping-cart__totals">
                            <h3>Valor total do Bilhete</h3>
                            
                            <table class="cart-totals">
                                <tbody>
                                    <tr>
                                        <th>Total</th>
                                        <td>R$ 20,00</td>
                                    </tr>
                                </tbody>
                            </table>
                            
                        </div>
                        <div class="mobile_fixed-btn_wrapper">
                                    {{-- <a href="{{ route('cart.checkout') }}" class="btn btn-primary btn-checkout">Continuar a compra</a> --}}
                                    <a href="#" class="btn btn-primary btn-checkout">Continuar a compra</a>
                            </div>
                        </div>
                    </div>
                </div>
            @else
                <div class="row">
                    <div class="col-md-12 text-center pt-5 bp-5">
                        <p>Nenhum item encontrado em seu bilhete</p>
                        <a href="#" class="btn btn-info">ESCOLHER CANDIDATOS</a>
                    </div>
                </div>
            @endif
        </div>
              

                
    </div>
    <!--end::Container-->
</div>
<!--end::Team Section-->
@endsection