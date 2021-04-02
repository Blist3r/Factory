<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDetallepedidosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detallepedidos', function (Blueprint $table) {
            $table->id();
            $table->integer('cantidad');

            #Relaciones
            $table->foreignId('pedidos_id')
                ->constrained()
                ->onDelete('cascade');

            $table->foreignId('inventarios_id')
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
        Schema::dropIfExists('detallepedidos');
    }
}
