@extends('layouts.index')

@section('title', 'Inicio')

@section('content')

<h1> States </h1>

<table>
    <thead>
        <tr>
            <th>#</th>
            <th>Nombre</th>
            <th>Ciudad id</th>
            <th>acciones</th>
        </tr>
    </thead>   
    <tbody>
        @foreach ($states as $state)
        <tr>
            <td>{{ $loop->index + 1}}</td>
            <td>{{ $state->name}}</td>
            <td>{{ $state->country_id}}</td>
            <td><button>Agregar</button></td>
            <td><a href="{{ route('states.item', $state->id) }}">Ver</a></td>
            <td><button>Eliminar</button></td>
        </tr>
        @endforeach
    </tbody>
</table>

@endsection