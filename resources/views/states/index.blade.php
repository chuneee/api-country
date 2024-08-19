@extends('layouts.index')

@section('title', 'Paises')

@section('content')
@if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

<div class="d-flex justify-content-between align-items-center mb-3">
    <h1>States</h1>
    <button data-bs-toggle="modal" data-bs-target="#addModal" class="btn btn-primary">Agregar</button>
</div>

<table class="table table-striped table-bordered">
    <thead class="thead-dark">
        <tr>
            <th>#</th>
            <th>Nombre</th>
            <th>Ciudad ID</th>
            <th>Acciones</th>
        </tr>
    </thead>   
    <tbody>
        @foreach ($states as $state)
        <tr>
            <td>{{ $loop->index + 1}}</td>
            <td>{{ $state->name}}</td>
            <td>{{ $state->country_id}}</td>
            <td>
            <a href="#" class="btn btn-primary btn-sm" data-name="{{ $state->name }}" data-country-id="{{ $state->country_id }}" data-bs-toggle="modal" data-bs-target="#viewModal" onclick="openViewModal(this)">Ver</a>
            <button data-id="{{ $state->id }}" data-name="{{ $state->name }}" data-country-id="{{ $state->country_id }}" data-bs-toggle="modal" data-bs-target="#editModal" class="btn btn-success btn-sm" onclick="openEditModal(this)">Editar</button>
            <button data-id="{{ $state->id }}" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deleteModal" onclick="openDeleteModal(this)">Eliminar</button>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

<div class="row mt-3">
    <div class="col text-center"> 
        {!! $states->withQueryString()->links('pagination::bootstrap-5') !!}
    </div>
</div>
@endsection


<!-- Modal Agregar Ciudad -->
<div class="modal fade" id="addModal" tabindex="-1" aria-labelledby="addModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addModalLabel">Agregar Estado</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="addForm" method="POST" action="{{ route('states.store') }}">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="stateNameAdd" class="form-label">Nombre</label>
                        <input type="text" class="form-control" id="stateNameAdd" name="name" required>
                    </div>
                    <div class="mb-3">
                        <label for="countryIdAdd" class="form-label">Ciudad ID</label>
                        <input type="text" class="form-control" id="countryIdAdd" name="country_id" required>
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
                <h5 class="modal-title" id="editModalLabel">Editar Estado</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="editForm" method="POST" action="">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="stateName" class="form-label">Nombre</label>
                        <input type="text" class="form-control" id="stateName" name="name" required>
                    </div>
                    <div class="mb-3">
                        <label for="countryId" class="form-label">Pais ID</label>
                        <input type="text" class="form-control" id="countryId" name="country_id" required>
                    </div>
                    <input type="hidden" id="stateId" name="id">
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

<!-- Modal para ver la ciudad -->
<div class="modal fade" id="viewModal" tabindex="-1" aria-labelledby="viewModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="viewModalLabel">Detalles del Estado</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p><strong>Nombre:</strong> <span id="viewStateName"></span></p>
                <p><strong>Ciudad ID:</strong> <span id="viewCountryId"></span></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>


<script>
function openViewModal(button) {
    const name = button.getAttribute('data-name');
    const countryId = button.getAttribute('data-country-id');

    document.getElementById('viewStateName').textContent = name;
    document.getElementById('viewCountryId').textContent = countryId;
}
</script>


<script>
function openEditModal(button) {
    // Obtén los datos del botón
    const id = button.getAttribute('data-id');
    const name = button.getAttribute('data-name');
    const countryId = button.getAttribute('data-country-id');

    // Llena los campos del modal
    document.getElementById('stateId').value = id;
    document.getElementById('stateName').value = name;
    document.getElementById('countryId').value = countryId;

    // Actualiza la acción del formulario con el ID correcto
    const form = document.getElementById('editForm');
    form.action = `{{ url('/states') }}/${id}`;
}

function openDeleteModal(button) {
    // Obtén el ID de la ciudad a eliminar
    const id = button.getAttribute('data-id');

    // Actualiza la acción del formulario con el ID correcto
    const form = document.getElementById('deleteForm');
    form.action = `{{ url('/states') }}/${id}`;

    // Abre el modal
    var myModal = new bootstrap.Modal(document.getElementById('deleteModal'));
    myModal.show();
}
</script>