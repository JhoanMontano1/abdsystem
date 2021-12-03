<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class clienteModel extends Model
{
    use HasFactory;
    public $timestamps=false;
    protected $table='cliente';
    protected $fillable=['nombres','apellidos','direccion','telefono'];

}
