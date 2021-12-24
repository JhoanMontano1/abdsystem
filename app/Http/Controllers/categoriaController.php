<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\categoriaModel;
class categoriaController extends Controller
{
    //
    public function index(){
        $categoria=$datos['categoria']=categoriaModel::paginate(5);
       return view('categoria.index',compact('categoria'));
    }

    public function create()
    {
        $categoria=$datos['categoria']=categoriaModel::paginate(10);

        return view('categoria.create',compact('categoria'));
    }


    public function store(Request $request)
    {
        //
        $campos=[
             'nombre'=>'required|string'];
            $mensaje=[
                'required'=>':attribute esta vacío',];
                $this->validate($request,$campos,$mensaje);
       
        $datos=request()->except('_token');
        categoriaModel::insert($datos);
        return redirect('categoria')->with('mensaje','La categoría se ha creado correctamente.');

    }

    public function show(categoria $categoria)
    {
        //
    }

    public function edit($id)
    {
        //

        $query1=DB::select('select count(id_categoria) from articulo where id_categoria='.$id);
        // $query2=DB::select('select count(id_categoria) from detalle_factura_cliente where id_articulo='.$id);
        if($query1[0]->{'count(id_categoria)'}>0)
        {
 return redirect('categoria')->with('mensaje2','No se ha podido editar la categoría; porque ya se encuentra asociada con uno o más artículos.');
        }
        else{
        $categoria=categoriaModel::findOrFail($id);
        $categoria2=$datos['categoria']=categoriaModel::paginate(20);
        return view('categoria.edit' , compact('categoria'));
        }




    }


    public function update(Request $request,$id)

    {
        $query1=DB::select('select count(id_categoria) from articulo where id_categoria='.$id);
        // $query2=DB::select('select count(id_categoria) from detalle_factura_cliente where id_articulo='.$id);
        if($query1[0]->{'count(id_categoria)'}>0)
        {
 return redirect('categoria')->with('mensaje2','No se ha podido editar la categoria porque ya se encuentra asociada con uno o mas articulos.');
        }
        else{

         $campos=[
            'nombre'=>'required|string'];
            $mensaje=[
                'required'=>':attribute esta vacío',];
                $this->validate($request,$campos,$mensaje);
        //
        $datos=request()->except(['_token','_method']);
        categoriaModel::where('id','=',$id)->update($datos);
        $categoria=categoriaModel::findOrFail($id);
        return redirect('categoria')->with('mensaje','categoria modificada correctamente');            
        }




    }


    public function destroy($id)
    {
        //
        $query1=DB::select('select count(id_categoria) from articulo where id_categoria='.$id);
        // $query2=DB::select('select count(id_categoria) from detalle_factura_cliente where id_articulo='.$id);
        if($query1[0]->{'count(id_categoria)'}>0)
        {
 return redirect('categoria')->with('mensaje2','No se ha podido eliminar la categoria porque ya se encuentra asociada con uno o mas articulos.');
        }
        else{
        categoriaModel::destroy($id);
        return redirect('categoria')->with('mensaje','categoria eliminada correctamente');
        }

    }
    public function search(){
        if(isset($_GET['search']))
        {
$value=$_GET['search'];
$search=$value;
       $categoria=DB::table('categoria')->where('nombre','like','%'. $value.'%')
       ->orWhere('id','like','%'. $value.'%')
       ->paginate(5);
       return view('categoria.search',compact('categoria','search'));

        }
    else{ $search=DB::select("select nombre from categoria");
    return json_encode($search);
    }

    }
}
