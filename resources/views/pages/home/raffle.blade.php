@extends('layouts.app')
@section('content')
<!--begin::Team Section-->
<div class="py-10 py-lg-20">
    <!--begin::Container-->
    <div class="container">
        
        @include('components.alert')
        <ul>
            <li>NOME: {{ $raffle->title  }}</li>
            <li>CODIGO: {{ $raffle->id  }}</li>
            <li>DESCRICAO: {{ $raffle->description  }}</li>
            <li>VENDEDOR: {{ $raffle->user->name  }}</li>
        </ul>

        <hr>

        <div class="container">
            <h1>{{ $raffle->title }}</h1>
            <p>{{ $raffle->description }}</p>
        
            <div class="mt-4">
                <h4>Escolha suas cotas:</h4>
                <form action="{{ route('cart.add', $raffle->id) }}" method="POST" id="quotaForm">
                    @csrf
                    <div class="row">
                        @foreach($raffle->quotas as $quota)
                            <div class="col-2 mb-2">
                                <button type="button" 
                                        class="btn btn-block 
                                            {{ $quota->status === 'available' ? 'btn-success' : ($quota->status === 'reserved' ? 'btn-warning' : 'btn-secondary') }}
                                            quota-btn"
                                        data-id="{{ $quota->id }}"
                                        {{ $quota->status !== 'available' ? 'disabled' : '' }}>
                                    {{ $quota->quota_number }}
                                </button>
                            </div>
                        @endforeach
                    </div>
        
                    <input type="hidden" name="selected_quotas[]" id="selectedQuotas">
                    <button type="submit" class="btn btn-primary mt-3">Adicionar ao Carrinho</button>
                    <a href="{{ route('cart.show') }}" class="btn btn-info mt-3"><i class="ki-duotone ki-handcart fs-2"></i>Ver Carrinho</a>
                </form>
            </div>
        </div>

        <br><hr>

        <h1>RIFAS DA MESMA CATEGORIA</h1>
        @if($rraffles)
            @foreach($rraffles as $item)
            <ul>
                <li>NOME: {{ $item->title  }}</li>
                <li>CODIGO: {{ $item->id  }}</li>
                <li>DESCRICAO: {{ $item->description  }}</li>
                <li>VENDEDOR: {{ $item->user->name  }}</li>
            </ul>
            @endforeach
        @endif
    </div>
    
</div>

@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const selectedQuotas = [];
        const quotaButtons = document.querySelectorAll('.quota-btn');

        quotaButtons.forEach(button => {
            button.addEventListener('click', function () {
                const quotaId = this.getAttribute('data-id');

                if (this.classList.contains('btn-info')) {
                    // Remover do selecionado
                    this.classList.remove('btn-info');
                    this.classList.add('btn-success');
                    const index = selectedQuotas.indexOf(quotaId);
                    if (index !== -1) {
                        selectedQuotas.splice(index, 1);
                    }
                } else {
                    // Adicionar ao selecionado
                    this.classList.remove('btn-success');
                    this.classList.add('btn-info');
                    selectedQuotas.push(quotaId);
                }

                // Atualizar o input oculto
                document.getElementById('selectedQuotas').value = JSON.stringify(selectedQuotas);
            });
        });
    });
</script>
@endpush