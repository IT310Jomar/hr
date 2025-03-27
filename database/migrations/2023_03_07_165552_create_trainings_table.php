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
        Schema::create('trainings', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('user_id');
            $table->timestamp('training_date')->nullable();
            $table->string('name');
            $table->string('instructor');
            $table->string('nature');
            $table->float('cost', 8, 2);
            $table->timestamp('returning_service')->nullable();
            $table->float('amount', 8, 2);
            $table->text('notes');
            $table->timestamp('training_start')->nullable();
            $table->timestamp('training_end')->nullable();
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
        Schema::dropIfExists('trainings');
    }
};
