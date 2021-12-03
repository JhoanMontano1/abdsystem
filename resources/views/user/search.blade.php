@if (Auth::user()->type!=1)
<script>
 window.location.href = '{{url("/")}}';
</script>
@endif

@include('componentes.header')
<h1 style="text-align: center;">Resultado de la busqueda en usuarios</h1>

<div class="container">
@if(Session::has('mensaje'))
<div class="alert alert-success alert_dismissible" role="alert">

{{Session::get('mensaje')}}

</div>
@endif
<a class="btn btn-primary" href="{{ url('user/create') }}">Nuevo usuario</a>


<br/>
<br/>
<div class="table-responsive">
<table class="table">
	<thead class="">
		<tr>
			<th>#</th>
			<th>Nombre</th>
			<th>Correo</th>
			<th>Privilegio</th>
			<th>Accion</th>
		</tr>
	</thead>
	<tbody>
		@foreach($user as $users)
		<tr>
			<td>{{ $users->id}}</td>
			<td>{{ $users->name}}</td>
			<td>{{ $users->email}}</td>
			<!-- <td>{{ $users->password}}</td> -->
			<td>{{ $users->type==1 ?'Admin' :'Normal'}}</td>
			
			@if ($users->id!=Auth::user()->id)
			<td>
			<button class="btn btn-warning">
                            <p></p>
                            <a href="{{url('/user/'.$users->id.'/edit')}}">
                                <img class="icon" src="{{asset('img/nuevoEditar.svg')}}" alt="" srcset="">
                            </a>
                            <p></p>
                        </button>
						<br>
						<br>
			<form action="{{ url('/user/'.$users->id) }}" method="post">
				@csrf
				{{method_field('DELETE')}}
				<button type="submit" onclick="return confirm('Seguro,¿Qué quieres eliminar?')"
                                class="btn btn-danger">
                                <p></p>
                                <img class="icon" src="{{asset('img/nuevoEliminar.svg')}}" alt="" srcset="">
                                <p></p>
                            </button>
			</form>
			</td>
			@else
			<td>
				<button class="btn btn-info" disabled>Usuario actual</button>
			</td>
			@endif

		</tr>
		@endforeach
	</tbody>
	
</table>

</div>

</div>
{{$user->links()}}

@include('componentes.footer')