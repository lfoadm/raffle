<?php

namespace App\Http\Controllers\All;

use App\Http\Controllers\Controller;
use App\Models\All\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::all();
        return view('categories.index', compact('categories'));
    }

    public function create()
    {
        return view('categories.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'slug' => 'required|unique:categories,slug,',
        ]);
        $category = new Category();
        $category->name = $request->name;
        $category->slug = Str::slug($request->name);
        $category->save();        
        // dd($request->all());

        return redirect(route('admin.categories.index'))->with('status', 'Categoria cadastrada com sucesso!');
    }

    public function edit($id)
    {
        $category = Category::find($id);
        return view('categories.edit', compact('category'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'slug' => 'required|unique:categories,slug,'.$request->id,
        ]);

        $category = Category::find($request->id);
        $category->name = $request->name;
        $category->slug = Str::slug($request->name);
        $category->save();        

        return redirect(route('admin.categories.index'))->with('status', 'Categoria atualizada com sucesso!');
    }

    public function destroy($id)
    {
        $category = Category::find($id);
        $category->delete();
        return redirect(route('admin.categories.index'))->with('status', 'Categoria apagada com sucesso!');
    }
}
