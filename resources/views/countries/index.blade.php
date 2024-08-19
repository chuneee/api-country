@extends('layouts.index')

@section('title', 'Inicio')

@section('content')
@if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

<div class="d-flex justify-content-between align-items-center mb-3">
    <h1>Countries</h1>
    <button data-bs-toggle="modal" data-bs-target="#addModal" class="btn btn-primary">Agregar</button>
</div>

<table class="table table-striped table-bordered">
    <thead class="thead-dark">
        <tr>
            <th>#</th>
            <th>Nombre</th>
            <th>Continente</th>
            <th>Población</th>
            <th>Idioma</th>
            <th>Moneda</th>
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
            <td>
            <a href="#" class="btn btn-primary btn-sm" data-name="{{ $country->name }}" data-continent="{{ $country->continent }}" data-population="{{ $country->population }}" data-language="{{ $country->language }}" data-currency="{{ $country->currency }}" data-capital="{{ $country->capital }}" data-bs-toggle="modal" data-bs-target="#viewModal" onclick="openViewModal(this)">Ver</a>
            <button data-id="{{ $country->id }}" data-name="{{ $country->name }}" data-continent="{{ $country->continent }}" data-population="{{ $country->population }}" data-language="{{ $country->language }}" data-currency="{{ $country->currency }}" data-capital="{{ $country->capital }}" data-bs-toggle="modal" data-bs-target="#editModal" class="btn btn-success btn-sm" onclick="openEditModal(this)">Editar</button>
            <button data-id="{{ $country->id }}" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deleteModal" onclick="openDeleteModal(this)">Eliminar</button>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

<!-- Paginación -->
<div class="row mt-3">
    <div class="col text-center"> 
        {!! $countries->withQueryString()->links('pagination::bootstrap-5') !!}
    </div>
</div>
@endsection

<!-- Modal Agregar País -->
<div class="modal fade" id="addModal" tabindex="-1" aria-labelledby="addModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addModalLabel">Agregar País</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="addForm" method="POST" action="{{ route('countries.store') }}">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="countryNameAdd" class="form-label">Nombre</label>
                        <input type="text" class="form-control" id="countryNameAdd" name="name" required>
                    </div>
                    <div class="mb-3">
                        <label for="continentAdd" class="form-label">Continente</label>
                        <input type="text" class="form-control" id="continentAdd" name="continent" required>
                    </div>
                    <div class="mb-3">
                        <label for="populationAdd" class="form-label">Población</label>
                        <input type="number" class="form-control" id="populationAdd" name="population" required>
                    </div>
                    <div class="mb-3">
                        <label for="languageAdd" class="form-label">Idioma</label>
                        <input type="text" class="form-control" id="languageAdd" name="language" required>
                    </div>
                    <div class="mb-3">
                        <label for="currencyAdd" class="form-label">Moneda</label>
                        <input type="text" class="form-control" id="currencyAdd" name="currency" required>
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

<!-- Modal Editar País -->
<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel">Editar País</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="editForm" method="POST" action="">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="countryName" class="form-label">Nombre</label>
                        <input type="text" class="form-control" id="countryName" name="name" required>
                    </div>
                    <div class="mb-3">
                        <label for="continent" class="form-label">Continente</label>
                        <input type="text" class="form-control" id="continent" name="continent" required>
                    </div>
                    <div class="mb-3">
                        <label for="population" class="form-label">Población</label>
                        <input type="number" class="form-control" id="population" name="population" required>
                    </div>
                    <div class="mb-3">
                        <label for="language" class="form-label">Idioma</label>
                        <input type="text" class="form-control" id="language" name="language" required>
                    </div>
                    <div class="mb-3">
                        <label for="currency" class="form-label">Moneda</label>
                        <input type="text" class="form-control" id="currency" name="currency" required>
                    </div>
                    <input type="hidden" id="countryId" name="id">
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
                    ¿Estás seguro de que quieres eliminar este país?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-danger">Eliminar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal para ver el país -->
<div class="modal fade" id="viewModal" tabindex="-1" aria-labelledby="viewModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="viewModalLabel">Detalles del País</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p><strong>Nombre:</strong> <span id="countryNameView"></span></p>
                <p><strong>Continente:</strong> <span id="continentView"></span></p>
                <p><strong>Población:</strong> <span id="populationView"></span></p>
                <p><strong>Idioma:</strong> <span id="languageView"></span></p>
                <p><strong>Moneda:</strong> <span id="currencyView"></span></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>

<script>
function openEditModal(button) {
    var country = button.dataset;
    document.getElementById('editForm').action = '/countries/' + country.id;
    document.getElementById('countryName').value = country.name;
    document.getElementById('continent').value = country.continent;
    document.getElementById('population').value = country.population;
    document.getElementById('language').value = country.language;
    document.getElementById('currency').value = country.currency;
}

function openDeleteModal(button) {
    var countryId = button.dataset.id;
    document.getElementById('deleteForm').action = '/countries/' + countryId;
}

function openViewModal(button) {
    var country = button.dataset;
    document.getElementById('countryNameView').innerText = country.name;
    document.getElementById('continentView').innerText = country.continent;
    document.getElementById('populationView').innerText = country.population;
    document.getElementById('languageView').innerText = country.language;
    document.getElementById('currencyView').innerText = country.currency;
}
</script>
