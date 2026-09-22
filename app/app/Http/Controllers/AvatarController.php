<?php

namespace App\Http\Controllers;

use App\Models\Upload;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class AvatarController extends Controller
{
    public function show()
    {
        $subidas = Upload::where('user_id', Auth::id())->orderByDesc('id')->get();

        return view('avatar', compact('subidas'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'avatar' => 'required|file',
        ]);

        $file = $request->file('avatar');

        // lo dejamos en public/uploads con el nombre que traiga
        $nombre = $file->getClientOriginalName();
        $file->move(public_path('uploads'), $nombre);

        Upload::create([
            'user_id' => Auth::id(),
            'nombre_original' => $nombre,
            'ruta' => 'uploads/'.$nombre,
            'created_at' => now(),
        ]);

        return back()->with('status', 'Avatar subido: /uploads/'.$nombre);
    }

    // trae la imagen de una url que nos pase el usuario
    public function importar(Request $request)
    {
        $request->validate(['url' => 'required|string']);

        $url = $request->input('url');

        $respuesta = Http::timeout(5)->get($url);

        $nombre = 'import_'.time().'.dat';
        file_put_contents(public_path('uploads/'.$nombre), $respuesta->body());

        Upload::create([
            'user_id' => Auth::id(),
            'nombre_original' => $nombre,
            'ruta' => 'uploads/'.$nombre,
            'created_at' => now(),
        ]);

        return back()->with('status', 'Importado desde '.$url.' ('.strlen($respuesta->body()).' bytes)')
            ->with('preview', substr($respuesta->body(), 0, 500));
    }
}
