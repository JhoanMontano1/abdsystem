<h1>{{$e}} Entrada</h1>
@if(count($errors)>0)
<div class="alert alert-danger" role="alert">
<ul>

@foreach($errors->all() as $errors)
<li>{{$errors}}</li>
@endforeach	
</ul>
</div>

@endif


<label for="id_proveedor">Proveedor</label>
<br>
<select name="id_proveedor">
<option disabled="true">Seleccione un proveedor</option>
@if(isset($proveedor))
@foreach($proveedor as $proveedores)

	<option value="{{$proveedores->id}}" 
		@if(isset($entrada)){{$proveedores->id==$entrada->id_proveedor ? 'selected' :''}}
		@endif>{{$proveedores->nombres}}
	</option>

@endforeach
@endif
</select>
<br>
<br>

<label for="id_forma">Forma de entrada</label>
<br>
<select name="id_forma_entrada">
<option disabled="true">Seleccione una forma de entrada</option>
@if(isset($forma_entrada))
@foreach($forma_entrada as $forma)

	<option value="{{$forma->id}}" 
		@if(isset($entrada)){{$forma->id==$entrada->id_forma_entrada ? 'selected' :''}}
		@endif>{{$forma->tipo}}
	</option>

@endforeach
@endif
</select>
<br>
<br>
<div class="form-group">
<label for="cantidad">Cantidad</label>
<input type="number" class="form-control"  name="cantidad" value="{{isset($entrada->cantidad)?$entrada->cantidad:old('cantidad')}}">
<br>
</div>
<div class="form-group">
<label for="fecha">Fecha</label>
<input type="date" class="form-control"  name="fecha" value="{{isset($entrada->fecha)?$entrada->fecha:old('fecha')}}">

<br>
</div>
<div class="form-group">
<label for="total">Total</label>
<input type="number" class="form-control"  name="total" value="{{isset($entrada->total)?$entrada->total:old('total')}}">

<br>
</div>

<input  class="btn btn-success" type="submit" value="{{$e}} entrada">
<br>
<br>
<a  class="btn btn-primary"href="{{url('entrada/')}}">Volver</a>
<br> 
@include('componentes.footer')