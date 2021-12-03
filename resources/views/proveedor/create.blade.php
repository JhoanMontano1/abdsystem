@include('componentes.header')
<div class="container">
<form action="{{url('/proveedor')}}" method="post">
@csrf
@include('proveedor.form',['e'=>'Crear'])
</form>
</div>