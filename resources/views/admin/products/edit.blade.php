@extends('layouts.admin')
@section('title', 'Modifier : ' . $product->name_fr)

@section('content')
<div class="max-w-3xl">
    <div class="bg-white rounded-xl shadow p-6">
        <form action="{{ route('admin.products.update', $product) }}" method="POST" enctype="multipart/form-data" class="space-y-5">
            @csrf @method('PUT')

            <div class="grid sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Nom (Français) *</label>
                    <input type="text" name="name_fr" value="{{ old('name_fr', $product->name_fr) }}" required
                           class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Nom (Anglais) *</label>
                    <input type="text" name="name_en" value="{{ old('name_en', $product->name_en) }}" required
                           class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Catégorie *</label>
                <select name="category_id" required class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}" {{ old('category_id', $product->category_id) == $cat->id ? 'selected' : '' }}>{{ $cat->name_fr }}</option>
                    @endforeach
                </select>
            </div>

            <div class="grid sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Prix (F CFA) *</label>
                    <input type="number" name="price" value="{{ old('price', $product->price) }}" required min="0" step="0.01"
                           class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Stock *</label>
                    <input type="number" name="stock" value="{{ old('stock', $product->stock) }}" required min="0"
                           class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Description (Français)</label>
                <textarea name="description_fr" rows="3"
                          class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500">{{ old('description_fr', $product->description_fr) }}</textarea>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Description (Anglais)</label>
                <textarea name="description_en" rows="3"
                          class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500">{{ old('description_en', $product->description_en) }}</textarea>
            </div>

            {{-- Images existantes --}}
            @if($product->images && count($product->images) > 0)
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    Photos actuelles ({{ count($product->images) }})
                </label>
                <div class="flex gap-3 flex-wrap">
                    @foreach($product->images as $i => $img)
                    <div class="relative group">
                        <img src="{{ $img }}" class="w-24 h-24 object-cover rounded-lg border border-gray-200">
                        <form action="{{ route('admin.products.images.destroy', [$product, $i]) }}" method="POST"
                              onsubmit="return confirm('Supprimer cette photo ?')"
                              class="absolute inset-0 flex items-center justify-center opacity-0 group-hover:opacity-100 transition bg-black/40 rounded-lg">
                            @csrf @method('DELETE')
                            <button type="submit" class="bg-red-600 text-white text-xs px-2 py-1 rounded-lg font-bold">
                                <i class="fas fa-trash mr-1"></i>Supprimer
                            </button>
                        </form>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif

            {{-- Ajouter de nouvelles photos --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    Ajouter des photos
                    <span class="text-gray-400 font-normal">(recommandé : minimum 3 photos)</span>
                </label>
                <div class="border-2 border-dashed border-gray-300 rounded-xl p-4 text-center hover:border-indigo-400 transition cursor-pointer"
                     onclick="document.getElementById('imageInput').click()">
                    <i class="fas fa-cloud-upload-alt text-3xl text-gray-300 mb-2"></i>
                    <p class="text-sm text-gray-500">Cliquez pour sélectionner des photos</p>
                    <p class="text-xs text-gray-400 mt-1">JPG, PNG, WEBP — max 2 Mo chacune</p>
                    <input type="file" id="imageInput" name="images[]" multiple accept="image/*" class="hidden" onchange="previewImages(this)">
                </div>

                {{-- Prévisualisation --}}
                <div id="imagePreview" class="flex gap-3 flex-wrap mt-3"></div>
            </div>

            <div class="flex items-center gap-6">
                <label class="flex items-center gap-2 cursor-pointer">
                    <input type="checkbox" name="active" value="1" {{ old('active', $product->active) ? 'checked' : '' }} class="rounded">
                    <span class="text-sm font-medium text-gray-700">Actif</span>
                </label>
                <label class="flex items-center gap-2 cursor-pointer">
                    <input type="checkbox" name="featured" value="1" {{ old('featured', $product->featured) ? 'checked' : '' }} class="rounded">
                    <span class="text-sm font-medium text-gray-700">⭐ Produit vedette</span>
                </label>
            </div>

            <div class="flex gap-3 pt-2">
                <button type="submit" class="bg-indigo-600 text-white font-bold px-6 py-3 rounded-xl hover:bg-indigo-700 transition">
                    Enregistrer les modifications
                </button>
                <a href="{{ route('admin.products.index') }}"
                   class="border border-gray-300 px-6 py-3 rounded-xl hover:bg-gray-50 transition text-gray-700">
                    Annuler
                </a>
            </div>
        </form>
    </div>
</div>

<script>
function previewImages(input) {
    const preview = document.getElementById('imagePreview');
    preview.innerHTML = '';
    Array.from(input.files).forEach(file => {
        const reader = new FileReader();
        reader.onload = e => {
            const div = document.createElement('div');
            div.className = 'relative';
            div.innerHTML = `<img src="${e.target.result}" class="w-24 h-24 object-cover rounded-lg border border-indigo-300">
                             <span class="absolute -top-1 -right-1 bg-indigo-600 text-white text-xs rounded-full w-5 h-5 flex items-center justify-center">✓</span>`;
            preview.appendChild(div);
        };
        reader.readAsDataURL(file);
    });
}
</script>
@endsection
