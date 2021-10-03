@extends('layouts.app')

@section('content')
<div class="container">


    <h1>{{ $modo }} Usuario </h1>

    @if(count($errors)>0)

    <div class="alert alert-danger" role="alert">
        <ul>
            @foreach( $errors->all() as $error)
            <li>{{ $error }} </li>
            @endforeach
        </ul>

    </div>

    @endif


    <div class="form-group">
        <label for="nombres"> Nombres </label>
        <input type="text" class="form-control" name="Nombres" value="{{ isset($usuarios->Nombres)? $usuarios->Nombres:old('Nombres') }}" id="nombres">
    </div>

    <div class="form-group">
        <label for="apellidos"> Apellidos </label>
        <input type="text" class="form-control" name="Apellidos" value="{{ isset($usuarios->Apellidos)? $usuarios->Apellidos:old('Apellidos') }}" id="apellidos">
    </div>

    <div class="form-group">
        <label for="telefono"> Telefono </label>
        <input type="number" class="form-control" name="Telefono" value="{{ isset($usuarios->Telefono)? $usuarios->Telefono:old('Telefono') }}" id="telefono">
    </div>

    <div class="form-group">
        <label for="correo"> Correo </label>
        <input type="text" class="form-control" name="Correo" value="{{ isset($usuarios->Correo)?$usuarios->Correo:old('Correo') }}"" id=" correo">
    </div>

    <div class="form-group">
        <label for="Foto"></label>
        @if(isset($usuarios->Foto))
        <img class="btn btn-outline-warning" src=" {{ asset('storage').'/'.$usuarios->Foto }}" width="100" alt="">
        @endif
        <input type="file" class="form-control" name="Foto" value='' id="Foto">

    </div>

    <input type="submit" class="btn btn-outline-success" value="{{ $modo }} datos">

    <a class="btn btn-outline-info" href="{{ url('usuarios/') }}">Regresar</a>
    <br>

</div>
@endsection