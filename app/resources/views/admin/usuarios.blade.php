@extends('layouts.app')

@section('title', 'Usuarios — Administración')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="mb-0">Usuarios</h4>
        <a href="{{ route('admin.index') }}" class="btn btn-outline-secondary btn-sm">← Panel</a>
    </div>

    <div class="card p-3">
        <table class="table mb-0">
            <thead><tr><th>ID</th><th>Nombre</th><th>Correo</th><th>Rol</th><th>Admin</th></tr></thead>
            <tbody>
            @foreach($usuarios as $u)
                <tr>
                    <td>{{ $u->id }}</td>
                    <td>{{ $u->name }}</td>
                    <td>{{ $u->email }}</td>
                    <td>{{ $u->role }}</td>
                    <td>{{ $u->is_admin ? 'sí' : 'no' }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection
