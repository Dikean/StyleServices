<?php

use Illuminate\Support\Str;

?>
@extends('layouts.panel')

@section('content')

<div class="card shadow">
    <div class="card-header border-0">
        <div class="row align-items-center">
            <div class="col">
                <h3 class="mb-0">Registrar nueva cita</h3>
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
        <form action="{{ url('/reservarcitas')}}" method="POST">
            @csrf

            <div class="form-row">
            <div class="form-group col-md-6">
                <label for="service">Servicio</label>
                <select name="services_id" id="service" class="form-control">
                    <option value="">Seleccionar Servicio</option>
                @foreach ($services as $service)
                    <option value="{{ $service->id }}"
                    @if(old('services_id') == $service->id) selected @endif>{{ $service->name }}</option>
                @endforeach
                </select>
            </div>
            <div class="form-group col-md-6">
                <label for="estilista">Estilista</label>
                <select name="estilista_id" id="estilista" class="form-control" required>
                @foreach ($estilistas as $estilista)
                    <option value="{{ $estilista->id }}"
                    @if(old('estilista_id') == $estilista->id) selected @endif>
                    {{ $estilista->name }}</option>
                @endforeach
                </select>
            </div>
            </div>
          
            <div class="form-group">
                <label for="date">Fecha</label>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="ni ni-calendar-grid-58"></i></span>
                    </div>
                    <input class="form-control datepicker" 
                    id="date" name="scheduled_date"
                    placeholder="Seleccionar fecha" type="date" 
                    value="{{ old('scheduled_date'), date('Y-m-d' ) }}" 
                    data-date-format="yyyy-mm-dd"
                    data-date-start-date="{{ date('Y-m-d') }}" 
                    data-date-end-date="+30d">
                </div>
            </div>
            <div class="form-group">
                <label for="hours">Hora de atencion</label>
                    <div class="container">
                        <div class="row">
                            <div class="col">
                                <h4 class="m-3" id="titleMorning"></h4>
                                <div id="hoursMornings">
                                    @if($intervals)
                                        @foreach($intervals['mornings'] as $key => $interval)
                                        <div class="custom-control custom-radio mb-3">
                                            <input type="radio" id="intervalMorning{{ $key }}" name="scheduled_time" value="{{ $interval['start'] }}" class="custom-control-input">
                                            <label class="custom-control-label" for="intervalMornin}} g{{ $key }}">{{ $interval['start'] }} - {{ $interval['end'] }}</label>
                                        </div>

                                        @endforeach
                                    @else 
                                    <mark>
                                        <small class="text-warning display-5">
                                            Selleciona un medico y una fecha, para ver las horas.
                                        </small>
                                    </mark>

                                    @endif
                                </div>
                            </div>
                            <div class="col">
                                <h4 class="m-3" id="titleAfternoon"></h4>
                                <div id="hoursAfternoon">
                                @if($intervals)
                                        @foreach($intervals['afternoon'] as $key => $interval)
                                        <div class="custom-control custom-radio mb-3">
                                            <input type="radio" id="intervalAfternoon{{ $key }}" name="scheduled_time" value="{{ $interval['start'] }}" class="custom-control-input">
                                            <label class="custom-control-label" for="intervalAfternoon{{ $key }}">{{ $interval['start'] }}- {{ $interval['end']  }}</label>
                                        </div>

                                        @endforeach
                                        @endif
                                </div>
                            </div>
                            
                        </div>
                    </div>
            <div>
          
            <button type="submit" class="btn btn-sm btn-primary mt-5">Guardar</button>
        </form>
    </div>
</div>


@endsection

@section('scripts')
<script src="{{ asset('js/plugins/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js')}}"></script>

<script src="{{ asset('/js/appointments/create.js')}}"></script>
@endsection