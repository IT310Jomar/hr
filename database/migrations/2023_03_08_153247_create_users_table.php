<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('account_id');
            $table->string('username')->unique();
            $table->string('email')->unique();
            $table->string('password')->nullable();
            $table->string('code')->nullable();
            $table->unsignedInteger('level_id');
            $table->string('image')->nullable();
            $table->rememberToken();
            $table->timestamps();
        
            $table->foreign('level_id')->references('id')->on('user_levels');
        });        
        
        DB::table('users')->insert(
            ['account_id'=> 1,
            'username'  => 'Sirius Admin',
            'email'     => 'sirius@itechmedialogic.com',
            'password'  => Hash::make('password'),
            'level_id'  => 1]
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
};
