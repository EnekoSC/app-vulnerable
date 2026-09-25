@extends('layouts.app')

@section('title', 'Administración — Santa S.L.')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="mb-0">Panel de administración</h4>
        <a href="{{ route('admin.usuarios') }}" class="btn btn-outline-secondary btn-sm">Usuarios</a>
    </div>

    <div class="card p-4">
        <h5 class="mb-3">Últimos comentarios (moderación)</h5>
        @forelse($comentarios as $c)
            <div class="border-bottom pb-2 mb-2">
                <div class="small text-muted">
                    {{ $c->autor }} · producto #{{ $c->product_id }} · {{ optional($c->created_at)->format('d/m/Y H:i') }}
                </div>
                <div class="comentario">{!! $c->cuerpo !!}</div>
            </div>
        @empty
            <p class="text-muted mb-0">No hay comentarios.</p>
        @endforelse
    </div>
@endsection
