@extends('layouts.app')

@section('title', 'Mi avatar — Santa S.L.')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-7">
            @if(session('preview'))
                <div class="card p-3 mb-3">
                    <h6 class="text-muted">Vista previa de lo importado</h6>
                    <pre class="mb-0" style="white-space:pre-wrap;">{{ session('preview') }}</pre>
                </div>
            @endif

            <div class="card p-4">
                <h4 class="mb-3">Subir avatar</h4>
                <form method="post" action="{{ route('avatar.store') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <input type="file" name="avatar" class="form-control" required>
                    </div>
                    <button class="btn btn-primary">Subir</button>
                </form>
            </div>

            <div class="card p-4 mt-3">
                <h5 class="mb-3">Importar avatar desde una URL</h5>
                <form method="post" action="{{ route('avatar.importar') }}">
                    @csrf
                    <div class="input-group">
                        <input type="text" name="url" class="form-control" placeholder="https://...">
                        <button class="btn btn-outline-secondary">Importar</button>
                    </div>
                </form>
            </div>

            @if($subidas->isNotEmpty())
                <div class="card p-4 mt-3">
                    <h6 class="text-muted">Tus archivos subidos</h6>
                    <ul class="mb-0">
                        @foreach($subidas as $s)
                            <li><a href="{{ url($s->ruta) }}" target="_blank">{{ $s->nombre_original }}</a></li>
                        @endforeach
                    </ul>
                </div>
            @endif
        </div>
    </div>
@endsection
