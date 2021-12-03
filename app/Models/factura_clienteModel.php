<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class factura_clienteModel extends Model
{
    use HasFactory;
    public $timestamps=false;
    protected $table='factura_cliente';
    protected $fillable=['id_cliente','fecha','_fecha','id_forma_pago','total','anulado'];

}
