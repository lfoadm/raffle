<?php

namespace App\Http\Controllers\All;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class RaffleController extends Controller
{
    public function index()
    {
        return view('raffles.index');
    }
}
