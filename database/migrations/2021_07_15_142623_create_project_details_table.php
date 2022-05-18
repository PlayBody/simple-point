<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProjectDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('project_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('project_id')->constrained('projects')->onUpdate('cascade')->onDelete('cascade');
            $table->float('ground_data', 8, 1)->nullable();
            $table->string('ground_data_output', 10)->nullable();
            $table->float('simplified_drawing', 8, 1)->nullable();
            $table->string('simplified_drawing_output', 10)->nullable();
            $table->float('simplified_drawing_rank', 1, 0)->nullable();
            $table->float('simplified_drawing_scale', 4, 0)->nullable();
            $table->float('contour_data', 8, 1)->nullable();
            $table->string('contour_data_output', 10)->nullable();
            $table->float('longitudinal_data', 8, 1)->nullable();
            $table->string('longitudinal_data_output', 10)->nullable();
            $table->float('simple_orthphoto', 8, 1)->nullable();
            $table->string('simple_orthphoto_output', 10)->nullable();
            $table->float('mesh_soil_volume', 8, 1)->nullable();
            $table->string('mesh_soil_volume_output', 10)->nullable();
            $table->float('simple_accuracy_table', 8, 1)->nullable();
            $table->string('simple_accuracy_table_output', 10)->nullable();
            $table->float('public_accuracy_table', 8, 1)->nullable();
            $table->string('public_accuracy_table_output', 10)->nullable();
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
        Schema::dropIfExists('project_details');
    }
}
