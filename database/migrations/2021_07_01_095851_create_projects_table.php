<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->foreignId('admin_id')->nullable()->constrained('users')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('client_id')->constrained('users')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('business_id')->nullable()->constrained('users')->onUpdate('cascade')->onDelete('cascade');
            $table->string('title');
            $table->float('amount', 10, 1);
            $table->date('delivery_date');
            $table->string('purchase_order_link')->nullable();
            $table->string('invoice_link')->nullable();
            $table->string('status', 10);
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
        Schema::dropIfExists('projects');
    }
}
