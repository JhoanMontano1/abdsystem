<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DetalleFacturaProveedor extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detalle_factura_proveedor', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_factura');
            $table->foreign('id_factura')->references('id')->on('factura_proveedor')->onDelete('cascade');
            $table->unsignedBigInteger('id_articulo');
            $table->foreign('id_articulo')->references('id')->on('articulo');
            $table->integer('cantidad');
            $table->integer('precio');
            $table->double('total');
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
        Schema::drop('detalle_factura_proveedor');
    }
}
