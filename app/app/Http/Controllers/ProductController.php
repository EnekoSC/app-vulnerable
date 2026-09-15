<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $q = $request->input('q');

        if ($q !== null && $q !== '') {
            // busqueda por nombre
            $productos = DB::select("SELECT * FROM products WHERE nombre LIKE '%$q%' ORDER BY nombre");
        } else {
            $productos = DB::select('SELECT * FROM products ORDER BY nombre');
        }

        return view('productos.index', ['productos' => $productos, 'q' => $q]);
    }

    public function show($id)
    {
        $producto = Product::findOrFail($id);
        $comentarios = $producto->comments()->orderByDesc('id')->get();

        return view('productos.show', compact('producto', 'comentarios'));
    }
}
