<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTDoHTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('t_do_h', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('company_id');
            $table->unsignedBigInteger('do_show_id');
            $table->unsignedBigInteger('so_id')->nullable();
            $table->date('delivery_date');
            $table->string('ship_to_address')->nullable();
            $table->string('ship_to_city', 25)->nullable();
            $table->string('ship_to_country', 25)->nullable();
            $table->string('ship_to_postal_code', 25)->nullable();
            $table->string('ship_to_phone1', 25)->nullable();
            $table->string('ship_to_phone2', 25)->nullable();
            $table->boolean('deleted');
            $table->integer('print');
            $table->text('note')->nullable();
            $table->timestamps();

            $table->foreign('company_id')
                ->references('id')
                ->on('companies')
                ->onDelete('no action');

            $table->foreign('so_id')
                ->references('id')
                ->on('t_so_h')
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
        Schema::dropIfExists('t_do_h');
    }
}
