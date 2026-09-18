@extends('layouts.app')

@section('title', 'Factura '.$factura->numero)

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card p-4">
                <div class="d-flex justify-content-between">
                    <h4>Factura {{ $factura->numero }}</h4>
                    <a href="{{ route('facturas.download', $factura->id) }}" class="btn btn-sm btn-primary">Descargar PDF</a>
                </div>
                <hr>
                <p><strong>Concepto:</strong> {{ $factura->concepto }}</p>
                <p><strong>Fecha:</strong> {{ optional($factura->created_at)->format('d/m/Y') }}</p>
                <p><strong>Importe:</strong> {{ number_format($factura->importe, 2, ',', '.') }} €</p>
                <p class="text-muted mb-0">Cliente #{{ $factura->user_id }}</p>
            </div>
            <a href="{{ route('facturas.index') }}" class="btn btn-link mt-2">← Volver</a>
        </div>
    </div>
@endsection
