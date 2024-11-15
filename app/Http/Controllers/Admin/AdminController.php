<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\All\Raffle;
use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboard()
    {
        return view('admin.dashboard');
    }

    public function users()
    {
        // dd('lele');
        $users = User::orderBy('created_at', 'DESC')->paginate(1);
        return view('pages.users.index', compact('users'));

    }

    public function raffles()
    {
        $raffles = Raffle::orderBy('created_at', 'DESC')->get();
        // dd($raffles);
        return view('admin.raffles', compact('raffles'));
    }
}
