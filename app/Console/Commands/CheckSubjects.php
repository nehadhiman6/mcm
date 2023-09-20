<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class CheckSubjects extends Command
{

  /**
   * The name and signature of the console command.
   *
   * @var string
   */
    protected $signature = 'subjects:check';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Checks students subjects for duplication';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();

        getYearlyDbConn(true);
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $dup_subs = \App\StudentSubs::groupBy(['student_subs.student_id', 'student_subs.subject_id'])
            ->select('student_subs.student_id', 'student_subs.subject_id', DB::raw('sum(1) as sub_count, max(id) as id'))
            ->having('sub_count', '>', 1)
            // ->where('student_subs.student_id','=',1689)
            ->get();
        foreach ($dup_subs as $dup) {
            $a = \App\StudentSubs::whereStudentId($dup->student_id)->whereSubjectId($dup->subject_id)
          ->where('id', '<', $dup->id)
          ->delete();
        }
        return 'done';
    }
}
