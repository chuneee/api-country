@extends('layouts.index')

@section('title', 'Inicio')

@section('content')
    <h1>Countries</h1>

    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Nombre</th>
                <th>Continente</th>
                <th>Población</th>
                <th>Idioma</th>
                <th>Moneda</th>
                <th>Capital</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($countries as $country)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $country->name }}</td>
                    <td>{{ $country->continent }}</td>
                    <td>{{ $country->population }}</td>
                    <td>{{ $country->language }}</td>
                    <td>{{ $country->currency }}</td>
                    <td>{{ $country->capital }}</td>
                    <td><button>Agregar</button></td>
                    <td><a href="{{ route('countries.item', $country->id) }}">Ver</a></td>
                    <td><button>Eliminar</button></td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Paginación -->
    {{ $countries->links() }}
@endsection
