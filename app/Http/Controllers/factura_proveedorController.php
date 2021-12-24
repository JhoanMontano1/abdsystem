<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\factura_proveedorModel;
use App\Models\proveedorModel;
use App\Models\clienteModel;
use App\Models\articuloModel;
use App\Models\forma_entradaModel;
use App\Models\forma_pagoModel;
use PDF;
class factura_proveedorController extends Controller
{
    //
    public function index(){
        $factura = DB::table('factura_proveedor')
        ->join('forma_pago', 'factura_proveedor.id_forma_pago', '=', 'forma_pago.id')
        ->join('proveedor', 'factura_proveedor.id_proveedor', '=', 'proveedor.id')
        ->select('factura_proveedor.*', 'proveedor.nombres as proveedor','forma_pago.tipo as forma_pago')
        ->paginate(5);
       return view('factura_proveedor.index',compact('factura'));
    echo 'probando...';
    }

    public function create()
    {
    }


    public function store(Request $request)
    {
        $factura=array(
            // 'id_articulo'=>$_POST['id_articulo'],
            'id_proveedor'=>$_POST['id_proveedor'],
            'id_forma_pago'=>$_POST['id_forma_pago'],
            // 'cantidad'=>$_POST['cantidad'],
            'total'=>$_POST['total'],
        );
        DB::table('factura_proveedor')->insert($factura);
        $id= DB::select('select max(id) from factura_proveedor');
        $id_factura=$id[0]->{'max(id)'};

        $array=$_POST['detalle'];
        $cantidad_total=0;
foreach($array as $detalles){
$f_detalle=array(
    'id_factura'=>$id_factura,
    'id_articulo'=>$detalles['id_articulo'],
    'cantidad'=>$detalles['cantidad'],
    'precio'=>$detalles['precio'],
    'total'=>$detalles['total']);
    $cantidad_total+=$detalles['cantidad'];
    DB::table('detalle_factura_proveedor')->insert($f_detalle);
    DB::update('update articulo set stock = stock + ? where id = ?', [$detalles["cantidad"],$detalles["id_articulo"]]);
}

$array_entrada=$_POST['entrada'];
$cantidad=$array_entrada['cantidad'];
$id_articulo=$array_entrada['id_articulo'];

$entrada=array(
    // 'id_articulo'=>$array_entrada['id_articulo'],
    'id_forma_entrada'=>$array_entrada['id_forma_entrada'],
    'id_proveedor'=>$array_entrada['id_proveedor'],
    'id_factura'=>$id_factura,
    'cantidad'=>$cantidad_total,
    'total'=>$_POST['total']);

DB::table('entrada')->insert($entrada);


echo $id_factura;
    }

    public function show(entrada $entrada)
    {
        //
    }

    public function edit($id)
    {

    }


    public function update(Request $request,$id)

    {

    }


    public function destroy($id)
    {
        factura_proveedorModel::destroy($id);
        return redirect('factura_proveedor')->with('mensaje','La factura se ha eliminada correctamente');
    }

    public function generateInvoice(){

        
        $fact=DB::select('select* from factura_proveedor where id='.$_GET['id']);
        $detalle=DB::select('select* from detalle_factura_proveedor where id_factura='.$_GET['id']);
        $proveedor=DB::select('select nombres from proveedor where id='.$fact[0]->{'id_proveedor'});
        $hora=DB::select('SELECT DATE(factura_proveedor.fecha) As fecha,HOUR(factura_proveedor.fecha) As hora,MINUTE(factura_proveedor.fecha) AS minuto FROM factura_proveedor where id='.$_GET['id']);
        // $hora=DB::select('SELECT Format(fecha ,"hh:mm") as hora from factura_proveedor where id='.$_GET['id']);
        $array=array(
            'id'=>$_GET['id'],
            'fecha'=>$hora[0]->{'fecha'},
            'proveedor'=>$proveedor[0]->{'nombres'},
            'hora'=>$hora[0]->{'hora'},
            'minuto'=>$hora[0]->{'minuto'},
            'total'=>$fact[0]->{'total'}
        );
        $array2=array();
        // echo 'factura no.'.$_GET['id'];
        // echo '</br>';
        // echo 'fecha: '.$fact[0]->{'fecha'};
        // echo '</br>';
        // echo 'proveedor: '.$proveedor[0]->{'nombres'};
        echo '</br>';
        foreach($detalle as $d){
            $articulo=DB::select('select descripcion from articulo where id='.$d->{'id_articulo'});
            $temp=array(
                'cantidad'=>$d->{'cantidad'},
                'descripcion'=>$articulo[0]->{'descripcion'},
                'precio'=>$d->{'precio'},
                'total'=>$d->{'total'}
            );
            array_push($array2,$temp);
        //   echo  'cantidad: '.$d->{'cantidad'}.' Descripcion: '.$articulo[0]->{'descripcion'};
        //   echo '</br>';

        }

        if(isset($_GET['pdf'])){

            $pdf=PDF::loadView('factura_proveedor.detalle',compact('array','array2'));
            return $pdf->stream("Factura.pdf");
        }
        else{return view('factura_proveedor.detalle',compact('array','array2'));}
        
    }
    public function cancelInvoice(){
$id=$_GET['id'];
$fact=DB::select('select* from factura_proveedor where id='.$_GET['id']);
$detalle=DB::select('select* from detalle_factura_proveedor where id_factura='.$_GET['id']);

foreach($detalle as $d){
    DB::update('update articulo set stock = stock - ? where id = ?', [$d->{'cantidad'} , $d->{'id_articulo'}]);
} 
DB::update('update factura_proveedor set anulado=1 where id='.$id); 

$factura=factura_proveedorModel::paginate(10);
return redirect()->route('factura_proveedor.index');
    }


    public function search(){

        $factura=array();
        if(isset($_GET['date_i']) && isset($_GET['date_f'])){

            $date_i= $_GET['date_i'];
            $date_f=$_GET['date_f'];
            $factura = DB::table('factura_proveedor')
            ->join('proveedor', 'factura_proveedor.id_proveedor', '=', 'proveedor.id')
            ->join('forma_pago', 'factura_proveedor.id_forma_pago', '=', 'forma_pago.id')
            ->select('factura_proveedor.*', 'proveedor.nombres as proveedor','forma_pago.tipo as forma_pago')
           ->WhereBetween('factura_proveedor._fecha', [$date_i, $date_f])
            ->paginate(5);
            return view('factura_proveedor.search',compact('factura','date_i','date_f'));
        }
        elseif(isset($_GET['search'])){

            $value= $_GET['search'];
            $search=$value;
            $factura = DB::table('factura_proveedor')
            ->join('proveedor', 'factura_proveedor.id_proveedor', '=', 'proveedor.id')
            ->join('forma_pago', 'factura_proveedor.id_forma_pago', '=', 'forma_pago.id')
            ->select('factura_proveedor.*', 'proveedor.nombres as proveedor','forma_pago.tipo as forma_pago')
           // ->WhereBetween('factura_cliente.fecha', [$date_i, $date_f])
           ->where('forma_pago.tipo','like','%'.$value.'%')
           ->orWhere('factura_proveedor.id','like','%'.$value.'%')
           ->orWhere('proveedor.nombres','like','%'. $value.'%')
           // ->orWhere('factura_proveedor._fecha','like','%'.$value.'%')
            ->paginate(5);
            return view('factura_proveedor.search',compact('factura','search'));
        }
     }
}