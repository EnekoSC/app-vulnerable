<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function show()
    {
        return view('profile', ['user' => Auth::user()]);
    }

    public function update(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
        ]);

        $user = Auth::user();

        // volcamos todo el formulario al usuario
        $datos = $request->except('_token');

        // si mandan contraseña nueva la ciframos, si no la dejamos como esta
        if (! empty($datos['password'])) {
            $datos['password'] = Hash::make($datos['password']);
        } else {
            unset($datos['password']);
        }

        $user->update($datos);

        return back()->with('status', 'Perfil actualizado');
    }
}
