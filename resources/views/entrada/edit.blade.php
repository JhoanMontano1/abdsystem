@include('componentes.header')
<div class="container">
<form action="{{url('/entrada/'.$entrada->id)}}" method="post">
@csrf
{{ method_field('PATCH')}}
@include('entrada.form' ,['e'=>'Editar'])

</form>
</div>