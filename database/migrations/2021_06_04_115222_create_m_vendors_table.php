<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMVendorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('m_vendors', function (Blueprint $table) {
            $table->id()->startingValue(2000001);
            $table->unsignedBigInteger('company_id');
            $table->unsignedBigInteger('show_id');
            $table->string('name',35);
            $table->string('address')->nullable();
            $table->text('city')->nullable();
            $table->text('country')->nullable();
            $table->string('phone')->nullable();
            $table->string('alt_phone1')->nullable();
            $table->string('alt_phone2')->nullable();
            $table->timestamps();

            $table->foreign('company_id')
                ->references('id')
                ->on('companies')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('m_vendors');
    }
}
