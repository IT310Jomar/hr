<?php

use App\Models\EmploymentStatus;
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
        Schema::create('employment_statuses', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->timestamps();
        });

        $data = array('Regular', 'Maternity', 'Paternity', 'Sabbatical', 'Terminated', 'Resigned', 'AWOL', 'Probationary', 'Part-Time', 'Extended Part-Time', 'Contractual / Project Based', 'On PIP', 'End of Contract');

        foreach($data as $val) {
            EmploymentStatus::insert(array('name' => $val));
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('employment_statuses');
    }
};
