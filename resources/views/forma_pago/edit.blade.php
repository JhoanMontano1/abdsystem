@include('componentes.header')
<div class="container">
<form action="{{url('/forma_pago/'.$forma_pago->id)}}" method="post">
@csrf
{{ method_field('PATCH')}}
@include('forma_pago.form' ,['e'=>'Editar'])

</form>
</div>