@include('componentes.header')

<h1 style="text-align: center;">Categorías</h1>
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
        <input type="hidden" name="context" value="categoria">
        <input type="submit" value="     Reporte" class="btn-primary" id="reporte">
    </form>    
    @endif


    <a href="{{url('categoria/create')}}" class="btn btn-success">Nueva categoria</a>
    <br>
    <br>
    <form action="{{url('/searchCat')}}" method="get">
       <div class="input-group">
  <input type="search" class="form-control rounded" name="search" required placeholder="Buscar" aria-label="Search"
  aria-describedby="search-addon" />
</div>     
    </form>

    <br />
    <br />
    <div class="table-responsive">
        <table class="table" id="table">
            <thead class="">
                <tr>
                    <th>#</th>
                    <th>Nombre</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($categoria as $categorias)
                <tr>
                    <td>{{ $categorias->id}}</td>
                    <td>{{ $categorias->nombre}}</td>
                    @if (Auth::user()->type==1)
                    <td>
                        <div class="d-flex">
                        <button class="btn btn-warning btn-sm mb-1">
                            <a href="{{url('/categoria/'.$categorias->id.'/edit')}}">
                                <img class="icon" src="{{asset('img/nuevoEditar.svg')}}" alt="" srcset="">
                            </a>
                        </button>
                        <p></p>
                        <form action="{{ url('/categoria/'.$categorias->id) }}" method="post">
                            @csrf
                            {{method_field('DELETE')}}
                            <button type="submit" onclick="return confirm('Seguro,¿Qué quieres eliminar esta categoría?')"
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
{{$categoria->links()}}    
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
            url: "{{url('searchCat')}}",
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
    <td >${datos.nombre}</td>

    @if (Auth::user()->type==1)
    <td>
        <div class="d-flex">
            <button class="btn btn-warning btn-sm mb-1">
                <a href="{{url('/categoria/')}}/${datos.id}/edit">
                    <img class="icon" src="{{asset('img/nuevoEditar.svg')}}" alt="" srcset="">
                </a>
            </button>
            <p></p>
            <form action="{{ url('/categoria/') }}/${datos.id}" method="post">
                @csrf
                {{method_field('DELETE')}}
                <button type="submit" onclick="return confirm('Seguro:¿Qué quieres eliminar esta categoria?')"
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