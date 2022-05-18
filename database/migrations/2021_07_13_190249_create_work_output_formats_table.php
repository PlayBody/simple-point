<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWorkOutputFormatsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('work_output_formats', function (Blueprint $table) {
            $table->foreignId('work_id')->constrained('works')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('output_format_id')->constrained('output_formats')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('work_output_formats');
    }
}
