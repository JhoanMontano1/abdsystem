<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class factura_proveedorModel extends Model
{
    use HasFactory;
    public $timestamps=false;
    protected $table='factura_proveedor';
    protected $fillable=['id_proveedor','fecha','_fecha','id_forma_pago','total','anulado'];

}
