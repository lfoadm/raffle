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
                    <h1 class="page-heading d-flex text-gray-900 fw-bold fs-3 flex-column justify-content-center my-0">Editando rifa: {{ $raffle->title }}</h1>
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
                        <li class="breadcrumb-item text-muted">Editando rifa</li>
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
                <!--begin::Form-->
                <form id="kt_ecommerce_add_product_form" class="form d-flex flex-column flex-lg-row" data-kt-redirect="apps/ecommerce/catalog/products.html" action="{{ route('raffles.update', ['raffle'=> $raffle->id]) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    {{-- <input type="hidden" name="id" value="{{ $raffle->id }}" /> --}}
                    <!--begin::Aside column-->
                    <div class="d-flex flex-column gap-7 gap-lg-10 w-100 w-lg-300px mb-7 me-lg-10">
                        <!--begin::Thumbnail settings-->
                        <div class="card card-flush py-4">
                            <!--begin::Card header-->
                            <div class="card-header">
                                <!--begin::Card title-->
                                <div class="card-title">
                                    <h2>Imagem</h2>
                                </div>
                                <!--end::Card title-->
                            </div>
                            <!--end::Card header-->
                            <!--begin::Card body-->
                            <div class="card-body text-center pt-0">
                                <!--begin::Image input-->

                                <style>
                                    .image-input-placeholder { 
                                        background-image: url('{{ asset('assets/media/svg/files/blank-image.svg') }}'); 
                                    }
                                    [data-bs-theme="dark"] .image-input-placeholder { 
                                        background-image: url('{{ asset('assets/media/svg/files/blank-image-dark.svg') }}'); 
                                    }
                                </style>
                                
                                <div class="image-input image-input-outline mb-3" 
                                     data-kt-image-input="true" 
                                     style="background-image: url('{{ $raffle->image ? asset('assets/media/products/' . $raffle->image) : asset('assets/media/svg/files/blank-image.svg') }}')">
                                    <!-- Preview existing avatar -->
                                    <div class="image-input-wrapper w-150px h-150px" 
                                         style="background-image: url('{{ $raffle->image ? asset('assets/media/products/' . $raffle->image) : asset('assets/media/svg/files/blank-image.svg') }}');">
                                    </div>
                                    
                                    <!--begin::Edit button-->
                                    <label class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow" data-kt-image-input-action="change" data-bs-toggle="tooltip" title="Alterar imagem">
                                        <i class="bi bi-pencil-fill fs-7"></i>
                                        <input type="file" name="image" accept="image/*" />
                                        <input type="hidden" name="image_remove" />
                                    </label>
                                    <!--end::Edit button-->
                                    
                                    <!--begin::Cancel button-->
                                    <span class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow" data-kt-image-input-action="cancel" data-bs-toggle="tooltip" title="Cancelar"></span>
                                    <!--end::Cancel button-->
                                    
                                    <!--begin::Remove button-->
                                    <span class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow" data-kt-image-input-action="remove" data-bs-toggle="tooltip" title="Remover"></span>
                                    <!--end::Remove button-->
                                </div>


                                <!--begin::Image input placeholder-->
                                {{-- <style>.image-input-placeholder { background-image: url('assets/media/svg/files/blank-image.svg'); } [data-bs-theme="dark"] .image-input-placeholder { background-image: url('assets/media/svg/files/blank-image-dark.svg'); }</style> --}}
                                <!--end::Image input placeholder-->
                                {{-- <div class="image-input image-input-empty image-input-outline image-input-placeholder mb-3" data-kt-image-input="true">
                                    <!--begin::Preview existing avatar-->
                                    <div class="image-input-wrapper w-150px h-150px"></div>
                                    <!--end::Preview existing avatar-->
                                    <!--begin::Label-->
                                    <label class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow" data-kt-image-input-action="change" data-bs-toggle="tooltip" title="inserir imagem">
                                        <i class="ki-duotone ki-pencil fs-7">
                                            <span class="path1"></span>
                                            <span class="path2"></span>
                                        </i>
                                        <!--begin::Inputs-->
                                        <input type="file" name="image" accept=".png, .jpg, .jpeg" />
                                        <input type="hidden" name="avatar_remove" />
                                        <!--end::Inputs-->
                                    </label>
                                    <!--end::Label-->
                                    <!--begin::Cancel-->
                                    <span class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow" data-kt-image-input-action="cancel" data-bs-toggle="tooltip" title="Cancel avatar">
                                        <i class="ki-duotone ki-cross fs-2">
                                            <span class="path1"></span>
                                            <span class="path2"></span>
                                        </i>
                                    </span>
                                    <!--end::Cancel-->
                                    <!--begin::Remove-->
                                    <span class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow" data-kt-image-input-action="remove" data-bs-toggle="tooltip" title="Remove avatar">
                                        <i class="ki-duotone ki-cross fs-2">
                                            <span class="path1"></span>
                                            <span class="path2"></span>
                                        </i>
                                    </span>
                                    <!--end::Remove-->
                                </div> --}}
                                <!--end::Image input-->
                                <!--begin::Description-->
                                <div class="text-muted fs-7">Defina a imagem do produto. Apenas *.png, *.jpg e *.jpeg Os arquivos de imagem são aceitos</div>
                                <!--end::Description-->
                            </div>
                            <!--end::Card body-->
                        </div>
                        <!--end::Thumbnail settings-->
                        <!--begin::Status-->
                        <div class="card card-flush py-4">
                            <!--begin::Card header-->
                            <div class="card-header">
                                <!--begin::Card title-->
                                <div class="card-title">
                                    <h2>Status</h2>
                                </div>
                                <!--end::Card title-->
                                <!--begin::Card toolbar-->
                                <div class="card-toolbar">
                                    <div class="rounded-circle {{ $raffle->status == 'active' ? 'bg-success' : 'bg-danger' }} w-15px h-15px" id="kt_ecommerce_add_product_status"></div>
                                </div>
                                <!--begin::Card toolbar-->
                            </div>
                            <!--end::Card header-->
                            <!--begin::Card body-->
                            <div class="card-body pt-0">
                                <!--begin::Select2-->
                                <select name="status" class="form-select mb-2" data-control="select2" data-hide-search="true" data-placeholder="Select an option" id="kt_ecommerce_add_product_status_select">
                                    <option></option>
                                    <option value="active" {{ $raffle->status == 'active' ? 'selected' : '' }}>Ativo</option>
                                    <option value="inactive" {{ $raffle->status == 'inactive' ? 'selected' : '' }}>Inativo</option>
                                </select>
                                <!--end::Select2-->
                                <!--begin::Description-->
                                <div class="text-muted fs-7">Defina o status da rifa.</div>
                                <!--end::Description-->
                            </div>
                            <!--end::Card body-->
                        </div>
                        <!--end::Status-->
                        <!--begin::Category & tags-->
                        <div class="card card-flush py-4">
                            <!--begin::Card header-->
                            <div class="card-header">
                                <!--begin::Card title-->
                                <div class="card-title">
                                    <h2>Detalhes</h2>
                                </div>
                                <!--end::Card title-->
                            </div>
                            <!--end::Card header-->
                            <!--begin::Card body-->
                            <div class="card-body pt-0">
                                <!--begin::Input group-->
                                <!--begin::Label-->
                                <label class="form-label">Categoria</label>
                                <!--end::Label-->
                                <!--begin::Select2-->
                                <select class="form-select mb-2" name="category_id" data-control="select2" data-placeholder="Selecione..." data-allow-clear="true">
                                    <option></option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}" 
                                            @if($category->id == $raffle->category_id) selected @endif>
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                </select>
                                <!--end::Select2-->
                                <!--begin::Description-->
                                <div class="text-muted fs-7 mb-7">Adicionar produto a uma categoria.</div>
                                <!--end::Description-->
                                <!--end::Input group-->
                            </div>
                            <!--end::Card body-->
                        </div>
                        <!--end::Category & tags-->
                    </div>
                    <!--end::Aside column-->
                    <!--begin::Main column-->
                    <div class="d-flex flex-column flex-row-fluid gap-7 gap-lg-10">
                        <!--begin:::Tabs-->
                        <ul class="nav nav-custom nav-tabs nav-line-tabs nav-line-tabs-2x border-0 fs-4 fw-semibold mb-n2">
                            <!--begin:::Tab item-->
                            <li class="nav-item">
                                <a class="nav-link text-active-primary pb-4 active" data-bs-toggle="tab" href="#kt_ecommerce_add_product_general">Edição</a>
                            </li>
                            <!--end:::Tab item-->
                        </ul>
                        <!--end:::Tabs-->

                                               
                        <!--begin::Tab content-->
                        <div class="tab-content">
                            <!--begin::Tab pane-->
                            <div class="tab-pane fade show active" id="kt_ecommerce_add_product_general" role="tab-panel">
                                <div class="d-flex flex-column gap-7 gap-lg-10">
                                    <!--begin::General options-->
                                    <div class="card card-flush py-4">
                                        <!--begin::Card body-->
                                        <div class="card-body pt-0">
                                            <!--begin::Input group-->
                                            <div class="mb-10 fv-row">
                                                <!--begin::Label-->
                                                <label class="required form-label">TÍTULO DA RIFA</label>
                                                <!--end::Label-->
                                                <!--begin::Input-->
                                                <input type="text" name="title" class="form-control mb-2" placeholder="Nome da rifa" value="{{ $raffle->title }}" />
                                                <!--end::Input-->
                                                    <!--begin::Label-->
                                                    <label class="required form-label">Slug</label>
                                                    <!--end::Label-->
                                                    <!--begin::Input-->
                                                    <input type="text" name="slug" class="form-control mb-2" placeholder="Slug" value="{{ $raffle->slug }}" />
                                                    <div class="text-muted fs-7">Campo automático.</div>
                                                    <!--end::Input-->
                                                </div>
                                            <!--end::Input group-->
                                            <!--begin::Input group-->
                                            <div>
                                                <!--begin::Label-->
                                                <label class="form-label">Descrição</label>
                                                <!--end::Label-->
                                                <!--begin::Editor-->
                                                {{-- <div id="kt_ecommerce_add_product_description" name="kt_ecommerce_add_product_description" class="min-h-200px mb-2"></div> --}}
                                                <textarea type="text" name="description" class="form-control mb-2" placeholder="Descrição da rifa" value="">{{ $raffle->description }}</textarea>
                                                <!--end::Editor-->
                                                <!--begin::Description-->
                                                <div class="text-muted fs-7">Defina uma descrição para a rifa para melhor visibilidade.</div>
                                                <!--end::Description-->
                                            </div>
                                            <!--end::Input group-->
                                        </div>
                                        <!--end::Card header-->
                                    </div>
                                    <!--end::General options-->
                                    
                                    <!--begin::Pricing-->
                                    <div class="card card-flush py-4">
                                        <!--begin::Card header-->
                                        <div class="card-header">
                                            <div class="card-title">
                                                <h2>Valores</h2>
                                            </div>
                                        </div>
                                        <!--end::Card header-->
                                        <!--begin::Card body-->
                                        <div class="card-body pt-0">
                                            <!--begin::Tax-->
                                            <div class="d-flex flex-wrap gap-5">
                                                <!--begin::Input group-->
                                                <div class="fv-row w-100 flex-md-root">
                                                    <!--begin::Label-->
                                                    <label class="required form-label">Quantidade de cotas</label>
                                                    <!--end::Label-->
                                                    <!--begin::Select2-->
                                                    <input type="number" name="quota_count" id="quota_count" class="form-control" value="{{ old('quota_count', $raffle->quota_count) }}" placeholder="Digite a quantidade de cotas" />
                                                    {{-- <input type="text" name="quota_count" class="form-control mb-2" value="{{ $raffle->quota_count }}" /> --}}
                                                    <!--end::Select2-->
                                                    <!--begin::Description-->
                                                    <div class="text-muted fs-7 mb-10">Defina a quantidade de cotas.</div>
                                                    <!--end::Description-->
                                                </div>
                                                <!--end::Input group-->
                                                <!--begin::Input group-->
                                                <div class="fv-row w-100 flex-md-root">
                                                    <!--begin::Label-->
                                                    <label class="form-label">Valor de cada cota (R$)</label>
                                                    <!--end::Label-->
                                                    <!--begin::Input-->
                                                    {{-- <input type="text" name="quota_price" class="form-control mb-2" value="" placeholder="0,00" id="quota_price" /> --}}
                                                    <input type="text" name="quota_price" id="quota_price" class="form-control" value="{{ old('quota_price', number_format($raffle->quota_price, 2, ',', '.')) }}" placeholder="Digite o preço por cota" />
                                                    
                                                    <!--end::Input-->
                                                </div>
                                                <!--end::Input group-->
                                            </div>
                                            <!--end:Tax-->
                                            <!--begin::Input group-->
                                            <div class="mb-10 fv-row">
                                                
                                                <!--begin::Input-->
                                                
                                                <h2 class="mb-6">Total da RIFA: 
                                                    <span class="fs-4 fw-semibold text-gray-500 me-1 align-self-start">R$</span>
                                                    <span class="fs-2hx fw-bold text-gray-900 me-2 lh-1 ls-n2" id="total_value_display">{{ number_format($raffle->total_value, 2, ',', '.') }}</span>
                                                </h2>
                                                <input type="hidden" name="total_value" id="total_value" value="{{ old('total_value', $raffle->total_value) }}" />
                                                {{-- <input type="text" name="total_value" class="form-control mb-2" placeholder="Valor total da rifa" value="{{ $raffle->total_value }}" /> --}}
                                                <!--end::Input-->
                                                <!--begin::Description-->
                                                <div class="text-muted fs-7">O valor total da rifa é definido de acordo com a quantidade e valor unitário de cotas.</div>
                                                <!--end::Description-->
                                            </div>
                                            <!--end::Input group-->
                                        </div>
                                        <!--end::Card header-->
                                    </div>
                                    <!--end::Pricing-->
                                </div>
                            </div>
                            <!--end::Tab pane-->
                        </div>
                        <!--end::Tab content-->
                        <div class="d-flex justify-content-end">
                            <!--begin::Button-->
                            <a href="{{ route('raffles.index') }}" id="kt_ecommerce_add_product_cancel" class="btn btn-light me-5">Cancelar</a>
                            <!--end::Button-->
                            <!--begin::Button-->
                            <button type="submit" id="kt_ecommerce_add_product_submit" class="btn btn-warning">
                                <span class="indicator-label">Atualizar</span>
                                <span class="indicator-progress">Aguarde... 
                                <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                            </button>
                            <!--end::Button-->
                        </div>
                    </div>
                    <!--end::Main column-->
                </form>
                <!--end::Form-->
            </div>
            <!--end::Content container-->
        </div>
        <!--end::Content-->
    </div>
    <!--end::Content wrapper-->
   @include('includes.footerAdmin')
