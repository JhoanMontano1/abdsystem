@include('componentes.header')
<h1 style="text-align: center;">Resultados de la búsqueda en artículos</h1>

<div class="container">
<a class="btn btn-primary" style="text-align: center;" href="{{url('/articulo')}}">Volver</a>
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
                    <th>Categoria</th>
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
<script>
   let pages=$(".pagination li a");
   for(let i=0;i<pages.length;i++){
     pages[i].href=pages[i].href+"&"+"search="+"<?php echo $search; ?>";
   }

</script>
@include('componentes.footer')