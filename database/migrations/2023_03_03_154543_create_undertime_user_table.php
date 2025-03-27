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
        Schema::create('undertime_user', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->date('requested_date');
            $table->float('amount');
            $table->enum('status',['undertime','overtime'])->default('undertime');
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
        Schema::dropIfExists('undertime_user');
    }
};
