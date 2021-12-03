<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class entradaModel extends Model
{
    use HasFactory;
    public $timestamps=false;
    protected $table='entrada';
    protected $fillable=['id_forma_entrada','id_proveedor','fecha','cantidad','total'];

}
