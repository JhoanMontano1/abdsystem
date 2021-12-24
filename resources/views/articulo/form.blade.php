<link rel="stylesheet" href="{{asset('css/jquery-ui.css')}}">
    <script  src="{{asset('js/jquery-ui.js')}}"></script>
<h1>{{$e}} artículo</h1>
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
<label for="descripcion">Descripción</label>
<input type="varchar" class="form-control" id="descripcion" name="descripcion" value="{{isset($articulo->descripcion)?$articulo->descripcion:old('descripcion')}}">
<br>

</div>
<div class="form-group">
<label for="precio_venta">Precio de venta</label>
<input type="number" class="form-control"  name="precio_venta" value="{{isset($articulo->precio_venta)?$articulo->precio_venta:old('precio_venta')}}">
<br>
</div>
<div class="form-group">
<label for="precio_compra">Precio de compra</label>
<input type="number" class="form-control"  name="precio_compra" value="{{isset($articulo->precio_compra)?$articulo->precio_compra:old('precio_compra')}}">
<br>
</div>

<!-- <div class="form-group">
<label for="stock">Stock</label>
<input type="number" class="form-control"  name="stock" value="{{isset($articulo->stock)?$articulo->stock:old('stock')}}">
<br>
</div> -->
<label for="id_categoria">Categoría</label>
<br>
<select name="id_categoria">
<option disabled="true">Seleccione una categoría</option>
@if(isset($categoria))
	
@foreach($categoria as $categorias)

	<option value="{{$categorias->id}}" 
		@if(isset($articulo)){{$categorias->id==$articulo->categoria_id ? 'selected' :''}}
		@endif>{{$categorias->nombre}}
	</option>

@endforeach
@endif
</select>
<br>
<br>
<label for="id_proveedor">Proveedor</label>
<br>
<select name="id_proveedor">
<option disabled="true">Seleccione un proveedor</option>
@if(isset($proveedor))

	
@foreach($proveedor as $proveedores)

	<option value="{{$proveedores->id}}" 
		@if(isset($articulo)){{$proveedores->id==$articulo->proveedor_id ? 'selected' :''}}
		@endif>{{$proveedores->nombres}}
	</option>

@endforeach
@endif
</select>
<br>
<br>

<input  class="btn btn-success" type="submit" value="{{$e}} artículo">
<br>
<br>
<a  class="btn btn-primary"href="{{url('articulo/')}}">Volver</a>
<br> 
@include('componentes.footer')
<script>
	var categories=[];
	
	$(document).ready(()=>{
		$.ajax({
  type: "GET",
  url: "{{url('/searchCat')}}",
  data: {

  },
  success: function(data) {
	data=JSON.parse(data);

data.forEach(datos=>{
	categories.push(datos.nombre);
});
	$("#descripcion").autocomplete({
		source:categories
	});
  }
});
		

	});

</script>