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
        Schema::create('salaries', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('user_id', false);
            $table->unsignedInteger('employee_id');
            $table->date('date_from')->nullable();
            $table->double('base_salary', 8, 2)->nullable();
            $table->string('others_type')->nullable();
            $table->double('other_supplies', 8, 2)->nullable();
            $table->double('monthly_gross', 8, 2)->nullable();
            $table->double('percentage_increase', 8, 2)->nullable();
            $table->double('raise_amount', 8, 2)->nullable();
            $table->double('raise_percentage', 8, 2)->nullable();
            $table->double('commission', 8, 2)->nullable();
            $table->unsignedInteger('salary_action_id')->nullable();
            $table->text('notes')->nullable();
            $table->double('clothing', 8, 2)->nullable();
            $table->double('communication', 8, 2)->nullable();
            $table->double('discretionary', 8, 2)->nullable();
            $table->double('laundry', 8, 2)->nullable();
            $table->double('meal', 8, 2)->nullable();
            $table->double('medical', 8, 2)->nullable();
            $table->double('productivity', 8, 2)->nullable();
            $table->double('rice', 8, 2)->nullable();
            $table->double('transportation', 8, 2)->nullable();
            $table->double('travel', 8, 2)->nullable();
            $table->double('others', 8, 2)->nullable();
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
        Schema::dropIfExists('salaries');
    }
};
