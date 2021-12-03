<h1>{{$e}} cliente</h1>
@if(count($errors)>0)
<div class="alert alert-danger" role="alert">
<ul>

@foreach($errors->all() as $errors)
<li>{{$errors}}</li>
@endforeach	
</ul>
</div>

@endif
<div class="form-group">
<label for="nombres">Nombres</label>
<input type="varchar" class="form-control" name="nombres" value="{{isset($cliente->nombres)?$cliente->nombres:old('nombres')}}">
<br>

</div>
<div class="form-group">
<label for="apellidos">Apellido</label>
<input type="varchar" class="form-control"  name="apellidos" value="{{isset($cliente->apellidos)?$cliente->apellidos:old('apellidos')}}">
<br>
</div>
<div class="form-group">
<label for="direccion">Direccion</label>
<input type="varchar" class="form-control"  name="direccion" value="{{isset($cliente->direccion)?$cliente->direccion:old('direccion')}}">

<br>
<div class="form-group">
    <label for="pais">Codigo de pais</label>
    <input class="form-control" type="number" required id="pais">
</div>

<div class="form-group">
<label for="telefono">Telefono</label>
<input type="number" pattern=".{0}|.{8,15}" class="form-control" required name="telefono" value="{{isset($proveedor->telefono)?$proveedor->telefono:old('telefono')}}">

<br>
</div>
<br>
<br>
<input  class="btn btn-success" type="submit" value="{{$e}} cliente">
<br>
<br>
<a  class="btn btn-primary"href="{{url('cliente/')}}">Volver</a>
<br> 
<script>
$(document).on("input","#pais",function(){
if($("#pais").val().length>3){
    $("#pais").prop("value",$("#pais").val().substring(0, 3));
}
});
    $(document).on("submit","form",function(){
        $("input[name='telefono']").prop("type","text");
$("input[name='telefono']").prop("value","+"+$("#pais").val()+$("input[name='telefono']").val());
    });

</script>
@include('componentes.footer')