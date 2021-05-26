<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTrabajosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trabajos', function (Blueprint $table) {
            $table->id();
            $table->string("tema",250);
            $table->integer("facultad_id");
            $table->integer("escuela_id");
            $table->integer("carrera_id");
            $table->string("titulo",250);
            $table->integer("recinto_id");
            $table->integer("ubicacion_id");
            $table->date("fecha_inicio");
            $table->date("fecha_fin");
            $table->string("nivel",30);
            $table->string("tipo_trabajo",30);
            $table->timestamps();
            $table->softDeletes('deleted_at', 0);
            $table->string("key_id",32);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('trabajos');
    }
}
