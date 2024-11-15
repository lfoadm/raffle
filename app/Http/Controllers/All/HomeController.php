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
}
