<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class FacturaProveedor extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('factura_proveedor', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_proveedor');
            $table->foreign('id_proveedor')->references('id')->on('proveedor');
            $table->dateTime('fecha');
            $table->date('_fecha');
            $table->unsignedBigInteger('id_forma_pago');
            $table->foreign('id_forma_pago')->references('id')->on('forma_pago');
            $table->double('total');
            $table->boolean('anulado')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('factura_proveedor');
    }
}
