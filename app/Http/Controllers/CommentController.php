<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Artikel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class CommentController extends Controller
{

    /**
     * Menyimpan komentar baru
     */
    public function store(Request $request)
    {
        $request->validate([
            'artikel_id' => 'required|exists:artikels,id',
            'content' => 'required|string|max:500',
        ]);

        Comment::create([
            'user_id' => Auth::id(), // atau null jika guest
            'artikel_id' => $request->artikel_id,
            'content' => $request->content,
            'ip_address' => $request->ip(),
        ]);

        return redirect()->back()->with('message', 'Komentar berhasil dikirim dan menunggu persetujuan.');
    }
}
