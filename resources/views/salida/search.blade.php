
@include('componentes.header')
<h1 style="text-align: center;">Resultado de búsqueda en salidas</h1>

<div class="container">
	<a class="btn btn-primary" href="{{url('/salida')}}">Volver</a>
@if(Session::has('mensaje'))
<div class="alert alert-success alert_dismissible" role="alert">

{{Session::get('mensaje')}}

</div>
@endif 


<br/>
<br/>
<div class="table-responsive">
<table class="table">
	<thead class="">
		<tr>
			<th>#</th>
			<th>Forma de salida</th>
			<th>Cliente</th>
			<th>Fecha</th>
			<th>Cantidad</th>
			<th>Total</th>
		</tr>
	</thead>
	<tbody>
		@foreach($salida as $salidas)
		<tr>
			<td>{{ $salidas->id}}</td>
			<td>{{ $salidas->forma_salida}}</td>
			<td>{{ $salidas->cliente}}</td>
			<td>{{ $salidas->fecha}}</td>
			<td>{{ $salidas->cantidad}}</td>
			<td>{{ $salidas->total}}</td>
			<!-- <td>
				<a href="{{url('/salida/'.$salidas->id.'/edit')}}"class="btn btn-warning">Editar </a>
			<form action="{{ url('/salida/'.$salidas->id) }}" class="d-inline" method="post">
				@csrf
				{{method_field('DELETE')}}
			<input class="btn btn-danger" type="submit" onclick="return confirm('Seguro,¿Qué quieres eliminar?')"value="Eliminar">
			</form>
			</td> -->
		</tr>
		@endforeach
	</tbody>
	
</table>

</div>

</div>
{{$salida->links()}}
<script>
   let pages=$(".pagination li a");
   for(let i=0;i<pages.length;i++){
     pages[i].href=pages[i].href+"&"+"search="+"<?php echo $search; ?>";
   }

</script>
@include('componentes.footer')