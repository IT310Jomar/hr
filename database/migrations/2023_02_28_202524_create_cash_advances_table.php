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
        Schema::create('cash_advances', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('user_id');
            $table->unsignedInteger('employee_id');
            $table->unsignedInteger('type_id')->nullable();
            $table->date('requested_date');
            $table->date('date_approved')->nullable();
            $table->date('date_decline')->nullable();
            $table->longText('reasons');
            $table->string('amount');
            $table->enum('request_status',['Pending','Approved','Declined'])->default('Pending');
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
        Schema::dropIfExists('cash_advances');
    }
};
