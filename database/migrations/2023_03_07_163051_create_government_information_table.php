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
        Schema::create('government_informations', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('user_id');
            $table->unsignedInteger('employee_id')->nullable();
            $table->string('sss')->nullable();
            $table->string('tin')->nullable();
            $table->string('phil_health')->nullable();
            $table->string('pag_ibig')->nullable();
            $table->string('prc')->nullable();
            $table->string('passport')->nullable();
            $table->unsignedInteger('tax_status_id')->nullable();
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
        Schema::dropIfExists('government_informations');
    }
};
