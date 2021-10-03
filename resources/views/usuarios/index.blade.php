@extends('layouts.app')

@section('content')
<div class="container">


    @if(Session::has('mensaje'))
    <div class="alert alert-primary alert-dismissible fade show" role="alert">
        {{ Session::get('mensaje') }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>

    </div>
    @endif




    <a href="{{ url('usuarios/create') }}" class="btn btn-outline-info">Registrar un Nuevo Usuario</a>

    <br />
    <br />
    <div class="col-md-12 table-responsive-lg">
        <table class="table table-light">

            <thead class="thead-light">
                <tr>
                    <th>#</th>
                    <th>foto</th>
                    <th>nombres</th>
                    <th>apellidos</th>
                    <th>telefono</th>
                    <th>correo</th>
                    <th>Estado</th>
                    <th>Acciones</th>
                </tr>
            </thead>

            <tbody>
                @foreach($usuarios as $usuario)
                <tr>
                    <td>{{ $usuario->id }} </td>

                    <td>
                        <img src=" {{ asset('storage').'/'.$usuario->Foto }}" width="100" alt="" class="img-thumbnail imgfluid">

                    </td>

                    <td>{{ $usuario->Nombres }}</td>
                    <td>{{ $usuario->Apellidos }}</td>
                    <td>{{ $usuario->Telefono }}</td>
                    <td>{{ $usuario->Correo }}</td>

                    <td>
                        <br>
                        @if ($usuario->Estatus == "Activo")
                        <a href=" {{ url('/cambiar-Estatus/'.$usuario->id)}} "><button type="button" class="btn btn-outline-success">Activa</button></a>
                        @else
                        <a href="{{ url('/cambiar-Estatus/'.$usuario->id)}}"><button type="button" class="btn btn-outline-danger">Inactiva</button></a>
                        @endif
                    </td>
                    <td>
                        <br>

                        <a class="btn btn-outline-warning" href=" {{url('/usuarios/'.$usuario->id.'/edit') }} ">
                            Editar
                        </a>

                        <form action="{{url('/usuarios/'.$usuario->id )}}" class="d-inline " method="post">
                            @csrf

                            {{method_field('DELETE')}}

                            <input class="btn btn-outline-secondary" type="submit" onclick="return confirm('¿Quieres borrar? ')" value="Borrar">

                        </form>

                    </td>
                </tr>
                @endforeach

            </tbody>
        </table>

    </div>
    {{ $usuarios->links() }}
</div>
@endsection