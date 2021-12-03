
@include('componentes.header')
<h1 style="text-align: center;">Resultado de la búsqueda en proveedores</h1>

<div class="container">
	<a class="btn btn-primary" href="{{url('/proveedor')}}">Volver</a>
@if(Session::has('mensaje'))
    <div class="alert alert-success alert_dismissible" role="alert">

        {{Session::get('mensaje')}}

    </div>
    @endif
    @if(Session::has('mensaje2'))
    <div class="alert alert-danger alert_dismissible" role="alert">

        {{Session::get('mensaje2')}}

    </div>
    @endif
<div class="table-responsive">
<table class="table">
	<thead class="">
		<tr>
			<th>#</th>
			<th>Nombres</th>
			<th>Nombre comercial</th>
			<th>Apellidos</th>
			<th>Direccion</th>
			<th>Telefono</th>
			<th>Acciones</th>
		</tr>
	</thead>
	<tbody>
		@foreach($proveedor as $proveedores)
		<tr>
                    <td>{{ $proveedores->id}}</td>
                    <td>{{ $proveedores->nombres}}</td>
                    <td>{{ $proveedores->apellidos}}</td>
                    <td>{{ $proveedores->nombre_comercial}}</td>
                    <td>{{ $proveedores->direccion}}</td>
                    <td>{{ $proveedores->telefono}}</td>
                    @if (Auth::user()->type==1)
                    <td>
                        <div class="d-flex">
                            <button class="btn btn-warning btn-sm mb-1">
                                <a href="{{url('/proveedor/'.$proveedores->id.'/edit')}}">
                                    <img class="icon" src="{{asset('img/nuevoEditar.svg')}}" alt="" srcset="">
                                </a>
                            </button>
                            <p></p>
                            <form action="{{ url('/proveedor/'.$proveedores->id) }}" method="post">
                                @csrf
                                {{method_field('DELETE')}}
                                <button type="submit"
                                    onclick="return confirm('Seguro,¿Qué quieres eliminar a este proveedor?')"
                                    class="btn btn-danger btn-sm">
                                    <img class="icon" src="{{asset('img/nuevoEliminar.svg')}}" alt="" srcset="">
                                </button>
                            </form>
                        </div>

                    </td>
                </tr>
                @endif

		@endforeach
	</tbody>
	
</table>

</div>

</div>
{{$proveedor->links()}}
<script>
   let pages=$(".pagination li a");
   for(let i=0;i<pages.length;i++){
     pages[i].href=pages[i].href+"&"+"search="+"<?php echo $search; ?>";
   }

</script>
@include('componentes.footer')