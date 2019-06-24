<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMaterialTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $tableName = 'material';

    /**
     * Run the migrations.
     * @table material
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->tableName, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('idMaterial');
            $table->string('nombre', 45)->nullable();
            $table->string('archivo', 100)->nullable()->default(null)->nullable();
            $table->integer('Evento_idEvento')->unsigned()->nullable();

            $table->index(["Evento_idEvento"], 'fk_Material_Evento1_idx');


            $table->foreign('Evento_idEvento', 'fk_Material_Evento1_idx')
                ->references('idEvento')->on('evento')
                ->onDelete('no action')
                ->onUpdate('no action');

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
        Schema::dropIfExists($this->tableName);
    }
}
