<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSustentantesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sustentantes', function (Blueprint $table) {
            $table->id();
            $table->string("nombre",100);
            $table->string("matricula",100);
            $table->string("telefono",250);
            $table->string("correo",250);
            $table->string("activo",2);
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
        Schema::dropIfExists('sustentantes');
    }
}
