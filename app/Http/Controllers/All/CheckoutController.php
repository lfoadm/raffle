<?php

namespace App\Http\Controllers\All;

use App\Http\Controllers\Controller;
use App\Models\All\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\All\Order;
use App\Models\All\RaffleQuota;
use App\Services\OrderService;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

use MercadoPago\Client\Common\RequestOptions;
use MercadoPago\Client\Payment\PaymentClient;
use MercadoPago\Exceptions\MPApiException;
use MercadoPago\MercadoPagoConfig;



class CheckoutController extends Controller
{
    public function showPaymentPage($orderId)
    {
        // Busca o pedido com itens e usuário associados
        $order = Order::with(['items.raffle', 'user'])->findOrFail($orderId);

        if ($order->items->isEmpty()) {
            return redirect()->route('cart.index')->withErrors('O pedido não possui itens.');
        }

        $items = $order->items->map(function ($item) {
            return [
                'id' => $item->raffle->id,
                'title' => 'Rifa: ' . $item->raffle->title,
                'description' => 'Rifa: ' . $item->raffle->description,
                'category_id' => 'Categoria: ' . $item->raffle->category_id,
                'quantity' => $item->quota_amount,
                'unit_price' => (float)$item->unit_price,
            ];
        })->toArray();

        // Calcula o valor total da transação
        $transactionAmount = array_reduce($items, function ($carry, $item) {
            return $carry + ($item['unit_price'] * $item['quantity']); // Multiplica pelo `quantity`, se necessário
        }, 0);

        // Configura os dados do comprador
        $payer = [
            'first_name' => $order->user->name,
            'email' => $order->user->email,
        ];

        // Gerar uma Idempotency Key única
        $idempotencyKey = uniqid('pix_', true);

        // Dados do pagamento
        $paymentData = [

            "transaction_amount" => $transactionAmount, // Valor da transação
            "description" => "Pagamento via Pix - Compra Rifa",
            "payment_method_id" => "pix", // Especificar Pix
            "payer" => $payer,
        ];

        // Chamada à API do Mercado Pago com Idempotency Key
        $response = Http::withToken(config('services.mercadopago.access_token'))->withHeaders([
                'X-Idempotency-Key' => $idempotencyKey, // Incluindo o cabeçalho
            ])->post('https://api.mercadopago.com/v1/payments', $paymentData);

        if ($response->successful()) {
            $responseData = $response->json();
            // $qr = $responseData['point_of_interaction']['transaction_data']['qr_code_base64'];
            // echo '<img src="data:image/png;base64, '.$qr.'" />';
            
            // Retornar a view com os dados do QR Code
            return view('pages.checkout.payment', [
                'qr_code' => $responseData['point_of_interaction']['transaction_data']['qr_code'],
                'qr_code_base64' => $responseData['point_of_interaction']['transaction_data']['qr_code_base64'],
                'expiration_time' => $responseData['date_of_expiration'],
                'transaction_id' => $responseData['id'],
                'transaction_amount' => $responseData['transaction_amount'],
                'order' => $order,
            ]);
        } else {
            // Log do erro e retorno para o usuário
            Log::error('Erro ao criar pagamento Pix', $response->json());
            return back()->withErrors(['error' => 'Erro ao processar o pagamento.']);
        }
    }

    /**
     * Manipula notificações (webhook) do Mercado Pago.
     */
    public function webhookHandler(Request $request)
    {
        Log::info('Webhook recebido:', $request->all());

        // Aqui você deve validar e processar o evento enviado pelo Mercado Pago
        // Consulte a documentação para verificar o tipo de evento e atualizar o status do pagamento.
        return response()->json(['status' => 'received'], 200);
    }
    
}