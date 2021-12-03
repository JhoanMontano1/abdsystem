<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\marcaModel;
class marcaController extends Controller
{
    //
    public function index(){
        $marca=$datos['marca']=marcaModel::paginate(10);
       return view('marca.index',compact('marca'));
    }

    public function create()
    {
        $marca=$datos['marca']=marcaModel::paginate(10);

        return view('marca.create',compact('marca'));
    }


    public function store(Request $request)
    {
        //
        $campos=[
             'nombre'=>'required|string'];
            $mensaje=[
                'required'=>'El :attribute esta vacio',];
                $this->validate($request,$campos,$mensaje);
       
        $datos=request()->except('_token');
        marcaModel::insert($datos);
        return redirect('marca')->with('mensaje','El marca se ha agregado correctamente');

    }

    public function show(marca $marca)
    {
        //
    }

    public function edit($id)
    {
        //
        $marca=marcaModel::findOrFail($id);
        $marca2=$datos['marca']=marcaModel::paginate(20);
        return view('marca.edit' , compact('marca'));

    }


    public function update(Request $request,$id)

    {
         $campos=[
            'nombre'=>'required|string'];
            $mensaje=[
                'required'=>'El :attribute esta vacio',];
                $this->validate($request,$campos,$mensaje);
        //
        $datos=request()->except(['_token','_method']);
        marcaModel::where('id','=',$id)->update($datos);
        $marca=marcaModel::findOrFail($id);
        return redirect('marca')->with('mensaje','marca modificada correctamente');

    }


    public function destroy($id)
    {
        //

        marcaModel::destroy($id);
        return redirect('marca')->with('mensaje','marca eliminada correctamente');
    }
}
