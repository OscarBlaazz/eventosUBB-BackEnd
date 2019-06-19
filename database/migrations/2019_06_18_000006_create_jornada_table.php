<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateJornadaTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $tableName = 'jornada';

    /**
     * Run the migrations.
     * @table jornada
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->tableName, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('idJornada');
            $table->string('nombre', 45);
            $table->date('fecha');
            $table->dateTime('horaInicio');
            $table->dateTime('horaFin');
            $table->string('ubicacion', 45);
            $table->string('descripcion', 250)->nullable()->default(null);
            $table->integer('Evento_idEvento');

            $table->index(["Evento_idEvento"], 'fk_Jornada_Evento1_idx');


            $table->foreign('Evento_idEvento', 'fk_Jornada_Evento1_idx')
                ->references('idEvento')->on('evento')
                ->onDelete('no action')
                ->onUpdate('no action');
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
