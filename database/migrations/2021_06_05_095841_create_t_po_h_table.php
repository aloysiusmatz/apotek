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
            $table->id()->startingValue('3000001');
            $table->unsignedBigInteger('company_id');
            $table->unsignedBigInteger('show_id');
            $table->date('delivery_date');
            $table->unsignedBigInteger('vendor_id');
            $table->string('payment_terms');
            $table->double('grand_total',15,2);
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
