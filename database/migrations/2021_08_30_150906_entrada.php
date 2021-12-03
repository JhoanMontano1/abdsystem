<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Entrada extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('entrada', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_articulo')->unsigned();
            $table->foreign('id_articulo')->references('id')->on('articulo');
            $table->unsignedBigInteger('id_forma_entrada')->unsigned();
            $table->foreign('id_forma_entrada')->references('id')->on('forma_entrada');
            $table->unsignedBigInteger('id_proveedor')->unsigned();
            $table->foreign('id_proveedor')->references('id')->on('proveedor');
            $table->unsignedBigInteger('id_factura')->unsigned();
            $table->foreign('id_factura')->references('id')->on('factura_proveedor')->onDelete('cascade');
            $table->date('fecha');
            $table->integer('cantidad');
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
        Schema::drop('entrada');
    }
}
