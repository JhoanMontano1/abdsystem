
@include('componentes.header')
<h1 style="text-align: center;">Salidas</h1>

<div class="container">
@if(Session::has('mensaje'))
<div class="alert alert-success alert_dismissible" role="alert">

{{Session::get('mensaje')}}

</div>
@endif
@if (Auth::user()->type==1)
<form action="{{url('/report')}}" method="get" class="btn btn-primary">
<input type="hidden" name="context" value="salida" >
<input type="submit" value="     Reporte" class="btn-primary" id="reporte" >
</form>    
    @endif

<a href="{{url('salida/create')}}" class="btn btn-success">Ingresar nueva salida</a> 
<br>
    <br>
    <form action="{{url('/searchSal')}}" method="get">
       <div class="input-group">
  <input type="search" class="form-control rounded" name="search" required placeholder="Buscar" aria-label="Search"
  aria-describedby="search-addon" />
</div>     
    </form>

<br/>
<br/>
<div class="table-responsive">
<table class="table" id="table">
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
			<td>C${{ $salidas->total}}</td>
			<!-- <td>
				<a href="{{url('/salida/'.$salidas->id.'/edit')}}"class="btn btn-warning">Editar </a>
			<form action="{{ url('/salida/'.$salidas->id) }}" class="d-inline" method="post">
				@csrf
				{{method_field('DELETE')}}
			<input class="btn btn-danger" type="submit" onclick="return confirm('Seguro,¿Qué quieres eliminar esta salida?')"value="Eliminar">
			</form>
			</td> -->
		</tr>
		@endforeach
	</tbody>
	
</table>

</div>

</div>
<div class="pag">
{{$salida->links()}}	
</div>

@include('componentes.footer')
<script>
var table = $('#table Tbody').html();
var pag = $('nav:has(ul.pagination)');
var search = "";
var currentHtml = "";
$(document).on("input", "input[name=search]", () => {
    let value = $("input[name=search]").val();
    if (value !== "") {
        $.ajax({
            url: "{{url('searchSal')}}",
            type: "get",
            cache: false,
            data: {
                value: value
            },
            success: function(data) {
                console.log(data);
                console.log(data.links);

                if ($('nav:has(ul.pagination)').length) {
                    $('nav:has(ul.pagination)').replaceWith(data.links);
                } else {
                    $(".pag").append(data.links);
                }


                let datos = JSON.parse(data.data);
                search = data.search;
                datos = datos.data;

                datos.forEach(datos => {
                    currentHtml +=
                        `
<tr p-id='${datos.id}'>
    <td >${datos.id}</td>
    <td >${datos.forma_salida}</td>
	<td >${datos.cliente}</td>
	<td >${datos.fecha}</td>
	<td >${datos.cantidad}</td>
	<td >C$${datos.total}</td>
</tr>
`;
                });
                $('#table Tbody').html(currentHtml);
                currentHtml = "";
                if (search != "") {
                    let pages = $(".pagination li a");
                    for (let i = 0; i < pages.length; i++) {
                        pages[i].href = pages[i].href + "&" + "search=" + search;
                    }

                }

            }
        });
    } else {

        $('#table Tbody').html(table);
        if ($('nav:has(ul.pagination)').length) {
            $('nav:has(ul.pagination)').replaceWith(pag);
        } else {
            $(".pag").append(pag);
        }
    }

});
</script>