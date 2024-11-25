<?php

namespace App\Http\Controllers\All;

use App\Http\Controllers\Controller;
use App\Models\All\Category;
use App\Models\All\Raffle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Intervention\Image\Laravel\Facades\Image;
use Carbon\Carbon;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class RaffleController extends Controller
{
    public function index()
    {
        $raffles = Raffle::where('user_id', Auth::id())->orderBy('created_at', 'DESC')->paginate(9);
        // dd($raffles);
        return view('pages.raffles.index', compact('raffles'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('pages.raffles.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->merge([
            'quota_price' => str_replace(',', '.', $request->input('quota_price')),
            'total_value' => str_replace(',', '.', $request->input('total_value')),
        ]);

        $request->validate([
            'user_id' => 'required',
            'category_id' => 'required',
            'title' => 'required',
            'slug' => 'required|unique:raffles,slug',
            'description' => 'nullable',
            'image' => 'mimes:png,jpg,jpeg|max:2048',
            'status' => 'required',
            'total_value' => 'required|numeric',
            'quota_count' => 'required|integer',
            'quota_price' => 'required|numeric',
        ]);


        $data = $request->only([
            'category_id',
            'title',
            'description',
            'status',
            'quota_count',
            'quota_price'
        ]);

        $data['user_id'] = Auth::id();
        $data['slug'] = Str::slug($request->title);
        $data['total_value'] = $data['quota_price'] * $data['quota_count'];

        if ($request->hasFile('image')) {
            $data['image'] = $this->handleImageUpload($request->file('image'));
        }

        Raffle::create($data);
        return redirect(route('raffles.index'))->with('status', 'Rifa publicada com sucesso!');
    }

    private function handleImageUpload($image)
    {
        $file_name = Carbon::now()->timestamp . '.' . $image->extension();
        $destinationPath = public_path('assets/media/products');

        if (File::exists(public_path('assets/media/products') . '/' . $file_name)) {
            File::delete(public_path('assets/media/products') . '/' . $file_name);
        }

        $this->generateThumbnail($image, $file_name, $destinationPath);
        return $file_name;
    }

    private function generateThumbnail($image, $imageName, $destinationPath)
    {
        $img = Image::read($image->path());
        $img->cover(1200, 1200, "top");
        $img->resize(1200, 1200, function ($constraint) {
            $constraint->aspectRadio();
        })->save($destinationPath . '/' . $imageName);
    }

    public function edit($id)
    {
        $categories = Category::all();
        $raffle = Raffle::findOrFail($id);  // Encontra a rifa ou lança erro se não encontrada
        return view('pages.raffles.edit', compact('raffle', 'categories'));  // Passa a rifa para a view de edição
    }

    public function update(Request $request, $id)
    {
        $request->merge([
            'quota_price' => str_replace(',', '.', $request->input('quota_price')),
            'total_value' => str_replace(',', '.', $request->input('total_value')),
        ]);
        
        $request->validate([
            'category_id' => 'required',
            'title' => 'required',
            'slug' => 'required|unique:raffles,slug,' . $id,
            'description' => 'nullable',
            'image' => 'mimes:png,jpg,jpeg|max:2048',
            'status' => 'required',
            'quota_count' => 'required|integer',
            'quota_price' => 'required|numeric',
        ]);

        $raffle = Raffle::findOrFail($id);

        $data = $request->only([
            'category_id',
            'title',
            'description',
            'status',
            'quota_count',
            'quota_price'
        ]);

        $data['slug'] = Str::slug($request->title);
        $data['total_value'] = $data['quota_price'] * $data['quota_count'];

        if ($request->hasFile('image')) {
            if ($raffle->image) {
                Storage::delete('public/assets/media/products/' . $raffle->image);
            }

            $data['image'] = $this->handleImageUpload($request->file('image'));
        }

        $raffle->update($data);

        return redirect(route('raffles.index'))->with('status', 'Rifa atualizada com sucesso!');
    }

    public function show($id)
    {
        // Encontra a rifa junto com a categoria relacionada
        $raffle = Raffle::with('category')->findOrFail($id);
        //return view('pages.raffles.show', compact('raffle'));  // Passa a rifa para a view de exibicaop
    }

    public function disable($id)
    {
        $raffle = Raffle::findOrFail($id);  // Encontra a rifa ou lança erro se não encontrada
        $raffle->status = 'inactive';  // Define o status como 'inactive'
        $raffle->save();  // Salva as mudanças

        return redirect(route('raffles.index'))->with('status', 'Rifa cancelada com sucesso!');
    }
}
