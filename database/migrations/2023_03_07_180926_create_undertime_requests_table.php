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
        Schema::create('undertime_requests', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('user_id')->nullable();
            $table->unsignedInteger('employee_id')->nullable();
            $table->date('date_req');
            $table->time('from');
            $table->time('to');
            $table->double('total_hours', 8, 2);
            $table->text('reason');
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
        Schema::dropIfExists('undertime_requests');
    }
};
