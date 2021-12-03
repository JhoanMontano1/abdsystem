<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\salidaModel;
use App\Models\clienteModel;
use App\Models\forma_salidaModel;
use App\Models\forma_pagoModel;
class salidaController extends Controller
{
    //
    public function index(){
        $salida = DB::table('salida')
        ->join('forma_salida', 'salida.id_forma_salida', '=', 'forma_salida.id')
        ->join('cliente', 'salida.id_cliente', '=', 'cliente.id')
        ->select('salida.*', 'cliente.nombres as cliente','forma_salida.tipo as forma_salida')
        ->paginate(5);
       return view('salida.index',compact('salida'));
    }

    public function create()
    {
        $forma_pago=$datos1['forma_pago']=forma_pagoModel::all();
        $cliente=$datos2['cliente']=clienteModel::all();
        $forma_salida=$datos3['forma_salida']=forma_salidaModel::all();
        return view('salida.create',compact('cliente','forma_salida','forma_pago'));
    }


    public function store(Request $request)
    {
        $salida=array(
            'id_articulo'=>$_POST['id_articulo'],
            'id_cliente'=>$_POST['id_cliente'],
            'id_forma_salida'=>$_POST['id_forma_salida'],
           'fecha'=>$_POST['fecha'],
            'cantidad'=>$_POST['cantidad'],
            'total'=>$_POST['total'],
        );

        $id=$salida['id_articulo'];
        $cantidad=$salida['cantidad'];

        DB::table('salida')->insert($salida);
        DB::update('update articulo set stock = stock - ? where id = ?', [$cantidad , $id]);
    }

    public function show(salida $salida)
    {
        //
    }

    public function edit($id)
    {
        //
        $salida=salidaModel::findOrFail($id);
        $cliente=$datos2['proveedor']=clienteModel::all();
        $forma_salida=$datos3['forma_salida']=forma_salidaModel::all();
        return view('salida.edit',compact('salida','cliente','forma_salida'));

    }


    public function update(Request $request,$id)

    {
         $campos=[
            'id_forma_salida'=>'required|integer',
            'id_cliente'=>'required|integer',
            'fecha'=>'required|date',
            'cantidad'=>'required|integer',
            'total'=>'required|integer'];
            $mensaje=[
                'required'=>'El :attribute esta vacío',];
                $this->validate($request,$campos,$mensaje);
        //
        $datos=request()->except(['_token','_method']);
        salidaModel::where('id','=',$id)->update($datos);
        $salida=salidaModel::findOrFail($id);
        return redirect('salida')->with('mensaje','salida modificada correctamente');

    }


    public function destroy($id)
    {
        //

        salidaModel::destroy($id);
        return redirect('salida')->with('mensaje','salida eliminada correctamente');
    }

    public function search(){
        $value=$_GET['search'];
        $search=$value;
        $salida = DB::table('salida')
        ->join('forma_salida', 'salida.id_forma_salida', '=', 'forma_salida.id')
        ->join('cliente', 'salida.id_cliente', '=', 'cliente.id')
        ->select('salida.*', 'cliente.nombres as cliente','forma_salida.tipo as forma_salida')
        ->where('salida.cantidad','like','%'. $value.'%')
        ->orWhere('salida.id','like','%'. $value.'%')
        ->orWhere('salida.total','like','%'. $value.'%')
        ->orWhere('cliente.nombres','like','%'. $value.'%')
        ->orWhere('forma_salida.tipo','like','%'. $value.'%')
        ->paginate(5);
            return view('salida.search',compact('salida','search'));
    }
}
