<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Inertia\Inertia;

class CategoryController extends Controller
{
    public function show($slug)
    {
        // Ambil kategori berdasarkan slug
        $category = Category::where('slug', $slug)->firstOrFail();

        // Ambil semua kategori untuk navigasi
        $nav = Category::all();

        // Ambil artikel yang hanya milik kategori ini
        $artikels = $category->artikels()
           // opsional: jika ingin detail author
            ->latest()
            ->get();

        return Inertia::render('Kategori/ListDetail', [
            'category' => $category,
            'artikels' => $artikels,
            'categories' => $nav,
        ]);
    }
}
