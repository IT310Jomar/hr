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
        Schema::create('schedule_adjustments', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('user_id')->nullable();
            $table->unsignedInteger('employee_id')->nullable();
            $table->unsignedInteger('type_id')->nullable();
            $table->date('date_from');
            $table->date('date_to');
            $table->time('shift_start');
            $table->time('shift_end');
            $table->text('break_start');
            $table->text('break_end');
            $table->enum('status_id',['Pending','Approved','Declined'])->default('Pending');
            $table->softDeletes();
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
        Schema::dropIfExists('schedule_adjustments');
    }
};
