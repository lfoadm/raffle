@extends('layouts.app')

@section('content')
<div class="container py-5">
    <h1 class="mb-4">Pagamento via PIX</h1>

    <!-- Resumo do Pedido -->
<div class="card mb-4">
    <div class="card-header">
        <h4>Resumo do Pedido</h4>
    </div>
    <div class="card-body">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Rifa</th>
                    <th>Cotas</th>
                    <th>Números das Cotas</th>
                    {{-- <th>Valor Unitário</th>
                    <th>Total</th> --}}
                </tr>
            </thead>
            <tbody>
                @php
                    // Agrupa os itens por rifa
                    $groupedItems = $order->items->groupBy('raffle_id');
                @endphp

                @foreach($groupedItems as $raffleId => $items)
                    @php
                        $raffleTitle = $items->first()->raffle->title;
                        $raffleQuotas = $items->pluck('raffleQuota')->flatten();
                        $quotaNumbers = $raffleQuotas->pluck('quota_number')->toArray();
                        $totalUnitPrice = $items->sum('unit_price');
                        $totalQuotaCount = $raffleQuotas->count();
                        $totalPrice = $items->reduce(function ($carry, $item) {
                            return $carry + ($item->unit_price * $item->raffleQuota->count());
                        }, 0);
                        
                    @endphp
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $raffleTitle }}</td>
                        <td>{{ $totalQuotaCount }}</td>
                        <td>{{ implode(', ', $quotaNumbers) }}</td>
                        {{-- <td>R$ {{ number_format($totalUnitPrice, 2, ',', '.') }}</td>
                        <td>R$ {{ number_format($totalPrice, 2, ',', '.') }}</td> --}}
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>


    <!-- Instruções e QR Code do PIX -->
    <div class="card text-center">
        <div class="card-header mt-6">
            <h3>Pagamento com PIX: </h3>
            <h1>Valor da transação: R$ {{ number_format($transaction_amount, 2, ',', '.')  }}</h1>
        </div>
        <div class="card-body text-center">
            <p class="text-success">Use o QR Code abaixo ou copie o código PIX para realizar o pagamento:</p>
            <!-- QR Code do PIX -->
            <div class="mb-4">
                <img src="data:image/png;base64,{{ $qr_code_base64 }}" style="max-width: 200px; border: 1px solid #ddd; padding: 10px;">
            </div>
            <p><strong>Código PIX:</strong></p>
            <div class="alert alert-info" id="qrCode" style="cursor: pointer;" onclick="copyToClipboard()" title="Clique para copiar">
                {{ $qr_code }}
            </div>

            {{-- <p>Status do pagamento: {{ $payment->status }}</p> --}}
            {{-- <p>Cliente: {{ $payment->description }}</p> --}}
            

            <p class="text-muted">Após realizar o pagamento, a confirmação será processada automaticamente. Caso tenha dúvidas, entre em contato com o suporte.</p>
        </div>
    </div>
</div>
@endsection
@push('scripts')
<script>
    function copyToClipboard() {
        // Seleciona o elemento pelo ID
        const qrCodeElement = document.getElementById('qrCode');
        
        // Cria um elemento de texto temporário para facilitar a cópia
        const tempInput = document.createElement('textarea');
        tempInput.value = qrCodeElement.textContent; // Pega o conteúdo do div
        document.body.appendChild(tempInput);
        
        // Seleciona o texto e copia para a área de transferência
        tempInput.select();
        tempInput.setSelectionRange(0, 99999); // Para dispositivos móveis
        document.execCommand('copy');
        
        // Remove o elemento temporário
        document.body.removeChild(tempInput);

        // Exibe uma mensagem opcional (pode usar um toast ou alert personalizado)
        alert('Conteúdo copiado para a área de transferência!');
    }
</script>
@endpush
