@include('componentes.header')
<div class="container">
<form action="{{url('/marca/'.$marca->id)}}" method="post">
@csrf
{{ method_field('PATCH')}}
@include('marca.form' ,['e'=>'Editar'])

</form>
</div>