
@include('componentes.header')
<h1 style="text-align: center;">Entradas</h1>

<div class="container">
@if(Session::has('mensaje'))
<div class="alert alert-success alert_dismissible" role="alert">

{{Session::get('mensaje')}}

</div>
@endif

<a href="{{url('entrada/create')}}" class="btn btn-success">Nueva entrada</a> 
@if (Auth::user()->type==1)
<form action="{{url('/report')}}" method="get" class="btn btn-primary">
<input type="hidden" name="context" value="entrada" >
<input type="submit" value="     Reporte" class="btn-primary" id="reporte" >
</form>    
    @endif

<br>
    <br>
    <form action="{{url('/searchEnt')}}" method="get">
       <div class="input-group">
  <input type="search" class="form-control rounded" name="search" required placeholder="Buscar" aria-label="Search"
  aria-describedby="search-addon" />
  <button type="submit" class="btn btn-outline-primary">Buscar</button>
</div>     
    </form>
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
			<input class="btn btn-danger" type="submit" onclick="return confirm('Seguro,¿Qué quieres eliminar esta entrada?')"value="Eliminar">
			</form>
			</td> -->
		</tr>
		@endforeach
	</tbody>
	
</table>

</div>
{{$entrada->links()}}
</div>

@include('componentes.footer')