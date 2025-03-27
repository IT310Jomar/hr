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
        Schema::create('benefits', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('user_id');
            $table->unsignedInteger('employee_id');
            $table->unsignedInteger('benefit_type_id');
            $table->boolean('active');
            $table->date('effective_date')->nullable();
            $table->date('enrollment_date')->nullable();
            $table->string('plan')->nullable();
            $table->string('beneficiary')->nullable();
            $table->text('notes')->nullable();
            $table->enum('payment_type', ['NA', 'Salary', 'Shouldered']);
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
        Schema::dropIfExists('benefits');
    }
};
