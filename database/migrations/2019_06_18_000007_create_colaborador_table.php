<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateColaboradorTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $tableName = 'colaborador';

    /**
     * Run the migrations.
     * @table colaborador
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->tableName, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('idColaborador');
            $table->string('nombre', 45);
            $table->string('nombreRepresentate', 45)->nullable()->default(null);
            $table->integer('telefono')->nullable()->default(null);
            $table->string('correo', 60)->nullable()->default(null);
            $table->string('sitioWeb', 45)->nullable()->default(null);
            $table->string('logo', 100)->nullable()->default(null);
            $table->integer('Evento_idEvento');

            $table->index(["Evento_idEvento"], 'fk_Colaborador_Evento1_idx');


            $table->foreign('Evento_idEvento', 'fk_Colaborador_Evento1_idx')
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
