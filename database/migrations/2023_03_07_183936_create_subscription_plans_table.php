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
        Schema::create('subscription_plans', function (Blueprint $table) {
            $table->id();
            $table->string('plan', 1024)->nullable();
            $table->string('subtitle', 1024)->nullable();
            $table->float('monthly_plan')->nullable();
            $table->float('monthly_in_on_eyear')->nullable();
            $table->float('yearly_plan')->nullable();
            $table->float('yearly_plan_in_one_month')->nullable();
            $table->integer('user_limit')->nullable();
            $table->integer('storage_limit')->nullable();
            $table->text('inclusions')->nullable();
            $table->smallInteger('is_best_seller')->default(0)->nullable();
            $table->text('thumbnail')->nullale();
            $table->smallInteger('status')->default(1);
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
        Schema::dropIfExists('subscription_plans');
    }
};
