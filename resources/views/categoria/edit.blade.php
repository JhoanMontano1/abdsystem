@include('componentes.header')
<div class="container">
<form action="{{url('/categoria/'.$categoria->id)}}" method="post">
@csrf
{{ method_field('PATCH')}}
@include('categoria.form' ,['e'=>'Editar'])

</form>
</div>