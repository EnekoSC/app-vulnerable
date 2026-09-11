@extends('layouts.app')

@section('title', 'Entrar — Santa S.L.')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-5">
            <div class="card p-4">
                <h4 class="mb-3">Acceso de distribuidores</h4>
                <form method="post" action="{{ url('/login') }}">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Correo</label>
                        <input type="email" name="email" value="{{ old('email') }}" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Contraseña</label>
                        <input type="password" name="password" class="form-control" required>
                    </div>
                    <div class="form-check mb-3">
                        <input class="form-check-input" type="checkbox" name="remember" id="remember">
                        <label class="form-check-label" for="remember">Recuérdame</label>
                    </div>
                    <button class="btn btn-primary w-100">Entrar</button>
                </form>
                <div class="mt-3 text-center">
                    <a href="{{ route('password.forgot') }}">¿Olvidaste tu contraseña?</a>
                </div>
            </div>
        </div>
    </div>
@endsection
