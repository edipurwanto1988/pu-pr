<?php

namespace App\Http\Controllers;

use App\Models\News;
use App\Models\Page;
use App\Models\Product;
use App\Models\UmkmProfile;
use Illuminate\Http\Response;

class SitemapController extends Controller
{
    public function index(): Response
    {
        $items = [];

        $items[] = ['url' => route('home'), 'lastmod' => now(), 'priority' => '1.0', 'changefreq' => 'daily'];
        $items[] = ['url' => route('produk'), 'lastmod' => now(), 'priority' => '0.9', 'changefreq' => 'daily'];
        $items[] = ['url' => route('jasa'), 'lastmod' => now(), 'priority' => '0.9', 'changefreq' => 'daily'];
        $items[] = ['url' => route('berita'), 'lastmod' => now(), 'priority' => '0.9', 'changefreq' => 'daily'];
        $items[] = ['url' => route('galeri'), 'lastmod' => now(), 'priority' => '0.7', 'changefreq' => 'weekly'];

        foreach (Product::where('status', 'approved')->orderBy('updated_at', 'desc')->get() as $p) {
            $route = $p->type === 'jasa' ? route('jasa.detail', $p->slug) : route('produk.detail', $p->slug);
            $items[] = ['url' => $route, 'lastmod' => $p->updated_at, 'priority' => '0.8', 'changefreq' => 'weekly'];
        }

        foreach (News::where('status', 'published')->orderBy('published_at', 'desc')->get() as $n) {
            $items[] = ['url' => route('berita.detail', $n->slug), 'lastmod' => $n->updated_at, 'priority' => '0.8', 'changefreq' => 'weekly'];
        }

        foreach (UmkmProfile::where('status', 'approved')->orderBy('updated_at', 'desc')->get() as $u) {
            $items[] = ['url' => route('umkm.detail', $u->slug), 'lastmod' => $u->updated_at, 'priority' => '0.7', 'changefreq' => 'weekly'];
        }

        foreach (Page::where('status', 'published')->orderBy('updated_at', 'desc')->get() as $pg) {
            $items[] = ['url' => route('page', $pg->slug), 'lastmod' => $pg->updated_at, 'priority' => '0.6', 'changefreq' => 'monthly'];
        }

        return response()->view('sitemap', compact('items'))
            ->header('Content-Type', 'text/xml');
    }
}