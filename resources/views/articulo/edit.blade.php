@include('componentes.header')
<div class="container">
<form action="{{url('/articulo/'.$articulo->id)}}" method="post">
@csrf
{{ method_field('PATCH')}}
@include('articulo.form' ,['e'=>'Editar'])

</form>
</div>