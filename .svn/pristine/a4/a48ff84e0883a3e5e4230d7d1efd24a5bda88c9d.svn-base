<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class CopyIDcardImages extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'images:copy';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
        $this->info('starting...');
        $students = \App\Student::join('courses', 'courses.id', '=', 'students.course_id')->orderBy('courses.sno')
            // ->where('courses.course_year', '=', 1)
            // ->where('courses.id', 3)
            ->where('students.adm_cancelled', '=', 'N')
            ->whereIn('admission_id', function ($query) {
                $query->from('attachments')
                    ->where(function ($q) {
                        $q->where('file_type', 'signature');
                    })
                    ->select('admission_id');
            })
            ->whereIn('admission_id', function ($query) {
                $query->from('attachments')
                    ->where(function ($q) {
                        $q->where('file_type', 'photograph');
                    })
                    ->select('admission_id');
            })
            ->whereIn('admission_id', function ($query) {
                $query->from('admission_forms')
                    ->where(function ($q) {
                        $q->where('final_submission', 'Y');
                    })
                    ->select('id');
            })
            ->with(['attachments' => function ($q) {
                $q->where('file_type', '=', 'photograph')
                    ->orWhere('file_type', '=', 'signature');
            }]);
        $students = $students->select('students.*')->orderBy('students.id');
        $students->chunk(100, function ($stds) {
            $course_id = 0;
            foreach ($stds as $std) {
                foreach ($std->attachments as $att) {
                    $file_path = "/images/" . $att->file_type . '_' . $std->admission_id . '.' . $att->file_ext;
                    // $file_done1 = "/mcm/" . $std->course_id . "/" . ($att->file_type == 'photograph' ? 'photos/' : 'signatures/') . ($att->file_type == 'photograph' ? 'P' : 'S') . "181" . $std->roll_no . '.jpg';

                    $file_ext = $att->file_ext;
                    if (strtoupper($att->file_ext) == 'JPEG') {
                        $file_ext = 'jpg';
                    }
                    $file_done = "/done/" . $std->course_id . "/" . ($att->file_type == 'photograph' ? 'photos/' : 'signatures/') . "/" . ($att->file_type == 'photograph' ? 'P' : 'S') . "181" . $std->roll_no . '.' . $file_ext;
                    $file_done1 = "/done1/" . $std->course_id . "/" . ($att->file_type == 'photograph' ? 'photos/' : 'signatures/') . "/" . ($att->file_type == 'photograph' ? 'P' : 'S') . "181" . $std->roll_no . '.' . $file_ext;
                    $file_done2 = "/done2/" . $std->course_id . "/" . ($att->file_type == 'photograph' ? 'photos/' : 'signatures/') . "/" . ($att->file_type == 'photograph' ? 'P' : 'S') . "181" . $std->roll_no . '.' . $file_ext;
                    $file_done4 = "/done4/" . $std->course_id . "/" . ($att->file_type == 'photograph' ? 'photos/' : 'signatures/') . "/" . ($att->file_type == 'photograph' ? 'P' : 'S') . "181" . $std->roll_no . '.' . $file_ext;
                    $new_path = "/pending/" . $std->course_id . "/" . ($att->file_type == 'photograph' ? 'photos/' : 'signatures/') . "/" . ($att->file_type == 'photograph' ? 'P' : 'S') . "181" . $std->roll_no . '.' . $file_ext;

                    $this->info($file_path);
                    $this->info($file_done1);
                    $this->info($new_path);

                    if (
                        Storage::disk('local')->exists($file_path) &&
                        Storage::disk('local')->exists($new_path) == false &&
                        Storage::disk('local')->exists($file_done) == false &&
                        Storage::disk('local')->exists($file_done1) == false &&
                        Storage::disk('local')->exists($file_done2) == false &&
                        Storage::disk('local')->exists($file_done4) == false
                        ) {
                        $this->info($file_path);
                        Storage::disk('local')->copy($file_path, $new_path);
                    }
                }
            }
        });
    }
}
