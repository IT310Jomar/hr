<?php

use App\Models\Types;
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
        Schema::create('types', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->timestamps();
        });

        $data = ['Missing Log', 'Schedule Conflict', 
        'Half Day Leave Undertime', 'On Leaves but with logs', 'Holiday / Rest day but with logs', 'Possible Overtime',
        'Early in', 'Possible Broken Shift', 'Possible Broken Undertime', 'Incomplete Logs'];

        foreach($data as $val) {
            Types::insert(array('name' => $val));
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('types');
    }
};
