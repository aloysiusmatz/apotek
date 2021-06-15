<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTInvstockTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('t_invstock', function (Blueprint $table) {
            $table->unsignedBigInteger('id');
            $table->unsignedBigInteger('item_id');
            $table->unsignedBigInteger('company_id');
            $table->smallInteger('period');
            $table->year('year');
            $table->unsignedBigInteger('location_id');
            $table->string('batch');
            $table->string('category');
            $table->double('qty',10,2);
            $table->timestamps();

            $table->foreign('company_id')
                ->references('id')
                ->on('companies')
                ->onDelete('no action');

            $table->primary(['id','item_id','company_id','period','year','location_id','batch'],'t_invstock_primary');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('t_invstock');
    }
}
