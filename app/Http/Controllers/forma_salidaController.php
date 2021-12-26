<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\DB;
use App\Models\forma_salidaModel;
class forma_salidaController extends Controller
{
    //
    public function index(){
        $forma_salida=$datos['forma_salida']=forma_salidaModel::paginate(5);
       return view('forma_salida.index',compact('forma_salida'));
    }

    public function create()
    {
        $forma_salida=$datos['forma_salida']=forma_salidaModel::paginate(10);

        return view('forma_salida.create',compact('forma_salida'));
    }


    public function store(Request $request)
    {
        //
        $campos=[
             'tipo'=>'required|string'];
            $mensaje=[
                'required'=>':attribute esta vacío',];
                $this->validate($request,$campos,$mensaje);
       
        $datos=request()->except('_token');
        forma_salidaModel::insert($datos);
        return redirect('forma_salida')->with('mensaje','La forma de salida se ha creado correctamente');

    }

    public function show(forma_salida $forma_salida)
    {
        //
    }

    public function edit($id)
    {
        //
        $query1=DB::select('select count(id_forma_salida) from salida where id_forma_salida='.$id);
        // $query2=DB::select('select count(id_forma_pago) from factura_proveedor where id_forma_pago='.$id);
        if($query1[0]->{'count(id_forma_salida)'}>0)
        {
 return redirect('forma_salida')->with('mensaje2','No se ha podido editar la forma de salida porque se encuentra asociada a uno o mas registros.');
        }
        else{
            $forma_salida=forma_salidaModel::findOrFail($id);
            // $forma_salida=$datos['forma_salida']=forma_salidaModel::paginate(20);
             return view('forma_salida.edit',compact('forma_salida')); 
        }




    }


    public function update(Request $request,$id)

    {
        $query1=DB::select('select count(id_forma_salida) from salida where id_forma_salida='.$id);
        // $query2=DB::select('select count(id_forma_pago) from factura_proveedor where id_forma_pago='.$id);
        if($query1[0]->{'count(id_forma_salida)'}>0)
        {
 return redirect('forma_salida')->with('mensaje2','No se ha podido editar la forma de salida porque se encuentra asociada a uno o mas registros.');
        }
        else{
            $campos=[
                'tipo'=>'required|string'];
                $mensaje=[
                    'required'=>':attribute esta vacío',];
                    $this->validate($request,$campos,$mensaje);
            //
            $datos=request()->except(['_token','_method']);
            forma_salidaModel::where('id','=',$id)->update($datos);
            $forma_salida=forma_salidaModel::findOrFail($id);
            return redirect('forma_salida')->with('mensaje','La forma de salida se ha modificado correctamente'); 
        }




    }


    public function destroy($id)
    {
        //
        $query1=DB::select('select count(id_forma_salida) from salida where id_forma_salida='.$id);
        // $query2=DB::select('select count(id_forma_pago) from factura_proveedor where id_forma_pago='.$id);
        if($query1[0]->{'count(id_forma_salida)'}>0)
        {
 return redirect('forma_salida')->with('mensaje2','No se ha podido eliminar la forma de salida porque se encuentra asociada a uno o mas registros.');
        }
        else{
            forma_salidaModel::destroy($id);
            return redirect('forma_salida')->with('mensaje','La forma de salida se ha eliminado correctamente');  
        }



    }
    public function search(){
        if(isset($_GET["search"])){
        $value=$_GET['search'];
        $search=$value;
        $forma_salida=forma_salidaModel::where('tipo','like','%'.$value.'%')
        ->orWhere('id','like','%'.$value.'%')
        ->paginate(5);
        return view('forma_salida.search',compact('forma_salida','search'));

        }
        else if(isset($_GET["value"]))
        {
            $value= $_GET["value"];
            $search=$value;
            $forma_salida=forma_salidaModel::where('tipo','like','%'.$value.'%')
            ->orWhere('id','like','%'.$value.'%')
            ->paginate(5);
            $data=json_encode($forma_salida);
            $res = array(
             'data' => $data,
             'links' => $forma_salida->links()->render(),
             'search'=>$value
            );
            return Response::json($res);
        }

    }
}
