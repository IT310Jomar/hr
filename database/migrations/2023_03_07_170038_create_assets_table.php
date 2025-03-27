<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('assets', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('user_id');
            $table->unsignedInteger('employee_id');
            $table->string('item')->nullable();
            $table->unsignedInteger('category_id');
            $table->unsignedInteger('condition_id');
            $table->float('price', 8, 2);
            $table->string('serial_number')->nullable();
            $table->date('date_acquired')->nullable();
            $table->date('date_issued')->nullable();
            $table->date('date_returned')->nullable();
            $table->text('notes');
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
        Schema::dropIfExists('assets');
    }
};
