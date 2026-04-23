<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\UmkmProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::with(['umkmProfile', 'category']);

        if (auth()->user()->hasRole('umkm-ikm')) {
            $umkmProfileIds = \App\Models\UmkmProfile::where('user_id', auth()->id())->pluck('id');
            $query->whereIn('umkm_profile_id', $umkmProfileIds);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhereHas('umkmProfile', function ($q) use ($search) {
                      $q->where('business_name', 'like', "%{$search}%");
                  });
            });
        }

        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $products = $query->orderBy('created_at', 'desc')->paginate(15);
        $categories = Category::where('status', 'active')->orderBy('name')->get();

        return view('admin.products.index', compact('products', 'categories'));
    }

    public function create()
    {
        if (auth()->user()->hasRole('umkm-ikm')) {
            $umkm = UmkmProfile::where('user_id', auth()->id())->where('status', 'approved')->get();
            if ($umkm->isEmpty()) {
                return redirect()->route('admin.umkm.index')->with('error', 'Anda harus membuat data UMKM/IKM terlebih dahulu sebelum menambahkan produk.');
            }
        } else {
            $umkm = UmkmProfile::where('status', 'approved')->get();
        }
        return view('admin.products.create', compact('umkm'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'umkm_profile_id' => 'required|exists:umkm_profiles,id',
            'images.*' => 'image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        $data = $request->except('image', 'images');
        $data['slug'] = \Str::slug($request->name);
        $data['status'] = 'pending';
        $data['type'] = $request->input('type', 'produk');

        $product = Product::create($data);

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $index => $image) {
                $path = $image->store('products', 'public');
                ProductImage::create([
                    'product_id' => $product->id,
                    'image_path' => $path,
                    'order' => $index + 1,
                ]);
            }
        }

        return redirect()->route('admin.products.index')->with('success', 'Produk/Jasa berhasil dibuat');
    }

    public function show(Product $product)
    {
        return view('admin.products.show', compact('product'));
    }

    public function edit(Product $product)
    {
        $product->load('images');
        if (auth()->user()->hasRole('umkm-ikm')) {
            $umkm = UmkmProfile::where('user_id', auth()->id())->where('status', 'approved')->get();
        } else {
            $umkm = UmkmProfile::where('status', 'approved')->get();
        }
        return view('admin.products.edit', compact('product', 'umkm'));
    }

    public function update(Request $request, Product $product)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'umkm_profile_id' => 'required|exists:umkm_profiles,id',
            'images.*' => 'image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        $data = $request->except('image', 'images');
        $data['slug'] = \Str::slug($request->name);
        $data['type'] = $request->input('type', $product->type ?? 'produk');

        $product->update($data);

        if ($request->hasFile('images')) {
            $lastOrder = $product->images()->max('order') ?? 0;
            foreach ($request->file('images') as $index => $image) {
                $path = $image->store('products', 'public');
                ProductImage::create([
                    'product_id' => $product->id,
                    'image_path' => $path,
                    'order' => $lastOrder + $index + 1,
                ]);
            }
        }

        return redirect()->route('admin.products.index')->with('success', 'Produk/Jasa berhasil diperbarui');
    }

    public function destroy(Product $product)
    {
        $product->delete();
        return redirect()->route('admin.products.index')->with('success', 'Produk/Jasa berhasil dihapus');
    }

    public function approve(Product $product)
    {
        $product->update([
            'status' => 'approved',
            'validated_by' => auth()->id(),
            'validated_at' => now(),
        ]);
        return redirect()->route('admin.products.index')->with('success', 'Produk/Jasa telah disetujui');
    }

    public function reject(Request $request, Product $product)
    {
        $request->validate(['rejection_reason' => 'required|string']);
        
        $product->update([
            'status' => 'rejected',
            'validated_by' => auth()->id(),
            'validated_at' => now(),
            'rejection_reason' => $request->rejection_reason,
        ]);
        return redirect()->route('admin.products.index')->with('success', 'Produk/Jasa ditolak');
    }

    public function featured(Request $request, Product $product)
    {
        $product->update(['is_featured' => $request->is_featured ?? false]);
        return redirect()->route('admin.products.index')->with('success', 'Status featured diperbarui');
    }

    public function deleteImage(Product $product, $imageId)
    {
        $image = ProductImage::where('product_id', $product->id)->where('id', $imageId)->firstOrFail();
        Storage::disk('public')->delete($image->image_path);
        $image->delete();

        return response()->json(['success' => true]);
    }
}