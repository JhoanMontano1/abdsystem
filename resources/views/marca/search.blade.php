@extends('layouts.app')

@section('content')
	@if(Session::has('mensaje'))
<div class="alert alert-success alert_dismissible" role="alert">

{{Session::get('mensaje')}}
@endif
<table class="table table-light">
	<thead class="thead-light">
		<tr>
			<th>#</th>
			<th>Fecha</th>
			<th>Total</th>
			<th>Factura</th>
			<th>Id_Proveedor</th>
			<th>Id_Forma</th>
			<th>Acciones</th>
		</tr>
	</thead>
	<tbody>
		@if(isset($result))
		@foreach($result as $entradas)
		<tr>
			<td>{{ $entradas->id}}</td>
			<td>{{ $entradas->fecha}}</td>
			<td>{{ $entradas->total}}</td>
			<td>{{ $entradas->factura}}</td>
			<td>{{ $entradas->proveedor_id}}</td>
			<td>{{ $entradas->forma_id}}</td>
			<td>
				<a href="{{url('/entrada/'.$entradas->id.'/edit')}}"class="btn btn-warning">Editar </a>
                |
			<form action="{{ url('/entrada/'.$entradas->id) }}" class="d-inline" method="post">
				@csrf
				{{method_field('DELETE')}}
			<input class="btn btn-danger" type="submit" onclick="return confirm('Seguro,que quieres eliminar')"value="Eliminar">
			</form>
			</td>
		</tr>
		@endforeach
		@endif
	</tbody>
</table>
<a href="{{url('entrada')}}" class="btn btn-primary center">Volver a inicio</a> 
<div style="text-align: center; font-size: large; background-color: #00AAE4; padding:25px; font-weight:bold;">Proyecto con fines academicos, equipo Montanocel</div>