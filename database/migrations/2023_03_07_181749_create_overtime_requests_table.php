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
        Schema::create('overtime_requests', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('user_id')->nullable();
            $table->unsignedInteger('employee_id')->nullable();
            $table->string('day');
            $table->date('shift_date');
            $table->time('shift_from');
            $table->time('shift_to');
            $table->enum('classification', ['normal', 'early']);
            $table->time('start');
            $table->time('end');
            $table->text('purpose');
            $table->enum('status_id',['Pending','Approved','Declined'])->default('Pending');
            // $table->unsignedInteger('status_id');
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
        Schema::dropIfExists('overtime_requests');
    }
};
