<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Factura</title>
    <style>
        .container{width:100%;
            text-align:center;}
        .factura{
          
        border:1px solid #3390FF;
          display:flex;
          flex-wrap:wrap;
          background-color:#ffff00;
          width:200px;
          height:200px;
          border-radius:10px;
          flex-direction:column;
        }
        .item1{
            
            border-radius:10px;
            width:100%;
            height:30px;
            text-align:center;
            background-color:#3390FF;
            padding-top:5px;
            color:white;
            font-weight:bold;
        }
        .item{
            margin:5px;
            padding:5px;
        }

        table {
        width: 100%
    }
    #factura{
        width: 100%;
    }

   table>thead>tr>th {
        font-family: Arial, serif;
        background-color: gray;
        color: white;
        padding-top: 0.5%;
    }

    table>tbody>tr>td {
        text-align: center;
        font-family: Arial, serif;
        color: black;
        padding-top: 0.5%;
    }
    </style>
</head>
<body>




        <div class="container">
<div>
    <img src="{{asset('img/logoCentral.png')}}" width="200px" height="60px" alt="" srcset="">
</div>
<div>
    David antonio picado flores.
</div>
<div style="font-weight:bold;">
PROPIETARIO
</div>
<div>
    Ruc: 001053890000P
</div>
<div>
    Dir.:Managua km 8 carrtera norte DDFka recargo 10 cuadras al norte 1 1/2 cuadra al oeste, barrio camilo chamorro.
</div>
<div>
    Cel.:88465479
</div>
<table id="factura">
    <thead>
        <tr><th>FACTURA</th></tr>
    </thead>
    <tbody>
        <tr>
            <td style="color:red;">No: {{$array['id']}}</td>
        </tr>
        <tr>
        <td>Fecha: {{$array['fecha']}}</td>
        </tr>
        <tr>
        <td>Hora: {{$array['hora']}}:{{$array['minuto']}}</td>
        </tr>
        <tr>
        <td>Cliente: {{$array['cliente']}}</td>
        </tr>
    </tbody>
</table>

<!-- <div class="factura">
<div class="item1"> 
    Factura
   
</div>
<div class="item">No.factura: {{$array['id']}}</div>
<div class="item">Fecha: {{$array['fecha']}}</div>
<div class="item">Hora: {{$array['hora']}}:{{$array['minuto']}}</div>
<div class="item">Proveedor: {{$array['cliente']}}</div>
</div> -->

<table>
    <thead>
            <tr>
                <th>Cantidad</th>
                <th>Descripcion</th>
                <th>Precio Unitario</th>
                <th>Precio Total</th>
            </tr>
    </thead>
    <tbody>
        @foreach ($array2 as $detalle)
            <tr>
                <td>{{$detalle['cantidad']}}</td>
                <td>{{$detalle['descripcion']}}</td>
                <td>{{$detalle['precio']}}C$</td>
                <td>{{$detalle['total']}}C$</td>
            </tr>
        @endforeach

        <tr>
            <td></td>
            <td></td>
            <td></td>
            <td>Desc: 0.0</td>
        </tr>
        <tr>
            <td></td>
            <td></td>
            <td></td>
            <td>Iva: {{$array['iva']}}</td>
        </tr>
        <tr>
            <td></td>
            <td></td>
            <td></td>
            <td>Subtotal:{{$array['total']}}C$</td>
        </tr>
        <tr>
            <td></td>
            <td></td>
            <td></td>
            <td>Total:{{($array['total']*$array['iva'])+$array['total']}}C$</td>
        </tr>
    </tbody>
</table>

<hr style="width:120px;">
<div>Entregue conforme</div>
<br>
<div>DAVID PICADO</div>
<div style="font-size:12px;">
    <strong>NOTA:</strong> Garantia de 1 mes para celulares y accesorios dependiendo del producto. <br>
    Y no se responde por golpe ni por mojarlo.
</div>
</div>


 @if (!isset($_GET['pdf']))
<form action="" method="get" style="text-align:center;">
<input type="hidden" name="pdf" value="true">
   
<input type="hidden" name="id" value="{{$_GET['id']}}">
<input type="submit" value="Imprimir factura">
</form>
<div style="text-align:center;">
<a  href="{{url('/factura_cliente')}}"><button >Volver</button></a>
</div>
@endif



</body>
</html>