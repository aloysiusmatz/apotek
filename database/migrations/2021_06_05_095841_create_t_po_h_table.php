<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTPoHTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('t_po_h', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('company_id');
            $table->unsignedBigInteger('po_show_id');
            $table->date('delivery_date');
            $table->unsignedBigInteger('vendor_id');
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
            $table->text('note');
            $table->timestamps();

            $table->foreign('company_id')
                ->references('id')
                ->on('companies')
                ->onDelete('no action');
            
            $table->foreign('vendor_id')
                ->references('id')
                ->on('m_vendors')
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
        Schema::dropIfExists('t_po_h');
    }
}
