
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
</div>     
    </form>
<br/>
<br/>
<div class="table-responsive">
<table class="table" id="table">
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
<div class="pag">
{{$entrada->links()}}	
</div>

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
            url: "{{url('searchEnt')}}",
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
    <td >${datos.forma_entrada}</td>
	<td >${datos.proveedor}</td>
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