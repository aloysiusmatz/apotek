<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTPoDTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('t_po_d', function (Blueprint $table) {
            $table->id();
            $table->integer('item_sequnce');
            $table->unsignedBigInteger('item_id');
            $table->double('qty',10,2);
            $table->double('price_unit',15,2);
            $table->integer('discount');
            $table->integer('tax');
            $table->timestamps();

            $table->foreign('id')
                ->references('id')
                ->on('t_po_h')
                ->onDelete('cascade');

            $table->foreign('item_id')
                ->references('id')
                ->on('m_items')
                ->onDelete('no action');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('t_po_d');
    }
}
