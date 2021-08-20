<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCompaniesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('companies', function (Blueprint $table) {
            $table->id();
            $table->text('company_code');
            $table->text('company_desc');
            $table->text('address');
            $table->text('npwp')->nullable();
            $table->text('phone');
            $table->text('altphone')->nullable();
            $table->text('city');
            $table->text('country');
            $table->text('postal_code');
            $table->text('currency');
            $table->text('currency_symbol')->nullable();
            $table->integer('default_tax', 2);
            $table->integer('decimal_display', 1);
            $table->string('thousands_separator', 1);
            $table->string('decimal_separator', 1);
            $table->integer('qty_decimal',1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('companies');
    }
}
