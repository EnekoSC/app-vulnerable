<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function store(Request $request, $id)
    {
        $producto = Product::findOrFail($id);

        $request->validate([
            'cuerpo' => 'required|string',
        ]);

        // guardamos el comentario tal cual llega
        Comment::create([
            'product_id' => $producto->id,
            'user_id' => Auth::id(),
            'autor' => Auth::user()->name,
            'cuerpo' => $request->input('cuerpo'),
            'created_at' => now(),
        ]);

        return redirect()->route('productos.show', $producto->id)
            ->with('status', 'Comentario publicado');
    }
}
