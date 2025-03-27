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
        Schema::create('user_levels', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->nullable();
            $table->text('privilege')->nullable();
            $table->timestamps();
        });

        $data = array('God Mode', 'Administrator', 'Supervisor / Manager', 'Employee');

        foreach ($data as $val) {
            DB::table('user_levels')->insert(
                array('name' => $val)
            );
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_levels');
    }
};
