@include('componentes.header')
<div class="container">
<form action="{{url('/forma_salida/'.$forma_salida->id)}}" method="post">
@csrf
{{ method_field('PATCH')}}
@include('forma_salida.form' ,['e'=>'Editar'])

</form>
</div>