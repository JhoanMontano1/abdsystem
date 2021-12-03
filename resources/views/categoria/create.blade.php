@include('componentes.header')
<div class="container">
<form action="{{url('/categoria')}}" method="post">
@csrf
@include('categoria.form',['e'=>'Crear'])
</form>
</div>