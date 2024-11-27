<?php

namespace App\Http\Controllers\All;

use App\Http\Controllers\Controller;
use App\Models\All\Cart;
use App\Models\All\Order as AllOrder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use MercadoPago\SDK;
use MercadoPago\Preference;
use MercadoPago\Payment;
use MercadoPago\Item;
use App\Models\All\Order;
use App\Models\All\RaffleQuota;
use App\Services\OrderService;
use Illuminate\Support\Facades\Http;
use MercadoPago\Resources\MerchantOrder\Item as MerchantOrderItem;
use MercadoPago\Resources\Preference as ResourcesPreference;
use MercadoPago\Client\Payment\PaymentClient;
use MercadoPago\Client\Common\RequestOptions;
use MercadoPago\Client\Preference\PreferenceClient;
use MercadoPago\MercadoPagoConfig;

class CheckoutController extends Controller
{
    protected $orderService;

    public function __construct(OrderService $orderService)
    {
        $this->orderService = $orderService;
    }

    public function finalizePurchase(Request $request)
    {
        $userId = Auth::id();
        
        // Busca o carrinho do usuário
        $cart = Cart::with('items.raffleQuota.raffle')->where('user_id', $userId)->first();
        //dd($cart);
        
        if (!$cart || $cart->items->isEmpty()) {
            return redirect()->route('cart.show')->withErrors('Seu carrinho está vazio.');
        }
        
        // Cria o pedido
        try {
            $order = $this->orderService->createOrderFromCart($cart);
            
            // Remove o carrinho e seus itens
            $cart->items()->delete();
            $cart->delete();

            return redirect()->route('checkout.payment', ['orderId' => $order->id]);
        } catch (\Exception $e) {
            return redirect()->route('cart.show')->withErrors('Erro ao processar o pedido: ' . $e->getMessage());
        }
    }
    

    

public function showPaymentPage($orderId)
{
    // Busca o pedido com itens e usuário associados
    $order = Order::with(['items.raffle', 'user'])->findOrFail($orderId);

    if ($order->items->isEmpty()) {
        return redirect()->route('cart.index')->withErrors('O pedido não possui itens.');
    }

    // Configura os itens de pagamento
    $items = $order->items->map(function ($item) {
        return [
            'title' => 'Rifa: ' . $item->raffle->title,
            'quantity' => $item->quota_amount,
            'unit_price' => (float)$item->unit_price,
            'currency_id' => 'BRL', // Define a moeda
        ];
    })->toArray();

    // Configura os dados do comprador
    $payer = [
        'name' => $order->user->name,
        'email' => $order->user->email,
    ];

    // Configura as URLs de retorno e notificação
    $backUrls = [
        'success' => route('checkout.success', ['orderId' => $orderId]),
        'failure' => route('checkout.failure', ['orderId' => $orderId]),
        'pending' => route('checkout.pending', ['orderId' => $orderId]),
    ];

    // Monta o payload para a criação do pagamento via PIX
    $payload = [
        'items' => $items,
        'payer' => $payer,
        'back_urls' => $backUrls,
        'notification_url' => route('webhook.mercadopago'),
        'external_reference' => (string)$order->id,
        'payment_methods' => [
            'excluded_payment_types' => [
                ['id' => 'credit_card'], // Apenas PIX será usado
            ],
            'installments' => 1,
        ],
    ];

    // Chamada à API do Mercado Pago
    $response = Http::withToken(config('services.mercadopago.access_token'))
        ->post('https://api.mercadopago.com/checkout/preferences', $payload);

    // Verifica se a resposta foi bem-sucedida
    if (!$response->successful()) {
        return redirect()->route('cart.index')->withErrors('Erro ao criar a preferência de pagamento.');
    }

    // Obtemos o ID da preferência e o link do QR Code
    $preference = $response->json();
    $preferenceId = $preference['id'] ?? null;
    $initPoint = $preference['init_point'] ?? null;

    if (!$preferenceId || !$initPoint) {
        return redirect()->route('cart.index')->withErrors('Erro ao processar o pagamento.');
    }

    // Retorna a página de pagamento com os dados da preferência
    return view('checkout.payment', [
        'order' => $order,
        'preferenceId' => $preferenceId,
        'initPoint' => $initPoint,
        'qrCode' => $preference['point_of_interaction']['transaction_data']['qr_code'] ?? null,
    ]);
}


    public function webhook(Request $request)
    {
        $data = $request->all();

        if (!isset($data['id'])) {
            return response()->json(['error' => 'ID não enviado'], 400);
        }

        // Consulta o pagamento no Mercado Pago
        $paymentId = $data['id'];
        $response = \MercadoPago\Payment::find_by_id($paymentId);

        if (!$response) {
            return response()->json(['error' => 'Pagamento não encontrado'], 404);
        }

        // Encontra o pedido com base no campo external_reference
        $order = Order::where('id', $response->external_reference)->with('items')->firstOrFail();

        // Atualiza o status do pedido
        if ($response->status == 'approved') {
            $order->update(['status' => 'paid']);
        } elseif (in_array($response->status, ['rejected', 'cancelled', 'expired'])) {
            // Atualiza o status do pedido para cancelado
            $order->update(['status' => 'cancelled']);

            // Libera as cotas associadas
            foreach ($order->items as $item) {
                RaffleQuota::whereIn('id', $item->raffle_quotas->pluck('id'))->update(['status' => 'available']);
            }
        }

        return response()->json(['status' => 'Webhook processado com sucesso.']);
    }   

}
