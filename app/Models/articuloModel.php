<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class articuloModel extends Model
{
    use HasFactory;
    public $timestamps=false;
    protected $table='articulo';
    protected $fillable=['descripcion','precio_compra','precio_venta','stock','id_categoria','id_proveedor'];

}
