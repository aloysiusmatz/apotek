<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTPricehistTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('t_pricehist', function (Blueprint $table) {
            $table->id();
            $table->date('posting_date');
            $table->unsignedBigInteger('movement_id');
            $table->unsignedBigInteger('movement_key');
            $table->unsignedBigInteger('item_id');
            $table->unsignedBigInteger('company_id');
            $table->double('qty',10,2);
            $table->double('amount', 15,2);
            $table->double('total_qty',10,2);
            $table->double('total_amount', 15,2);
            $table->double('cogs', 15,2);
            $table->timestamps();

            $table->foreign('company_id')
                ->references('id')
                ->on('companies')
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
        Schema::dropIfExists('t_pricehist');
    }
}
