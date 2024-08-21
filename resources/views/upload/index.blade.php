@extends('layouts.index')

@section('title', 'Subir SQL')

@section('content')
@if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

@if(session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
@endif

<h1>Subir SQL</h1>

<form action="{{ route('upload.inserts') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="mb-3">
        <label for="sql_file" class="form-label">Seleccionar archivo SQL</label>
        <input type="file" class="form-control" id="sql_file" name="sql_file" required>
    </div>
    <button type="submit" class="btn btn-primary">Subir Archivo</button>
</form>
@endsection
