<?php

use App\Models\OffenseLevel;
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
        Schema::create('offense_levels', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->timestamps();
        });

        $data = array('First Offense', 'Second Offense', 'Third Offense', 'Fourth Offense', 'Fifth Offense');

        foreach($data as $val) {
            OffenseLevel::insert(array('name' => $val));
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('offense_levels');
    }
};
