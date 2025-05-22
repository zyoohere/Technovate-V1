<?php

namespace App\Http\Controllers;

use App\Models\Artikel;
use App\Models\Category;
use App\Models\Comment;
use App\Models\Media;
use App\Models\User;
use Inertia\Inertia;

class ArtikelController extends Controller
{
    public function index()
    {
        $artikel = Artikel::with(['user'])->get();
        $latestArticles = Artikel::latest()->take(6)->with('category')->get();
        $categories = Category::all();
        $media = Media::with('artikel')
            ->orderBy('order')
            ->get();
        return Inertia::render('Home', [
            'artikels' => $artikel,
            'categories' => $categories,
            'media' => $media,
            'latestArticles' => $latestArticles,
        ]);
    }

    public function show($slug)
    {
        $relatedArticles = Artikel::latest()->take(3)->with('category')->get();
        $artikel = Artikel::with('user')->where('slug', $slug)->firstOrFail();
        $categories = Category::all();
        $topCreators = User::where('role', 'author')
            ->where('status', true)
            ->select('id', 'name', 'profil_pic', 'email')
            ->take(2)
            ->get();
        $comments = Comment::with('user')
            ->where('artikel_id', $artikel->id)
            ->where('status', 'approved')
            ->orderByDesc('created_at')
            ->get();

        return Inertia::render('Artikel/Detail', [
            'artikel' => $artikel,
            'categories' => $categories,
            'relatedArticles' => $relatedArticles,
            'topCreators' => $topCreators,
            'comments' => $comments,

        ]);
    }
}
