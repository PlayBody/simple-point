<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePricesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('prices', function (Blueprint $table) {
            $table->id();
            $table->foreignId('work_id')->constrained('works')->onUpdate('cascade')->onDelete('cascade');
            $table->float('main_amount', 8, 1)->nullable();
            $table->string('main_unit', 10)->nullable();
            $table->float('add_amount', 8, 1)->nullable();
            $table->string('add_unit', 10)->nullable();
            $table->float('main_period', 8, 1)->nullable();
            $table->string('main_period_unit', 10)->nullable();
            $table->float('add_period', 8, 1)->nullable();
            $table->string('add_period_unit', 10)->nullable();
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
        Schema::dropIfExists('prices');
    }
}
