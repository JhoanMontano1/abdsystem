@include('componentes.header')
<div class="container">
<form action="{{url('/cliente/'.$cliente->id)}}" method="post">
@csrf
{{ method_field('PATCH')}}
@include('cliente.form' ,['e'=>'Editar'])

</form>
</div>