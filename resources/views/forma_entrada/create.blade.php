@include('componentes.header')
<div class="container">
<form action="{{url('/forma_entrada')}}" method="post">
@csrf
@include('forma_entrada.form',['e'=>'Crear'])
</form>
</div>