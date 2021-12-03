@include('componentes.header')
Marcas
<div class="container">
<form action="{{url('/marca')}}" method="post">
@csrf
@include('marca.form',['e'=>'Crear'])
</form>
</div>