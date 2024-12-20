<!DOCTYPE html>
<html lang="pt-BR">
	<!--begin::Head-->
	<head>
		<title>Raffle</title>
		<meta charset="utf-8" />
		<meta name="description" content="Participe de rifas eletrônicas e ajude a transformar vidas! No nosso site, você pode adquirir e compartilhar rifas com seus amigos para apoiar causas importantes e pessoas que precisam, tudo de forma rápida e segura, mesmo à distância. Junte-se a uma comunidade solidária e concorra a prêmios enquanto faz o bem." />
		<meta name="keywords" content="Rifa eletrônica, Solidariedade online, Ajudar pessoas, Rifa digital, Doação online, Compartilhar rifas, Caridade à distância, Causas solidárias, Rifa beneficente, Prêmios solidários, Apoio a causas, Sorteios online, Solidariedade virtual, Contribuição social, Rifa compartilhada, Comunidade solidária, Apoiar de longe, Engajamento social, Doação segura, Prêmios beneficentes" />
		<meta name="viewport" content="width=device-width, initial-scale=1" />
		<meta property="og:locale" content="pt-BR" />
		<meta property="og:type" content="website" />
		<meta property="og:title" content="Raffle - Transformando solidariedade em prêmios" />
		<meta property="og:url" content="http://127.0.0.1:8000" />
		<meta property="og:site_name" content="Raffles online" />
		<link rel="canonical" href="http://127.0.0.1:8000/account-dashboard" />
		<link rel="shortcut icon" href="{{ asset('assets/media/logos/fav.ico') }}" />
		<!--begin::Fonts(mandatory for all pages)-->
		<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Inter:300,400,500,600,700" />
		<!--end::Fonts-->
		<!--begin::Global Stylesheets Bundle(mandatory for all pages)-->
		<link href="{{ asset('assets/plugins/global/plugins.bundle.css') }}" rel="stylesheet" type="text/css" />
		<link href="{{ asset('assets/css/style.bundle.css') }}" rel="stylesheet" type="text/css" />
		@stack("styles")
		<!--end::Global Stylesheets Bundle-->
		<script>// Frame-busting to prevent site from being loaded within a frame without permission (click-jacking) if (window.top != window.self) { window.top.location.replace(window.self.location.href); }</script>
	</head>
	<style>
		.btn-warning {
			background-color: #F58634 !important;
			
		}
	</style>
	<body id="kt_body" data-bs-spy="scroll" data-bs-target="#kt_landing_menu" class="bg-body position-relative app-blank">
		<!--begin::Theme mode setup on page load-->
		<script>
			var defaultThemeMode = "light"; var themeMode; if ( document.documentElement ) { if ( document.documentElement.hasAttribute("data-bs-theme-mode")) { themeMode = document.documentElement.getAttribute("data-bs-theme-mode"); } else { if ( localStorage.getItem("data-bs-theme") !== null ) { themeMode = localStorage.getItem("data-bs-theme"); } else { themeMode = defaultThemeMode; } } if (themeMode === "system") { themeMode = window.matchMedia("(prefers-color-scheme: dark)").matches ? "dark" : "light"; } document.documentElement.setAttribute("data-bs-theme", themeMode); }
		</script>
		<!--end::Theme mode setup on page load-->
		<!--begin::Root-->
		<div class="d-flex flex-column flex-root" id="kt_app_root">
			<!--begin::Header Section-->
			<div class="mb-0" id="home">
				<!--begin::Wrapper-->
				<div class="bgi-no-repeat bgi-size-contain bgi-position-x-center bgi-position-y-bottom landing-dark-bg" style="background-image: url(assets/media/svg/illustrations/landing.svg)">
					<!--begin::Header-->
					<div class="landing-header" data-kt-sticky="true" data-kt-sticky-name="landing-header" data-kt-sticky-offset="{default: '200px', lg: '300px'}">
						<!--begin::Container-->
						<div class="container">
							<!--begin::Wrapper-->
							<div class="d-flex align-items-center justify-content-between">
								<!--begin::Logo-->
								<div class="d-flex align-items-center flex-equal">
									<!--begin::Mobile menu toggle-->
									<button class="btn btn-icon btn-active-color-primary me-3 d-flex d-lg-none" id="kt_landing_menu_toggle">
										<i class="ki-duotone ki-abstract-14 fs-2hx">
											<span class="path1"></span>
											<span class="path2"></span>
										</i>
									</button>
									<!--end::Mobile menu toggle-->
									<!--begin::Logo image-->
									<a href="{{ route('home') }}">
										<img alt="Logo" src="{{ asset('assets/media/logos/logo-raffle.png') }}" class="logo-default h-25px h-lg-30px" />
										<img alt="Logo" src="{{ asset('assets/media/logos/logo-raffle-dark.png') }}" class="logo-sticky h-20px h-lg-25px" />
									</a>
									<!--end::Logo image-->
								</div>
								<!--end::Logo-->
								<!--begin::Menu wrapper-->
								<div class="d-lg-block" id="kt_header_nav_wrapper">
									<div class="d-lg-block p-5 p-lg-0" data-kt-drawer="true" data-kt-drawer-name="landing-menu" data-kt-drawer-activate="{default: true, lg: false}" data-kt-drawer-overlay="true" data-kt-drawer-width="200px" data-kt-drawer-direction="start" data-kt-drawer-toggle="#kt_landing_menu_toggle" data-kt-swapper="true" data-kt-swapper-mode="prepend" data-kt-swapper-parent="{default: '#kt_body', lg: '#kt_header_nav_wrapper'}">
										<!--begin::Menu-->
										<div class="menu menu-column flex-nowrap menu-rounded menu-lg-row menu-title-gray-600 menu-state-title-primary nav nav-flush fs-5 fw-semibold" id="kt_landing_menu">

											<div class="menu-item">
												<a class="menu-link nav-link active py-3 px-4 px-xxl-6" href="{{ route('home') }}" data-kt-scroll-toggle="true" data-kt-drawer-dismiss="true">Início</a>
											</div>
											
											<div class="menu-item">
												<a class="menu-link nav-link py-3 px-4 px-xxl-6" href="{{ route('home.raffles') }}" data-kt-scroll-toggle="true" data-kt-drawer-dismiss="true">Todas as rifas</a>
											</div>

											@guest
											@else
												<div class="menu-item">
													<a class="menu-link nav-link py-3 px-4 px-xxl-6" href="{{ route('dashboard') }}" data-kt-scroll-toggle="true" data-kt-drawer-dismiss="true">Painel</a>
												</div> 
											@endguest

											
											{{-- <div class="menu-item">
												<a class="menu-link nav-link py-3 px-4 px-xxl-6" href="#portfolio" data-kt-scroll-toggle="true" data-kt-drawer-dismiss="true">Portfolio</a>
											</div>
											
											<div class="menu-item">
												<a class="menu-link nav-link py-3 px-4 px-xxl-6" href="#pricing" data-kt-scroll-toggle="true" data-kt-drawer-dismiss="true">Pricing</a>
											</div>
                                            --}}
										</div>
										<!--end::Menu-->
									</div>
								</div>

								@guest
									<div class="flex-equal text-end ms-1">
										<a href="{{ route('login') }}" class="btn btn-warning">Minha conta</a>
									</div>
                                @else
								
								

								@if(Auth::user()->cart)
								<div class="flex-equal text-end ms-1">
									<a class="btn btn-info" href="{{ route('cart.show') }}" data-kt-scroll-toggle="true" data-kt-drawer-dismiss="true">
										<span class="ms-2">Carrinho</span>
										<div class="position-relative d-inline-block">
											<i class="ki-duotone ki-handcart fs-2" style="font-size: 3.5rem;"></i>
											@if(Auth::user()->cart && Auth::user()->cart->items->count() > 0)
												<span class="badge badge-success position-absolute top-0 start-100 translate-middle">
													{{ Auth::user()->cart->items->count() }}
												</span>
											@endif
										</div>
									</a>
								</div>
								@else
									<div class="flex-equal text-end ms-1">
										<button class="btn btn-secondary" href="#">
											<span class="ms-2">Carrinho vazio</span>
											<div class="position-relative d-inline-block">
												<i class="ki-duotone ki-handcart fs-2" style="font-size: 3.5rem;"></i>
											</div>
										</button>
									</div>
								@endif
                                @endguest
								<!--end::Toolbar-->
							</div>
							<!--end::Wrapper-->
						</div>
						<!--end::Container-->
					</div>
					<!--end::Header-->
					
				</div>
				<!--end::Wrapper-->
				<!--begin::Curve bottom-->
				<div class="landing-curve landing-dark-color mb-10 mb-lg-20">
					<svg viewBox="15 12 1470 48" fill="none" xmlns="http://www.w3.org/2000/svg">
						<path d="M0 11C3.93573 11.3356 7.85984 11.6689 11.7725 12H1488.16C1492.1 11.6689 1496.04 11.3356 1500 11V12H1488.16C913.668 60.3476 586.282 60.6117 11.7725 12H0V11Z" fill="currentColor"></path>
					</svg>
				</div>
				<!--end::Curve bottom-->
			</div>
			<!--end::Header Section-->

            @yield('content')
			@include('includes.footerApp')
			
		</div>
		
		<!--end::Root-->
		<!--begin::Scrolltop-->
		<div id="kt_scrolltop" class="scrolltop" data-kt-scrolltop="true">
			<i class="ki-duotone ki-arrow-up">
				<span class="path1"></span>
				<span class="path2"></span>
			</i>
		</div>
		<!--end::Scrolltop-->
		<!--begin::Javascript-->
		<script>var hostUrl = "assets/";</script>
		<!--begin::Global Javascript Bundle(mandatory for all pages)-->
		<script src="assets/plugins/global/plugins.bundle.js"></script>
		<script src="assets/js/scripts.bundle.js"></script>
		<!--end::Global Javascript Bundle-->
		<!--begin::Vendors Javascript(used for this page only)-->
		<script src="assets/plugins/custom/fslightbox/fslightbox.bundle.js"></script>
		<script src="assets/plugins/custom/typedjs/typedjs.bundle.js"></script>
		<!--end::Vendors Javascript-->
		<!--begin::Custom Javascript(used for this page only)-->
		<script src="assets/js/custom/landing.js"></script>
		<script src="assets/js/custom/pages/pricing/general.js"></script>
		<!--end::Custom Javascript-->
		@stack("scripts")
		<!--end::Javascript-->
	</body>
	<!--end::Body-->
</html>