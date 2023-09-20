<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class ChangeImagesNames extends Command
{

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'images:change';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Changes names of images uploaded by students for PU';

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
                    $file_done1 = "/final/pu/" . $std->course_id . "/" . ($att->file_type == 'photograph' ? 'photos/' : 'signatures/') . ($att->file_type == 'photograph' ? 'P' : 'S') . "178" . $std->roll_no . '.jpg';
                    $file_done2 = "/final/pu/" . $std->course_id . "/" . ($att->file_type == 'photograph' ? 'photos/' : 'signatures/') . ($att->file_type == 'photograph' ? 'P' : 'S') . "181" . $std->roll_no . '.jpg';
                    $file_done3 = "/final/pu/" . $std->course_id . "/" . ($att->file_type == 'photograph' ? 'photo/' : 'signature/') . ($att->file_type == 'photograph' ? 'P' : 'S') . "178" . $std->roll_no . '.jpg';
                    $file_done4 = "/final/pu/" . $std->course_id . "/" . ($att->file_type == 'photograph' ? 'photo/' : 'signature/') . ($att->file_type == 'photograph' ? 'P' : 'S') . "181" . $std->roll_no . '.jpg';
                    $file_done5 = "/final/pu/" . $std->course_id . "/" . ($att->file_type == 'photograph' ? 'photo/' : 'signatures/') . ($att->file_type == 'photograph' ? 'P' : 'S') . "181" . $std->roll_no . '.jpg';
                    $file_done6 = "/final/pu/" . $std->course_id . "/" . ($att->file_type == 'photograph' ? 'photo/' : 'sign/') . ($att->file_type == 'photograph' ? 'P' : 'S') . "181" . $std->roll_no . '.jpg';
                    $file_done7 = "/final/pu/" . $std->course_id . "/" . ($att->file_type == 'photograph' ? 'photo/' : 'sign/') . ($att->file_type == 'photograph' ? 'P' : 'S') . "178" . $std->roll_no . '.jpg';
                    $file_done8 = "/final/pu/" . $std->course_id . "/" . ($att->file_type == 'photograph' ? 'photo/' : 'signs/') . ($att->file_type == 'photograph' ? 'P' : 'S') . "181" . $std->roll_no . '.jpg';
                    $file_done9 = "/final/pu/" . $std->course_id . "/" . ($att->file_type == 'photograph' ? 'photo/' : 'signs/') . ($att->file_type == 'photograph' ? 'P' : 'S') . "178" . $std->roll_no . '.jpg';
                    if (strtoupper($att->file_ext) == 'JPEG' || strtoupper($att->file_ext) == 'PNG') {
                        $file_ext = $att->file_ext;
                        if (strtoupper($att->file_ext) == 'JPEG') {
                            $file_ext = 'jpg';
                        }
                        $new_path = "/pu/" . $std->course_id . "/" . ($att->file_type == 'photograph' ? 'P' : 'S') . "181" . $std->roll_no . '.' . $file_ext;
                    } else {
                        $new_path = "/pu/" . $std->course_id . "/" . ($att->file_type == 'photograph' ? 'P' : 'S') . "181" . $std->roll_no . '.' . $file_ext;
                    }
                    if (Storage::disk('local')->exists($file_path) && Storage::disk('local')->exists($file_done1) == false && Storage::disk('local')->exists($file_done2) == false && Storage::disk('local')->exists($file_done3) == false && Storage::disk('local')->exists($file_done4) == false && Storage::disk('local')->exists($file_done5) == false && Storage::disk('local')->exists($file_done6) == false && Storage::disk('local')->exists($file_done7) == false && Storage::disk('local')->exists($file_done8) == false && Storage::disk('local')->exists($file_done9) == false) {
                        $this->info($file_path);
                        Storage::disk('local')->copy($file_path, $new_path);
                    }
                }
            }
        });
    }
}
