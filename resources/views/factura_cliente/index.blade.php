@include('componentes.header')
<h1 style="text-align: center;">Facturas de salida</h1>
<div class="d-flex justify-content-center w-100 flex-wrap" id="ventas">
    <div class="item text-center w-100 alert alert-primary">
        <h3>Productos más vendidos del mes: <br><?=$product[0]->{'articulo'}?><br>Total: <?=$product[0]->{'cantidad_vendida'}?>
        </h3>
    </div>

    <div class="item text-center w-100 alert alert-secondary">
        <h3>Productos menos vendidos del mes: <br><?=$product2[0]->{'articulo'}?><br>Total: <?=$product2[0]->{'cantidad_vendida'}?>
        </h3>
    </div>
</div>
<div class="container">
    @if(Session::has('mensaje'))
    <div class="alert alert-success alert_dismissible" role="alert">

        {{Session::get('mensaje')}}

    </div>
    @endif
    @if (Auth::user()->type==1)
    <form action="{{url('/report')}}" method="get" class="text-center btn btn-primary">
        <input type="hidden" name="context" value="factura_cliente">
        <input type="submit" value="     Reporte" class="btn-primary" id="reporte">
    </form>
    <button class="btn btn-primary" onclick="btnVentaClick()">
        <div class="d-flex">
            <div style="height:20px;" class="w-75 d-flex flex-wrap d-inline">
                <div style="width:56%;margin-top:-5px;">+</div>
                <div style="width:56%;margin-top:-15px;">-</div>
            </div>
            <div>
                <i class="fas fa-shopping-cart"></i>
            </div>
        </div>

    </button>
    @endif


    <br>
    <br>
    <form action="{{url('/searchFacSal')}}" method="get">
        <div class="input-group">
            <input type="search" class="form-control rounded" name="search" required placeholder="Buscar"
                aria-label="Search" aria-describedby="search-addon" />
        </div>
    </form>
    <br>
    <input required name="date_i" class="form-control" type="date" id="">
    <input required name="date_f" class="form-control" type="date" id="">
</div>
<div class="text-center">
    <button onclick="searchByDate()" class="btn btn-primary">
        Buscar entre fechas
    </button>
</div>
<br />
<br />
<div class="table-responsive">
    <table class="table" id="table">
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
                <td>C${{ $facturas->total}}</td>
                @if (Auth::user()->type==1)
                <td>
                    <div class="d-flex">
                        <form id="form-anular" action="{{url('/cancel_invoice_client')}}" method="get">
                            <input type="hidden" name="id" value="{{$facturas->id}}">
                            <button onclick="return confirm('Seguro,¿Qué quieres anular?')" id="btn-anular"
                                {{ $facturas->anulado===1 ?'disabled' :''}} class="btn btn-secondary btn-sm mb-1"
                                type="submit" value="{{ $facturas->anulado===1 ?'Anulado' :'Anular'}}">
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
                            <button type="submit"
                                onclick="return confirm('Seguro,¿Qué quieres eliminar esta factura de cliente?')"
                                class="btn btn-danger btn-sm">
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
<div class="pag">
    {{$factura->links()}}
</div>
</div>

@include('componentes.footer')
<script>
let ventas = $("#ventas").html();
$("#ventas").html("");
$('#form-anular').submit(() => {
    $('#btn-anular').prop('disabled', true);
});

var table = $('#table Tbody').html();
var pag = $('nav:has(ul.pagination)');
var search = "";
var date_i = "";
var date_f = "";
var currentHtml = "";
$('input[name=date_i]').val(moment().format('YYYY-MM-DD'));
$('input[name=date_f]').val(moment().format('YYYY-MM-DD'));

