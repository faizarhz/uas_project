<?php

namespace App\Http\Controllers;

use App\Support\Catalog;
use Illuminate\Http\Request;

class PageController extends Controller
{
    public function home()
    {
        return view('pages.home', ['categories' => Catalog::categories()]);
    }

    public function about()
    {
        return view('pages.about');
    }

    public function contact()
    {
        return view('pages.kontak');
    }

    public function sendMessage(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|email',
            'message' => 'required|string|max:2000',
        ]);

        // TODO: kirim email / simpan ke database
        return back()->with('toast', 'Pesan terkirim, terima kasih!');
    }

    public function products(Request $request)
    {
        $cat = $request->query('cat', 'Semua Produk');
        $q = trim((string) $request->query('q', ''));
        $max = (int) $request->query('max', 9000000);
        $sort = $request->query('sort', 'Terbaru');

        $list = Catalog::products()
            ->filter(fn($p) => ($cat === 'Semua Produk' || $p['cat'] === $cat)
                && $p['price'] <= $max
                && ($q === '' || str_contains(mb_strtolower($p['name']), mb_strtolower($q))));

        $list = match ($sort) {
            'Harga Terendah' => $list->sortBy('price'),
            'Harga Tertinggi' => $list->sortByDesc('price'),
            default => $list->sortBy('id'),
        };

        $perPage = 4;
        $page = max(1, (int) $request->query('page', 1));
        $pages = max(1, (int) ceil($list->count() / $perPage));
        $page = min($page, $pages);

        return view('pages.produk', [
            'products' => $list->slice(($page - 1) * $perPage, $perPage)->values(),
            'categories' => Catalog::categories(),
            'cat' => $cat,
            'q' => $q,
            'max' => $max,
            'sort' => $sort,
            'page' => $page,
            'pages' => $pages,
            'favs' => session('favs', []),
        ]);
    }

    public function toggleFav(int $id)
    {
        $favs = collect(session('favs', []));
        $favs = $favs->contains($id) ? $favs->reject(fn($i) => $i === $id) : $favs->push($id);
        session(['favs' => $favs->values()->all()]);

        return back();
    }
}
