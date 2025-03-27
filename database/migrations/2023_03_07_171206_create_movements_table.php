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
        Schema::create('movements', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('user_id');
            $table->unsignedInteger('employee_id');
            $table->date('date_from')->nullable();
            $table->date('date_to')->nullable();
            $table->string('from_position')->nullable();
            $table->string('from_department')->nullable();
            $table->unsignedInteger('from_employment_type_id');
            $table->unsignedInteger('from_employment_status_id');
            $table->string('to_position')->nullable();
            $table->string('to_department')->nullable();
            $table->unsignedInteger('to_employment_type_id');
            $table->unsignedInteger('to_employment_status_id');
            $table->string('action_for');
            $table->text('notes')->nullable();
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
        Schema::dropIfExists('movements');
    }
};
