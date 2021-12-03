<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class detalle_factura_clienteModel extends Model
{
    use HasFactory;
    public $timestamps=false;
    protected $table='detalle_factura_cliente';
    protected $fillable=['id_factura','id_articulo','cantidad','precio','total'];

}
