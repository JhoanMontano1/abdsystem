@include('componentes.header')
<div class="container">
<form action="{{url('/forma_entrada/'.$forma_entrada->id)}}" method="post">
@csrf
{{ method_field('PATCH')}}
@include('forma_entrada.form' ,['e'=>'Editar'])

</form>
</div>