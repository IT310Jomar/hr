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
        Schema::create('incident_reports', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('user_id')->nullable();
            $table->unsignedInteger('employee_id');
            $table->unsignedInteger('offense_level_id');
            $table->text('account');
            $table->text('immediate_head');
            $table->text('incident');
            $table->dateTime('dt_of_incident');
            $table->enum('status_id',['Pending','Approved','Declined'])->default('Pending');
            // $table->unsignedInteger('status_id');
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
        Schema::dropIfExists('incident_reports');
    }
};
