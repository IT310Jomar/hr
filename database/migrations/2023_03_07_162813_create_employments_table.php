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
        Schema::create('employments', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('user_id');
            $table->integer('employee_id');
            $table->unsignedInteger('department_id');
            $table->unsignedInteger('location_id');
            $table->integer('job_grade', false)->nullable();
            $table->enum('billability', ['Billable', 'Non-Billable']);
            $table->enum('type', ['Rank-and-File', 'Manager', 'Officer']);
            $table->string('title')->nullable();
            $table->date('date_hired')->nullable();
            $table->date('date_regularization')->nullable();
            // $table->unsignedInteger('user_type_id');
            $table->unsignedInteger('status_id');
            $table->text('remarks')->nullable();
            $table->integer('biometric', false);
            $table->enum('payroll_type', ['Hourly', 'Daily', 'Semi-Monthly', 'Monthly']);
            $table->integer('payroll_pie_id', false)->nullable();
            $table->unsignedInteger('schedule_type_id')->nullable();
            $table->integer('working_hours', false)->nullable();
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
        Schema::dropIfExists('employments');
    }
};
