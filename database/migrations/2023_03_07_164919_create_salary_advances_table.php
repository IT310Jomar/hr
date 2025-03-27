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
        Schema::create('salary_advances', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('user_id');
            $table->unsignedInteger('loan_type_id');
            $table->timestamp('date_request')->nullable();
            $table->timestamp('date_released')->nullable();
            $table->timestamp('date_deduction_start')->nullable();
            $table->timestamp('date_deduction_end')->nullable();
            $table->double('total_amount', 8, 2);
            $table->integer('pay_period', false);
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
        Schema::dropIfExists('salary_advances');
    }
};
