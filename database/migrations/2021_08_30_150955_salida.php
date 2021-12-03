<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Salida extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('salida', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_articulo')->unsigned();
            $table->foreign('id_articulo')->references('id')->on('articulo');
            $table->unsignedBigInteger('id_forma_salida');
            $table->foreign('id_forma_salida')->references('id')->on('forma_salida');
            $table->unsignedBigInteger('id_cliente');
            $table->foreign('id_cliente')->references('id')->on('cliente');
            $table->unsignedBigInteger('id_factura')->unsigned();
            $table->foreign('id_factura')->references('id')->on('factura_cliente')->onDelete('cascade');
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
        Schema::drop('salida');
    }
}
