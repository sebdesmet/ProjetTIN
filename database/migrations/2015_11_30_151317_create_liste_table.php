<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateListeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('liste', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name_user');
            $table->string('name_liste');
            $table->text('description_liste');
            $table->integer('tache_acc');
            $table->integer('tache_tot');
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
        Schema::drop('liste');
    }
}
