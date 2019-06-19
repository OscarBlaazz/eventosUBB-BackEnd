<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInscripcionTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $tableName = 'inscripcion';

    /**
     * Run the migrations.
     * @table inscripcion
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->tableName, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('idInscripcion');
            $table->date('fechaInscripcion')->nullable()->default(null);
            $table->integer('Persona_idPersona') -> unsigned();
            $table->integer('Evento_idEvento')-> unsigned();

            $table->index(["Evento_idEvento"], 'fk_Inscripcion_Evento1_idx');

            $table->index(["Persona_idPersona"], 'fk_Inscripcion_Persona1_idx');


            $table->foreign('Evento_idEvento', 'fk_Inscripcion_Evento1_idx')
                ->references('idEvento')->on('evento')
                ->onDelete('no action')
                ->onUpdate('no action');

            $table->foreign('Persona_idPersona', 'fk_Inscripcion_Persona1_idx')
                ->references('idPersona')->on('persona')
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
