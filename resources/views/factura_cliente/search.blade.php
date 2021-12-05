
@include('componentes.header')
<h1 style="text-align: center;">Resultado de la búsqueda en facturas de salida</h1>

<div class="container">
<a class="btn btn-primary" href="{{url('/factura_cliente')}}">Volver</a>
    @if(Session::has('mensaje'))
    <div class="alert alert-success alert_dismissible" role="alert">

        {{Session::get('mensaje')}}

    </div>
    @endif

    <br />
    <br />
    <div class="table-responsive">
        <table class="table">
            <thead class="">
                <tr>
                    <th>#</th>
                    <th>Cliente</th>
                    <th>Fecha</th>
                    <th>Forma de pago</th>
                    <th>Total</th>
                    <th>Opciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($factura as $facturas)
                <tr>
                    <td>{{ $facturas->id}}</td>
                    <td>{{ $facturas->cliente}}</td>
                    <td>{{ $facturas->fecha}}</td>
                    <td>{{ $facturas->forma_pago}}</td>
                    <td>{{ $facturas->total}}</td>
                    @if (Auth::user()->type==1)
                    <td>
                        <div class="d-flex">
                        <form id="form-anular" action="{{url('/cancel_invoice_client')}}" method="get">
						<input type="hidden" name="id" value="{{$facturas->id}}">
						<button onclick="return confirm('Seguro,¿Qué quieres anular?')" id="btn-anular" {{ $facturas->anulado===1 ?'disabled' :''}}
                         class="btn btn-secondary btn-sm mb-1" type="submit" value="{{ $facturas->anulado===1 ?'Anulado' :'Anular'}}">
                            <img class="icon" src="{{asset('img/anular.svg')}}" alt="" srcset="">
                        </button>
                        <p></p>
						</form>
						<form action="{{url('/invoice_client')}}" method="get">
						<input type="hidden" name="id" value="{{$facturas->id}}">
						<button class="btn btn-primary btn-sm mb-1" type="submit">
                            <img class="icon" src="{{asset('img/verBlanco.svg')}}" alt="" srcset="">
                        </button>
                        <p></p>
						</form>
                        @if (Auth::user()->type==1 && $facturas->anulado===1)
                        <form action="{{ url('/factura_cliente/'.$facturas->id) }}" class="d-inline" method="post">
                            @csrf
                            {{method_field('DELETE')}}
                            <button type="submit" onclick="return confirm('Seguro,¿Qué quieres eliminar esta factura de cliente?')" class="btn btn-danger btn-sm">
                            <img class="icon" src="{{asset('img/nuevoEliminar.svg')}}" alt="" srcset="">
                        </button>
                        </form>
                        </div>

                        @endif
                    </td>			
			@endif

                </tr>

                @endforeach
            </tbody>

        </table>

    </div>

</div>
{{$factura->links()}}
<script>
   let pages=$(".pagination li a");

   <?php if(isset($search))
   {
    echo `
    <script type=\"text/javascript\">
    for(let i=0;i<pages.length;i++){

        pages[i].href=pages[i].href+"&"+"search="+"<?php echo $search; ?>";
      }
    </script>
`;
   }else
   {
    echo `
    <script type=\"text/javascript\">
    for(let i=0;i<pages.length;i++){

        pages[i].href=pages[i].href+"&"+"date_i="+"<?php echo $date_i; ?>"+"&"+"date_f="+"<?php echo $date_f; ?>";
      }
    </script>
`;

   }
    ?>


</script>
@include('componentes.footer')