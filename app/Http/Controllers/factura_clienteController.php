<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\DB;
use App\Models\factura_clienteModel;
use App\Models\entradaModel;
use App\Models\proveedorModel;
use App\Models\clienteModel;
use App\Models\articuloModel;
use App\Models\forma_entradaModel;
use App\Models\forma_pagoModel;
use PDF;
class factura_clienteController extends Controller
{
    //
    public function index(){
        $product=DB::select("select articulo.id,descripcion as articulo, sum(detalle_factura_cliente.cantidad) as cantidad_vendida from articulo inner join detalle_factura_cliente on articulo.id=detalle_factura_cliente.id_articulo inner join factura_cliente on factura_cliente.id=detalle_factura_cliente.id_factura where factura_cliente.anulado=0 and month(factura_cliente._fecha)=month(curdate()) group by articulo.id order by cantidad_vendida desc limit 1;");

        $product2=DB::select("select articulo.id,descripcion as articulo, sum(detalle_factura_cliente.cantidad) as cantidad_vendida from articulo inner join detalle_factura_cliente on articulo.id=detalle_factura_cliente.id_articulo inner join factura_cliente on factura_cliente.id=detalle_factura_cliente.id_factura where factura_cliente.anulado=0 and month(factura_cliente._fecha)=month(curdate()) group by articulo.id order by cantidad_vendida limit 1;");
        // $product=DB::table('articulo')
        // ->join('detalle_factura_cliente', 'articulo.id', '=', 'detalle_factura_cliente.id_articulo')
        // ->join('factura_cliente','factura_cliente_detalle.id_factura','=','factura_cliente.id')
        // ->select('articulo.id','articulo.descripcion as articulo','sum(detalle_factura_cliente.cantidad) as cantidad_vendida')
        // ->where('factura_cliente.anulado','=',0)
        // ->groupBy('articulo.id')
        // ->limit(1)
        // ->get();

        $factura = DB::table('factura_cliente')
        ->join('forma_pago', 'factura_cliente.id_forma_pago', '=', 'forma_pago.id')
        ->join('cliente', 'factura_cliente.id_cliente', '=', 'cliente.id')
        ->select('factura_cliente.*', 'cliente.nombres as cliente','forma_pago.tipo as forma_pago')
        ->paginate(5);
       return view('factura_cliente.index',compact('factura','product','product2'));
    }

    public function create()
    {
        $entrada=$datos['entrada']=entradaModel::all();
       
        $proveedor=$datos2['proveedor']=proveedorModel::all();
        $forma_pago=$datos3['forma_pago']=forma_pagoModel::all();
        $forma_entrada=$datos4['forma_entrada']=forma_entradaModel::all();
        return view('entrada.create',$entrada,compact('proveedor','forma_entrada','forma_pago'));
    }


    public function store(Request $request)
    {
        $factura=array(
            // 'id_articulo'=>$_POST['id_articulo'],
            'id_cliente'=>$_POST['id_cliente'],
            'id_forma_pago'=>$_POST['id_forma_pago'],
            // 'cantidad'=>$_POST['cantidad'],
            'iva'=>$_POST['iva'],
            'total'=>$_POST['total'],
        );
        DB::table('factura_cliente')->insert($factura);
        $id= DB::select('select max(id) from factura_cliente');
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
            DB::table('detalle_factura_cliente')->insert($f_detalle);
            DB::update('update articulo set stock = stock - ? where id = ?', [$detalles['cantidad'] , $detalles['id_articulo']]);
        }

        $array_salida=$_POST['salida'];

        $salida=array(
            // 'id_articulo'=>$array_salida['id_articulo'],
            'id_forma_salida'=>$array_salida['id_forma_salida'],
            'id_cliente'=>$array_salida['id_cliente'],
            'id_factura'=>$id_factura,
            'cantidad'=>$cantidad_total,
            'total'=>$_POST['total']);

        DB::table('salida')->insert($salida);

        echo $id_factura;
        // articuloModel::where('id','=',$id)->update($datos);
        // return json_encode(array(
        //     "statusCode"=>200
        // ));
        //
        // $campos=[
        //      'id_forma_entrada'=>'required|integer',
        //     'id_proveedor'=>'required|integer',
        //     'fecha'=>'required|date',
        //     'cantidad'=>'required|integer',
        //     'total'=>'required|integer'];
        //     $mensaje=[
        //         'required'=>'El :attribute esta vacio',];
        //         $this->validate($request,$campos,$mensaje);
       
