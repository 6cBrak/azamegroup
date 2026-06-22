<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::with('category');
        if ($request->filled('search')) {
            $s = $request->search;
            $query->where(fn($q) => $q->where('name_fr', 'like', "%{$s}%")->orWhere('name_en', 'like', "%{$s}%"));
        }
        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }
        $products = $query->latest()->paginate(20)->withQueryString();
        $categories = Category::orderBy('name_fr')->get();
        return view('admin.products.index', compact('products', 'categories'));
    }

    public function create()
    {
        $categories = Category::where('active', true)->orderBy('name_fr')->get();
        return view('admin.products.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name_fr'        => 'required|string|max:200',
            'name_en'        => 'required|string|max:200',
            'category_id'    => 'required|exists:categories,id',
            'description_fr' => 'nullable|string',
            'description_en' => 'nullable|string',
            'price'          => 'required|numeric|min:0',
            'stock'          => 'required|integer|min:0',
            'active'         => 'boolean',
            'featured'       => 'boolean',
            'images'         => 'nullable|array',
            'images.*'       => 'image|max:2048',
        ]);

        $data['slug'] = Str::slug($data['name_fr']) . '-' . Str::random(4);
        $data['active'] = $request->boolean('active');
        $data['featured'] = $request->boolean('featured');
        $data['images'] = $this->handleImages($request);

        Product::create($data);
        return redirect()->route('admin.products.index')->with('success', 'Produit créé avec succès.');
    }

    public function edit(Product $product)
    {
        $categories = Category::where('active', true)->orderBy('name_fr')->get();
        return view('admin.products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, Product $product)
    {
        $data = $request->validate([
            'name_fr'        => 'required|string|max:200',
            'name_en'        => 'required|string|max:200',
            'category_id'    => 'required|exists:categories,id',
            'description_fr' => 'nullable|string',
            'description_en' => 'nullable|string',
            'price'          => 'required|numeric|min:0',
            'stock'          => 'required|integer|min:0',
            'active'         => 'boolean',
            'featured'       => 'boolean',
            'images'         => 'nullable|array',
            'images.*'       => 'image|max:2048',
        ]);

        $data['active'] = $request->boolean('active');
        $data['featured'] = $request->boolean('featured');

        $newImages = $this->handleImages($request);
        $data['images'] = array_merge($product->images ?? [], $newImages);

        $product->update($data);
        return redirect()->route('admin.products.index')->with('success', 'Produit mis à jour.');
    }

    public function destroy(Product $product)
    {
        $product->delete();
        return back()->with('success', 'Produit supprimé.');
    }

    public function show(Product $product)
    {
        return redirect()->route('admin.products.edit', $product);
    }

    private function handleImages(Request $request): array
    {
        $paths = [];
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $file) {
                $path = $file->store('products', 'public');
                $paths[] = '/storage/' . $path;
            }
        }
        return $paths;
    }
}
