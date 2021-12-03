<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class forma_pagoModel extends Model
{
    use HasFactory;
    public $timestamps=false;
    protected $table='forma_pago';
    protected $fillable=['tipo'];

}
