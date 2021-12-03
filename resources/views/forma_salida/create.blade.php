@include('componentes.header')
<div class="container">
<form action="{{url('/forma_salida')}}" method="post">
@csrf
@include('forma_salida.form',['e'=>'Crear'])
</form>
</div>