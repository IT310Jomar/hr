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
        Schema::create('accounts', function (Blueprint $table) {
            $table->id();
            $table->string('firstname');
            $table->string('lastname');
            $table->string('email', 2048)->nullable();
            $table->string('recovery_email', 2048)->nullable();
            $table->text('company_name')->nullable();
            $table->string('contact_no', 32)->nullable();
            $table->string('industry', 2048)->comment('company type')->nullable();
            $table->text('address')->nullable();
            $table->text('city')->nullable();
            $table->text('region')->nullable();
            $table->text('zipcode')->nullable();
            $table->text('website')->nullable();
            $table->text('logo')->nullable();
            $table->bigInteger('account_status_id')->default(1);
            $table->smallInteger('is_device_sync')->default(0);
            $table->timestamps();
        });

        DB::table('accounts')->insert(
            ['firstname'=> 'Kit',
            'lastname' => 'Casinillo',
            'email'     => 'sirius@itechmedialogic.com',
            'company_name' => 'ITech Media Logic',
            'contact_no' => '09164810492',
            'industry' => 'Information Technology and Services',
            'address' => 'Zone 3 Poblacion',
            'city' => ' El Salvador City',
            'region' => '10',
            'zipcode' => '9017',
            'website' => 'https://itechmedialogic.com',
            'account_status_id'  => 1,
            'is_device_sync' => 0
            ]
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('accounts');
    }
};
