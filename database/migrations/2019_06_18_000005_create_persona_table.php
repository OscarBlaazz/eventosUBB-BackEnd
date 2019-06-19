<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePersonaTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $tableName = 'persona';

    /**
     * Run the migrations.
     * @table persona
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->tableName, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('idPersona');
            $table->string('nombre', 45);
            $table->string('apellido', 45);
            $table->string('correo', 60);
            $table->string('sexo', 45)->nullable()->default(null);
            $table->integer('Rol_idRol')-> unsigned();
            $table->integer('Unidad_idUnidad')->nullable()->default(null)-> unsigned();
            $table->integer('Evento_idEvento')-> unsigned();

            $table->index(["Unidad_idUnidad"], 'fk_Persona_Unidad1_idx');

            $table->index(["Rol_idRol"], 'fk_Persona_Rol_idx');

            $table->index(["Evento_idEvento"], 'fk_Persona_Evento1_idx');


            $table->foreign('Evento_idEvento', 'fk_Persona_Evento1_idx')
                ->references('idEvento')->on('evento')
                ->onDelete('no action')
                ->onUpdate('no action');

            $table->foreign('Rol_idRol', 'fk_Persona_Rol_idx')
                ->references('idRol')->on('rol')
                ->onDelete('no action')
                ->onUpdate('no action');

            $table->foreign('Unidad_idUnidad', 'fk_Persona_Unidad1_idx')
                ->references('idUnidad')->on('unidad')
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
