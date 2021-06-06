<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVentasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ventas', function (Blueprint $table) {
            $table->id();
            $table->date('fecha');
            $table->integer('total');
            $table->integer('domicilio');
            $table->string('metodo_pago'); 

            #Relaciones
            $table->foreignId('sedes_id')
                ->constrained()
                ->onDelete('cascade');

            $table->foreignId('users_id')
                ->constrained()
                ->onDelete('cascade');

            $table->foreignId('clientes_id')
                ->constrained()
                ->onDelete('cascade');

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
        Schema::dropIfExists('ventas');
    }
}
