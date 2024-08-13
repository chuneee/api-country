<h1> Countries</h1>

<table>
    <thead>
        <tr>
            <th>#</th>
            <th>nombre</th>
            <th>continente</th>
            <th>Poblacion</th>
            <th>idioma</th>
            <th>moneda</th>
            <th>capital</th>
            <th>acciones</th>
        </tr>
    </thead>   
    <tbody>
        @foreach ($countries as $country)
        <tr>
            <td>{{ $loop->index + 1}}</td>
            <td>{{ $country->name}}</td>
            <td>{{ $country->continent}}</td>
            <td>{{ $country->population}}</td>
            <td>{{ $country->language}}</td>
            <td>{{ $country->currency}}</td>
            <td>{{ $country->capital}}</td>
            <td><button>Agregar</button></td>
            <td><a href="{{ route('countries.item', $country->id) }}">Ver</a></td>
            <td><button>Eliminar</button></td>
        </tr>
        @endforeach
    </tbody>
</table>
