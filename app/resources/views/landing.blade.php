@extends('layouts.app')

@section('title', 'Distribuciones Santa S.L. — Portal de distribuidores')

@section('content')
    <div class="p-5 mb-4 bg-white rounded-3 text-center">
        <h1 class="display-6 fw-bold">Portal de distribuidores</h1>
        <p class="lead col-md-8 mx-auto">
            Distribuciones Santa S.L. — mayorista de juguetes y artículos de temporada.
            Consulta el catálogo, gestiona tus pedidos y descarga tus facturas.
        </p>
        <div class="mt-3">
            <a href="{{ route('login') }}" class="btn btn-primary btn-lg">Acceder</a>
            <a href="{{ route('register') }}" class="btn btn-outline-secondary btn-lg">Alta de cliente</a>
        </div>
    </div>

    <div class="row g-3">
        <div class="col-md-4">
            <div class="card p-3 h-100">
                <h5>Catálogo mayorista</h5>
                <p class="text-muted mb-0">Miles de referencias de temporada listas para tu tienda.</p>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card p-3 h-100">
                <h5>Facturación</h5>
                <p class="text-muted mb-0">Descarga tus facturas en PDF cuando las necesites.</p>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card p-3 h-100">
                <h5>Atención al distribuidor</h5>
                <p class="text-muted mb-0">Un equipo dedicado para tu negocio todo el año.</p>
            </div>
        </div>
    </div>
@endsection
