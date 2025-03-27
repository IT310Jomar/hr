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
        Schema::create('cashadvance_user', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->date('requested_date');
            $table->float('amount');
            $table->enum('status',['advance','exact','Delay'])->default('advance');
            $table->rememberToken();
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
        Schema::dropIfExists('cashadvance_user');
    }
};
