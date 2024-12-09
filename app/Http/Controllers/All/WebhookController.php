<?php

namespace App\Http\Controllers\All;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Models\All\Order;
use Illuminate\Support\Facades\Http;

class WebhookController extends Controller
{
    public function handleNotification(Request $request)
    {
        $data = $request->all();
        dd($data);
        Log::info('Notificação recebida', $data);

        if (!isset($data['data']['id'])) {
            return response()->json(['error' => 'Dados inválidos'], 400);
        }

        $paymentId = $data['data']['id'];

        // Consultar detalhes do pagamento na API do Mercado Pago
        $response = Http::withToken(config('services.mercadopago.access_token'))->get("https://api.mercadopago.com/v1/payments/{$paymentId}");

        dd($response->json());

        if ($response->successful()) {
            $paymentData = $response->json();
            $status = $paymentData['status'];

            // Atualizar status do pedido
            $order = Order::where('transaction_id', $paymentId)->first();

            if ($order) {
                if ($status === 'approved') {
                    $order->update(['status' => 'paid']);
                    $this->finalizeOrder($order); // Finaliza o pedido
                } elseif ($status === 'rejected') {
                    $order->update(['status' => 'rejected']);
                } elseif ($status === 'pending') {
                    $order->update(['status' => 'pending']);
                }
            }

            return response()->json(['success' => true], 200);
        }

        return response()->json(['error' => 'Erro ao buscar pagamento'], 500);
    }

    private function finalizeOrder($order)
    {
        // Lógica de finalização do pedido
        // Exemplo: enviar e-mail de confirmação, liberar rifas, etc.
        Log::info('Pedido finalizado com sucesso', ['order_id' => $order->id]);
    }
}
