<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class proveedorModel extends Model
{
    use HasFactory;
    public $timestamps=false;
    protected $table='proveedor';
    protected $fillable=['nombres','apellidos','nombre_comercial','direccion','telefono'];

}
