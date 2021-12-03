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
  <input type="search" class="form-control rounded" name="search" required placeholder="Buscar" aria-label="Search"
  aria-describedby="search-addon" />
  <button type="submit" class="btn btn-outline-primary">Buscar</button>
</div>     
    </form>



    <br />
    <br />
    
    <div class="table-responsive">
        <table class="table">
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
                    <td {{$articulos->stock<=0 ?'style=text-decoration:line-through;color:red;' :"" }}>{{ $articulos->id}}</td>
                    <td {{$articulos->stock<=0 ?'style=text-decoration:line-through;color:red;' :"" }}>{{ $articulos->descripcion}}</td>
                    <td {{$articulos->stock<=0 ?'style=text-decoration:line-through;color:red;' :"" }}>{{ $articulos->stock}}</td>
                    <td {{$articulos->stock<=0 ?'style=text-decoration:line-through;color:red;' :"" }}>{{ $articulos->precio_compra}}</td>
                    <td {{$articulos->stock<=0 ?'style=text-decoration:line-through;color:red;' :"" }}>{{ $articulos->precio_venta}}</td>
                    <td {{$articulos->stock<=0 ?'style=text-decoration:line-through;color:red;' :"" }}>{{ $articulos->categoria}}</td>
                    <td {{$articulos->stock<=0 ?'style=text-decoration:line-through;color:red;' :"" }}>{{ $articulos->proveedor}}</td>
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
                            <button type="submit" onclick="return confirm('Seguro:¿Qué quieres eliminar este artículo?')"
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
{{$articulo->links()}}
@include('componentes.footer')