@include('componentes.header')
<h1 style="text-align: center;">Proveedores</h1>

<div class="container">
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
    @if (Auth::user()->type==1)
    <form action="{{url('/report')}}" method="get" class="btn btn-primary">
        <input type="hidden" name="context" value="proveedor">
        <input type="submit" value="     Reporte" class="btn-primary" id="reporte">
    </form>
    @endif

    <a href="{{url('proveedor/create')}}" class="btn btn-success">Nuevo proveedor</a>

    <br>
    <br>
    <form action="{{url('/searchPro')}}" method="get">
        <div class="input-group">
            <input type="search" class="form-control rounded" name="search" required placeholder="Buscar"
                aria-label="Search" aria-describedby="search-addon" />
        </div>
    </form>
    <br />
    <br />
    <div class="table-responsive">
        <table class="table" id="table">
            <thead class="">
                <tr>
                    <th>#</th>
                    <th>Nombres</th>
                    <th>Apellidos</th>
                    <th>Nombre comercial</th>
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
<div class="pag">
{{$proveedor->links()}}    
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
            url: "{{url('searchPro')}}",
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
    <td >${datos.nombres}</td>
	<td >${datos.apellidos}</td>
	<td >${datos.nombre_comercial}</td>
	<td >${datos.direccion}</td>
	<td >${datos.telefono}</td>
        
    @if (Auth::user()->type==1)
    <td>
        <div class="d-flex">
            <button class="btn btn-warning btn-sm mb-1">
                <a href="{{url('/proveedor/')}}/${datos.id}/edit">
                    <img class="icon" src="{{asset('img/nuevoEditar.svg')}}" alt="" srcset="">
                </a>
            </button>
            <p></p>
            <form action="{{ url('/proveedor/') }}/${datos.id}" method="post">
                @csrf
                {{method_field('DELETE')}}
                <button type="submit" onclick="return confirm('Seguro:¿Qué quieres eliminar este proveedor?')"
                    class="btn btn-danger btn-sm">
                    <img class="icon" src="{{asset('img/nuevoEliminar.svg')}}" alt="" srcset="">
                </button>

            </form>
        </div>

    </td>
    @endif
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