<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reporte</title>
    <!-- <link rel="stylesheet" href="{{asset('css/bootstrap.min.css')}}"> -->
    <style>
    .container {}

    .container>table {
        width: 100%
    }

    .container>table>thead>tr>th {
        font-family: Arial, serif;
        background-color: gray;
        color: white;
        padding-top: 0.5%;
    }

    .container>table>tbody>tr>td {
        text-align: center;
        font-family: Arial, serif;
        color: black;
        padding-top: 0.5%;
    }
    </style>
</head>

<body>
    <form action="{{url('/report')}}" method="get">
        @if(isset($_GET['context']))
        <input type="hidden" name="context" value="{{$_GET['context']}}">
        @endif
        @if(!isset($_GET['pdf']))

        <div style="text-align:center;">
            <a style="text-decoration:none; border-radius: 30px;background-color:#009900;color:white;"
                href="{{$context}}">Volver</a> <br>
            <input type="submit" value="Descargar pdf"
                style="border-radius: 30px;background-color:#009900;color:white;">
        </div>
        @endif
        <input type="hidden" name="pdf" value="true">

    </form>
    <?php
$array=array();
$variable="";
foreach($datos as $value){

  $variable= implode(",",array_keys($value));
}
$array=explode(',',$variable);
$array2=array();
foreach($array as $value){
    $temp=$value;
   if (substr($value,0,2)=="id"){
       $temp=substr($value,2,strlen($value));
       array_push($array2,"#".strtoupper(substr($temp,1,1)).substr(str_replace("_"," ",$temp),2,strlen($temp)));
   }
   else{array_push($array2,strtoupper(substr($temp,0,1)).substr($temp,1,strlen($temp)));}

}
?>
    <div class="container">
        <table class="table">
            <thead class="">
                <tr>
                    <?php $n=0; ?>
                    @foreach ($array2 as $value)

                    <th @if ($value=="Total" ) numero={{$n}} id=Total @elseif ($value=="Cantidad" ) numero={{$n}}
                        id=Cantidad @elseif ($value=="Iva" ) numero={{$n}} id=Iva @endif>
                        {{$value}}
                    </th>
                    <?php $n+=1; ?>
                    @endforeach

                </tr>
            </thead>
            <tbody>

                @foreach($datos as $dato)
                <tr>
                    @foreach ($dato as $valor)
                    <td>
                        {{$valor}}
                    </td>
                    @endforeach



                </tr>
                @endforeach

            </tbody>

        </table>
    </div>
</body>

</html>
<script src="{{asset('js/jquery.js')}}"></script>
<script>
var cantidad_position = $("#Cantidad").attr("numero");
var total_position = $("#Total").attr("numero");
var iva_position = $("#Iva").attr("numero");
var table = $("#table tbody tr");


$("tbody tr").each(function(index, element) {
    var rows=$(element).children();

   let temp_total= $(rows[total_position]).html();
   let temp_iva=$(rows[iva_position]).html();
   $(rows[total_position]).html("C$"+$.trim(temp_total));
   $(rows[iva_position]).html(parseFloat(temp_iva*100)+"%");
 });
</script>