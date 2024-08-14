@extends('layouts.index')

@section('title', 'Inicio')

@section('content')
@if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

<div class="d-flex justify-content-between align-items-center mb-3">
    <h1>Cities</h1>
    <button data-bs-toggle="modal" data-bs-target="#addModal" class="btn btn-primary">Agregar</button>
</div>

<table class="table table-striped table-bordered">
    <thead class="thead-dark">
        <tr>
            <th>#</th>
            <th>Nombre</th>
            <th>Estado ID</th>
            <th>Acciones</th>
        </tr>
    </thead>   
    <tbody>
        @foreach ($cities as $city)
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $city->name }}</td>
            <td>{{ $city->state_id }}</td>
            <td>
                <a href="{{ route('cities.item', $city->id) }}" class="btn btn-primary btn-sm">Ver</a>
                <button data-id="{{ $city->id }}" data-name="{{ $city->name }}" data-state-id="{{ $city->state_id }}" data-bs-toggle="modal" data-bs-target="#editModal" class="btn btn-success btn-sm" onclick="openEditModal(this)">Editar</button>
                <button data-id="{{ $city->id }}" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deleteModal" onclick="openDeleteModal(this)">Eliminar</button>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection

<!-- Modal Agregar Ciudad -->
<div class="modal fade" id="addModal" tabindex="-1" aria-labelledby="addModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addModalLabel">Agregar Ciudad</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="addForm" method="POST" action="{{ route('cities.store') }}">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="cityNameAdd" class="form-label">Nombre</label>
                        <input type="text" class="form-control" id="cityNameAdd" name="name" required>
                    </div>
                    <div class="mb-3">
                        <label for="stateIdAdd" class="form-label">Estado ID</label>
                        <input type="text" class="form-control" id="stateIdAdd" name="state_id" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-primary">Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Editar Ciudad -->
<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel">Editar Ciudad</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="editForm" method="POST" action="">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="cityName" class="form-label">Nombre</label>
                        <input type="text" class="form-control" id="cityName" name="name" required>
                    </div>
                    <div class="mb-3">
                        <label for="stateId" class="form-label">Estado ID</label>
                        <input type="text" class="form-control" id="stateId" name="state_id" required>
                    </div>
                    <input type="hidden" id="cityId" name="id">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-primary">Guardar cambios</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Confirmación de Eliminación -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteModalLabel">Confirmar Eliminación</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="deleteForm" method="POST" action="">
                @csrf
                @method('DELETE')
                <div class="modal-body">
                    ¿Estás seguro de que quieres eliminar esta ciudad?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-danger">Eliminar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function openEditModal(button) {
    // Obtén los datos del botón
    const id = button.getAttribute('data-id');
    const name = button.getAttribute('data-name');
    const stateId = button.getAttribute('data-state-id');

    // Llena los campos del modal
    document.getElementById('cityId').value = id;
    document.getElementById('cityName').value = name;
    document.getElementById('stateId').value = stateId;

    // Actualiza la acción del formulario con el ID correcto
    const form = document.getElementById('editForm');
    form.action = `{{ url('/cities') }}/${id}`;
}

function openDeleteModal(button) {
    // Obtén el ID de la ciudad a eliminar
    const id = button.getAttribute('data-id');

    // Actualiza la acción del formulario con el ID correcto
    const form = document.getElementById('deleteForm');
    form.action = `{{ url('/cities') }}/${id}`;

    // Abre el modal
    var myModal = new bootstrap.Modal(document.getElementById('deleteModal'));
    myModal.show();
}
</script>
