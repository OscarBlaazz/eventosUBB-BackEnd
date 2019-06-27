<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUnidadTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $tableName = 'unidad';

    /**
     * Run the migrations.
     * @table unidad
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->tableName, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('idUnidad');
            $table->integer('contadorEvento')->nullable();
            $table->string('logoUnidad', 100)->nullable();
            $table->string('sede', 45)->nullable();
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
