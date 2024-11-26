<?php

namespace App\Http\Controllers\All;

use App\Http\Controllers\Controller;
use App\Models\All\Cart;
use App\Models\All\CartItem;
use App\Models\All\Raffle;
use App\Models\All\RaffleQuota;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CartController extends Controller
{
    public function add(Request $request, $raffleId)
    {
        // Decodificar o JSON no campo 'selected_quotas'
        $selectedQuotas = json_decode($request->input('selected_quotas')[0], true);

        // Verificar se a decodificação funcionou
        if (json_last_error() !== JSON_ERROR_NONE) {
            return back()->withErrors(['selected_quotas' => 'Erro ao processar as cotas selecionadas.']);
        }

        // Substituir o campo original para validação
        $request->merge(['selected_quotas' => $selectedQuotas]);

        // Validar os dados
        $request->validate([
            'selected_quotas' => 'required|array|min:1', // Garante que cotas foram enviadas
            'selected_quotas.*' => 'integer|exists:raffle_quotas,id', // Garante que as cotas existem no banco
        ]);

        // Identifica o usuário logado
        $userId = Auth::id();

        // Busca ou cria um carrinho para o usuário
        $cart = Cart::firstOrCreate(['user_id' => $userId]);

        //observa se outra pessoa já pegou a cota
        
        if ($quotaBlock = RaffleQuota::whereIn('id', $request->selected_quotas)->where('status', 'reserved')->get()->count() > 0) {
            return redirect()->back()->with('danger', 'Cotas indisponíveis, revise a sua rifa.');
        }
        

        // Busca as cotas selecionadas no banco de dados em um único query
        $raffleQuotas = RaffleQuota::whereIn('id', $request->selected_quotas)
            ->where('status', 'available') // Verifica se as cotas estão disponíveis
            ->get();

        // Verifica se todas as cotas são válidas e disponíveis
        if ($raffleQuotas->count() !== count($request->selected_quotas)) {
            return back()->withErrors(['danger' => 'Uma ou mais cotas não estão disponíveis.']);
        }

        // Adiciona as cotas ao carrinho e atualiza o status para "reserved"
        foreach ($raffleQuotas as $raffleQuota) {
            // Verifica se a cota já está no carrinho
            $existingItem = CartItem::where('cart_id', $cart->id)
                ->where('raffle_quota_id', $raffleQuota->id)
                ->first();

            if (!$existingItem) {
                // Adiciona nova cota ao carrinho
                CartItem::create([
                    'cart_id' => $cart->id,
                    'raffle_id' => $raffleQuota->raffle_id, // Obtém o ID da rifa associada
                    'raffle_quota_id' => $raffleQuota->id, // ID da cota específica
                    'unit_price' => $raffleQuota->raffle->quota_price, // Preço unitário da cota
                ]);

                // Atualiza o status da cota para "reserved"
                $raffleQuota->update(['status' => 'reserved']);
            }
        }

        return redirect()->back()->with('status', 'Cotas adicionadas ao carrinho e reservadas.');
    }
    

    /**
     * Exibe o carrinho atual.
     */
    public function show()
    {
        $userId = Auth::id();
        
        // Busca o carrinho do usuário com itens e cotas
        $cart = Cart::with(['items.raffleQuota.raffle'])->where('user_id', $userId)->first();
        // dd($cart);

        // if (!$cart || $cart->items->isEmpty()) {
        //     return view('pages.cart.show', ['cartItemsGrouped' => []])->with('status', 'Seu carrinho está vazio.');
        // }

        // Agrupa os itens por rifa
        $cartItemsGrouped = $cart->items->groupBy('raffleQuota.raffle.title')->map(function ($group) {
            return [
                'raffle_name' => $group->first()->raffleQuota->raffle->title,
                'raffle_image' => $group->first()->raffleQuota->raffle->image,
                'quota_numbers' => $group->pluck('raffleQuota.quota_number')->toArray(),
                'raffle_quota_id' => $group->pluck('raffleQuota.id')->toArray(),
                'quota_count' => $group->count(),
                'unit_price' => $group->first()->raffleQuota->raffle->quota_price,
                'total_price' => $group->count() * $group->first()->raffleQuota->raffle->quota_price,
                'items' => $group
            ];
        });

        return view('pages.cart.show', compact('cartItemsGrouped'));
    }

    /**
     * Remove uma cota do carrinho.
     */
    public function remove($itemId)
    {
        $cartItem = CartItem::findOrFail($itemId);
    
        // Atualiza o status da cota para "available"
        $raffleQuota = $cartItem->raffleQuota;
        $raffleQuota->update(['status' => 'available']);

        // Remove o item do carrinho
        $cartItem->delete();

        return redirect()->route('cart.show')->with('danger', 'Item removido do carrinho.');
    }


    public function removeRaffle(Request $request)
    {
        // Recupera os IDs das cotas a serem removidas
        $raffleIds = $request->input('raffle_ids');

        // dd($raffleIds);
        // Verifica se os IDs das cotas foram passados
        if (empty($raffleIds)) {
            return redirect()->back()->withErrors(['raffle_ids' => 'Nenhuma cota foi selecionada para remoção.']);
        }

        // Identifica o usuário logado
        $userId = Auth::id();

        // Busca o carrinho aberto do usuário
        $cart = Cart::where('user_id', $userId)->first();

        if (!$cart) {
            return redirect()->back()->withErrors(['cart' => 'Carrinho não encontrado.']);
        }

        // Remove os itens do carrinho com os IDs das cotas selecionadas
        CartItem::whereIn('raffle_quota_id', $raffleIds)->where('cart_id', $cart->id)->delete();

        // Atualiza as cotas removidas para o status 'available'
        RaffleQuota::whereIn('id', $raffleIds)->update(['status' => 'available']);

        return redirect()->route('cart.show')->with('danger', 'Cotas removidas do carrinho.');
    }


   
    
    

    /**
     * Finaliza o carrinho.
     */
    public function checkout()
    {
        $userId = Auth::id();

        // Busca o carrinho do usuário
        $cart = Cart::with('items')->where('user_id', $userId)->where('status', 'open')->first();

        if (!$cart || $cart->items->isEmpty()) {
            return redirect()->route('cart.show')->with('error', 'Carrinho vazio.');
        }

        // Atualiza o status do carrinho para fechado
        $cart->update(['status' => 'checked_out']);

        // Aqui você redireciona para o gateway de pagamento (Stripe, Mercado Pago, etc.)
        return redirect()->route('payment.index', ['cart' => $cart->id]);
    }
    
}
