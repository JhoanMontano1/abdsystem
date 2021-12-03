
@include('componentes.header')
<h1 style="text-align: center;">Facturas de salida</h1>

<div class="container">
    @if(Session::has('mensaje'))
    <div class="alert alert-success alert_dismissible" role="alert">

        {{Session::get('mensaje')}}

    </div>
    @endif
    @if (Auth::user()->type==1)
     <form action="{{url('/report')}}" method="get" class="text-center btn btn-primary">
        <input type="hidden" name="context" value="factura_cliente">
        <input type="submit" value="     Reporte" class="btn-primary" id="reporte" >
    </form>   
    @endif


    <br>
    <br>
    <form action="{{url('/searchFacSal')}}" method="get">
       <div class="input-group">
  <input type="search" class="form-control rounded" name="search" required placeholder="Buscar" aria-label="Search"
  aria-describedby="search-addon" />
  <button type="submit" class="btn btn-outline-primary">Buscar</button>
</div>     
    </form>
    <br>
    <form action="{{url('/searchFacSal')}}" method="get">
        <div class="form-group">
            <input required name="date_i" class="form-control" type="date"  id="">
            <input required name="date_f" class="form-control" type="date"  id="">
        </div>
        <div class="text-center">
          <button type="submit" class="btn btn-primary">
            Buscar entre fechas
        </button>          
        </div>
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
    $('#form-anular').submit(()=>{
$('#btn-anular').prop('disabled',true);
    });

</script>
@include('componentes.footer')