function searchByDate() {
    let date_i = $("input[name=date_i]").val();
    let date_f = $("input[name=date_f]").val();
    let type = 1;
    $.ajax({
        url: "{{url('searchFacSal')}}",
        type: "get",
        cache: false,
        data: {
            date_i: date_i,
            date_f: date_f,
            type: type
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
            date_i = data.date_i;
            date_f = data.date_f;
            datos = datos.data;

            datos.forEach(datos => {
                currentHtml +=
                    `
<tr p-id='${datos.id}'>
    <td >${datos.id}</td>
    <td >${datos.cliente}</td>
    <td > ${datos.fecha}</td>
    <td > ${datos.forma_pago}</td>
    <td > C$${datos.total}</td>

    @if (Auth::user()->type==1)
                    <td>
                        <div class="d-flex">
                            <form id="form-anular" action="{{url('/cancel_invoice_client')}}" method="get">
                                <input type="hidden" name="id" value="${datos.id}">
                                <button onclick="return confirm('Seguro,¿Qué quieres anular?')" id="btn-anular"
                                ${datos.anulado===1 ?'disabled' :''} class="btn btn-secondary btn-sm mb-1"
                                    type="submit" value="${datos.anulado===1 ?'Anulado' :'Anular'}">
                                    <img class="icon" src="{{asset('img/anular.svg')}}" alt="" srcset="">
                                </button>
                            </form>
                            <p></p>
                            <form action="{{url('/invoice_client')}}" method="get">
                                <input type="hidden" name="id" value="${datos.id}">
                                <button class="btn btn-primary btn-sm mb-1" type="submit">
                                    <img class="icon" src="{{asset('img/verBlanco.svg')}}" alt="" srcset="">
                                </button>
                            </form>
                            <p></p>
                            @if (Auth::user()->type==1)
                            ${datos.anulado===1 ?`
                                <form action="{{ url('/factura_cliente/') }}/${datos.id}" class="d-inline"
                                method="post">
                                @csrf
                                {{method_field('DELETE')}}
                                <button type="submit"
                                    onclick="return confirm('Seguro,¿Qué quieres eliminar esta factura de cliente?')"
                                    class="btn btn-danger btn-sm">
                                    <img class="icon" src="{{asset('img/nuevoEliminar.svg')}}" alt="" srcset="">
                                </button>
                            </form>` :''}

                        </div>

                        @endif
                    </td>
                    @endif
</tr>
`;
            });
            $('#table Tbody').html(currentHtml);
            currentHtml = "";
            let pages = $(".pagination li a");
            for (let i = 0; i < pages.length; i++) {

                pages[i].href = pages[i].href + "&" + "date_i=" + date_i + "&date_f=" + date_f;
            }

        }
    });
}



$(document).on("input", "input[name=search]", () => {
    let value = $("input[name=search]").val();
    let type = 0;
    if (value !== "") {
        $.ajax({
            url: "{{url('searchFacSal')}}",
            type: "get",
            cache: false,
            data: {
                search: value,
                type: type
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
    <td >${datos.cliente}</td>
    <td > ${datos.fecha}</td>
    <td > ${datos.forma_pago}</td>
    <td > C$${datos.total}</td>
    
    @if (Auth::user()->type==1)
                    <td>
                        <div class="d-flex">
                            <form id="form-anular" action="{{url('/cancel_invoice_client')}}" method="get">
                                <input type="hidden" name="id" value="${datos.id}">
                                <button onclick="return confirm('Seguro,¿Qué quieres anular?')" id="btn-anular"
                                ${datos.anulado===1 ?'disabled' :''} class="btn btn-secondary btn-sm mb-1"
                                    type="submit" value="${datos.anulado===1 ?'Anulado' :'Anular'}">
                                    <img class="icon" src="{{asset('img/anular.svg')}}" alt="" srcset="">
                                </button>
                            </form>
                            <p></p>
                            <form action="{{url('/invoice_client')}}" method="get">
                                <input type="hidden" name="id" value="${datos.id}">
                                <button class="btn btn-primary btn-sm mb-1" type="submit">
                                    <img class="icon" src="{{asset('img/verBlanco.svg')}}" alt="" srcset="">
                                </button>
                            </form>
                            <p></p>
                            @if (Auth::user()->type==1)
                            ${datos.anulado===1 ?`
                                <form action="{{ url('/factura_cliente/') }}/${datos.id}" class="d-inline"
                                method="post">
                                @csrf
                                {{method_field('DELETE')}}
                                <button type="submit"
                                    onclick="return confirm('Seguro,¿Qué quieres eliminar esta factura de cliente?')"
                                    class="btn btn-danger btn-sm">
                                    <img class="icon" src="{{asset('img/nuevoEliminar.svg')}}" alt="" srcset="">
                                </button>
                            </form>` :''}

                        </div>

                        @endif
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

function btnVentaClick() {
    if ($("#ventas").html().length > 0) {
        $("#ventas").html("");
    } else {
        $("#ventas").html(ventas);
    }
}
</script>