        //         // echo $request;

        // $datos=request()->except('_token');
        // entradaModel::insert($datos);
        //return redirect('entrada')->with('mensaje','La entrada se ha agregado correctamente');

    }

    public function show(entrada $entrada)
    {
        //
    }

    public function edit($id)
    {
        //
        $entrada=entradaModel::findOrFail($id);
        $proveedor=$datos2['proveedor']=proveedorModel::all();
        $forma_entrada=$datos3['forma_entrada']=forma_entradaModel::all();
        return view('entrada.edit',compact('entrada','proveedor','forma_entrada'));

    }


    public function update(Request $request,$id)

    {
         $campos=[
            'id_forma_entrada'=>'required|integer',
            'id_proveedor'=>'required|integer',
            'fecha'=>'required|date',
            'cantidad'=>'required|integer',
            'total'=>'required|integer'];
            $mensaje=[
                'required'=>'El :attribute esta vacío',];
                $this->validate($request,$campos,$mensaje);
        //
        $datos=request()->except(['_token','_method']);
        entradaModel::where('id','=',$id)->update($datos);
        $entrada=entradaModel::findOrFail($id);
        return redirect('entrada')->with('mensaje','entrada modificada correctamente');

    }


    public function destroy($id)
    {
        //

        factura_clienteModel::destroy($id);
        return redirect('factura_cliente')->with('mensaje','La factura se ha eliminada correctamente.');
    }


    public function generateInvoice(){

        
        $fact=DB::select('select* from factura_cliente where id='.$_GET['id']);
        $detalle=DB::select('select* from detalle_factura_cliente where id_factura='.$_GET['id']);
        $cliente=DB::select('select nombres,apellidos from cliente where id='.$fact[0]->{'id_cliente'});
        $hora=DB::select('SELECT DATE(factura_cliente.fecha) As fecha,HOUR(factura_cliente.fecha) As hora,MINUTE(factura_cliente.fecha) AS minuto FROM factura_cliente where id='.$_GET['id']);
        // $hora=DB::select('SELECT Format(fecha ,"hh:mm") as hora from factura_proveedor where id='.$_GET['id']);
        $array=array(
            'id'=>$_GET['id'],
            'fecha'=>$hora[0]->{'fecha'},
            'cliente'=>$cliente[0]->{'nombres'}.' '.$cliente[0]->{'apellidos'},
            'hora'=>$hora[0]->{'hora'},
            'minuto'=>$hora[0]->{'minuto'},
            'iva'=>$fact[0]->{'iva'},
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

            $pdf=PDF::loadView('factura_cliente.detalle',compact('array','array2'));
            return $pdf->stream("Factura.pdf");
        }
        else{return view('factura_cliente.detalle',compact('array','array2'));}
        
    }
    public function cancelInvoice(){
$id=$_GET['id'];
$fact=DB::select('select* from factura_cliente where id='.$_GET['id']);
$detalle=DB::select('select* from detalle_factura_cliente where id_factura='.$_GET['id']);

foreach($detalle as $d){
    DB::update('update articulo set stock = stock + ? where id = ?', [$d->{'cantidad'} , $d->{'id_articulo'}]);
} 
DB::update('update factura_cliente set anulado=1 where id='.$id); 

$factura=factura_clienteModel::paginate(10);
return redirect()->route('factura_cliente.index');
    }

    public function search(){
        // $factura=array();
        // if(isset($_GET['date_i']) && isset($_GET['date_f'])){
        //     $date_i=$_GET['date_i'];
        //     $date_f=$_GET['date_f'];
            
        //     $factura = DB::table('factura_cliente')
        //     ->join('cliente', 'factura_cliente.id_cliente', '=', 'cliente.id')
        //     ->join('forma_pago', 'factura_cliente.id_forma_pago', '=', 'forma_pago.id')
        //     ->select('factura_cliente.*', 'cliente.nombres as cliente','forma_pago.tipo as forma_pago')
        //     ->WhereBetween('factura_cliente._fecha', [$date_i, $date_f])
        //     ->paginate(5);
        //     return view('factura_cliente.search',compact('factura','date_i','date_f'));
        // }
        // elseif(isset($_GET['search'])){
        //     $search= $_GET['search'];
        //     $factura = DB::table('factura_cliente')
        //     ->join('cliente', 'factura_cliente.id_cliente', '=', 'cliente.id')
        //     ->join('forma_pago', 'factura_cliente.id_forma_pago', '=', 'forma_pago.id')
        //     ->select('factura_cliente.*', 'cliente.nombres as cliente','forma_pago.tipo as forma_pago')
        //    // ->WhereBetween('factura_cliente.fecha', [$date_i, $date_f])
        //    ->where('forma_pago.tipo','like','%'.$search.'%')
        //    ->orWhere('factura_cliente.id','like','%'.$search.'%')
        //    ->orWhere('cliente.nombres','like','%'. $search.'%')
        //    ->orWhere('factura_cliente._fecha','like','%'.$search.'%')
        //     ->paginate(5);
        //     return view('factura_cliente.search',compact('factura','search'));
        // } 


        $factura=array();
        if(isset($_GET['date_i']) && isset($_GET['date_f'])){
if(isset($_GET['type']))
{
    $date_i= $_GET['date_i'];
    $date_f=$_GET['date_f'];
    $factura = DB::table('factura_cliente')
    ->join('cliente', 'factura_cliente.id_cliente', '=', 'cliente.id')
    ->join('forma_pago', 'factura_cliente.id_forma_pago', '=', 'forma_pago.id')
    ->select('factura_cliente.*', 'cliente.nombres as cliente','forma_pago.tipo as forma_pago')
    ->WhereBetween('factura_cliente._fecha', [$date_i, $date_f])
    ->paginate(5);
    $data=json_encode($factura);
    $res = array(
     'data' => $data,
     'links' => $factura->links()->render(),
     'date_i'=>$date_i,
     'date_f'=>$date_f
    );
    return Response::json($res);
}

else{
    $date_i= $_GET['date_i'];
    $date_f=$_GET['date_f'];
    $factura = DB::table('factura_cliente')
    ->join('cliente', 'factura_cliente.id_cliente', '=', 'cliente.id')
    ->join('forma_pago', 'factura_cliente.id_forma_pago', '=', 'forma_pago.id')
    ->select('factura_cliente.*', 'cliente.nombres as cliente','forma_pago.tipo as forma_pago')
    ->WhereBetween('factura_cliente._fecha', [$date_i, $date_f])
    ->paginate(5);

    return view('factura_cliente.search',compact('factura','date_i','date_f'));

}

        }
        elseif(isset($_GET['search'])){
            if(isset($_GET['type']))
            {
                $value= $_GET['search'];
                $search=$value;
                $factura = DB::table('factura_cliente')
                ->join('cliente', 'factura_cliente.id_cliente', '=', 'cliente.id')
                ->join('forma_pago', 'factura_cliente.id_forma_pago', '=', 'forma_pago.id')
                ->select('factura_cliente.*', 'cliente.nombres as cliente','forma_pago.tipo as forma_pago')
               // ->WhereBetween('factura_cliente.fecha', [$date_i, $date_f])
               ->where('forma_pago.tipo','like','%'.$search.'%')
               ->orWhere('factura_cliente.id','like','%'.$search.'%')
               ->orWhere('cliente.nombres','like','%'. $search.'%')
               ->orWhere('factura_cliente._fecha','like','%'.$search.'%')
                ->paginate(5);
                $data=json_encode($factura);
                $res = array(
                 'data' => $data,
                 'links' => $factura->links()->render(),
                 'search'=>$search
                );
                return Response::json($res);
            }
            else
            {
            $value= $_GET['search'];
            $search=$value;
            $factura = DB::table('factura_cliente')
            ->join('cliente', 'factura_cliente.id_cliente', '=', 'cliente.id')
            ->join('forma_pago', 'factura_cliente.id_forma_pago', '=', 'forma_pago.id')
            ->select('factura_cliente.*', 'cliente.nombres as cliente','forma_pago.tipo as forma_pago')
           // ->WhereBetween('factura_cliente.fecha', [$date_i, $date_f])
           ->where('forma_pago.tipo','like','%'.$search.'%')
           ->orWhere('factura_cliente.id','like','%'.$search.'%')
           ->orWhere('cliente.nombres','like','%'. $search.'%')
           ->orWhere('factura_cliente._fecha','like','%'.$search.'%')
            ->paginate(5);
            return view('factura_cliente.search',compact('factura','search'));                
            }

        }
    }
}
