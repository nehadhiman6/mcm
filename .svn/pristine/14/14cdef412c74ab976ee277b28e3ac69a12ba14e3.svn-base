<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Course;
use App\Subject;
use App\CourseSubject;
use App\Student;
use App\StudentSubs;
use DB;
use App\Pupin;
use App\PrvStudent;

class ImportPupinData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'pupin:import';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Imports Pupin Data';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        getYearlyDbConn(true);
        getPrvYearDbConn(true);
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {   
        // DB::connection(getYearlyDbConn())->table('subjects')->truncate();
        // DB::connection(getYearlyDbConn())->table('courses')->truncate();
        // DB::connection(getYearlyDbConn())->table('students')->truncate();
        // DB::connection(getYearlyDbConn())->table('course_subject')->truncate();
        // DB::connection(getYearlyDbConn())->table('student_subs')->truncate();

        Pupin::chunk(50,function($pupins){
            foreach($pupins as $pupin) {
                $student = PrvStudent::whereRollNo($pupin->rollno)->first();
                // dd($student);
                if(!$student) {
                    $course = Course::firstOrCreate(['class_code' => $pupin->class],['class_code' => $pupin->class,'course_id' => $pupin->class,'course_name' => $pupin->class,'course_year' => 1,'status' => 'GRAD','sub_combination' => '0','adm_open' => 'Y','adm_close_date' => '31-07-2018']);
                    $subid1 = 0;
                    $subid2 = 0;
                    $subid3 = 0;
                    $subid4 = 0;
                    $subid5 = 0;
                    $subid6 = 0;
                    $subid7 = 0;
                    $subid8 = 0;
                    $subid9 = 0;
                    $subid10 = 0;
                    $subid11 = 0;
                    if($pupin->subject1 != '') {
                        $subject = Subject::firstOrCreate(['uni_code' => $pupin->subject1],['subject' => $pupin->subject1,'description' => 'optional','practical' => '0','uni_code' => $pupin->subject1]);
                        $course_sub = CourseSubject::firstOrCreate(['course_id' => $course->id,'subject_id' => $subject->id],['course_id' => $course->id,'subject_id' => $subject->id,'sub_type' => 'O','uni_code' => $subject->uni_code,'practical' => 'N','add_on_course' => 'N','honours' => 'N']);
                        $subid1 = $subject->id;
                    }
                    if($pupin->subject2 != '') {
                        $subject = Subject::firstOrCreate(['uni_code' => $pupin->subject2],['subject' => $pupin->subject2,'description' => 'optional','practical' => '0','uni_code' => $pupin->subject2]);
                        $course_sub = CourseSubject::firstOrCreate(['course_id' => $course->id,'subject_id' => $subject->id],['course_id' => $course->id,'subject_id' => $subject->id,'sub_type' => 'O','uni_code' => $subject->uni_code,'practical' => 'N','add_on_course' => 'N','honours' => 'N']);
                        $subid2 = $subject->id;
                    }
                    if($pupin->subject3 != '') {
                        $subject = Subject::firstOrCreate(['uni_code' => $pupin->subject3],['subject' => $pupin->subject3,'description' => 'optional','practical' => '0','uni_code' => $pupin->subject3]);
                        $course_sub = CourseSubject::firstOrCreate(['course_id' => $course->id,'subject_id' => $subject->id],['course_id' => $course->id,'subject_id' => $subject->id,'sub_type' => 'O','uni_code' => $subject->uni_code,'practical' => 'N','add_on_course' => 'N','honours' => 'N']);
                        $subid3 = $subject->id;
                    }
                    if($pupin->subject4 != '') {
                        $subject = Subject::firstOrCreate(['uni_code' => $pupin->subject4],['subject' => $pupin->subject4,'description' => 'optional','practical' => '0','uni_code' => $pupin->subject4]);
                        $course_sub = CourseSubject::firstOrCreate(['course_id' => $course->id,'subject_id' => $subject->id],['course_id' => $course->id,'subject_id' => $subject->id,'sub_type' => 'O','uni_code' => $subject->uni_code,'practical' => 'N','add_on_course' => 'N','honours' => 'N']);
                        $subid4 = $subject->id;
                    }
                    if($pupin->subject5 != '') {
                        $subject = Subject::firstOrCreate(['uni_code' => $pupin->subject5],['subject' => $pupin->subject5,'description' => 'optional','practical' => '0','uni_code' => $pupin->subject5]);
                        $course_sub = CourseSubject::firstOrCreate(['course_id' => $course->id,'subject_id' => $subject->id],['course_id' => $course->id,'subject_id' => $subject->id,'sub_type' => 'O','uni_code' => $subject->uni_code,'practical' => 'N','add_on_course' => 'N','honours' => 'N']);
                        $subid5 = $subject->id;
                    }
                    if($pupin->esubject != '') {
                        $subject = Subject::firstOrCreate(['uni_code' => $pupin->esubject],['subject' => $pupin->esubject,'description' => 'optional','practical' => '0','uni_code' => $pupin->esubject]);
                        $course_sub = CourseSubject::firstOrCreate(['course_id' => $course->id,'subject_id' => $subject->id],['course_id' => $course->id,'subject_id' => $subject->id,'sub_type' => 'O','uni_code' => $subject->uni_code,'practical' => 'N','add_on_course' => 'N','honours' => 'N']);
                        $subid6 = $subject->id;
                    }
                    if($pupin->subject6 != '') {
                        $subject = Subject::firstOrCreate(['uni_code' => $pupin->subject6],['subject' => $pupin->subject6,'description' => 'optional','practical' => '0','uni_code' => $pupin->subject6]);
                        $course_sub = CourseSubject::firstOrCreate(['course_id' => $course->id,'subject_id' => $subject->id],['course_id' => $course->id,'subject_id' => $subject->id,'sub_type' => 'O','uni_code' => $subject->uni_code,'practical' => 'N','add_on_course' => 'N','honours' => 'N']);
                        $subid11 = $subject->id;
                    }
                    if($pupin->subject7 != '') {
                        $subject = Subject::firstOrCreate(['uni_code' => $pupin->subject7],['subject' => $pupin->subject7,'description' => 'optional','practical' => '0','uni_code' => $pupin->subject7]);
                        $course_sub = CourseSubject::firstOrCreate(['course_id' => $course->id,'subject_id' => $subject->id],['course_id' => $course->id,'subject_id' => $subject->id,'sub_type' => 'O','uni_code' => $subject->uni_code,'practical' => 'N','add_on_course' => 'N','honours' => 'N']);
                        $subid7 = $subject->id;
                    }
                    if($pupin->subject8 != '') {
                        $subject = Subject::firstOrCreate(['uni_code' => $pupin->subject8],['subject' => $pupin->subject8,'description' => 'optional','practical' => '0','uni_code' => $pupin->subject8]);
                        $course_sub = CourseSubject::firstOrCreate(['course_id' => $course->id,'subject_id' => $subject->id],['course_id' => $course->id,'subject_id' => $subject->id,'sub_type' => 'O','uni_code' => $subject->uni_code,'practical' => 'N','add_on_course' => 'N','honours' => 'N']);
                        $subid8 = $subject->id;
                    }
                    if($pupin->subject9 != '') {
                        $subject = Subject::firstOrCreate(['uni_code' => $pupin->subject9],['subject' => $pupin->subject9,'description' => 'optional','practical' => '0','uni_code' => $pupin->subject9]);
                        $course_sub = CourseSubject::firstOrCreate(['course_id' => $course->id,'subject_id' => $subject->id],['course_id' => $course->id,'subject_id' => $subject->id,'sub_type' => 'O','uni_code' => $subject->uni_code,'practical' => 'N','add_on_course' => 'N','honours' => 'N']);
                        $subid9 = $subject->id;
                    }
                    if($pupin->subject10 != '') {
                        $subject = Subject::firstOrCreate(['uni_code' => $pupin->subject10],['subject' => $pupin->subject10,'description' => 'optional','practical' => '0','uni_code' => $pupin->subject10]);
                        $course_sub = CourseSubject::firstOrCreate(['course_id' => $course->id,'subject_id' => $subject->id],['course_id' => $course->id,'subject_id' => $subject->id,'sub_type' => 'O','uni_code' => $subject->uni_code,'practical' => 'N','add_on_course' => 'N','honours' => 'N']);
                        $subid10 = $subject->id;
                    }

                    // id, admission_id, adm_entry_id, std_user_id, std_type_id, adm_source, adm_no, adm_date, roll_no,
                    //  status, adm_cancelled, course_id, loc_cat, cat_id, resvcat_id, religion, geo_cat, nationality, 
                    // name, mobile, aadhar_no, gender, father_name, mother_name, guardian_name, dob, blood_grp, migration, 
                    // blind, hostel, per_address, city, state_id, pincode, same_address, corr_address, corr_city, 
                    // corr_state_id, corr_pincode, father_occup, father_desig, father_phone, father_mobile, f_office_addr,
                    //  father_email, mother_occup, mother_desig, mother_phone, mother_mobile, mother_email, m_office_addr,
                    //  guardian_occup, guardian_desig, guardian_phone, guardian_mobile, guardian_email, g_office_addr, 
                    // annual_income, pu_regno, pupin_no, gap_year, org_migrate, migrated, migrate_detail, disqualified, 
                    // disqualify_detail, sports, cultural, academic, f_nationality, foreign_national, passportno, visa, 
                    // res_permit, card_print, card_no, removed, created_by, updated_by, created_at, updated_at                

                    //  reg_type, category, fee, board, prev_session, 
                    // prev_rollno, addon,
                    $student = new PrvStudent();
                    $student->roll_no = $pupin->rollno;
                    $student->adm_date = $pupin->enroll_date;
                    $student->dob = $pupin->dob;
                    $student->father_name = $pupin->father;
                    $student->name = $pupin->name;
                    $student->mother_name = $pupin->mother;
                    $student->gender = $pupin->gender;
                    $student->per_address = $pupin->paddress;
                    $student->mobile = $pupin->contact;
                    $student->course_id = $course->id;
                    $student->std_type_id = 2;
                    $student->save();
                    if($subid1 != 0)
                        $std_sub = StudentSubs::firstOrCreate(['student_id' => $student->id,'subject_id' => $subid1],['student_id' => $student->id,'subject_id' => $subid1]);
                    if($subid2 != 0)
                        $std_sub = StudentSubs::firstOrCreate(['student_id' => $student->id,'subject_id' => $subid2],['student_id' => $student->id,'subject_id' => $subid2]);
                    if($subid3 != 0)
                        $std_sub = StudentSubs::firstOrCreate(['student_id' => $student->id,'subject_id' => $subid3],['student_id' => $student->id,'subject_id' => $subid3]);
                    if($subid4 != 0)
                        $std_sub = StudentSubs::firstOrCreate(['student_id' => $student->id,'subject_id' => $subid4],['student_id' => $student->id,'subject_id' => $subid4]);
                    if($subid5 != 0)
                        $std_sub = StudentSubs::firstOrCreate(['student_id' => $student->id,'subject_id' => $subid5],['student_id' => $student->id,'subject_id' => $subid5]);
                    if($subid6 != 0)
                        $std_sub = StudentSubs::firstOrCreate(['student_id' => $student->id,'subject_id' => $subid6],['student_id' => $student->id,'subject_id' => $subid6]);
                    if($subid7 != 0)
                        $std_sub = StudentSubs::firstOrCreate(['student_id' => $student->id,'subject_id' => $subid7],['student_id' => $student->id,'subject_id' => $subid7]);
                    if($subid8 != 0)
                        $std_sub = StudentSubs::firstOrCreate(['student_id' => $student->id,'subject_id' => $subid8],['student_id' => $student->id,'subject_id' => $subid8]);
                    if($subid9 != 0)
                        $std_sub = StudentSubs::firstOrCreate(['student_id' => $student->id,'subject_id' => $subid9],['student_id' => $student->id,'subject_id' => $subid9]);
                    if($subid10 != 0)
                        $std_sub = StudentSubs::firstOrCreate(['student_id' => $student->id,'subject_id' => $subid10],['student_id' => $student->id,'subject_id' => $subid10]);
                    if($subid11 != 0)
                        $std_sub = StudentSubs::firstOrCreate(['student_id' => $student->id,'subject_id' => $subid11],['student_id' => $student->id,'subject_id' => $subid11]);
                }

            }
        });
    }
}
