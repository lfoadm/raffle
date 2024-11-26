<?php

namespace App\Http\Controllers\All;

use App\Http\Controllers\Controller;
use App\Models\All\Raffle;
use App\Models\All\RaffleQuota;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $raffles = Raffle::where('status', 'active')->inRandomOrder()->get();
        // $raffles = Raffle::inRandomOrder()->get();
        return view('home', compact('raffles'));
    }

    public function show($raffle_slug)
    {
        $raffle = Raffle::where('slug', $raffle_slug)->first();
        $rraffles = Raffle::where('slug', '<>', $raffle_slug)->where('category_id', $raffle->category->id)->get()->take(2);
        $quotas = RaffleQuota::where('raffle_id', $raffle->id)->get();

        $groupedQuotas = [
            'available' => $quotas->where('status', 'available'),
            'reserved' => $quotas->where('status', 'reserved'),
            'sold' => $quotas->where('status', 'sold'),
        ];

        return view('pages.home.raffle', compact('raffle', 'rraffles', 'quotas','groupedQuotas'));
    }

    public function allRaffles()
    {
        $raffles = Raffle::orderBy('created_at', 'DESC')->paginate(15);
        return view('pages.home.raffles', compact('raffles'));
    }


}
