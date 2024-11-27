<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;
use App\Models\All\Order;
use App\Models\All\OrderItem;
use App\Models\All\RaffleQuota;
use Illuminate\Support\Facades\Log;

class OrderService
{
    public function createOrderFromCart($cart)
    {
        DB::beginTransaction();
    
        try {
            // Criação da ordem principal
            $order = Order::create([
                'user_id' => $cart->user_id,
                'status' => 'pending',
                'total_amount' => $cart->items->sum(function ($item) {
                    return $item->unit_price;
                }),
            ]);
    
            // Agrupa os itens do carrinho por rifa
            $groupedItems = $cart->items->groupBy('raffle_id');
    
            // Processa cada grupo de itens
            foreach ($groupedItems as $raffleId => $items) {
    
                // Verifica se existem itens no grupo
                if ($items->isEmpty()) {
                    throw new \Exception("Nenhum item encontrado para raffle_id: {$raffleId}");
                }
    
                // Itera pelos itens da rifa e cria um registro de OrderItem para cada um
                foreach ($items as $item) {
                    $orderItem = OrderItem::create([
                        'order_id' => $order->id,
                        'raffle_id' => $raffleId,
                        'raffle_quota_id' => $item->raffle_quota_id, // ID único da cota
                        'quota_amount' => 1, // Sempre 1, porque cada item no carrinho representa uma cota única
                        'unit_price' => $item->unit_price, // Preço do item
                        'total_price' => $item->unit_price, // Igual ao preço unitário porque quota_amount é 1
                    ]);
    
                    // Atualiza o status da cota para 'sold'
                    RaffleQuota::where('id', $item->raffle_quota_id)
                        ->update(['status' => 'sold']);
                }
            }
    
            DB::commit();
            return $order;
    
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e; // Lança a exceção para tratamento posterior
        }
    }
    


    // public function createOrderFromCart($cart)
    // {
    //     DB::beginTransaction();

    //     try {
    //         // Cria o pedido principal
    //         $order = Order::create([
    //             'user_id' => $cart->user_id,
    //             'status' => 'pending',
    //             'total_amount' => $cart->items->sum(function ($item) {
    //                 return $item->unit_price;
    //             }),
    //         ]);
            
    //         // Agrupa os itens do carrinho por rifa
    //         $groupedItems = $cart->items->groupBy('raffle_id');

            
    //         foreach ($groupedItems as $raffleId => $items) {
                

    //             // Cria os itens do pedido para cada rifa
    //             OrderItem::create([
    //                 'order_id' => $order->id,
    //                 'raffle_id' => $raffleId, // O ID da rifa vem da chave do grupo
    //                 'raffle_quota_id' => $items->pluck('raffle_quota_id')->toArray(), // IDs das cotas agrupadas
    //                 'quota_amount' => $items->count(), // Quantidade de cotas
    //                 'unit_price' => $items->first()->unit_price, // Preço unitário
    //                 'total_price' => $items->sum('unit_price'), // Preço total do grupo
    //             ]);

    //             // Atualiza o status das cotas para 'sold'
    //             RaffleQuota::whereIn('id', $items->pluck('raffle_quota_id'))
    //                 ->update(['status' => 'sold']);
    //         }

    //         DB::commit();
    //         return $order;

    //     } catch (\Exception $e) {
    //         DB::rollBack();
    //         Log::error('Erro ao criar pedido:', ['error' => $e->getMessage()]);
    //         throw $e; // Lança a exceção para tratamento posterior
    //     }
    // }


    // public function createOrderFromCart($cart)
    // {
    //     return DB::transaction(function () use ($cart) {
    //         // Cria o pedido
    //         dd("chegou no servico");

    //         $order = Order::create([
    //             'user_id' => $cart->user_id,
    //             'total_amount' => $cart->items->sum('total_price'),
    //             'status' => 'pending', // Pedido inicialmente pendente
    //         ]);

    //         // Cria os itens do pedido
    //         foreach ($cart->items as $item) {
    //             OrderItem::create([
    //                 
    //             ]);

    //             // Atualiza o status da cota para "sold"
    //             $quota = RaffleQuota::find($item->raffle_quota_id);
    //             $quota->update(['status' => 'sold']);
    //         }

    //         return $order;
    //     });
    // }
}


