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
        Schema::create('schedule_configuration', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('schedule_type_id')->nullable();
            $table->string('day')->nullable();
            $table->time('shift_start')->nullable();
            $table->time('shift_end')->nullable();
            $table->time('break_start')->nullable();
            $table->time('break_end')->nullable();
            $table->boolean('rest_day')->default(false);
            $table->timestamps();
        });
        
        $data = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];
        $start_shift = '07:00:00';
        $shift_end = '17:00:00';
        $break_start = '12:00:00';
        $break_end = '13:00:00';
        $schedule_type_id = 1;
        
        foreach ($data as $day) {
            DB::table('schedule_configuration')->insert([
                'day' => $day,
                'shift_start' => $start_shift,
                'shift_end' => $shift_end,
                'break_start' => $break_start,
                'break_end' => $break_end,
                'schedule_type_id' => $schedule_type_id,
            ]);
        }        
        

        $gy_day = array('Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday');
        $gy_shift_start = '22:00:00';
        $gy_shift_end = '06:00:00';
        $gy_break_start = '01:00:00';
        $gy_break_end = '02:00:00';
        $gy_schedule_type_id = '2';

        foreach ($gy_day as $val) {
            DB::table('schedule_configuration')->insert([
                'day'               => $val,
                'shift_start'       => $gy_shift_start,
                'shift_end'         => $gy_shift_end,
                'break_start'       => $gy_break_start,
                'break_end'         => $gy_break_end,
                'schedule_type_id'  => $gy_schedule_type_id,
            ]);
        }

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('schedule_configuration');
    }
};
