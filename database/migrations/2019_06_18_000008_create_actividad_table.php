<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateActividadTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $tableName = 'actividad';

    /**
     * Run the migrations.
     * @table actividad
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->tableName, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('idActividad');
            $table->string('nombre', 45)->nullable();
            $table->time('horaInicio')->nullable();
            $table->time('horaFin')->nullable();
            $table->string('ubicacion', 45)->nullable();
            $table->string('descripcion', 250)->nullable()->default(null);
            $table->integer('Jornada_idJornada')-> unsigned();
            $table->integer('Expositor_idExpositor')->nullable()->default(null)-> unsigned();

            $table->index(["Jornada_idJornada"], 'fk_Actividad_Jornada1_idx');

            $table->index(["Expositor_idExpositor"], 'fk_Actividad_Expositor1_idx');


            $table->foreign('Expositor_idExpositor', 'fk_Actividad_Expositor1_idx')
                ->references('idExpositor')->on('expositor')
                ->onDelete('no action')
                ->onUpdate('no action');

            $table->foreign('Jornada_idJornada', 'fk_Actividad_Jornada1_idx')
                ->references('idJornada')->on('jornada')
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