</div>
<!--end:::Main-->
@endsection
@push('scripts')
<script>
    $(function() {
        $("input[name='title']").on("input", function() {
            $("input[name='slug']").val(StringToSlug($(this).val()));
        });
    });

    function StringToSlug(Text) {
        return Text
            .toLowerCase()
            .normalize("NFD") // Divide caracteres acentuados em base + acento
            .replace(/[\u0300-\u036f]/g, "") // Remove os acentos
            .replace(/[^\w ]+/g, "") // Remove caracteres especiais restantes
            .replace(/ +/g, "-"); // Substitui espaços por hífens
    }

    document.addEventListener('DOMContentLoaded', function() {
        const quotaCountInput = document.getElementById('quota_count');
        const quotaPriceInput = document.getElementById('quota_price');
        const totalValueInput = document.getElementById('total_value');
        const totalValueDisplay = document.getElementById('total_value_display');

        function formatCurrency(value) {
            return value.toLocaleString('pt-BR', {
                style: 'currency',
                currency: 'BRL',
                minimumFractionDigits: 2
            }).replace('R$', '').trim(); // Remove "R$" para exibir no formato desejado
        }

        function updateTotalValue() {
            const quotaCount = parseInt(quotaCountInput.value) || 0;
            const quotaPriceRaw = quotaPriceInput.value.replace(/\./g, '').replace(',', '.');
            const quotaPrice = parseFloat(quotaPriceRaw) || 0;

            const totalValue = quotaCount * quotaPrice;

            // Atualiza o <h2> com o valor formatado
            totalValueDisplay.textContent = formatCurrency(totalValue);

            // Atualiza o input hidden
            totalValueInput.value = totalValue.toFixed(2);
        }

        // Escuta os eventos de input nos campos
        quotaCountInput.addEventListener('input', updateTotalValue);
        quotaPriceInput.addEventListener('input', updateTotalValue);
    });
    

   

    document.getElementById('quota_price').addEventListener('input', function (e) {
        let value = e.target.value;

        // Remove todos os caracteres não numéricos
        value = value.replace(/[^\d]/g, '');

        // Remove zeros à esquerda (exceto no caso de "0,00")
        value = value.replace(/^0+(?!$)/, '');

        // Caso tenha mais de 2 dígitos, adiciona a vírgula antes dos dois últimos dígitos
        if (value.length > 2) {
            value = value.slice(0, -2) + ',' + value.slice(-2);
        } else if (value.length === 2) {
            value = '0,' + value; // Dois dígitos -> 0,xx
        } else if (value.length === 1) {
            value = '0,0' + value; // Um dígito -> 0,0x
        }

        // Adiciona o separador de milhar (ponto)
        const parts = value.split(',');
        parts[0] = parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, '.');
        value = parts.join(',');

        e.target.value = value;
    });
</script>
@endpush
