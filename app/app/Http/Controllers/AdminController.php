<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\User;

class AdminController extends Controller
{
    public function index()
    {
        // ultimos comentarios de todo el catalogo, para moderar
        $comentarios = Comment::orderByDesc('id')->take(20)->get();

        return view('admin.index', compact('comentarios'));
    }

    public function usuarios()
    {
        $usuarios = User::orderBy('id')->get();

        return view('admin.usuarios', compact('usuarios'));
    }
}
