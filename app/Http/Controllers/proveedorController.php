<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\DB;
use App\Models\proveedorModel;
class proveedorController extends Controller
{
    //
    public function index(){
        $proveedor=$datos['proveedor']=proveedorModel::paginate(5);
       return view('proveedor.index',compact('proveedor'));
    }

    public function create()
    {
        $proveedor=$datos['proveedor']=proveedorModel::paginate(5);

        return view('proveedor.create',compact('proveedor'));
    }


    public function store(Request $request)
    {
        //
        $campos=[
            'nombres'=>'required|string',
            'nombre_comercial'=>'required|string',
            'apellidos'=>'required|string',
            'direccion'=>'required|string',
            'telefono'=>'required|string|max:15'];
            $mensaje=[
                'required'=>':attribute esta vacío',];
                $this->validate($request,$campos,$mensaje);
       
        $datos=request()->except('_token');
        proveedorModel::insert($datos);
        return redirect('proveedor')->with('mensaje','El proveedor se ha registrado correctamente');

    }

    public function show(proveedor $proveedor)
    {
        //
    }

    public function edit($id)
    {
        //
        $query1=DB::select('select count(id_proveedor) from factura_proveedor where id_proveedor='.$id);
        $query2=DB::select('select count(id_proveedor) from articulo where id_proveedor='.$id);
        if($query1[0]->{'count(id_proveedor)'}>0 || $query2[0]->{'count(id_proveedor)'}>0)
        {
 return redirect('proveedor')->with('mensaje2','No se ha podido editar el proveedor, porque existe en uno o mas registros de factura o articulo.');
        }
        else{

            $proveedor=proveedorModel::findOrFail($id);
            $proveedor2=$datos['proveedor']=proveedorModel::paginate(5);
            return view('proveedor.edit' , compact('proveedor'));   
        }
        


    }


    public function update(Request $request,$id)

    {
        $query1=DB::select('select count(id_proveedor) from factura_proveedor where id_proveedor='.$id);
        $query2=DB::select('select count(id_proveedor) from articulo where id_proveedor='.$id);
        if($query1[0]->{'count(id_proveedor)'}>0 || $query2[0]->{'count(id_proveedor)'}>0)
        {
 return redirect('proveedor')->with('mensaje2','No se ha podido editar el proveedor porque existe en uno o mas registros de factura o articulo.');
        }
        else{

            $campos=[
                'nombres'=>'required|string',
                'nombre_comercial'=>'required|string',
                'apellidos'=>'required|string',
                'direccion'=>'required|string',
                'telefono'=>'required|string|max:15'];
                $mensaje=[
                    'required'=>':attribute esta vacío',];
                    $this->validate($request,$campos,$mensaje);
            //
            $datos=request()->except(['_token','_method']);
            proveedorModel::where('id','=',$id)->update($datos);
            $proveedor=proveedorModel::findOrFail($id);
            return redirect('proveedor')->with('mensaje','proveedor modificado correctamente');   
        }



    }


    public function destroy($id)
    {
        //
        $query1=DB::select('select count(id_proveedor) from factura_proveedor where id_proveedor='.$id);
        $query2=DB::select('select count(id_proveedor) from articulo where id_proveedor='.$id);
        if($query1[0]->{'count(id_proveedor)'}>0 || $query2[0]->{'count(id_proveedor)'}>0)
        {
 return redirect('proveedor')->with('mensaje2','No se ha podido eliminar el proveedor porque existe en uno o mas registros de factura o articulo.');
        }
        else{

            proveedorModel::destroy($id);
            return redirect('proveedor')->with('mensaje',' El proveedor  se ha eliminado correctamente');     
        }

    }
    public function search(){
        if(isset($_GET["search"])){
        $value=$_GET['search'];
        $search=$value;
        $proveedor=DB::table('proveedor')->where('nombres','like','%'. $value.'%')
        ->orWhere('id','like','%'. $value.'%')
        ->paginate(5);
        return view('proveedor.search',compact('proveedor','search'));

        }
        else if(isset($_GET["value"]))
        {
            $value= $_GET["value"];
            $search=$value;
            $proveedor=DB::table('proveedor')->where('nombres','like','%'. $value.'%')
            ->orWhere('id','like','%'. $value.'%')
            ->paginate(5);
            $data=json_encode($proveedor);
            $res = array(
             'data' => $data,
             'links' => $proveedor->links()->render(),
             'search'=>$value
            );
            return Response::json($res);
        }
        

    }
}
