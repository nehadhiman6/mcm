<?php

namespace App\Http\Controllers\Reports;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Online\StudentFeedback;
use App\Models\Maintenance\FeedbackSection;
use App\Models\Maintenance\FeedbackQuestion;
use App\Student;
use Illuminate\Support\Facades\Gate;

class StudentFeedbackReportController extends Controller
{
    public function index()
    {
        if (Gate::denies('student-feedback-report')) {
            return deny();
        }
        return view('reports.student_feedback_report');
    }

    public function getOverallData()
    {
        ini_set('memory_limit', '512M');

        $overall_stu_feed = FeedbackQuestion::orderBy('section_id')->with('student_feedback', 'feedback_section')->get();

        return reply(
            'OK',
            [
                'overall_stu_feed' => $overall_stu_feed,
            ]
        );
    }

    public function getStudentsWithFeedback()
    {
        ini_set('memory_limit', '512M');

        $students =  Student::whereIn('id', function ($q) {
            $q->from(getYearlyDb() . '.student_feedback')
                ->select('std_id');
        })
        ->with(['feedback:id,question_id,std_id,rating'])
            ->get(['id', 'roll_no','name']);
        $questions = FeedbackQuestion::orderBy('section_id')->with('feedback_section:id,name')
            ->get(['id', 'question', 'section_id']);
            
        return reply(
            'OK',
            [
                'students' => $students,
                'questions' => $questions,
            ]
        );
    }

    public function getStudentsWithFeedbackSuggestion(){
        ini_set('memory_limit', '512M');
        $students =  Student::join('student_feedback_suggestion','students.id','=','student_feedback_suggestion.std_id')
        ->join('courses', 'students.course_id', '=', 'courses.id')       
        ->select([
            'courses.course_name','students.roll_no','students.name','student_feedback_suggestion.suggestion',
        ])->get();

        return reply(
            'OK',
            [
                'students' => $students,
            ]
        );
    }
}
