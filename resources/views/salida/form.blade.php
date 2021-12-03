<h1>{{$e}} salida</h1>
@if(count($errors)>0)
<div class="alert alert-danger" role="alert">
<ul>

@foreach($errors->all() as $errors)
<li>{{$errors}}</li>
@endforeach	
</ul>
</div>

@endif


<label for="id_cliente">Cliente</label>
<br>
<select name="id_cliente">
<option disabled="true">Seleccione un cliente</option>
@if(isset($cliente))
@foreach($cliente as $clientes)

	<option value="{{$clientes->id}}" 
		@if(isset($salida)){{$clientes->id==$salida->id_cliente ? 'selected' :''}}
		@endif>{{$clientes->nombres}}
	</option>

@endforeach
@endif
</select>
<br>
<br>

<label for="id_forma_salida">Forma de salida</label>
<br>
<select name="id_forma_salida">
<option disabled="true">Seleccione una forma de salida</option>
@if(isset($forma_salida))
@foreach($forma_salida as $forma)

	<option value="{{$forma->id}}" 
		@if(isset($salida)){{$forma->id==$salida->id_forma_salida ? 'selected' :''}}
		@endif>{{$forma->tipo}}
	</option>

@endforeach
@endif
</select>
<br>
<br>
<div class="form-group">
<label for="cantidad">Cantidad</label>
<input type="number" class="form-control"  name="cantidad" value="{{isset($salida->cantidad)?$salida->cantidad:old('cantidad')}}">
<br>
</div>
<div class="form-group">
<label for="fecha">Fecha</label>
<input type="date" class="form-control"  name="fecha" value="{{isset($salida->fecha)?$salida->fecha:old('fecha')}}">

<br>
</div>
<div class="form-group">
<label for="total">Total</label>
<input type="number" class="form-control"  name="total" value="{{isset($salida->total)?$salida->total:old('total')}}">

<br>
</div>

<input  class="btn btn-success" type="submit" value="{{$e}} salida">
<br>
<br>
<a  class="btn btn-primary"href="{{url('salida/')}}">Volver</a>
<br> 
@include('componentes.footer')