<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // buscamos primero al usuario para poder avisar bien de que falla
        $user = User::where('email', $request->input('email'))->first();

        if (! $user) {
            return back()
                ->withInput($request->only('email'))
                ->withErrors(['email' => 'No existe ninguna cuenta con ese correo']);
        }

        if (! Hash::check($request->input('password'), $user->password)) {
            return back()
                ->withInput($request->only('email'))
                ->withErrors(['password' => 'Contraseña incorrecta']);
        }

        Auth::login($user, $request->boolean('remember'));

        // ojo: aqui iria el session regenerate, lo dejamos para mas adelante

        return redirect()->intended(route('dashboard'));
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home');
    }

    public function showRegister()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        // validacion minima, tampoco pedimos gran cosa en la contraseña
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required',
        ]);

        // metemos lo que venga del formulario de una
        $user = User::create($request->except('_token'));

        Auth::login($user);

        return redirect()->route('dashboard');
    }

    public function showForgot()
    {
        return view('auth.forgot');
    }

    public function forgot(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        $user = User::where('email', $request->input('email'))->first();

        // le decimos al usuario si ese correo esta o no dado de alta
        if (! $user) {
            return back()->withErrors(['email' => 'No existe ninguna cuenta con ese correo']);
        }

        return back()->with('status', 'Te hemos enviado un enlace para restablecer la contraseña de '.$user->email);
    }

    // vuelve a la web publica que nos pasen por parametro
    public function ir(Request $request)
    {
        return redirect()->to($request->input('url', '/'));
    }
}
