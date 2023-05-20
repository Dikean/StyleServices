@extends('layouts.panel')

@section('content')

<div class="card shadow">
    <div class="card-header border-0">
        <div class="row align-items-center">
            <div class="col">
                <h3 class="mb-0">Cancelar cita</h3>
            </div>
            <div class="col text-right">
                  <a href="{{ url('/miscitas')}}" class="btn btn-sm btn-success">Regresar</a>
                  <i class="fas fa-chevron-left"></i>
                </div>
        </div>
    </div>
    <div class="card-body">
        @if(session('notification'))
        <div class="alert alert-success" role="alert">
            {{ session('notification')}}
        </div>
        @endif
        @if($role == 'cliente')
        <p>Se cancelara tu cita reservada con el medico <b>{{$appointment->estilista->name}}</b>
            (servicio <b>{{$appointment->services->name}}</b>)
            para el dia <b>{{$appointment->scheduled_date}}</b>
        </p>
        @elseif($role == 'estilista')
        <p>Se cancelara la cita medica del paciente <b>{{$appointment->cliente->name}}</b>
            (servicio <b>{{$appointment->services->name}}</b>)
            para el dia <b>{{$appointment->scheduled_date}}</b>
            , la hora <b>{{$appointment->scheduled_time}}</b>
        </p>
        @else
        <p>Se cancelara la cita medica del paciente <b>{{$appointment->cliente->name}}</b>
        que sera atendido por el estilista <b>{{$appointment->estilista->name}}</b>
            (servicio <b>{{$appointment->services->name}}</b>)
            para el dia <b>{{$appointment->scheduled_date}}</b>
            , la hora <b>{{$appointment->scheduled_time}}</b>
        </p>
        @endif
        <form action="{{ url('/miscitas/'. $appointment->id. '/cancel') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="justification">Ponga los motivos de la cancelacion:</label>
                <textarea name="justification" id="justification" rows="3" class="form-control" required></textarea>
            </div>
            <button class=
            "btn btn-danger" type="submit">Cancelar cita</button>
        </form>

  
    </div>

</div>


@endsection