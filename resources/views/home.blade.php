@extends('layouts.app')
@section('content')
<!--begin::Team Section-->
<div class="py-10 py-lg-20">
    <!--begin::Container-->
    <div class="container">
        <!--begin::Heading-->
        <div class="text-center mb-12">
            <!--begin::Title-->
            <h3 class="fs-2hx text-gray-900 mb-5" id="team" data-kt-scroll-offset="{default: 100, lg: 150}">A sorte está apenas um clique distante!</h3>
            <!--end::Title-->
            <!--begin::Sub-title-->
            <div class="fs-1 fw-bold text-warning">Sorte, emoção e muito mais, aqui!</div>
            <!--end::Sub-title=-->
        </div>
        <!--end::Heading-->
        <!--begin::Slider-->
        <div class="tns tns-default" style="direction: ltr">
            <!--begin::Wrapper-->
            <div data-tns="true" data-tns-loop="true" data-tns-swipe-angle="false" data-tns-speed="2000" data-tns-autoplay="true" data-tns-autoplay-timeout="18000" data-tns-controls="true" data-tns-nav="false" data-tns-items="1" data-tns-center="false" data-tns-dots="false" data-tns-prev-button="#kt_team_slider_prev" data-tns-next-button="#kt_team_slider_next" data-tns-responsive="{1200: {items: 3}, 992: {items: 2}}">
                <!--begin::Item-->
                @foreach ($raffles as $raffle)
                <div class="text-center">
                    <!--begin::Photo-->
                    
                        <a href="{{ route('raffle.show', ['raffle_slug' => $raffle->slug]) }}">
                            <div class="octagon mx-auto mb-5 d-flex w-200px h-200px bgi-no-repeat bgi-size-contain bgi-position-center" style="background-image:url({{ $raffle->image ? asset('assets/media/products/' . $raffle->image) : asset('assets/media/svg/files/blank-image.svg') }})">
                            </div>
                        </a>
                    <!--end::Photo-->
                    <!--begin::Person-->
                    <div class="mb-0">
                        <!--begin::Name-->
                        <a href="href="{{ route('raffle.show', ['raffle_slug' => $raffle->slug]) }}"" class="text-gray-900 fw-bold text-hover-primary fs-3">{{ $raffle->title }}</a>
                        <!--end::Name-->
                        <!--begin::Position-->
                        <div class="text-muted fs-6 fw-semibold mt-1">{{ $raffle->description }}</div>
                        <a href="#" class="text-gray-900 fw-bold text-hover-primary fs-3">R$ {{ number_format($raffle->quota_price, 2, ',', '.') }}</a>
                        {{-- <img loading="lazy" src="{{ asset('assets/media/products') }}/{{ $raffle->image }}" width="330" height="400" alt="{{ $raffle->title }}" class="pc__img"> --}}
                        <!--begin::Position-->
                    </div>
                    <a class="btn btn-success position-relative me-5 mt-10" href="{{ route('raffle.show', ['raffle_slug' => $raffle->slug]) }}"><i class="bi bi-cart"></i>Comprar</a>
                </div>
                @endforeach
                <!--end::Item-->
            </div>
            <!--end::Wrapper-->
            
            <!--begin::Button-->
            <button class="btn btn-icon btn-active-color-primary" id="kt_team_slider_prev">
                <i class="ki-duotone ki-left fs-2x"></i>
            </button>
            <!--end::Button-->
            <!--begin::Button-->
            <button class="btn btn-icon btn-active-color-primary" id="kt_team_slider_next">
                <i class="ki-duotone ki-right fs-2x"></i>
            </button>
            <!--end::Button-->
        </div>
        <!--end::Slider-->
    </div>
    <!--end::Container-->
</div>
<!--end::Team Section-->
@endsection