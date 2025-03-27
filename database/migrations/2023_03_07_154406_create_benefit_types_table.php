<?php

use App\Models\BenefitType;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('benefit_types', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->boolean('status')->default(1);
            $table->timestamps();
        });

        $data = array('Leave Credits', 'HMO after 6 months', 'HMO after probationary period', 'HMO', 'Health', 'Life Insurance', 'Accident Insurance', 'Commission', 'Other Benefits');

        foreach($data as $val) {
            BenefitType::insert(array('name' => $val));
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('benefit_types');
    }
};
