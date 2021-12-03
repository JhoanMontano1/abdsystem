<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\clienteModel;
class clienteController extends Controller
{
    //
    public function index(){
        $cliente=$datos['cliente']=clienteModel::paginate(5);
       return view('cliente.index',compact('cliente'));
    }

    public function create()
    {
        $cliente=$datos['cliente']=clienteModel::paginate(10);

        return view('cliente.create',compact('cliente'));
    }


    public function store(Request $request)
    {
        //
        $campos=[
             'nombres'=>'required|string',
            'apellidos'=>'required|string',
            'direccion'=>'required|string',
            'telefono'=>'required|string'];
            $mensaje=[
                'required'=>':attribute esta vacío',];
                $this->validate($request,$campos,$mensaje);
       
        $datos=request()->except('_token');
        clienteModel::insert($datos);
        return redirect('cliente')->with('mensaje','El cliente se ha creado correctamente');

    }

    public function show(cliente $cliente)
    {
        //
    }

    public function edit($id)
    {

        // $query1=DB::select('select count(id_articulo) from detalle_factura_proveedor where id_articulo='.$id);
        $query1=DB::select('select count(id_cliente) from factura_cliente where id_cliente='.$id);
        if($query1[0]->{'count(id_cliente)'}>0)
        {
 return redirect('cliente')->with('mensaje2','No se ha podido editar el cliente porque existe en una o mas registros de factura.');
        }
        else{
        $cliente=clienteModel::findOrFail($id);
        $cliente2=$datos['cliente']=clienteModel::paginate(20);
        return view('cliente.edit' , compact('cliente'));
        }

        //


    }


    public function update(Request $request,$id)

    {
        $query1=DB::select('select count(id_cliente) from factura_cliente where id_cliente='.$id);
        if($query1[0]->{'count(id_cliente)'}>0)
        {
 return redirect('cliente')->with('mensaje2','No se ha podido editar el cliente porque existe en una o mas registros de factura.');
        }
        else{
         $campos=[
            'nombres'=>'required|string',
            'apellidos'=>'required|string',
            'direccion'=>'required|string',
            'telefono'=>'required|string'];
            $mensaje=[
                'required'=>':attribute esta vacío',];
                $this->validate($request,$campos,$mensaje);
        //
        $datos=request()->except(['_token','_method']);
        clienteModel::where('id','=',$id)->update($datos);
        $cliente=clienteModel::findOrFail($id);
        return redirect('cliente')->with('mensaje','cliente modificado correctamente');


        }


    }


    public function destroy($id)
    {
        //

        $query1=DB::select('select count(id_cliente) from factura_cliente where id_cliente='.$id);
        if($query1[0]->{'count(id_cliente)'}>0)
        {
 return redirect('cliente')->with('mensaje2','No se ha podido eliminar al cliente; porque existe en uno o más registros de factura.');
        }
        else{

        clienteModel::destroy($id);
        return redirect('cliente')->with('mensaje',' El cliente se ha eliminado correctamente.');            
        }


    }
    public function search(){
        $value=$_GET['search'];
        $search=$value;
        $cliente=DB::table('cliente')->where('nombres','like','%'. $value.'%')
        ->orWhere('id','like','%'. $value.'%')
        ->paginate(5);
        return view('cliente.search',compact('cliente','search'));
    }
}
