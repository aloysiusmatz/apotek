<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTDoDTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('t_do_d', function (Blueprint $table) {
            $table->unsignedBigInteger('id');
            $table->integer('item_sequence');
            $table->integer('locbatch_split');
            $table->unsignedBigInteger('item_id');
            $table->unsignedBigInteger('location_id');
            $table->string('batch');
            $table->double('qty',10,2);
            $table->timestamps();

            $table->foreign('id')
            ->references('id')
            ->on('t_do_h')
            ->onDelete('cascade');

            $table->foreign('item_id')
                ->references('id')
                ->on('m_items')
                ->onDelete('no action');

            $table->primary(['id','item_sequence', 'locbatch_split'],'t_do_d_primary');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('t_do_d');
    }
}
