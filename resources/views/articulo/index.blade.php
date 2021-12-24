@include('componentes.header')
<h1 style="text-align: center;">Artículos</h1>
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
        <input type="hidden" name="context" value="articulo">
        <input type="submit" value="     Reporte" class="btn-primary" id="reporte">
    </form>
    @endif

    <a href="{{url('articulo/create')}}" class="btn btn-success">Nuevo artículo</a>
    <br>
    <br>
    <form action="{{url('/searchArt')}}" method="get">
        <div class="input-group">
            <input type="search" class="form-control rounded" name="search" required placeholder="Buscar"
                aria-label="Search" aria-describedby="search-addon" />
            <button type="submit" class="btn btn-outline-primary">Buscar</button>
        </div>
    </form>



    <br />
    <br />

    <div class="table-responsive">
        <table id="table" class="table">
            <thead class="">
                <tr>
                    <th>#</th>
                    <th>Descripción</th>
                    <th>Stock</th>
                    <th>Precio Compra</th>
                    <th>Precio venta</th>
                    <th>Categoría</th>
                    <th>Proveedor</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>

                @foreach($articulo as $articulos)

                <tr>
                    <td {{$articulos->stock<=0 ?'style=text-decoration:line-through;color:red;' :"" }}>
                        {{ $articulos->id}}</td>
                    <td {{$articulos->stock<=0 ?'style=text-decoration:line-through;color:red;' :"" }}>
                        {{ $articulos->descripcion}}</td>
                    <td {{$articulos->stock<=0 ?'style=text-decoration:line-through;color:red;' :"" }}>
                        {{ $articulos->stock}}</td>
                    <td {{$articulos->stock<=0 ?'style=text-decoration:line-through;color:red;' :"" }}>
                        {{ $articulos->precio_compra}}C$</td>
                    <td {{$articulos->stock<=0 ?'style=text-decoration:line-through;color:red;' :"" }}>
                        {{ $articulos->precio_venta}}C$</td>
                    <td {{$articulos->stock<=0 ?'style=text-decoration:line-through;color:red;' :"" }}>
                        {{ $articulos->categoria}}</td>
                    <td {{$articulos->stock<=0 ?'style=text-decoration:line-through;color:red;' :"" }}>
                        {{ $articulos->proveedor}}</td>
                    @if (Auth::user()->type==1)
                    <td>
                        <div class="d-flex">
                            <button class="btn btn-warning btn-sm mb-1">
                                <a href="{{url('/articulo/'.$articulos->id.'/edit')}}">
                                    <img class="icon" src="{{asset('img/nuevoEditar.svg')}}" alt="" srcset="">
                                </a>
                            </button>
                            <p></p>
                            <form action="{{ url('/articulo/'.$articulos->id) }}" method="post">
                                @csrf
                                {{method_field('DELETE')}}
                                <button type="submit"
                                    onclick="return confirm('Seguro:¿Qué quieres eliminar este artículo?')"
                                    class="btn btn-danger btn-sm">
                                    <img class="icon" src="{{asset('img/nuevoEliminar.svg')}}" alt="" srcset="">
                                </button>

                            </form>
                        </div>

                    </td>
                    @endif
                </tr>

                @endforeach
            </tbody>

        </table>

    </div>

</div>
<div class="pag">
    {{$articulo->links()}}
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
            url: "{{url('searchArt')}}",
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
    <td ${datos.stock<=0 ?'style=text-decoration:line-through;color:red;' :''}>${datos.id}</td>
    <td ${datos.stock<=0 ?'style=text-decoration:line-through;color:red;' :''}>${datos.descripcion}</td>
    <td ${datos.stock<=0 ?'style=text-decoration:line-through;color:red;' :''}> ${datos.stock}</td>
    <td ${datos.stock<=0 ?'style=text-decoration:line-through;color:red;' :''}> ${datos.precio_compra}</td>
    <td ${datos.stock<=0 ?'style=text-decoration:line-through;color:red;' :''}> ${datos.precio_venta}</td>
    <td ${datos.stock<=0 ?'style=text-decoration:line-through;color:red;' :''}> ${datos.categoria}</td>
    <td ${datos.stock<=0 ?'style=text-decoration:line-through;color:red;' :''}> ${datos.proveedor}</td>

    @if (Auth::user()->type==1)
    <td>
        <div class="d-flex">
            <button class="btn btn-warning btn-sm mb-1">
                <a href="{{url('/articulo/')}}/${datos.id}/edit">
                    <img class="icon" src="{{asset('img/nuevoEditar.svg')}}" alt="" srcset="">
                </a>
            </button>
            <p></p>
            <form action="{{ url('/articulo/') }}/${datos.id}" method="post">
                @csrf
                {{method_field('DELETE')}}
                <button type="submit" onclick="return confirm('Seguro:¿Qué quieres eliminar este artículo?')"
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