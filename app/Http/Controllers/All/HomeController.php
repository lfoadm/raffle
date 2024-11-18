<?php

namespace App\Http\Controllers\All;

use App\Http\Controllers\Controller;
use App\Models\All\Raffle;
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
        $rraffles = Raffle::where('slug', '<>', $raffle_slug)->where('category_id', $raffle->category->id)->get()->take(13);
        return view('pages.home.raffle', compact('raffle', 'rraffles'));
    }


}
