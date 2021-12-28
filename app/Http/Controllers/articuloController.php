<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\DB;
use App\Models\articuloModel;
use App\Models\categoriaModel;
use App\Models\proveedorModel;
class articuloController extends Controller
{
    //
    public function index(){
        $articulo=$datos['articulo']=articuloModel::paginate(10);
        $articulo = DB::table('articulo')
        ->join('proveedor', 'articulo.id_proveedor', '=', 'proveedor.id')
        ->join('categoria', 'articulo.id_categoria', '=', 'categoria.id')
        ->select('articulo.*', 'proveedor.nombres as proveedor','categoria.nombre as categoria')
        // ->where('articulo.descripcion','like','%i%')
        // ->orWhere('articulo.id','like','%1%')
        ->paginate(5);
      return view('articulo.index',compact('articulo'));
    }

    public function create()
    {
        $articulo=DB::select('select* from articulo');
        //$articulo=$datos['articulo']=articuloModel::paginate(10);
        $categoria=$datos2['categoria']=categoriaModel::paginate(10);
        $proveedor=$datos3['proveedor']=proveedorModel::paginate(10);
        return view('articulo.create',$articulo,compact('categoria','proveedor'));
    }


    public function store(Request $request)
    {
        //
        $campos=[
             'descripcion'=>'required|string',
            'precio_compra'=>'required|numeric',
            'precio_venta'=>'required|numeric',
            // 'stock'=>'required|integer',
            'id_categoria'=>'required|integer',
            'id_proveedor'=>'required|integer',
        ];
            $mensaje=[
                'required'=>':attribute vacío',];
                $this->validate($request,$campos,$mensaje);
       
        $datos=request()->except('_token');
        articuloModel::insert($datos);
        return redirect('articulo')->with('mensaje','El artículo se ha agregado correctamente.');

    }

    public function show(articulo $articulo)
    {
        //
    }

    public function edit($id)
    {
        //

        $query1=DB::select('select count(id_articulo) from detalle_factura_proveedor where id_articulo='.$id);
        $query2=DB::select('select count(id_articulo) from detalle_factura_cliente where id_articulo='.$id);
        
        if($query1[0]->{'count(id_articulo)'}>0 || $query2[0]->{'count(id_articulo)'}>0)
        {
 return redirect('articulo')->with('mensaje2','Este artículo no se puede editar; porque existe en una o varias facturas.');
        }
        else{
            $articulo=articuloModel::findOrFail($id);
            $articulo2=$datos['articulo']=articuloModel::paginate(10);
            $categoria=$datos2['categoria']=categoriaModel::paginate(10);
            $proveedor=$datos3['proveedor']=proveedorModel::paginate(10);
            return view('articulo.edit',compact('articulo','categoria','proveedor'));
        }



    }


    public function update(Request $request,$id)

    {

        $query1=DB::select('select count(id_articulo) from detalle_factura_proveedor where id_articulo='.$id);
        $query2=DB::select('select count(id_articulo) from detalle_factura_cliente where id_articulo='.$id);
        if($query1[0]->{'count(id_articulo)'}>0 || $query2[0]->{'count(id_articulo)'}>0)
        {
 return redirect('articulo')->with('mensaje2','No se ha podido editar este articulo porque existe en uno o mas registros de factura.');
        }
        else{
            $campos=[
                'descripcion'=>'required|string',
                'precio_compra'=>'required|numeric',
                'precio_venta'=>'required|numeric',
                // 'stock'=>'required|integer',
                'id_categoria'=>'required|integer',
                'id_proveedor'=>'required|integer',
            ];
                $mensaje=[
                    'required'=>':attribute vacío',];
                    $this->validate($request,$campos,$mensaje);
            //
            $datos=request()->except(['_token','_method']);
            articuloModel::where('id','=',$id)->update($datos);
            $articulo=articuloModel::findOrFail($id);
            return redirect('articulo')->with('mensaje','El artículo se ha modificado correctamente.');
        }




    }


    public function destroy($id)
    {
        //

        $query1=DB::select('select count(id_articulo) from detalle_factura_proveedor where id_articulo='.$id);
        $query2=DB::select('select count(id_articulo) from detalle_factura_cliente where id_articulo='.$id);
        // echo 'Este articulo existe '.$query1[0]->{'count(id_articulo)'}.' vez(veces) en facturas de proveedor';
        // echo '</br>';
        // echo 'Este articulo existe '.$query2[0]->{'count(id_articulo)'}.' vez(veces) en facturas de cliente';
        
        if($query1[0]->{'count(id_articulo)'}>0 || $query2[0]->{'count(id_articulo)'}>0)
        {
 return redirect('articulo')->with('mensaje2','No se ha podido eliminar este articulo porque existe en uno o mas registros de factura.');
        }
        else{
articuloModel::destroy($id);
return redirect('articulo')->with('mensaje',' El artículo se ha eliminado exitosamente.');
        }
        
       
    }
    public function search(){
        if(isset($_GET["search"])){

            $value= $_GET["search"];
            $search=$value;
            $articulo = DB::table('articulo')
            ->join('proveedor', 'articulo.id_proveedor', '=', 'proveedor.id')
            ->join('categoria', 'articulo.id_categoria', '=', 'categoria.id')
            ->select('articulo.*', 'proveedor.nombres as proveedor','categoria.nombre as categoria')
            ->where('articulo.descripcion','like','%'. $value.'%')
            ->orWhere('articulo.id','like','%'. $value.'%')
            ->orWhere('articulo.stock','like','%'. $value.'%')
            ->paginate(5);
            return view('articulo.search',compact('articulo','search'));
        }
        else if(isset($_GET["value"]))
       $value= $_GET["value"];
       $search=$value;
       $articulo = DB::table('articulo')
       ->join('proveedor', 'articulo.id_proveedor', '=', 'proveedor.id')
       ->join('categoria', 'articulo.id_categoria', '=', 'categoria.id')
       ->select('articulo.*', 'proveedor.nombres as proveedor','categoria.nombre as categoria')
       ->where('articulo.descripcion','like','%'. $value.'%')
       ->orWhere('articulo.id','like','%'. $value.'%')
       ->orWhere('articulo.stock','like','%'. $value.'%')
       ->paginate(5);
       $data=json_encode($articulo);
       $res = array(
        'data' => $data,
        'links' => $articulo->links()->render(),
        'search'=>$value
       );
       return Response::json($res);
    }

}
