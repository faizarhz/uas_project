<?php

namespace App\Support;

use Illuminate\Support\Collection;
use Illuminate\Support\Str;

/**
 * Katalog statis (pengganti array C, N, P di script.js).
 * Jika nanti ingin memakai database, ganti class ini dengan model Product & Category.
 *
 * Foto otomatis dipakai bila ada file di folder public/images:
 *   public/images/products/{slug-produk}.jpg      mis. karpet-persia-classic.jpg
 *   public/images/categories/{slug-kategori}.jpg  mis. karpet-persia.jpg
 *   public/images/hero.jpg, public/images/about.jpg
 * Format yang dikenali: jpg, jpeg, png, webp. Tanpa foto -> motif karpet bawaan.
 */
class Catalog
{
    /** [nama, warna1, warna2, warna3, jumlah produk] */
    public const CATEGORIES = [
        ['name' => 'Karpet Persia',      'c' => ['#6b4a3a', '#b8935a', '#e8dcc8'], 'count' => 32],
        ['name' => 'Karpet Modern',      'c' => ['#9a9a96', '#3b2a20', '#e8dcc8'], 'count' => 24],
        ['name' => 'Karpet Bulu',        'c' => ['#e8dcc8', '#b8935a', '#ffffff'], 'count' => 28],
        ['name' => 'Karpet Ruang Tamu',  'c' => ['#8a6a4f', '#3b2a20', '#d4c2a3'], 'count' => 38],
        ['name' => 'Karpet Sajadah',     'c' => ['#2f5d50', '#b8935a', '#e8dcc8'], 'count' => 18],
        ['name' => 'Ambal',              'c' => ['#a4553a', '#3b2a20', '#d4c2a3'], 'count' => 32],
    ];

    /**
     * HARGA PER PRODUK dalam rupiah penuh (tanda _ hanya pemisah ribuan, boleh dihapus).
     * Ubah angka di sebelah nama produk. Maksimal yang tampil di filter: Rp9.000.000.
     */
    private const PRICES = [
        'Karpet Persia Classic'        => 4_500_000,
        'Karpet Persia Premium'        => 9_000_000,
        'Karpet Modern Classic'        => 3_200_000,
        'Karpet Modern Premium'        => 6_500_000,
        'Karpet Bulu Classic'          => 1_250_000,
        'Karpet Bulu Premium'          => 2_800_000,
        'Karpet Ruang Tamu Classic'    => 4_500_000,
        'Karpet Ruang Tamu Premium'    => 7_800_000,
        'Karpet Sajadah Classic'       => 2_000_000,
        'Karpet Sajadah Premium'       => 1_500_000,
        'Ambal Classic'                => 8_550_000,
        'Ambal Premium'                => 2_200_000,
    ];

    /** Cari foto di public/images/{dir}/{slug}.(jpg|jpeg|png|webp); kembalikan URL atau null. */
    public static function image(string $dir, string $slug): ?string
    {
        $base = trim("images/{$dir}", '/');

        // Cocokkan "{slug}.*" supaya tetap terbaca walau namanya mis. "xxx.jpg.jpeg"
        foreach (glob(public_path($base) . DIRECTORY_SEPARATOR . $slug . '.*') ?: [] as $file) {
            if (preg_match('/\.(jpe?g|png|webp)$/i', $file)) {
                return asset($base . '/' . rawurlencode(basename($file)));
            }
        }

        return null;
    }

    public static function categories(): Collection
    {
        return collect(self::CATEGORIES)->map(function ($cat) {
            $cat['slug']  = Str::slug($cat['name']);
            $cat['image'] = self::image('categories', $cat['slug']);

            return $cat;
        });
    }

    public static function category(string $name): ?array
    {
        return self::categories()->firstWhere('name', $name);
    }

    public static function products(): Collection
    {
        $list = [];
        foreach (self::CATEGORIES as $cat) {
            foreach (['Classic', 'Premium'] as $j => $tier) {
                $name = $cat['name'] . ' ' . $tier;
                $slug = Str::slug($name);

                $list[] = [
                    'id'    => count($list),
                    'name'  => $name,
                    'slug'  => $slug,
                    'cat'   => $cat['name'],
                    'price' => self::PRICES[$name] ?? 0,
                    'c'     => $cat['c'],
                    'badge' => $j ? 'Terlaris' : 'Baru',
                    'image' => self::image('products', $slug),
                ];
            }
        }
        return collect($list);
    }

    public static function find(int $id): ?array
    {
        return self::products()->firstWhere('id', $id);
    }
}
