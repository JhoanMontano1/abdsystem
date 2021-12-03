@include('componentes.header')
<div class="container">

<div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Nueva entrada(s)</div>
<div class="card-body">

<div class="form-group row">
    <label for="type" class="col-md-4 col-form-label text-md-right">Fecha</label>

    <div class="col-md-6">
<input type="datetime-local" name="fecha" id="">
    </div>
</div>

<div class="form-group row">
    <label for="type" class="col-md-4 col-form-label text-md-right">Tipo de entrada</label>

    <div class="col-md-6">
 <select name="id_forma_entrada">
    <option disabled="true">Seleccione una forma de entrada</option>
    @if(isset($forma_entrada))
    @foreach($forma_entrada as $forma)

    <option value="{{$forma->id}}" @if(isset($entrada)){{$forma->id==$entrada->id_forma_entrada ? 'selected' :''}}
        @endif>{{$forma->tipo}}
    </option>

    @endforeach
    @endif
</select>
    </div>
</div>
<div class="form-group row">
    <label for="type" class="col-md-4 col-form-label text-md-right">Proveedor</label>

    <div class="col-md-6">
<select name="id_proveedor">
    <option disabled="true">Seleccione un proveedor</option>
    @if(isset($proveedor))
    @foreach($proveedor as $proveedores)

    <option value="{{$proveedores->id}}"
        @if(isset($entrada)){{$proveedores->id==$entrada->id_proveedor ? 'selected' :''}} @endif>
        {{$proveedores->nombres}}
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
    <label for="type" class="col-md-4 col-form-label text-md-right">Buscar artículo</label>

    <div class="col-md-6">
<input type="search" name="" value="" id="searchA" context="articulo">
    </div>
</div>



    </div>
    <table id="tabla" class="table">
        <thead>
            <tr>
                 <th scope="col">Prod.</th>
                <th scope="col">Cant.</th>
                <th scope="col">Precio</th>
                <th scope="col">Agregar</th>          
            </tr>
     
        </thead>

        <Tbody>
        </Tbody>
    </table>
    <h3>Factura:</h3>

    <!-- <h5>Iva   <input type="checkbox" name="" id="Check_iva"> <input type="number" name="" id="iva"></h5>
    <h5>Desc <input type="checkbox" name="" id="Check_descuento"> <input type="number" name="" id="descuento"></h5> -->
    <div class="container">
      <div class="row">
        <div class="col-12">
          <div class="table-responsive">
    <table id="factura" style="" class="table">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Cant.</th>
                <th scope="col">Nombre</th>
                <th scope="col">Prec./U</th>
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
<table class="table">
        <thead>
            <tr>
                <th>
                    Total
                </th>
                <!-- <th>
                    Desc
                </th>
                <th>
                   Iva
                </th> -->
            </tr>
        </thead>
        <tbody>
            <tr>
                <td id="_total">-</td>
                <!-- <td id="_descuento">-</td>
                <td id="_iva">-</td> -->
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

