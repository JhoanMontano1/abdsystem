@include('componentes.header')
<div class="container">
<form action="{{url('/forma_pago')}}" method="post">
@csrf
@include('forma_pago.form',['e'=>'Crear'])
</form>
</div>