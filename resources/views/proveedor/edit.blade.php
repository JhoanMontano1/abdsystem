@include('componentes.header')
<div class="container">
<form action="{{url('/proveedor/'.$proveedor->id)}}" method="post">
@csrf
{{ method_field('PATCH')}}
@include('proveedor.form' ,['e'=>'Editar'])

</form>
</div>