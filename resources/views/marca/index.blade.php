<h1 style="text-align: center;">clientes</h1>
@include('componentes.header')


<div class="container">
@if(Session::has('mensaje'))
<div class="alert alert-success alert_dismissible" role="alert">

{{Session::get('mensaje')}}

</div>
@endif
<form action="{{url('/report')}}" method="get">
<input type="hidden" name="context" value="marca" >
<input type="submit" value="Reporte" class="btn btn-primary">
</form>
<a href="{{url('marca/create')}}" class="btn btn-success">Ingresar nueva marca</a> 


<br/>
<br/>
<div class="table-responsive">
<table class="table">
	<thead class="">
		<tr>
			<th>#</th>
			<th>Nombre</th>
			<th>Acciones</th>
		</tr>
	</thead>
	<tbody>
		@foreach($marca as $marcas)
		<tr>
			<td>{{ $marcas->id}}</td>
			<td>{{ $marcas->nombre}}</td>
			<td>
				<a href="{{url('/marca/'.$marcas->id.'/edit')}}"class="btn btn-warning">Editar </a>
			<form action="{{ url('/marca/'.$marcas->id) }}" class="d-inline" method="post">
				@csrf
				{{method_field('DELETE')}}
			<input class="btn btn-danger" type="submit" onclick="return confirm('Seguro,¿Qué quieres eliminar?')"value="Eliminar">
			</form>
			</td>
		</tr>
		@endforeach
	</tbody>
	
</table>

</div>

</div>
{{$marca->links()}}
@include('componentes.footer')