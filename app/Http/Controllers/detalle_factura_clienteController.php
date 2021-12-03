<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\entradaModel;
use App\Models\proveedorModel;
use App\Models\clienteModel;
use App\Models\articuloModel;
use App\Models\forma_entradaModel;
use App\Models\forma_pagoModel;
use App\Http\Controllers\PDF;
class entradaController extends Controller
{
    //
    public function index(){
        $entrada=$datos['entrada']=entradaModel::paginate(5);
       return view('entrada.index',compact('entrada'));
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
        $entrada=array(
            'id_articulo'=>$_POST['id_articulo'],
            'id_proveedor'=>$_POST['id_proveedor'],
            'id_forma_entrada'=>$_POST['id_forma_entrada'],
           'fecha'=>$_POST['fecha'],
            'cantidad'=>$_POST['cantidad'],
            'total'=>$_POST['total'],
        );

        $id=$entrada['id_articulo'];
        $cantidad=$entrada['cantidad'];

        DB::table('entrada')->insert($entrada);
        DB::update('update articulo set stock = stock + ? where id = ?', [$cantidad , $id]);
        
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
       echo 'recibido'; 
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

        entradaModel::destroy($id);
        return redirect('entrada')->with('mensaje','entrada eliminada correctamente');
    }

    public function search(){
        $json=array();
        $context=$_GET['context'];
        $value=$_GET['value'];

        switch($context){
            case 'proveedor':
                $datos= proveedorModel::where('nombres','like','%'. $value.'%')->get()->toArray();
                foreach($datos as $dato){
                    $json[]=array(
                        'id'=>$dato['id'],
                        'nombre'=>$dato['nombres'],
                        
                    ); 
                }
                
                break;
                case 'articulo':
                    $datos= articuloModel::where('descripcion','like','%'. $value.'%')->get()->toArray();
                    foreach($datos as $dato){
                        $json[]=array(
                            'id'=>$dato['id'],
                            'nombre'=>$dato['descripcion'],
                            'precio'=>$dato['precio_venta'],
                        ); 
                    }
                    break;
        }
      // $datos= entradaModel::where('cantidad','like','%'. $value.'%')->get()->toArray();
    //   $datos= $datos->makeHidden(['created_at','updated_at'])->toArray();
      
    // foreach($datos as $dato){
    //     $json[]=array(
    //         'id'=>$dato['id'],
    //         'id_f_entrada'=>$dato['id_forma_entrada'],
    //         'id_proveedor'=>$dato['id_proveedor'],
    //         'fecha'=>$dato['fecha'],
    //         'cantidad'=>$dato['cantidad'],
    //         'total'=>$dato['total'],
    //     ); 
    // }
      echo json_encode($json);

    }
}
