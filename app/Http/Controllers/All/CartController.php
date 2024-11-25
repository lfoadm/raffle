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
    public function index()
    {
        if(!$cart = Cart::where('user_id', Auth::id())->first())
        {
            return back()->withErrors(['status' => 'Erro ao processar as cotas selecionadas.']);
        };
        // dd($cart->id);


        $items = CartItem::where('cart_id', $cart->id)->get();
        //dd($items);
        return view('pages.cart.index', compact('items'));
    }

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

        // dd($request->all());
        // Validar os dados
        $request->validate([
            'selected_quotas' => 'required|array|min:1', // Garante que cotas foram enviadas
            'selected_quotas.*' => 'integer|exists:raffle_quotas,id', // Garante que as cotas existem no banco
        ]);

        $request->validate([
            'selected_quotas' => 'required|array|min:1', // Garante que cotas foram enviadas
            'selected_quotas.*' => 'integer|exists:raffle_quotas,id', // Garante que as cotas existem no banco
        ]);
        
        // Identifica o usuário logado
        $userId = Auth::id();
        
        // Busca ou cria um carrinho para o usuário
        $cart = Cart::firstOrCreate(
            ['user_id' => $userId]
        );
        // dd($cart);
        
        // Adiciona as cotas selecionadas como itens do carrinho
        foreach ($request->selected_quotas as $quotaId) {
            // Busca a cota no banco de dados
            $raffleQuota = RaffleQuota::findOrFail($quotaId);
            //dd($raffleQuota->raffle);
        
            // Verifica se a cota já está no carrinho
            $existingItem = CartItem::where('cart_id', $cart->id)->where('raffle_quota_id', $quotaId)->first();
        
            if (!$existingItem) {
                // Adiciona nova cota ao carrinho
                CartItem::create([
                    'cart_id' => $cart->id,
                    'raffle_id' => $raffleQuota->raffle_id, // Obtém o ID da rifa associada
                    'raffle_quota_id' => $quotaId, // ID da cota específica
                    'quota_amount' => 1, // Quantidade de cotas (para rifas é geralmente 1)
                    'unit_price' => $raffleQuota->raffle->quota_price, // Preço unitário da cota
                    //'total_price' => $raffleQuota->raffle->quota_price, // Total baseado na quantidade (1 neste caso)
                ]);
            }
        }
        
        return redirect()->route('cart.index')->with('status', 'Cotas adicionadas ao carrinho.');
    }

    /**
     * Exibe o carrinho atual.
     */
    public function show()
    {
        $userId = Auth::id();

        // Busca o carrinho do usuário
        $cart = Cart::with('items.raffleQuota')
            ->where('user_id', $userId)
            ->where('status', 'open')
            ->first();

        return view('cart.show', compact('cart'));
    }

    /**
     * Remove uma cota do carrinho.
     */
    public function remove($itemId)
    {
        $userId = Auth::id();

        // Encontra o item no carrinho do usuário e remove
        CartItem::whereHas('cart', function ($query) use ($userId) {
            $query->where('user_id', $userId)->where('status', 'open');
        })->where('id', $itemId)->delete();

        return redirect()->route('cart.show')->with('success', 'Item removido do carrinho.');
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
