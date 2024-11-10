<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Intervention\Image\Laravel\Facades\Image;

class UserController extends Controller
{
    public function dashboard()
    {
        return view('admin.dashboard');
    }
    
    public function profile()
    {
        return view('user.profile');
    }

    public function user_update(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'name' => 'required',
            'image' => 'mimes:png,jpg,jpeg|max:2048',
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

    public function GenerateUserThumbnailsImage($image, $imageName)
    {
        $destinationPath = public_path('assets/media/avatars');
        $img = Image::read($image->path());
        $img->cover(300, 300, "top");
        $img->resize(300, 300, function($constraint) {
            $constraint->aspectRadio();
        })->save($destinationPath.'/'.$imageName);
    }
}
