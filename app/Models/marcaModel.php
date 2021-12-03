<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class marcaModel extends Model
{
    use HasFactory;
    public $timestamps=false;
    protected $table='marca';
    protected $fillable=['nombre'];

}
