<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHictorycalMedicineTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('history_medicine', function (Blueprint $table) {
            $table->increments('account_id');
            $table->dateTime('date_of_purchase');
            $table->integer('doctor_id');
            $table->string('medicine');
            $table->string('dosage',255);
            $table->integer('amount');
            $table->string('payment');
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
        Schema::dropIfExists('history_medicine');
    }
}
