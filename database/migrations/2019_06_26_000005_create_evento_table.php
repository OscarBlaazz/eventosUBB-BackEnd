<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEventoTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $tableName = 'evento';

    /**
     * Run the migrations.
     * @table evento
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->tableName, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('idEvento');
            $table->string('nombreEvento', 100)->nullable();
            $table->string('ubicacion', 45)->nullable();
            $table->string('direccion', 45)->nullable();
            $table->string('detalles', 250)->nullable();
            $table->string('imagen', 500)->nullable();
            $table->integer('capacidad')->nullable();
            $table->softDeletes();
            $table->string('nombreEventoInterno', 100)->nullable();
            $table->integer('ciudad_idCiudad')->nullable()->unsigned();

            $table->index(["ciudad_idCiudad"], 'fk_evento_ciudad_idx');


            $table->foreign('ciudad_idCiudad', 'fk_evento_ciudad_idx')
                ->references('idCiudad')->on('ciudad')
                ->onDelete('set null')
                ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
     public function down()
     {
       Schema::dropIfExists($this->tableName);
     }
}
