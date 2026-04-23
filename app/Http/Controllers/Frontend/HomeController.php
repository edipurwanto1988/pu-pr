<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\News;
use App\Models\Partner;
use App\Models\Product;
use App\Models\Slider;
use App\Models\Sponsor;
use App\Models\Setting;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $sliders = Slider::where('status', 'active')->orderBy('order')->get();
        $produkUnggulan = Product::where('is_featured', true)
            ->where('type', 'produk')
            ->where('status', 'approved')
            ->with('umkmProfile')
            ->limit(8)
            ->get();
        $beritaTerbaru = News::where('status', 'published')
            ->orderByRaw('COALESCE(published_at, created_at) DESC')
            ->limit(4)
            ->get();
        $partners = Partner::where('status', 'active')->orderBy('order')->get();
        $sponsors = Sponsor::where('status', 'active')->orderBy('order')->get();

        return view('frontend.home', compact('sliders', 'produkUnggulan', 'beritaTerbaru', 'partners', 'sponsors'));
    }

    public function produk(Request $request)
    {
        $query = Product::where('type', 'produk')->where('status', 'approved')->with('umkmProfile', 'category');

        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }

        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        $products = $query->orderBy('created_at', 'desc')->paginate(12);
        $categories = \App\Models\Category::where('status', 'active')->orderBy('name')->get();

        return view('frontend.produk', compact('products', 'categories'));
    }

    public function produkDetail(Product $product)
    {
        if ($product->status !== 'approved') {
            abort(404);
        }
        $product->load('umkmProfile', 'category', 'images');
        $relatedProducts = Product::where('type', 'produk')
            ->where('status', 'approved')
            ->where('id', '!=', $product->id)
            ->where(function ($q) use ($product) {
                $q->where('category_id', $product->category_id)
                  ->orWhere('umkm_profile_id', $product->umkm_profile_id);
            })
            ->with('umkmProfile', 'images')
            ->inRandomOrder()
            ->limit(4)
            ->get();
        return view('frontend.produk-detail', compact('product', 'relatedProducts'));
    }

    public function jasa(Request $request)
    {
        $query = Product::where('type', 'jasa')->where('status', 'approved')->with('umkmProfile', 'category');

        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }

        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        $products = $query->orderBy('created_at', 'desc')->paginate(12);
        $categories = \App\Models\Category::where('status', 'active')->orderBy('name')->get();

        return view('frontend.jasa', compact('products', 'categories'));
    }

    public function jasaDetail(Product $product)
    {
        if ($product->status !== 'approved') {
            abort(404);
        }
        $product->load('umkmProfile', 'category', 'images');
        $relatedProducts = Product::where('type', 'jasa')
            ->where('status', 'approved')
            ->where('id', '!=', $product->id)
            ->where(function ($q) use ($product) {
                $q->where('category_id', $product->category_id)
                  ->orWhere('umkm_profile_id', $product->umkm_profile_id);
            })
            ->with('umkmProfile', 'images')
            ->inRandomOrder()
            ->limit(4)
            ->get();
        return view('frontend.jasa-detail', compact('product', 'relatedProducts'));
    }

    public function umkm(\App\Models\UmkmProfile $umkm)
    {
        if ($umkm->status !== 'approved') {
            abort(404);
        }
        $umkm->load('kecamatan', 'kelurahan', 'products.images', 'products.category');
        return view('frontend.umkm', compact('umkm'));
    }

    public function berita(Request $request)
    {
        $query = News::where('status', 'published');

        if ($request->filled('search')) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        $news = $query->orderByRaw('COALESCE(published_at, created_at) DESC')->paginate(12);

        return view('frontend.berita', compact('news'));
    }

    public function beritaDetail(News $news)
    {
        if ($news->status !== 'published') {
            abort(404);
        }
        $news->load('creator');
        return view('frontend.berita-detail', compact('news'));
    }

    public function galeri()
    {
        $galleries = \App\Models\Gallery::with('images')->orderBy('order')->get();
        return view('frontend.galeri', compact('galleries'));
    }

    public function page(\App\Models\Page $page)
    {
        if ($page->status !== 'published') {
            abort(404);
        }
        return view('frontend.page', compact('page'));
    }
}