let currentHtml = "";
let facturaHtml="";
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
                currentHtml +=
                    `
    <tr p-id='${datos.id}'>

    <td>${datos.nombre}</td>
    <td> <input type="number" value="1" class="cantidad" pattern="^[1-9]" title='Only Number' min="1" step="1" style="width:40%;"/> </td>
    <td> <input disabled style="width:40%;" value="${datos.precio}" type="number"/> </td>
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
$(document).on('click','.itemResult',function(){
    let existente=false;
    let factura=$('#factura Tbody tr');
    let selfItem= $(this)[0];
    let selfId=$(selfItem.parentElement.parentElement).attr('p-id');
    let filas=$('#tabla Tbody tr');
    console.log('Elemento presionado: '+$(selfItem.parentElement.parentElement).attr('p-id'));
    searchById(selfId,'cantidad');

//VERIFICAMOS SI HAY AL MENOS UNA FILA EN EL CUERPO DE LA TABLA
if($('#factura tr').length>1){

//VERIFICAR SI EL PRODUCTO YA SE HA ANADIDO A LA FACTURA, DE SER ASI SE SUMA LA CANTIDAD
//Y SE VUELVE A CALCULAR EL TOTAL
for(let i=0;i<factura.length;i++){

    if($(factura[i]).attr('p-id')===$(selfItem.parentElement.parentElement).attr('p-id')){
        existente=true;
        break;
    }
}}

let precio;
let cantidad;
let nombre;
let id;
for(let i=0;i<filas.length;i++){

//Busca hasta encontrar el id correspondiente para extraer la informacion de la fila
//de resultados, y a continuacion se agregan a la tabla de factura
if($(filas[i]).attr('p-id')===$(selfItem.parentElement.parentElement).attr('p-id') )
{
    items=$(filas[i]).children();

    //ID
    id=$(filas[i]).attr('p-id');
    //NOMBRE
    nombre=$(items[0]).html();

    //CANTIDAD
   cantidad=$(items[1]).children();
   cantidad=$(cantidad).val(); 

   //PRECIO
   precio=$(items[2]).children();
   precio=$(precio).val();



break;
}

}


//SI EL ELEMENTO NO EXISTE ENTONCES:
if(!existente){
    facturaHtml+=
`<tr p-id="${id}">
<td>${id}</td>
<td>${cantidad}</td>
<td>${nombre}</td>
<td>${precio}</td>
<td>${cantidad*precio}</td>
<td> <button class='btn btn-sm btn-danger delete'>Eliminar</button></td>
</tr>`;


   console.log('cantidad: '+cantidad);
   console.log('Nombre: '+nombre);
   console.log('Precio: '+precio);
   $('#factura Tbody').html(facturaHtml);

}
//SI EXISTE
else
{
    console.log('elemento existente');
calcFactura(id,cantidad);
facturaHtml=$('#factura Tbody').html();
}


///TOTAL FINAL
totalFinal();
});

function calcFactura(id,_cantidad)
{
let total=searchById(id,'total');
let precio=searchById(id,'precio');
let cantidad=searchById(id,'cantidad');

$(cantidad).html(parseInt($(cantidad).html())+parseInt(_cantidad));
console.log('cantidad actualizada: '+$(cantidad).html());
console.log('precio: '+$(precio).html());

$(total).html(parseInt($(cantidad).html())*parseInt($(precio).html()));
}

function searchById(id,param){
    let factura=$('#factura Tbody tr');
    for(let i=0;i<factura.length;i++){

if($(factura[i]).attr('p-id')===id){
    let value=$(factura[i]).children();
switch(param){
    case 'cantidad':
    value=$(value[1]);
    break;
    case 'total':
    value=$(value[4]);
    break;
    case 'precio':
        value=$(value[3]);
    break;
}
//console.log(param==='total'?'total:' :'cantidad: '+value);

  return value;
}
}
}

$(document).on('click','.delete',function(){
    let element=$(this)[0].parentElement.parentElement;
    
    $(element).remove();
    
    facturaHtml=$('#factura Tbody').html();
    totalFinal();
    
});
/*---------------------------------------*/
function totalFinal() {
let datos=$('#factura Tbody tr');
let total=0;
if(datos.length>0){
for(let i=0;i<datos.length;i++){
  let temp=$(datos[i]).children();
  total+=parseInt($(temp[4]).html());
  $('#_total').html(total);
}   
}
else{$('#_total').html('-');}

}

///ANADIR FACTURA Y DETALLES DE FACTURA
function FACTURA(){

    console.log($('#factura tr').length);
    if($('#factura tr').length>1){
        $('#btn-factura').prop('disabled',true);
    let array=[];
    let id;
    let cantidad;
    let total;
    let precio;
    let id_forma_entrada;
    let id_forma_pago;
    let id_proveedor;
    let fecha;
    let _token;
    let factura=$('#factura Tbody tr');
    for(let i=0;i<factura.length;i++){
        id=$(factura[i]).attr('p-id');
        let value=$(factura[i]).children();
        cantidad=$(value[1]).html();
        total=$(value[4]).html();
        precio =$(value[3]).html();
       id_forma_entrada=$('select[name=id_forma_entrada]').val();
        id_forma_pago=$('select[name=id_forma_pago]').val();
        id_proveedor=$('select[name=id_proveedor]').val();
        fecha=$('input[name=fecha]').val();
//alert("producto numero: "+(i+1)+"\nid: "+id+"\ncantidad: "+cantidad+"\ntotal: "+total+"\nprecio: "+precio+"\nid_forma_entrada: "+id_forma_entrada+"\nid_forma_pago: "+id_forma_pago+"\nid_proveedor: "+id_proveedor+"\nfecha: "+fecha);
        _token   = $('meta[name="csrf-token"]').attr('content');

        let temp={
            id_articulo:id,
            cantidad:cantidad,
            total:total,
            precio:precio
        };

        array.push(temp);
    }

    let array_entrada={
    id_articulo:id,
      id_forma_entrada:id_forma_entrada,
      id_proveedor:id_proveedor,
      fecha:fecha,
      cantidad:cantidad,
      total:total
        };
console.log(array);
$.ajax({
  type: "POST",
  url: "{{url('/factura_proveedor')}}",
  data: {
      detalle:array,
      entrada:array_entrada,
      id_forma_pago:id_forma_pago,
      id_proveedor:id_proveedor,
      fecha:fecha,
      total:$('#_total').html(),
      _token: _token
  },
  success: function(data) {
    window.location = `
    {{url('/invoice_prov?id=${data}')}}
    `;
      console.log(data);
  }
});
}else{alert('Sin productos en lista');};

}

$(document).on('input','.cantidad',function(e){
    let self=$(this)[0];
    let value=$(self).val();
    if(value<1){
        $(self).val('1');
    }
});
</script>