<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePermissionRev1 extends Migration {

  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up() {
    $permissions = [
      ['name' => 'MISC-INST', 'label' => 'MISC. INSTALLMENTS'],
      ['name' => 'ADMISSION-REGISTER', 'label' => 'ADMISSION REGISTER'],
      ['name' => 'CENTRALIZED-STUDENT', 'label' => 'CENTRALIZED STUDENTS'],
      ['name' => 'CONCESSION-REPORT', 'label' => 'STUDENT WITH CONCESSION'],
      ['name' => 'FUNDWISE-COLLECTION', 'label' => 'FUND WISE COLLECTION'],
      ['name' => 'PENDING-BALANCE', 'label' => 'PENDING BALANCE REPORT'],
      ['name' => 'PROSPECTUS-FEESREPORT', 'label' => 'PROSPECTUS FEES REPORT'],
      ['name' => 'FUNDBALANCE', 'label' => 'FUND-WISE BALANCE'],
      ['name' => 'STUDENT-SUBJECTS', 'label' => 'STUDENT SUBJECTS'],
      ['name' => 'SUB-STD-STRENGTH', 'label' => 'SUBJECT-WISE STUDENT STRENGTH'],
    ];
    foreach ($permissions as $permission) {
      $p = \App\Permission::where('name', '=', $permission['name'])->first();
      if ($p) {
        $per = \App\Permission::where('name', '=', $permission['name'])->update($permission);
      } else {
        $per = \App\Permission::Create($permission);
      }
    }
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down() {
    //
  }

}
