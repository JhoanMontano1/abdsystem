<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class salidaModel extends Model
{
    use HasFactory;
    public $timestamps=false;
    protected $table='salida';
    protected $fillable=['id_forma_salida','id_cliente','fecha','cantidad','total'];

}
