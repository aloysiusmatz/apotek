<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTItmoveDTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('t_itmove_d', function (Blueprint $table) {
            $table->unsignedBigInteger('id');
            $table->unsignedBigInteger('item_id');
            $table->unsignedBigInteger('from_loc')->nullable();
            $table->unsignedBigInteger('to_loc')->nullable();
            $table->unsignedBigInteger('from_batch')->nullable();
            $table->unsignedBigInteger('to_batch')->nullable();
            $table->double('qty',10,2);
            $table->double('amount', 15, 2)->nullable();
            $table->timestamps();

            $table->foreign('id')
                ->references('id')
                ->on('t_itmove_h')
                ->onDelete('cascade');
            
            $table->primary(['id','item_id'],'t_itmove_d_primary');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('t_itmove_d');
    }
}
