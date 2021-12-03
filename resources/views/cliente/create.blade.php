@include('componentes.header')
<div class="container">
<form action="{{url('/cliente')}}" method="post">
@csrf
@include('cliente.form',['e'=>'Crear'])
</form>
</div>