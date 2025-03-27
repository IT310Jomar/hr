<?php

use App\Models\RequirementItem;
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
        Schema::create('requirement_items', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->timestamps();
        });

        $data = array('Copy of Resume', '2pcs of 2x2 picture', '2pcs of 1x1 picture', 'Photocopy of Birth certificate', 'Photocopy of Birth certificate of dependents', 'Photocopy of Marriage Contract', 'Photocopy of 2 valid ID', 'Photocopy of SSS ID', 'Photocopy of Philhealth ID', 'Photocopy of TIN ID', 'Photocopy of Pag-ibig ID/number', 'Photocopy of latest BIR 2316', 'NBI Clerance', 'Copies of Certificate of Employment', 'Copy of Transcript of Records', 'Copy of Diploma', 'Copy of License (PRC, etc)', 'Copy of Passport', 'Copy of ACR/AEP/VISA', 'Pre-employment medical examination', 'Employee Information Sheet', 'ATM application', 'Philhealth form (PMRF)', 'Pag-ibig MDF printout from ONLINE MEMBERSHIP', 'Pag-ibig RTMRLD form (merging form)', 'BIR 1902 (without TIN #)', 'BIR 2305 & 1905 forms', 'Employment Contract', 'ID application form', 'Orientation Module', 'New Hire First Day Checklist', 'Waiver for non submission of BIR 2316', 'Promissory Note', 'Employment requirements Form (signed and checked)');

        foreach ($data as $val) {
            RequirementItem::insert(
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
        Schema::dropIfExists('requirement_items');
    }
};
