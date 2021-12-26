<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\DB;
use App\Models\forma_pagoModel;
class forma_pagoController extends Controller
{
    //
    public function index(){
        $forma_pago=$datos['forma_pago']=forma_pagoModel::paginate(5);
       return view('forma_pago.index',compact('forma_pago'));
    }

    public function create()
    {
        $forma_pago=$datos['forma_pago']=forma_pagoModel::paginate(10);

        return view('forma_pago.create',compact('forma_pago'));
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
        forma_pagoModel::insert($datos);
        return redirect('forma_pago')->with('mensaje','La forma de pago se ha agregado correctamente');

    }

    public function show(forma_pago $forma_pago)
    {
        //
    }

    public function edit($id)
    {
        //
        $query1=DB::select('select count(id_forma_pago) from factura_cliente where id_forma_pago='.$id);
        $query2=DB::select('select count(id_forma_pago) from factura_proveedor where id_forma_pago='.$id);
        if($query1[0]->{'count(id_forma_pago)'}>0 || $query2[0]->{'count(id_forma_pago)'}>0)
        {
 return redirect('forma_pago')->with('mensaje2','No se ha podido editar la forma de pago porque se encuentra asociada a uno o mas registros.');
        }
        else{

            $forma_pago=forma_pagoModel::findOrFail($id);
            // $forma_pago=$datos['forma_pago']=forma_pagoModel::paginate(20);
             return view('forma_pago.edit',compact('forma_pago'));
        }
        


    }


    public function update(Request $request,$id)

    {
        $query1=DB::select('select count(id_forma_pago) from factura_cliente where id_forma_pago='.$id);
        $query2=DB::select('select count(id_forma_pago) from factura_proveedor where id_forma_pago='.$id);
        if($query1[0]->{'count(id_forma_pago)'}>0 || $query2[0]->{'count(id_forma_pago)'}>0)
        {
 return redirect('forma_pago')->with('mensaje2','No se ha podido editar la forma de pago porque se encuentra asociada a uno o mas registros.');
        }
        else{
            $campos=[
                'tipo'=>'required|string'];
                $mensaje=[
                    'required'=>':attribute esta vacío',];
                    $this->validate($request,$campos,$mensaje);
            //
            $datos=request()->except(['_token','_method']);
            forma_pagoModel::where('id','=',$id)->update($datos);
            $forma_pago=forma_pagoModel::findOrFail($id);
            return redirect('forma_pago')->with('mensaje','La forma de pago se ha modificado correctamente');  
        }




    }


    public function destroy($id)
    {
        //

        $query1=DB::select('select count(id_forma_pago) from factura_cliente where id_forma_pago='.$id);
        $query2=DB::select('select count(id_forma_pago) from factura_proveedor where id_forma_pago='.$id);
        if($query1[0]->{'count(id_forma_pago)'}>0 || $query2[0]->{'count(id_forma_pago)'}>0)
        {
 return redirect('forma_pago')->with('mensaje2','No se ha podido eliminar la forma de pago porque se encuentra asociada a uno o mas registros.');
        }
        else{


            forma_pagoModel::destroy($id);
            return redirect('forma_pago')->with('mensaje','La forma de pago se ha eliminado correctamente');  
        }

    }
    public function search(){
        if(isset($_GET["search"])){
        $value=$_GET['search'];
        $search=$value;
        $forma_pago=forma_pagoModel::where('tipo','like','%'.$value.'%')
        ->orWhere('id','like','%'.$value.'%')
        ->paginate(5);
        return view('forma_pago.search',compact('forma_pago','search'));

        }
        else if(isset($_GET["value"]))
        {
            $value= $_GET["value"];
            $search=$value;
            $forma_pago=forma_pagoModel::where('tipo','like','%'.$value.'%')
            ->orWhere('id','like','%'.$value.'%')
            ->paginate(5);
            $data=json_encode($forma_pago);
            $res = array(
             'data' => $data,
             'links' => $forma_pago->links()->render(),
             'search'=>$value
            );
            return Response::json($res);
        }

    }
}
