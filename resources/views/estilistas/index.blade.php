@extends('layouts.panel')

@section('content')

    <div class="card shadow">
            <div class="card-header border-0">
              <div class="row align-items-center">
                <div class="col">
                  <h3 class="mb-0">Estilistas</h3>
                </div>
                <div class="col text-right">
                  <a href="{{ url('/estilistas/create')}}" class="btn btn-sm btn-primary">Nuevo Estilista</a>
                </div>
              </div>
            </div>
            <div class="card-body">
                @if(session('notification'))
                <div class="alert alert-success" role="alert">
                 {{ session('notification')}}
                </div>

                @endif
            </div>
            <div class="table-responsive">
              <!-- Projects table -->
              <table class="table align-items-center table-flush">
                <thead class="thead-light">
                  <tr>
                    <th scope="col">Nombre</th>
                    <th scope="col">Correo</th>
                    <th scope="col">Cedula</th>
                    <th scope="col">Opciones</th>
                  </tr>
                </thead>
                <tbody>
                    @foreach($estilistas as $estilista)
                  <tr>
                    <th scope="row">
                      {{$estilista->name}}
                    </th>
                    <td>
                    {{$estilista->email}}
                    </td>
                    <td>
                    {{$estilista->cedula}}
                    </td>
                    <td>
                     
                      <form action="{{url('/estilistas/'.$estilista->id)}}" method="POST">
                          @csrf
                          @method('DELETE')
                          <a href="{{url('/estilistas/'.$estilista->id.'/edit')}}" class="btn btn-sm btn-primary">Editar</a>
                          <button type="submit" class="btn btn-sm btn-danger">Eliminar</button>
                      </form>
                     
                    </td>
                    
                  </tr>
                  </tr>
                  @endforeach
                </tbody>
              </table>
            </div>
            <div class="card-body">
              {{ $estilistas->Links() }}
            </div>
          </div>
        
      
@endsection
