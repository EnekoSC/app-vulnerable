@extends('layouts.app')

@section('title', 'Recuperar contraseña — Santa S.L.')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-5">
            <div class="card p-4">
                <h4 class="mb-3">Recuperar contraseña</h4>
                <p class="text-muted">Introduce tu correo y te enviaremos un enlace.</p>
                <form method="post" action="{{ url('/password/forgot') }}">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Correo</label>
                        <input type="email" name="email" value="{{ old('email') }}" class="form-control" required>
                    </div>
                    <button class="btn btn-primary w-100">Enviar enlace</button>
                </form>
            </div>
        </div>
    </div>
@endsection
