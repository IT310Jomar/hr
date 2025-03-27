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
        Schema::create('attendance_logs', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('user_id')->nullable();
            $table->unsignedInteger('employee_id');
            $table->date('login');
            $table->time('timeIn');
            $table->date('logout')->nullable();
            $table->time('timeOut')->nullable();
            $table->enum('state', ['Check In', 'Check Out']);
            $table->text('type')->nullable();
            $table->text('remarks')->nullable();
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
        Schema::dropIfExists('attendance_logs');
    }
};
