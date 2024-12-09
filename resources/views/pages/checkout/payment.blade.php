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

            <!-- Contador regressivo -->
            <div class="countdown">
                Tempo restante para pagar: <h1 id="countdown-timer"></h1>
            </div>
            
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

    // Obtenha a data de expiração do QR Code
    const expirationTime = new Date("{{ $expiration_time }}");
        
    // Função para atualizar o contador
    function updateCountdown() {
        const now = new Date();
        const timeRemaining = expirationTime - now;

        if (timeRemaining > 0) {
            const minutes = Math.floor((timeRemaining % (1000 * 10 * 60)) / (1000 * 60));
            const seconds = Math.floor((timeRemaining % (1000 * 60)) / 1000);

            // Atualiza o texto do contador
            document.getElementById("countdown-timer").textContent = 
                `${minutes.toString().padStart(2, '0')}:${seconds.toString().padStart(2, '0')}`;
        } else {
            // Quando o tempo acabar
            document.getElementById("countdown-timer").textContent = "Expirado!";
            alert("O tempo para pagamento expirou. Por favor, gere um novo QR Code.");
            clearInterval(countdownInterval); // Para o intervalo
        }
    }

    // Atualiza o contador a cada 1 segundo
    const countdownInterval = setInterval(updateCountdown, 1000);

    // Chamada inicial para exibir imediatamente
    updateCountdown();
</script>
@endpush
