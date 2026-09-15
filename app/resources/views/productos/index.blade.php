@extends('layouts.app')

@section('title', 'Catálogo — Santa S.L.')

@section('content')
    <h4 class="mb-3">Catálogo</h4>

    <form method="get" action="{{ route('productos.index') }}" class="mb-3">
        <div class="input-group">
            <input type="text" name="q" value="{{ $q }}" class="form-control" placeholder="Buscar producto por nombre...">
            <button class="btn btn-primary">Buscar</button>
        </div>
    </form>

    <div class="row g-3">
        @forelse($productos as $p)
            <div class="col-md-4">
                <div class="card p-3 h-100">
                    <h5>{{ $p->nombre }}</h5>
                    <p class="text-muted small">{{ $p->descripcion }}</p>
                    <div class="mt-auto d-flex justify-content-between align-items-center">
                        <span class="fw-bold">{{ number_format($p->precio, 2, ',', '.') }} €</span>
                        <a href="{{ route('productos.show', $p->id) }}" class="btn btn-sm btn-outline-secondary">Ver</a>
                    </div>
                </div>
            </div>
        @empty
            <p>No se han encontrado productos.</p>
        @endforelse
    </div>
@endsection
