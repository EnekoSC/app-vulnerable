@extends('layouts.app')

@section('title', $producto->nombre.' — Santa S.L.')

@section('content')
    <div class="row">
        <div class="col-md-8">
            <div class="card p-4">
                <h4>{{ $producto->nombre }}</h4>
                <p class="text-muted">{{ $producto->descripcion }}</p>
                <p class="fw-bold fs-5">{{ number_format($producto->precio, 2, ',', '.') }} €</p>
                <p class="small text-muted">Stock: {{ $producto->stock }} uds.</p>
            </div>

            <div class="card p-4 mt-3">
                <h5 class="mb-3">Comentarios</h5>

                @forelse($comentarios as $c)
                    <div class="border-bottom pb-2 mb-2">
                        <div class="small text-muted">{{ $c->autor }} · {{ optional($c->created_at)->format('d/m/Y') }}</div>
                        <div class="comentario">{!! $c->cuerpo !!}</div>
                    </div>
                @empty
                    <p class="text-muted">Sé el primero en comentar.</p>
                @endforelse

                <form method="post" action="{{ route('productos.comentar', $producto->id) }}" class="mt-3">
                    @csrf
                    <div class="mb-2">
                        <textarea name="cuerpo" rows="3" class="form-control" placeholder="Escribe tu comentario..." required></textarea>
                    </div>
                    <button class="btn btn-primary btn-sm">Publicar</button>
                </form>
            </div>
        </div>
        <div class="col-md-4">
            <a href="{{ route('productos.index') }}" class="btn btn-link">← Volver al catálogo</a>
        </div>
    </div>
@endsection
