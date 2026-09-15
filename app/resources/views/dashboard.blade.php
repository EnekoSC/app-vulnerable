@extends('layouts.app')

@section('title', 'Panel — Santa S.L.')

@section('content')
    <h4 class="mb-3">Hola, {{ $user->name }}</h4>

    <div class="row g-3">
        <div class="col-md-8">
            <div class="card p-3">
                <h6 class="text-muted">Últimas facturas</h6>
                @if($facturas->isEmpty())
                    <p class="mb-0">Todavía no tienes facturas.</p>
                @else
                    <table class="table table-sm mb-0">
                        <thead><tr><th>Nº</th><th>Concepto</th><th>Importe</th><th></th></tr></thead>
                        <tbody>
                        @foreach($facturas as $f)
                            <tr>
                                <td>{{ $f->numero }}</td>
                                <td>{{ $f->concepto }}</td>
                                <td>{{ number_format($f->importe, 2, ',', '.') }} €</td>
                                <td><a href="{{ route('facturas.show', $f->id) }}">ver</a></td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                @endif
            </div>
        </div>
        <div class="col-md-4">
            <div class="card p-3">
                <h6 class="text-muted">Tu cuenta</h6>
                <p class="mb-1"><strong>Correo:</strong> {{ $user->email }}</p>
                <p class="mb-1"><strong>Rol:</strong> {{ $user->role }}</p>
                <a href="{{ route('profile') }}" class="btn btn-sm btn-outline-secondary mt-2">Editar perfil</a>
            </div>
        </div>
    </div>
@endsection
