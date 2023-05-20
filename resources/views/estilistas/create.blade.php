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
                  <h3 class="mb-0">Nuevo Estilista</h3>
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
                <form action="{{ url('/estilistas')}}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="name">Nombre del Estilista</label>
                        <input type="text" name="name" class="form-control" value="{{ old('name') }}" required>
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
                        <input type="text" name="email" class="form-control" value="{{ old('email') }}">
                    </div>
                    <div class="form-group">
                        <label for="cedula">Cedula</label>
                        <input type="text" name="cedula" class="form-control" value="{{ old('cedula') }}">
                    </div>
                    <div class="form-group">
                        <label for="address">Direccion</label>
                        <input type="text" name="address" class="form-control" value="{{ old('address') }}">
                    </div>
                    <div class="form-group">
                        <label for="phone">Telefono / Movil</label>
                        <input type="text" name="phone" class="form-control" value="{{ old('phone') }}">
                    </div>
                    <div class="form-group">
                        <label for="password">Contraseña</label>
                        <input type="text" name="password" class="form-control" value="{{ old('password', Str::random(8)) }}">
                    </div>
                    <button type="submit" class="btn btn-sm btn-primary">Crear estilista</button>
                </form>
           </div>
          </div>
        
      
@endsection

@section('scripts')

<!-- Latest compiled and minified JavaScript -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/js/bootstrap-select.min.js"></script>
@endsection