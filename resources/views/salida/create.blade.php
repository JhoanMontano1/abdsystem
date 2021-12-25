@include('componentes.header')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">Nueva salida(s)</div>
            <div class="card-body">

                <!-- <div class="form-group row">
                    <label for="type" class="col-md-4 col-form-label text-md-right">Fecha</label>

                    <div class="col-md-6">
                        <input type="datetime-local" name="fecha" id="">
                    </div>
                </div> -->

                <div class="form-group row">
                    <label for="type" class="col-md-4 col-form-label text-md-right">Tipo de salida</label>

                    <div class="col-md-6">
                        <select name="id_forma_salida">
                            <option disabled="true">Seleccione una forma de entrada</option>
                            @if(isset($forma_salida))
                            @foreach($forma_salida as $forma)

                            <option value="{{$forma->id}}">{{$forma->tipo}}
                            </option>

                            @endforeach
                            @endif
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="type" class="col-md-4 col-form-label text-md-right">Cliente</label>

                    <div class="col-md-6">
                        <select name="id_cliente">
                            <option disabled="true">Seleccione un Cliente</option>
                            @if(isset($cliente))
                            @foreach($cliente as $clientes)

                            <option value="{{$clientes->id}}">
                                {{$clientes->nombres}}
                            </option>

                            @endforeach
                            @endif
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="type" class="col-md-4 col-form-label text-md-right">Forma de pago</label>

                    <div class="col-md-6">
                        <select name="id_forma_pago">
                            <option disabled="true">Forma de pago</option>
                            @if(isset($forma_pago))
                            @foreach($forma_pago as $pago)

                            <option value="{{$pago->id}}"
                                @if(isset($entrada)){{$pago->id==$entrada->id_forma_pago ? 'selected' :''}} @endif>
                                {{$pago->tipo}}
                            </option>

                            @endforeach
                            @endif
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                        <label for="type" class="col-md-4 col-form-label text-md-right">Iva</label>

                        <div class="col-md-6">
                            <select name="iva">
                            <option value="0.00">0%</option>
                        <option value="0.05">5%</option>
                        <option value="0.10">10%</option>
                        <option value="0.15">15%</option>
                            </select>
                        </div>
                    </div>
                <div class="form-group row">
                    <label for="type" class="col-md-4 col-form-label text-md-right">Buscar artículo</label>

                    <div class="col-md-6">
                        <input type="search" name="" value="" id="searchA" context="articulo_venta">
                    </div>
                </div>

            </div>
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <div class="table-responsive">
                            <table id="tabla" class="table">
                                <thead>
                                    <tr>
                                        <th scope="col">Producto</th>
                                        <th scope="col">Cantidad</th>
                                        <th scope="col">Precio</th>
                                        <th scope="col">Stock</th>
                                        <th scope="col">Agregar</th>
                                    </tr>

                                </thead>

                                <Tbody>
                                </Tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <h3>Factura:</h3>

            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <div class="table-responsive">
                            <table id="factura" class="table">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Cant.</th>
                                        <th scope="col">Nombre</th>
                                        <th scope="col">Precio/U</th>
                                        <th scope="col">Total</th>
                                        <th scope="col">Quitar</th>
                                    </tr>
                                </thead>
                                <Tbody>

                                </Tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <table>
                <thead>
                    <tr>
                        <th>
                            Total
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td id="_total">-</td>
                    </tr>
                </tbody>
            </table>
            <div class="text-center">
                <button class="btn btn-primary" id="btn-factura" onclick="FACTURA()" id="btn">Facturar</button>
                <a class="btn btn-secondary" href="{{url('/salida')}}">Volver</a>
            </div>

        </div>
        @include('componentes.footer')



        <script>
        $('input[name=fecha]').val(moment().format('YYYY-MM-DDThh:mm'));
        $('#iva').hide();
        $('#descuento').hide();
        let stockResult = 0;
        let currentHtml = "";
        let facturaHtml = "";
        let tabla = $("#tabla");
        tabla.css("color", "blue");



        function search(context, value) {
            $.ajax({
                url: "{{url('search')}}",
                type: "get",
                cache: false,
                data: {
                    value: value,
                    context: context
                },
                success: function(data) {
                    let datos = JSON.parse(data);
                    console.log(datos);
                    datos.forEach(datos => {
                        stockResult = datos.stock;
                        currentHtml +=
                            `
    <tr p-id='${datos.id}' p-stock='${datos.stock}'>

    <td>${datos.nombre}</td>
    <td> <input type="number" value="1" class="cantidad" pattern="^[1-9]" title='Only Number' min="1" step="1" style="width:40%;"/> </td>
    <td> <input disabled style="width:40%;" value="C$${datos.precio}" type="text"/> </td>
    <td>${datos.stock} </td>
    <td> <button class='btn btn-sm btn-primary itemResult'>+</button></td>
    </tr>
    `;
                    });
                    $('#tabla Tbody').html(currentHtml);
                    currentHtml = "";
                }
            });
        }
        //BUSCADOR
        $('#searchA').on('input', () => {
            if ($('#searchA').val() !== "") {
                search($('#searchA').attr('context'), $('#searchA').val());
            } else {
                $('#tabla Tbody').html('');
            }
        });



        //EVENTO DE CLICK EN LOS ITEMS RESULTANTES DE LA BUSQUEDA
        $(document).on('click', '.itemResult', function() {
            let existente = false;
            let factura = $('#factura Tbody tr');
            let selfItem = $(this)[0];
            let selfStock = $(selfItem.parentElement.parentElement).attr('p-stock');
            let selfId = $(selfItem.parentElement.parentElement).attr('p-id');
            let filas = $('#tabla Tbody tr');
            console.log('Elemento presionado: ' + $(selfItem.parentElement.parentElement).attr('p-id'));
            searchById(selfId, 'cantidad');

            //VERIFICAMOS SI HAY AL MENOS UNA FILA EN EL CUERPO DE LA TABLA
            if ($('#factura tr').length > 1) {

                //VERIFICAR SI EL PRODUCTO YA SE HA ANADIDO A LA FACTURA, DE SER ASI SE SUMA LA CANTIDAD
                //Y SE VUELVE A CALCULAR EL TOTAL
                for (let i = 0; i < factura.length; i++) {

                    if ($(factura[i]).attr('p-id') === $(selfItem.parentElement.parentElement).attr('p-id')) {
                        existente = true;
                        break;
                    }
                }
            }

            let precio;
            let cantidad;
            let nombre;
            let id;
            for (let i = 0; i < filas.length; i++) {

                //Busca hasta encontrar el id correspondiente para extraer la informacion de la fila
                //de resultados, y a continuacion se agregan a la tabla de factura
                if ($(filas[i]).attr('p-id') === $(selfItem.parentElement.parentElement).attr('p-id')) {
                    items = $(filas[i]).children();

                    //ID
                    id = $(filas[i]).attr('p-id');
                    //NOMBRE
                    nombre = $(items[0]).html();

                    //CANTIDAD
                    cantidad = $(items[1]).children();
                    cantidad = $(cantidad).val();

                    //PRECIO
                    precio = $(items[2]).children();
                    precio = $(precio).val();



                    break;
                }

            }


            //SI EL ELEMENTO NO EXISTE ENTONCES:
            //alert('\nCantidad que se quiere anadir:'+cantidad+'\nstock del producto: '+selfStock);
            selfStock = parseInt(selfStock);
            cantidad = parseInt(cantidad);
            if (!existente) {
                //alert('no existe');
                if (selfStock >= cantidad) {
                    // alert('es mayor');
                    facturaHtml +=
                        `<tr p-id="${id}">
<td>${id}</td>
<td>${cantidad}</td>
<td>${nombre}</td>
<td>${precio}C$</td>
<td>C$${parseFloat(cantidad)*parseFloat(precio.substring(2,precio.length))}</td>
<td> <button class='btn btn-sm btn-danger delete'>Eliminar</button></td>
</tr>`;


                    console.log('cantidad: ' + cantidad);
                    console.log('Nombre: ' + nombre);
                    console.log('Precio: ' + precio);
                    $('#factura Tbody').html(facturaHtml);
                } else {
                    alert('La cantidad ingresada supera la cantidad en stock');
                }
                //+'\nCantidad que se quiere anadir: '+selfStock+'\nstock del producto'+cantidad


            }
            //SI EXISTE
            else {
                console.log('elemento existente');
                calcFactura(id, cantidad, selfStock);
                facturaHtml = $('#factura Tbody').html();
            }


            ///TOTAL FINAL
            totalFinal();
        });

        function calcFactura(id, _cantidad, stock) {
            let total = searchById(id, 'total');
            let precio = searchById(id, 'precio');
            let cantidad = searchById(id, 'cantidad');
            let cantidadInt = parseInt($(cantidad).html()) + parseInt(_cantidad);
            if (stock >= cantidadInt) {
                $(cantidad).html(parseInt($(cantidad).html()) + parseInt(_cantidad));
                console.log('cantidad actualizada: ' + $(cantidad).html());
                console.log('precio: ' + $(precio).html());

                $(total).html("C$"+parseInt($(cantidad).html()) * parseFloat($(precio).html().substring(2,$(precio).html().length)));
            } else {
                alert('La cantidad ingresada super al stock del productos')
            }

        }

        function searchById(id, param) {
            let factura = $('#factura Tbody tr');
            for (let i = 0; i < factura.length; i++) {

                if ($(factura[i]).attr('p-id') === id) {
                    let value = $(factura[i]).children();
                    switch (param) {
                        case 'cantidad':
                            value = $(value[1]);
                            break;
                        case 'total':
                            value = $(value[4]);
                            break;
                        case 'precio':
                            value = $(value[3]);
                            break;
                    }
                    //console.log(param==='total'?'total:' :'cantidad: '+value);

                    return value;
                }
            }
        }

        $(document).on('click', '.delete', function() {
            let element = $(this)[0].parentElement.parentElement;

            $(element).remove();

            facturaHtml = $('#factura Tbody').html();
            totalFinal();

        });


        /*---------------------------------------*/
        function totalFinal() {
            let datos = $('#factura Tbody tr');
            let total = 0;
            if (datos.length > 0) {
                for (let i = 0; i < datos.length; i++) {
                    let temp = $(datos[i]).children();
                    total += parseInt($(temp[4]).html().substring(2,$(temp[4]).html().length));
                    $('#_total').html("C$"+total);
                }
            } else {
                $('#_total').html('-');
            }

        }


        ///ANADIR FACTURA Y DETALLES DE FACTURA
        function FACTURA() {

            if ($('#factura tr').length > 1) {
                $('#btn-factura').prop('disabled', true);
                let array = [];
                let iva;
                let id;
                let cantidad;
                let total;
                let precio;
                let id_forma_salida;
                let id_forma_pago;
                let id_cliente;
                // let fecha;
                let _token;
                let factura = $('#factura Tbody tr');
                for (let i = 0; i < factura.length; i++) {
                    id = $(factura[i]).attr('p-id');
                    let value = $(factura[i]).children();
                    cantidad = $(value[1]).html();
                    total =parseFloat($(value[4]).html().substring(2,$(value[4]).html().length));
                    precio =parseFloat($(value[3]).html().substring(2,$(value[3]).html().length));
                    id_forma_salida = $('select[name=id_forma_salida]').val();
                    id_forma_pago = $('select[name=id_forma_pago]').val();
                    id_cliente = $('select[name=id_cliente]').val();
                    iva=$('select[name=iva]').val();
                    // fecha = $('input[name=fecha]').val();

                    _token = $('meta[name="csrf-token"]').attr('content');

                    let temp = {
                        id_articulo: id,
                        cantidad: cantidad,
                        total: total,
                        precio: precio
                    }

                    array.push(temp);
                }

                let array_salida = {
                    id_articulo: id,
                    id_forma_salida: id_forma_salida,
                    id_cliente: id_cliente,
                    // fecha: fecha,
                    cantidad: cantidad,
                    total: total,
                }

                console.log(array);
                $.ajax({
                    type: "POST",
                    url: "{{url('/factura_cliente')}}",
                    data: {
                        detalle: array,
                        salida: array_salida,
                        id_forma_pago: id_forma_pago,
                        id_cliente: id_cliente,
                        // fecha: fecha,
                        iva:iva,
                        total: parseFloat($('#_total').html().substring(2,$('#_total').html().length)),
                        _token: _token
                    },
                    success: function(data) {
                        window.location = `
    {{url('/invoice_client?id=${data}')}}
    `;
                        console.log(data);
                    }
                });
            } else {
                alert('La lista de elementos esta vacia')
            }

        }

        $(document).on('input', '.cantidad', function(e) {
            let self = $(this)[0];
            let value = $(self).val();
            if (value < 1) {
                $(self).val('1');
            }
        });
        </script>