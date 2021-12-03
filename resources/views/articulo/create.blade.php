@include('componentes.header')
<div class="container">
<form action="{{url('/articulo')}}" method="post">
@csrf
@include('articulo.form',['e'=>'Crear'])
</form>
</div>