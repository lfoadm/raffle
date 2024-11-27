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
                        <th>Valor Unitário</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($cart->items as $key => $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $item->raffle->title }}</td>
                            <td>{{ count($item->raffleQuota) }}</td>
                            <td>
                                {{ implode(', ', $item->raffleQuota->pluck('quota_number')->toArray()) }}
                            </td>
                            <td>R$ {{ number_format($item->unit_price, 2, ',', '.') }}</td>
                            <td>R$ {{ number_format($item->unit_price * count($item->raffleQuota), 2, ',', '.') }}</td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="5" class="text-end"><strong>Total Geral:</strong></td>
                        <td><strong>R$ {{ number_format($cart->total, 2, ',', '.') }}</strong></td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>

    <!-- Instruções e QR Code do PIX -->
    <div class="card">
        <div class="card-header">
            <h4>Pagamento com PIX</h4>
        </div>
        <div class="card-body text-center">
            <p class="text-success">Use o QR Code abaixo ou copie o código PIX para realizar o pagamento:</p>
            <!-- QR Code do PIX -->
            <div class="mb-4">
                <img src="{{ $pixQRCode }}" alt="QR Code para pagamento" style="max-width: 200px; border: 1px solid #ddd; padding: 10px;">
            </div>
            <p><strong>Código PIX:</strong></p>
            <div class="alert alert-secondary">
                {{ $pixCode }}
            </div>

            <p class="text-muted">Após realizar o pagamento, a confirmação será processada automaticamente. Caso tenha dúvidas, entre em contato com o suporte.</p>
        </div>
    </div>
</div>
@endsection
