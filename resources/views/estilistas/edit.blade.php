<?php

use Illuminate\Support\Str;

?>


@extends('layouts.panel')

@section('styles')
<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/css/bootstrap-select.min.css">

@endsection

@section('content')

    <div class="card shadow">
            <div class="card-header border-0">
              <div class="row align-items-center">
                <div class="col">
                  <h3 class="mb-0">Editar Estilista</h3>
                </div>
                <div class="col text-right">
                  <a href="{{ url('/estilistas')}}" class="btn btn-sm btn-success">Regresar</a>
                  <i class="fas fa-chevron-left"></i>
                </div>
              </div>
            </div>
           <div class="card-body">

            @if($errors->any())
              @foreach($errors->all() as $error)
                <div class="alert alert-danger" role="alert">
                  <i class="fas fa-exclamation-triangle"></i>
                  <strong>Por favor!</strong> {{ $error }}
                </div>


              @endforeach
            @endif
                <form action="{{ url('/estilistas/'.$estilista->id)}}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                        <label for="name">Nombre del Estilista</label>
                        <input type="text" name="name" class="form-control" value="{{ old('name', $estilista->name) }}">
                    </div>
                    <div class="form-group">
                      <label for="services">Servicios</label>
                      <select name="services[]" id="services" class="form-control selectpicker"
                      data-style="btn-primary" title="Seleccionar Servicios" multiple required>
                        @foreach ($services as $service)
                          <option value="{{ $service->id }}">{{ $service->name }}</option>
                        @endforeach
                    </select>
                    </div>
                    <div class="form-group">
                        <label for="email">Correo electronico</label>
                        <input type="text" name="email" class="form-control" value="{{ old('email', $estilista->email) }}">
                    </div>
                    <div class="form-group">
                        <label for="cedula">Cedula</label>
                        <input type="text" name="cedula" class="form-control" value="{{ old('cedula', $estilista->cedula) }}">
                    </div>
                    <div class="form-group">
                        <label for="address">Direccion</label>
                        <input type="text" name="address" class="form-control" value="{{ old('address', $estilista->address) }}">
                    </div>
                    <div class="form-group">
                        <label for="phone">Telefono / Movil</label>
                        <input type="text" name="phone" class="form-control" value="{{ old('phone', $estilista->phone) }}">
                    </div>
                    <div class="form-group">
                        <label for="password">Contraseña</label>
                        <input type="text" name="password" class="form-control">
                        <small class="text-warning">Solo llene el campo si desea cambiar la contraseña</small>
                    </div>
                    <button type="submit" class="btn btn-sm btn-primary">Guardar Cambios</button>
                </form>
           </div>
          </div>
        
      
@endsection

@section('scripts')

<!-- Latest compiled and minified JavaScript -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/js/bootstrap-select.min.js"></script>

<script>
  $(document).ready(()=> {});
  $('#services').selectpicker('val', @JSON($services_ids));
</script>
@endsection
