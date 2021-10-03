


<form action="{{ url('/usuarios')}}"  method="POST" enctype="multipart/form-data">
@csrf

@include('usuarios.form',['modo'=>'Crear']);
</form>