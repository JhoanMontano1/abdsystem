<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\DB;
use App\Models\forma_entradaModel;
class forma_entradaController extends Controller
{
    //
    public function index(){
        $forma_entrada=$datos['forma_entrada']=forma_entradaModel::paginate(5);
       return view('forma_entrada.index',compact('forma_entrada'));
    }

    public function create()
    {
        $forma_entrada=$datos['forma_entrada']=forma_entradaModel::paginate(10);

        return view('forma_entrada.create',compact('forma_entrada'));
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
        forma_entradaModel::insert($datos);
        return redirect('forma_entrada')->with('mensaje','La forma de entrada se ha agregado correctamente');

    }

    public function show(forma_entrada $forma_entrada)
    {
        //
    }

    public function edit($id)
    {
        //
        $query1=DB::select('select count(id_forma_entrada) from entrada where id_forma_entrada='.$id);
        if($query1[0]->{'count(id_forma_entrada)'}>0)
        {
 return redirect('forma_entrada')->with('mensaje2','No se ha podido editar la forma de entrada porque se encuentra asociada a uno o mas registros.');
        }
        else{

            $forma_entrada=forma_entradaModel::findOrFail($id);
            // $forma_entrada=$datos['forma_entrada']=forma_entradaModel::paginate(20);
             return view('forma_entrada.edit',compact('forma_entrada'));   
        }
        


    }


    public function update(Request $request,$id)

    {
        $query1=DB::select('select count(id_forma_entrada) from entrada where id_forma_entrada='.$id);
        if($query1[0]->{'count(id_forma_entrada)'}>0)
        {
 return redirect('forma_entrada')->with('mensaje2','No se ha podido editar la forma de entrada porque se encuentra asociada a uno o mas registros.');
        }
        else{
            $campos=[
                'tipo'=>'required|string'];
                $mensaje=[
                    'required'=>':attribute esta vacío',];
                    $this->validate($request,$campos,$mensaje);
            //
            $datos=request()->except(['_token','_method']);
            forma_entradaModel::where('id','=',$id)->update($datos);
            $forma_entrada=forma_entradaModel::findOrFail($id);
            return redirect('forma_entrada')->with('mensaje','La forma de entrada se ha modificado correctamente');    
        }



    }


    public function destroy($id)
    {
        //
        $query1=DB::select('select count(id_forma_entrada) from entrada where id_forma_entrada='.$id);
        if($query1[0]->{'count(id_forma_entrada)'}>0)
        {
 return redirect('forma_entrada')->with('mensaje2','No se ha podido eliminar la forma de entrada porque se encuentra asociada a uno o mas registros.');
        }
        else{

        forma_entradaModel::destroy($id);
        return redirect('forma_entrada')->with('mensaje','La forma de entrada se ha eliminado correctamente');     
        }

    }
    public function search(){
        if(isset($_GET["search"])){
$value=$_GET['search'];
$search=$value;
$forma_entrada=forma_entradaModel::where('tipo','like','%'.$value.'%')
->orWhere('id','like','%'.$value.'%')
->paginate(5);
return view('forma_entrada.search',compact('forma_entrada','search'));

        }
        else if(isset($_GET["value"]))
        {
            $value= $_GET["value"];
            $search=$value;
            $forma_entrada=forma_entradaModel::where('tipo','like','%'.$value.'%')
            ->orWhere('id','like','%'.$value.'%')
            ->paginate(5);
            $data=json_encode($forma_entrada);
            $res = array(
             'data' => $data,
             'links' => $forma_entrada->links()->render(),
             'search'=>$value
            );
            return Response::json($res);
        }
        


    }
}