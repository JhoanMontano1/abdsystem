@include('componentes.header')
<div class="container">
<form action="{{url('/salida/'.$salida->id)}}" method="post">
@csrf
{{ method_field('PATCH')}}
@include('salida.form' ,['e'=>'Editar'])

</form>
</div>