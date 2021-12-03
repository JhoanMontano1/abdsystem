<?php

namespace App\Http\Controllers;
use App\Models\entradaModel;
use App\Models\articuloModel;
use App\Models\categoriaModel;
use App\Models\forma_entradaModel;
use App\Models\forma_pagoModel;
use App\Models\forma_salidaModel;
use App\Models\factura_proveedorModel;
use App\Models\factura_clienteModel;
use App\Models\marcaModel;
use App\Models\proveedorModel;
use App\Models\salidaModel;
use App\Models\clienteModel;
use App\Models\User;
use PDF;
use Illuminate\Http\Request;

class pdfController extends Controller
{
    //
    public function view(){
        $datos=null;
        if(isset($_GET['context'])){
            $context=$_GET['context'];
            if($context=="entrada"){
                $datos= entradaModel::all();
            }
            else if($context=="salida"){
                $datos= salidaModel::all();
            }
            else if($context=="articulo"){
                $datos= articuloModel::all();
            }
            else if($context=="proveedor"){
                $datos= proveedorModel::all();
            }
            else if($context=="categoria"){
                $datos= categoriaModel::all();
            }
            else if($context=="marca"){
                $datos= marcaModel::all();
            }
            else if($context=="forma_entrada"){
                $datos= forma_entradaModel::all();
            }
            else if($context=="forma_salida"){
                $datos= forma_salidaModel::all();
            }
            else if($context=="forma_pago"){
                $datos= forma_pagoModel::all();
            }
            else if($context=="cliente"){
                $datos= clienteModel::all();
            }
            else if($context=="factura_proveedor"){
                $datos= factura_proveedorModel::all();
            }
            else if($context=="factura_cliente"){
                $datos= factura_clienteModel::all();
            }
            else if($context=="user"){
                $datos= User::all();
            }

            $datos=$datos->makeHidden(['created_at','updated_at','email_verified_at'])->toArray();
            if(isset($_GET['pdf'])){
                $pdf=PDF::loadView('componentes.report',compact('datos'));
                return $pdf->stream($context."_Reporte.pdf");
            }
            else{
                return view('componentes.report',compact('datos','context'));
            }

        }
    }
}
