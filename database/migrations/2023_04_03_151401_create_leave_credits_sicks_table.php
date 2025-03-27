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
        Schema::create('leave_credits_sicks', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('employee_id');
            $table->enum('name',['Sick'])->nullable();
            $table->integer('credits')->default(0);
            $table->text('reasons')->nullable();
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
        Schema::dropIfExists('leave_credits_sicks');
    }
};
