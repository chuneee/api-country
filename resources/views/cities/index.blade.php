<h1> Cities</h1>

<table>
    <thead>
        <tr>
            <th>#</th>
            <th>Nombre</th>
            <th>Estado id</th>
            <th>acciones</th>
        </tr>
    </thead>   
    <tbody>
        @foreach ($cities as $city)
        <tr>
            <td>{{ $loop->index + 1}}</td>
            <td>{{ $city->name}}</td>
            <td>{{ $city->state_id}}</td>
            <td><button>Agregar</button></td>
            <td><a href="{{ route('cities.item', $city->id) }}">Ver</a></td>
            <td><button>Eliminar</button></td>
        </tr>
        @endforeach
    </tbody>
</table>