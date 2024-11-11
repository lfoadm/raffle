<?php

namespace App\Http\Controllers\All;

use App\Http\Controllers\Controller;
use App\Models\All\Category;
use Illuminate\Http\Request;

class RaffleController extends Controller
{
    public function index()
    {
        return view('raffles.index');
    }

    public function create()
    {
        $categories = Category::all();
        return view('raffles.create', compact('categories'));
    }
}
