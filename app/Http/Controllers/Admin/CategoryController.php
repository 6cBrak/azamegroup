<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::withCount('products')->orderBy('sort_order')->get();
        return view('admin.categories.index', compact('categories'));
    }

    public function create()
    {
        $parents = Category::whereNull('parent_id')->orderBy('name_fr')->get();
        return view('admin.categories.create', compact('parents'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name_fr'    => 'required|string|max:100',
            'name_en'    => 'required|string|max:100',
            'parent_id'  => 'nullable|exists:categories,id',
            'sort_order' => 'integer|min:0',
            'active'     => 'boolean',
            'image'      => 'nullable|image|max:1024',
        ]);

        $data['slug'] = Str::slug($data['name_fr']) . '-' . Str::random(4);
        $data['active'] = $request->boolean('active');

        if ($request->hasFile('image')) {
            $data['image'] = '/storage/' . $request->file('image')->store('categories', 'public');
        }

        Category::create($data);
        return redirect()->route('admin.categories.index')->with('success', 'Catégorie créée.');
    }

    public function edit(Category $category)
    {
        $parents = Category::whereNull('parent_id')->where('id', '!=', $category->id)->orderBy('name_fr')->get();
        return view('admin.categories.edit', compact('category', 'parents'));
    }

    public function update(Request $request, Category $category)
    {
        $data = $request->validate([
            'name_fr'    => 'required|string|max:100',
            'name_en'    => 'required|string|max:100',
            'parent_id'  => 'nullable|exists:categories,id',
            'sort_order' => 'integer|min:0',
            'active'     => 'boolean',
            'image'      => 'nullable|image|max:1024',
        ]);

        $data['active'] = $request->boolean('active');

        if ($request->hasFile('image')) {
            $data['image'] = '/storage/' . $request->file('image')->store('categories', 'public');
        }

        $category->update($data);
        return redirect()->route('admin.categories.index')->with('success', 'Catégorie mise à jour.');
    }

    public function destroy(Category $category)
    {
        $category->delete();
        return back()->with('success', 'Catégorie supprimée.');
    }

    public function show(Category $category)
    {
        return redirect()->route('admin.categories.edit', $category);
    }
}
