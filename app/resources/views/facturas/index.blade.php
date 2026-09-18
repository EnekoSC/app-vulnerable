@extends('layouts.app')

@section('title', 'Mis facturas — Santa S.L.')

@section('content')
    <h4 class="mb-3">Mis facturas</h4>

    <div class="card p-3">
        @if($facturas->isEmpty())
            <p class="mb-0">No tienes facturas todavía.</p>
        @else
            <table class="table mb-0">
                <thead><tr><th>Nº</th><th>Concepto</th><th>Fecha</th><th>Importe</th><th></th></tr></thead>
                <tbody>
                @foreach($facturas as $f)
                    <tr>
                        <td>{{ $f->numero }}</td>
                        <td>{{ $f->concepto }}</td>
                        <td>{{ optional($f->created_at)->format('d/m/Y') }}</td>
                        <td>{{ number_format($f->importe, 2, ',', '.') }} €</td>
                        <td>
                            <a href="{{ route('facturas.show', $f->id) }}">ver</a> ·
                            <a href="{{ route('facturas.download', $f->id) }}">PDF</a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        @endif
    </div>
@endsection
