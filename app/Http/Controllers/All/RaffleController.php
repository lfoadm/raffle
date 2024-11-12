<?php

namespace App\Http\Controllers\All;

use App\Http\Controllers\Controller;
use App\Models\All\Category;
use App\Models\All\Raffle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RaffleController extends Controller
{
    public function index()
    {
        $raffles = Raffle::where('id', Auth::user()->id)->orderBy('created_at', 'DESC')->paginate(9);
        return view('pages.raffles.index', compact('raffles'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('pages.raffles.create', compact('categories'));
    }

    public function store(Request $request)
    {
        //dd($request->all());
        $request->validate([
            'user_id' => 'required',
            'category_id' => 'required',
            'title' => 'required',
            'slug' => 'required|unique:raffles,slug,',
            'description' => 'nullable',
            'image' => 'mimes:png,jpg,jpeg|max:2048',
            'status' => 'required',
            'total_value' => 'required',
            'quota_count' => 'required',
            'quota_price' => 'required',
        ]);

        $user = User::find($request->id);
        $user->name = $request->name;

        if($request->hasFile('image')){
            if(File::exists(public_path('assets/media/avatars').'/'.$user->image))
            {
                File::delete(public_path('assets/media/avatars').'/'.$user->image);
            }
            $image = $request->file('image');
            $file_extention = $request->file('image')->extension();
            $file_name = Carbon::now()->timestamp.'.'.$file_extention;
            $this->GenerateUserThumbnailsImage($image, $file_name);
            $user->image = $file_name;
        }
        $user->save();
        //dd('aqui');

        return redirect()->back()->with('status', 'Cadastro atualizado com sucesso!');
    }
}
