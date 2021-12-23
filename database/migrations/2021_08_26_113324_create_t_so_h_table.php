<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTSoHTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('t_so_h', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('company_id');
            $table->unsignedBigInteger('so_show_id');
            $table->date('delivery_date');
            $table->unsignedBigInteger('customer_id')->nullable();
            $table->string('customer_desc');
            $table->string('payment_terms');
            $table->double('grand_total',15,2);
            $table->boolean('deleted');
            $table->integer('print');
            $table->string('ship_to_address')->nullable();
            $table->string('ship_to_city', 25)->nullable();
            $table->string('ship_to_country', 25)->nullable();
            $table->string('ship_to_postal_code', 25)->nullable();
            $table->string('ship_to_phone1', 25)->nullable();
            $table->string('ship_to_phone2', 25)->nullable();
            $table->double('shipping_value',15,2)->nullable();
            $table->double('others_value',15,2)->nullable();
            $table->text('note')->nullable();
            $table->timestamps();

            $table->foreign('company_id')
                ->references('id')
                ->on('companies')
                ->onDelete('no action');

            $table->foreign('customer_id')
                ->references('id')
                ->on('m_customers')
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
        Schema::dropIfExists('t_so_h');
    }
}
