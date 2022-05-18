<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDeliverableDataTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('deliverable_data', function (Blueprint $table) {
            $table->id();
            $table->foreignId('project_id')->constrained('projects')->onUpdate('cascade')->onDelete('cascade');
            $table->string('deliverable_data_link');
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
        Schema::dropIfExists('deliverable_data');
    }
}
