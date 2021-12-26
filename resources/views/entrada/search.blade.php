
@include('componentes.header')
<h1 style="text-align: center;">Resultado de búsqueda en entradas</h1>

<div class="container">
	<a class="btn btn-primary" href="{{url('/entrada')}}">Volver</a>
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
			<th>Forma de entrada</th>
			<th>Proveedor</th>
			<th>Fecha</th>
			<th>Cantidad</th>
			<th>Total</th>
		</tr>
	</thead>
	<tbody>
		@foreach($entrada as $entradas)
		<tr>
			<td>{{ $entradas->id}}</td>
			<td>{{ $entradas->forma_entrada}}</td>
			<td>{{ $entradas->proveedor}}</td>
			<td>{{ $entradas->fecha}}</td>
			<td>{{ $entradas->cantidad}}</td>
			<td>C${{ $entradas->total}}</td>
			<!-- <td>
				<a href="{{url('/entrada/'.$entradas->id.'/edit')}}"class="btn btn-warning">Editar </a>
				
			<form action="{{ url('/entrada/'.$entradas->id) }}" class="d-inline" method="post">
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
{{$entrada->links()}}

</div>
<script>
   let pages=$(".pagination li a");
   for(let i=0;i<pages.length;i++){
     pages[i].href=pages[i].href+"&"+"search="+"<?php echo $search; ?>";
   }

</script>
@include('componentes.footer')