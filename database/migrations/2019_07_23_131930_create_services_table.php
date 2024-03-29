<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateServicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('services', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->datetime('deleted_at')->nullable();
            $table->string('intitule');
            $table->integer('nbr_bc');
            $table->boolean('fixe');
            $table->boolean('urgence');
            $table->integer('hopital_id')->unsigned();
            $table->foreign('hopital_id')->references('id')->on('hopitals');
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
        Schema::dropIfExists('services');
    }
}
