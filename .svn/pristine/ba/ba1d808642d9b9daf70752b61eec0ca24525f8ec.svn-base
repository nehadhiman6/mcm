<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Student;
use App\StudentSubs;
use Illuminate\Database\Eloquent\Collection;
use DB;

class AddSubjects extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'subjects:add';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Add subjects from admission subjects table.';

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
        {
            // dd(StudentSubs::firstOrNew(['subject_id' => 7, 'student_id' => 4894], ['sub_group_id' => 5]));
            $students = Student::orderBy('id');
    
            // dd($trns->first());
            $i = 0;
            $students->chunk(50, function ($stds) use ($i) {
                foreach ($stds as $std) {
                    DB::connection(getYearlyDbConn())->beginTransaction();
                    $old_sub_ids = $std->stdSubs->pluck('id')->toArray();
                    $std_subs = new Collection();
                    foreach ($std->admform->admSubs as $subs) {
                        // $arr = ['subject_id' => $subs->subject_id, 'sub_group_id' => $subs->sub_group_id, 'student_id' => $std->id];
                        $attr = ['subject_id' => $subs->subject_id, 'student_id' => $std->id];
                        $values = ['sub_group_id' => $subs->sub_group_id, 'ele_group_id' => $subs->ele_group_id];
                        $subject = StudentSubs::firstOrNew($attr, $values);
                        if ($subject->exists) {
                            $subject->fill($values);
                        }
                        $subject->save();
                        $std_subs->add($subject);
                    }
                    if (count($old_sub_ids) > 0) {
                        $new_sub_ids = $std_subs->pluck('id')->toArray();
                        $to_be_removed = array_diff($old_sub_ids, $new_sub_ids);
                        $std->stdSubs()->whereIn('id', $to_be_removed)->delete();
                    }
                    DB::connection(getYearlyDbConn())->commit();
                }
                $this->info((50 * ++$i) . ' records done!');
            });
        }
    }
}
