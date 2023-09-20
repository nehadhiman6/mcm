<?php

/*
  |--------------------------------------------------------------------------
  | Web Routes
  |--------------------------------------------------------------------------
  |
  | This file is where you may define all of the routes that are handled
  | by your application. Just tell Laravel the URIs it should respond
  | to using a Closure or controller method. Build something great!
  |
 */

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

// if (env('APP_ENV', 'production') == 'local') {
//     Event::listen('Illuminate\Database\Events\QueryExecuted', function ($event) {
//         \Log::info($event->sql);
//         \Log::info($event->bindings);
//         \Log::info($event->time);
//     });
// }



Route::get('/', ['middleware' => 'auth', function () {
    view()->share('signedIn', auth()->check());
    view()->share('user', auth()->user());
    return view('app');
}]);
//Student Registration And Login Routes
//Route::get('admforms/{formno}/profile','OnlineRegController@getProfile');
//Route::get('admforms', 'OnlineRegController@admForm');
Route::get('stulogin', 'Online\StdLoginController@showLoginForm')->name('student.login');
Route::post('stulogin', 'Online\StdLoginController@login');
Route::get('term-conditions', function () {
    return view('term_conditions');
});
Route::get('student-timetable-attachment/{course_id}', 'Online\TimeTableController@showTimetableAttachment');
Route::resource('student-timetable', 'Online\TimeTableController');

Route::get('alumniregister', 'Alumni\AlumniLoginController@getRegisterAlumniUser');
Route::get('alumni/activation/link', 'Alumni\AlumniRegisterController@resendActLink');
Route::post('alumni/activation/link', 'Alumni\AlumniRegisterController@postResendActLink');
Route::get('alumni/activate/{token}', 'Alumni\AlumniRegisterController@verify')->name('alumni.account.activate');
Route::post('alumniregister', 'Alumni\AlumniRegisterController@registerAlumniUser');
Route::post('alumni/logout', 'Alumni\AlumniLoginController@logout')->name('alumni.logout');
Route::post('alumnilogin', 'Alumni\AlumniLoginController@login');
Route::get('alumnilogin', 'Alumni\AlumniLoginController@index');
Route::get('alumnies/status/{status}/{id}', 'Alumni\AlumniMeetController@changeEventStatus');
Route::post('alumnies/event', 'Alumni\AlumniMeetController@attendingMeetListFiltered');
Route::get('alumnies/event', 'Alumni\AlumniMeetController@attendingMeetList');
Route::get('alumnies/meet', 'Alumni\AlumniMeetController@addEvent');
Route::resource('alumnies', 'Alumni\AlumniMeetController');

Route::post('alumni/password/email', 'Alumni\AlmForgotPasswordController@sendResetLinkEmail');
Route::get('alumni/password/reset', 'Alumni\AlmForgotPasswordController@showLinkRequestForm');
Route::post('alumni/password/reset', 'Alumni\AlmResetPasswordController@reset');
Route::get('alumni/password/reset/{token}', 'Alumni\AlmResetPasswordController@showResetForm')->name('alumni.password.reset');

Route::post('join-meet', 'Alumni\AlumaniStuFormController@meetJoinSave');
Route::get('going-alumnies-meet', 'Alumni\AlumaniStuFormController@goingAlumnieMeet');
Route::get('alumni-student/{id}/show-donation', 'Alumni\AlumaniStuFormController@showDonation');
Route::get('alumni-student/{id}/details', 'Alumni\AlumaniStuFormController@details');
Route::resource('alumni-student', 'Alumni\AlumaniStuFormController');

Route::get('payments/alumni-fee-status', 'Payments\AlumniMeetFeeController@feeStatus');
Route::resource('payments/alumni-meet-fee', 'Payments\AlumniMeetFeeController');
Route::resource('payments/alumni-member-fee', 'Payments\AlumniLifeMemberFeeController');

Route::post('send-sms-alumni/course', 'Alumni\SendSmsAlumniController@sendCourseSms');
Route::get('send-sms-alumni/course-list', 'Alumni\SendSmsAlumniController@getCoursesList');
Route::resource('send-sms-alumni', 'Alumni\SendSmsAlumniController');
Route::resource('send-regsms-alumni', 'Alumni\SendRegSmsAlumniController');
Route::resource('export_to_alumni', 'Alumni\ExportToAlumniController');
Route::resource('feedback-sections', 'Maintenance\FeedbackSectionController');
Route::resource('feedback-questions', 'Maintenance\FeedbackQuestionController');

//tab-student-form
Route::resource('nehas-adm-form', 'Online\NewStdAdmFormController');
Route::resource('student-adm-details', 'StudentAdmissionForm\StudentDetailController');
Route::resource('parent-adm-details', 'StudentAdmissionForm\ParentDetailController');
Route::resource('subject-option', 'StudentAdmissionForm\SubjectOptionController');
Route::resource('acedmic-details', 'StudentAdmissionForm\AcedmicDetailController');
Route::resource('for-mig-alumni-details', 'StudentAdmissionForm\ForeignMigrationAlumniController');
Route::resource('adm-declaration', 'StudentAdmissionForm\DeclarationController');


Route::get('new-adm-form/{student_id}/student-feedback', 'Online\StudentFeedbackController@index');

Route::get('new-adm-form/{id}/attachments', 'Online\NewStdAdmFormController@showAttachment');
Route::get('new-adm-form/{roll_no}/studentinfo', 'Online\NewStdAdmFormController@getStudentDetails');
Route::get('new-adm-form/{stu}/preview', 'Online\NewStdAdmFormController@show');
Route::get('new-adm-form/previewhostel/{admission_form}/', 'Online\NewStdAdmFormController@showHostel');
Route::get('new-adm-form/leave-application/{leave}/', 'Online\NewStdAdmFormController@leaveApplication');
Route::get('new-adm-form/no-dues-slip/{slip}/', 'Online\NewStdAdmFormController@noDuesSlip');
Route::get('new-adm-form/{stu}/details', 'Online\NewStdAdmFormController@details');
Route::patch('new-adm-form/{admission_form}', 'Online\NewStdAdmFormController@update');
Route::resource('new-adm-form', 'Online\NewStdAdmFormController');




Route::resource('student-consent', 'Online\StudentConsentController');
Route::resource('admforms', 'Online\StdAdmFormController');
Route::post('student/logout', 'Online\StdLoginController@logout')->name('student.logout');
Route::post('buyprospectus/courses', 'Online\OnlineRegController@getCourses');
Route::get('buyprospectus', 'Online\OnlineRegController@showRegistrationForm');
Route::post('buyprospectus', 'Online\OnlineRegController@register');
Route::get('student/activation/link', 'Online\OnlineRegController@resendActLink');
Route::post('student/activation/link', 'Online\OnlineRegController@postResendActLink');
Route::get('student/activate/{token}', 'Online\OnlineRegController@verify')->name('students.account.activate');

Route::get('admforms/{roll_no}/studentinfo', 'Online\StdAdmFormController@getStudentDetails');
Route::get('admforms/{stu}/preview', 'Online\StdAdmFormController@show');
Route::get('admforms/previewhostel/{admission_form}/', 'Online\StdAdmFormController@showHostel');
Route::get('admforms/leave-application/{leave}/', 'Online\StdAdmFormController@leaveApplication');
Route::get('admforms/no-dues-slip/{slip}/', 'Online\StdAdmFormController@noDuesSlip');
Route::get('admforms/{stu}/details', 'Online\StdAdmFormController@details');
Route::patch('admforms/{admission_form}', 'Online\StdAdmFormController@update');
Route::get('admforms/{student_id}/student-feedback', 'Online\StudentFeedbackController@index');

Route::resource('student-feedback', 'Online\StudentFeedbackController');
Route::resource('date-sheets', 'Examination\DateSheetController');
Route::post('exam-locations/center-wise', 'Examination\ExamLocationController@getCenterLocations');
Route::resource('exam-locations', 'Examination\ExamLocationController');
Route::post('seating-plan-location/print', 'Examination\SeatingPlanLocationController@printSeatingPlan');
Route::get('seating-plan/exams', 'Examination\SeatingPlanController@create');
Route::resource('seating-plan-location', 'Examination\SeatingPlanLocationController');
Route::post('seating-plan/location-seats', 'Examination\SeatingPlanController@getLocationSeats');
Route::post('seating-plan/subject-section', 'Examination\SeatingPlanController@subjectSectionStrength');
Route::get('seating-plan-list', 'Examination\SeatingPlanController@seatingPlanList');
Route::post('seating-plan-list', 'Examination\SeatingPlanController@getSeatingPlan');
Route::resource('seating-plan', 'Examination\SeatingPlanController');
Route::resource('uni-rollno', 'Examination\UniversityRollNoController');
Route::get('exam-master-list', 'Examination\MasterExamController@puExamList');
Route::resource('exam-master', 'Examination\MasterExamController');
Route::post('pu-exam-std-entry', 'Examination\PuMarksEntryController@savePuExamStudent');
Route::resource('pu-marks-entry', 'Examination\PuMarksEntryController');
Route::get('pu-exam-report', 'Examination\PuExamReportController@index');

Route::get('hostel-form/{id}', 'Online\HostelApplicationController@index');
Route::resource('hostel-form', 'Online\HostelApplicationController');

Route::patch('final-submissions/{admform}/confirm', 'Online\FinalSubmissionController@confirmSubmission');
Route::resource('final-submissions', 'Online\FinalSubmissionController');
//Student Attachment Route
Route::get('admforms/{adm_id}/addattachments', 'Online\AttachmentController@addAttachments');
Route::get('stdattachment/{adm_id}', 'Online\AttachmentController@index');
Route::get('stdattachment/{adm_id}/{file_type}', 'Online\AttachmentController@show')->name('students.get.image');
Route::patch('stdattachment/{attachment}/{admission_id}', 'Online\AttachmentController@store');
Route::resource('stdattachment', 'Online\AttachmentController');

Route::post('student/password/email', 'Online\StdForgotPasswordController@sendResetLinkEmail');
Route::get('student/password/reset', 'Online\StdForgotPasswordController@showLinkRequestForm');
Route::post('student/password/reset', 'Online\StdResetPasswordController@reset');
Route::get('student/password/reset/{token}', 'Online\StdResetPasswordController@showResetForm')->name('students.password.reset');

Route::resource('payments/prospectus', 'Payments\ProspectusFeeController');
Route::resource('payments/pros-hostel', 'Payments\ProspectusFeeHostelController');

Route::get('admfees/{fee}/printreceipt', 'Payments\PayAdmissionFeeController@printReceipt');
Route::resource('payadmfees', 'Payments\PayAdmissionFeeController');

Route::resource('stdpayments', 'Payments\StdPaymentController');
Route::get('stdreceipts/{fee}/printreceipt', 'Payments\StdPaymentController@printReceipt');

Route::resource('penddues', 'Payments\PaymentController');
Route::resource('hosteldues', 'Payments\HostelPaymentController');
Route::resource('otherdues', 'Payments\OtherPaymentController');


//Masters Routes
Route::get('/subjects/list', function () {
    $json = json_encode(\App\Subject::orderBy('subject')->get(['id', 'subject', 'uni_code']));
    //  dd($json);
    return $json;
});

Route::get('hostels-locations', 'LocationController@getHostelLocation');
Route::resource('locations', 'LocationController');
Route::resource('states', 'StateController');
Route::resource('cities', 'CityController');
Route::resource('categories', 'CategoryController');
Route::resource('resvcategories', 'ResvCategoryController');
Route::resource('boards', 'BoardController');
Route::resource('subjects', 'SubjectController');
Route::resource('designation', 'DesignationController');
Route::resource('department', 'DepartmentController');
Route::resource('faculty', 'FacultyController');
Route::get('staff-details/', 'StaffController@edit');
Route::post('staff/rejoin', 'StaffController@saveStaffRejoin');
Route::get('staff/{staff_id}/rejoin', 'StaffController@staffRejoin');
Route::post('staff/left', 'StaffController@saveStaffLeft');
Route::get('staff/{staff_id}/left', 'StaffController@staffLeft');
Route::resource('staff', 'StaffController');
Route::resource('staff-qual', 'StaffQualificationController');
Route::resource('staff-experience', 'StaffExperienceController');
Route::resource('staff-research', 'ResearchController');
Route::resource('staff-courses', 'StaffCourseController');
Route::resource('staff-promotion', 'StaffPromotionController');
Route::get('stdsublist', 'SectionAllotController@subStdStrength');
Route::resource('secallot', 'SectionAllotController');
Route::resource('section', 'SectionController');
Route::post('messages/course', 'MessageController@sendCourseSms');
Route::get('messages/course-list', 'MessageController@getCoursesList');
Route::resource('messages', 'MessageController');
Route::resource('secallocations', 'TeacherSectionController');

Route::post('staffmsg/type', 'StaffMessageController@sendTypeSms');
Route::resource('staffmsg', 'StaffMessageController');
Route::resource('attendance-report', 'Attendance\AttendanceReportController');
Route::resource('attendance', 'Attendance\AttendanceController');
Route::get('students/roll_no/{roll_no}/{course_id}', 'StudentController@getStudent');
// Route::get('student-marks', 'MarksController@getStudentMarks');
Route::post('student-marks/show', 'MarksDirectController@checkRecord');
Route::post('student-marks/paper-data', 'MarksDirectController@showPaper');
Route::post('student-marks/subject', 'MarksDirectController@show');
Route::post('student-marks/remove', 'MarksDirectController@removeMarksRecord');
// Route::post('student-marks', 'MarksController@saveStudentMarks');
Route::resource('student-marks', 'MarksDirectController');

Route::get('marks-report/classwise', 'MarksReportController@getClasswiseReport');
Route::get('marks-report/student', 'MarksReportController@getStudentReport');
Route::post('marks-report/classwise', 'MarksReportController@classwiseMarksReport');
Route::post('marks-report/student', 'MarksReportController@studentMarksReport');
Route::get('marks-report/subjectwise', 'MarksReportController@subjectwiseMarksReport');
Route::resource('marks-report', 'MarksReportController');

Route::resource('marks', 'MarksController');
// subject -sections
Route::post('allot-section/subject-section', 'AllotSectionController@showSubjectSection');
Route::resource('allot-section', 'AllotSectionController');
Route::post('subject-section/sub-subject', 'SubjectSectionController@saveSubSubjects');
Route::post('subject-section/section', 'SubjectSectionController@showSection');
Route::post('subject-section/show', 'SubjectSectionController@show');
Route::resource('subject-section', 'SubjectSectionController');

Route::post('daily-attendance/students-list', 'Attendance\DailyAttendanceController@getStudentsList');
Route::post('daily-attendance/subject-section', 'Attendance\DailyAttendanceController@showSubjectSection');
Route::resource('daily-attendance', 'Attendance\DailyAttendanceController');
// Courses
//Route::get('/courses/list', function() {
//  $classes = \App\Course::with(['subjects' => function($query) {
//                $query->select('id', 'subject_id', 'course_id');
//              }])
//          ->orderBy('course_name')->get(['id', 'course_name']);
//  $json = json_encode($classes->prepend(['course_name' => 'Select', 'id' => 0]));
//  return $json;
//});
Route::post('inst-attachment/{courses}', 'CourseController@saveInstructionCourseAttach');
Route::get('show-attachment/{courses}', 'CourseController@showAttachment');
Route::get('courses/{courses}/inst-attachment', 'CourseController@showInstructionCourseAttach');
Route::get('courses/{courses}/subjects', 'CourseController@subjects');
Route::get('courses/{courses}/addsubject', 'CourseController@addSubject');
Route::get('courses/{courses}/electives', 'ElectiveController@index');
Route::post('courses/{courses}/storesubject', 'CourseController@storesubject');
Route::get('courses/{courses}/editsubject', 'CourseController@editsubject');
Route::patch('courses/{courses}/{subjects}/updatesubject', 'CourseController@updatesubject');
Route::post('courses/subs', 'CourseController@getSubs');
Route::post('courses/subsforcharges', 'CourseController@getSubjectsForCharges');
Route::get('courses/{courses}/subgroup', 'CourseController@subGroup');
Route::post('courses/{courses}/addgroup', 'CourseController@addGroup');
Route::get('courses/{groups}/editgroup', 'CourseController@editGroup');
Route::patch('courses/{courses}/{groups}/updategroup', 'CourseController@updateGroup');
Route::get('courses/{courses}/subjects_list_course', 'CourseController@getSubjectsListAndCourseDet');
Route::get('courses/{courses}/subjects_list', 'CourseController@getSubjectsList');
Route::patch('courses/add-on/{add_course_id}/edit', 'CourseController@updateAddOn');
Route::get('courses/add-on/create', 'CourseController@createAddOnCourse');
Route::post('courses/add-on', 'CourseController@storeAddOnCourse');
Route::get('courses/add-on/{add_course_id}/edit', 'CourseController@editAddOnCourse');

Route::resource('courses', 'CourseController');
Route::get('electives/{elective_id}/editsubject', 'ElectiveController@editSubjects');
Route::patch('electives/{subject_id}/editsubject', 'ElectiveController@updatesubject');
Route::get('electives/{course_id}/{elective_id}/addsubjects', 'ElectiveController@addSubjects');
Route::get('electives/{elective_id}/removesubject', 'ElectiveController@removesubject');
Route::post('electives/{course_id}/storesubject', 'ElectiveController@storesubject');
Route::post('electives/{elective_id}/addgroup', 'ElectiveController@storeGroup');
Route::get('electives/{elective_group_id}/editgroup', 'ElectiveController@showGroup');
Route::patch('electives/{elective_group_id}/editgroup', 'ElectiveController@updateGroup');
Route::post('electives/{course_id}', 'ElectiveController@store');
Route::get('electives/{course_id}/{elective_id}/addgroup', 'ElectiveController@addGroup');
Route::resource('electives', 'ElectiveController');


//Fees Master And Feestructure

Route::get('feeheads/{feehead}/subheads', 'Fees\SubHeadController@index');
Route::patch('subheads/{subhead}/updtfeehead', 'Fees\SubHeadController@updtFeehead');
Route::post('feeheads/{feehead}/addsubhead', 'Fees\SubHeadController@store');
Route::get('subheads/{subhead}/delete', 'Fees\SubHeadController@deleteSubhead');
Route::resource('subheads', 'Fees\SubHeadController');

Route::resource('feeheads', 'Fees\FeeHeadController');
Route::resource('concessions', 'Fees\ConcessionController');
Route::resource('installments', 'Fees\InstallmentController');
Route::resource('inst-debit', 'Fees\InstDebitController');
Route::get('college-pending/{courseid}', 'Fees\MiscDebitController@collegePending');
Route::resource('misc-debit', 'Fees\MiscDebitController');

Route::get('hostel-pending/{courseid}', 'Fees\MiscDebitHostelController@pending');
Route::resource('misc-debit-hostel', 'Fees\MiscDebitHostelController');
Route::get('outsider-pending/pending', 'Fees\MiscDebitOutsiderController@pending');
Route::resource('misc-debit-outsider', 'Fees\MiscDebitOutsiderController');

//Route::get('feestructure/{stdtype}/{inst}/{feehead}','Fees\FeeStructureController@showForm');
Route::get('feestructure/feeheads', 'Fees\FeeStructureController@feeHeadWise');
Route::get('feestructure/subheads', 'Fees\FeeStructureController@subHeadWise');
Route::get('feestructure/copy', 'Fees\FeeStructureController@showCopyForm');
Route::post('feestructure/copy', 'Fees\FeeStructureController@makeCopy');
Route::resource('feestructure', 'Fees\FeeStructureController');
Route::resource('subcharges', 'Fees\SubjectChargesController');
Route::resource('stdsubcharges', 'Fees\StdSubChargesController');

// Admissions Form
Route::get('admission-form/scrutinized-hostel/{id}/{type}', 'AdmissionFormController@getScrutinizedHostel');
Route::post('admission-form/scrutinized', 'AdmissionFormController@openScrutinizedForm');
Route::get('admission-form/{stu}/scrutinized', 'AdmissionFormController@getOpenScrutinized');
Route::post('admission-form/attachment-submission', 'AdmissionFormController@openAttachmentAddmissionForm');
Route::get('admission-form/{stu}/attachment-submission', 'AdmissionFormController@getOpenAttchmentSubmission');
Route::post('admission-form/open-submission', 'AdmissionFormController@openStudentAddmissionForm');
Route::get('admission-form/{stu}/open-submission', 'AdmissionFormController@getOpenSubmission');
Route::get('admission-form/payments', 'AdmissionFormController@paymentReport');
Route::get('admission-form/{stu}/preview', 'AdmissionFormController@show');
Route::get('admission-form/{stu}/details', 'AdmissionFormController@details');
Route::get('admission-form/{stu}/printdetail', 'AdmissionFormController@printDetail');
Route::get('admission-form/{stu}/hostel', 'AdmissionFormController@showHostel');
Route::get('admission-all-attachment-show/{stu}', 'AdmissionFormController@getAllAttachment');

Route::resource('admission-form', 'AdmissionFormController');
Route::resource('adm-subject-combination', 'AdmissionSubjectCombinationController');

Route::resource('adm-subject-options', 'AddmissionFormSubjectOptionController');

Route::get('std-adm-entry/printslip', 'Online\StdAdmFormController@printSlip');

Route::get('adm-entries/{stduser}/editemail', 'Admissions\AdmEntryController@editEmail');
Route::patch('adm-entries/{stduser}/updtemail', 'Admissions\AdmEntryController@updateEmail');
Route::get('adm-entries/{adm}/printslip', 'Admissions\AdmEntryController@printSlip');
Route::get('adm-entries/chkmanual', 'Admissions\AdmEntryController@checkManualFormno');

Route::resource('adm-entries', 'Admissions\AdmEntryController');
Route::resource('consents', 'Admissions\ConsentController');
// Route::get('discrepancy/{id}/dis', 'Admissions\DiscrepancyController@indexData');
Route::resource('discrepancy', 'Admissions\DiscrepancyController');

Route::resource('admissions', 'Admissions\AdmissionController');

Route::get('hostels/outsiders/ledger', 'Admissions\HostelOutsiderController@ledger');
Route::resource('hostels/outsiders', 'Admissions\HostelOutsiderController');
Route::resource('hostels', 'Admissions\HostelController');

Route::get('hostel/{roll_no}/student', 'Hostel\HostelAttendenceController@getStudentDetails');
Route::post('hostel-attendance/show', 'Hostel\HostelAttendenceController@getHostelAttendence');
Route::post('hostel-attendance/block-location', 'Hostel\HostelAttendenceController@getLocations');
Route::resource('hostel-attendance', 'Hostel\HostelAttendenceController');
Route::post('hostels-allocation/change', 'Hostel\HostelAllocationController@changeHostelAllocation');
Route::get('hostels-allocation/students', 'Hostel\HostelAllocationController@getHostelAllocated');
// Route::post('hostel-allocation/block-location','Hostel\HostelAllocationController@getLocations');
Route::resource('hostels-allocation', 'Hostel\HostelAllocationController');

//Bill & Receipts
Route::get('receipts/{receipt}/printreceipt', 'ReceiptController@printReceipt');
Route::post('receipts/pending/details', 'ReceiptController@getPendDetails');
Route::resource('receipts-college', 'Receipts\CollegeReceiptController');
Route::resource('receipts-hostel', 'Receipts\HostelReceiptController');
Route::resource('receipts-outsider', 'Receipts\HostelOutsiderReceiptController');
Route::resource('fee-insts', 'Receipts\FeeInstController');
Route::resource('host-fee-insts', 'Receipts\HostelFeeInstController');
Route::resource('cent-fee-insts', 'Receipts\CentFeeInstController');
Route::resource('misc-insts', 'Receipts\MiscInstController');
Route::resource('receipts', 'ReceiptController');
Route::get('students/{student}/printbill', 'BillController@printBill');
Route::resource('bills', 'BillController');

//Bill Cancellation
Route::patch('/bill/cancel', 'BillCancellationController@destroy');
Route::get('bill/cancel/detail', 'BillCancellationController@getCancelDetail');
Route::resource('/bill/cancel', 'BillCancellationController');

Route::get('idcard/generate', 'Reports\IDCardController@generateCardNo');

//Reports
Route::get('adm-subjects', 'Reports\AdmissionSubjectController@index');
Route::get('sub-admstrength', 'Reports\AdmStrengthController@subStdStrength');
Route::get('subwise-admdetails', 'Reports\AdmStrengthController@subwiseStdDetails');
Route::get('std-subjects', 'Reports\StudentSubjectController@index');
Route::get('stdwise-feedetails', 'Reports\FeeReportsController@stdFeeDetails');
Route::resource('feecollections', 'Reports\FeeReportsController');
Route::resource('feestr-report', 'Reports\FeeStrReportController');
Route::get('stdstrength', 'Reports\StdStrengthController@stdStrength');
Route::get('sub-stdstrength', 'Reports\StdStrengthController@subStdStrength');
Route::get('subwise-stddetails', 'Reports\StdStrengthController@subwiseStdDetails');
Route::get('funds/shdetails', 'Reports\FundWiseRepController@shdetails');
Route::get('funds/details', 'Reports\FundWiseRepController@details');
Route::get('fundwise-collection', 'Reports\FundWiseRepController@index');
Route::get('prospectus-fees', 'Reports\ProspectusFeesRepController@index');
Route::get('admregister', 'Reports\AdmissionRegisterController@index');
Route::get('pendbalance', 'Reports\PendingBalanceController@index');
Route::get('fundbalance', 'Reports\PendingBalanceController@fundWise');
Route::get('feeheadbalance', 'Reports\PendingBalanceController@feeheadWise');
Route::get('subheadbalance', 'Reports\PendingBalanceController@subheadWise');
Route::get('idcard-report', 'Reports\IDCardController@index');
Route::get('concess-report', 'Reports\ConcessionRepController@index');
Route::get('daybook', 'Reports\DayBookController@index');
Route::get('daybook2', 'Reports\DayBookController@daybook2');
Route::get('dbsummary', 'Reports\DayBookController@daybookSummary');
Route::get('feeheadwise-coll', 'Reports\CollectionRegisterController@feeheadCollection');
Route::get('subheadwise-coll', 'Reports\CollectionRegisterController@subheadCollection');
Route::get('student-wise-feedback-suggestion', 'Reports\StudentFeedbackReportController@getStudentsWithFeedbackSuggestion');
Route::get('student-wise-feedback', 'Reports\StudentFeedbackReportController@getStudentsWithFeedback');
Route::get('student-feedback-overall', 'Reports\StudentFeedbackReportController@getOverallData');
Route::resource('student-feedback-report', 'Reports\StudentFeedbackReportController');
Route::get('hostel-strength', 'Reports\HostelStrengthController@index');

//Students Report
Route::get('centralized/students', 'Reports\CentralizedStudentController@index');
Route::get('stdledger', 'StudentController@stdLedger');
Route::get('students/{student}/editrollno', 'StudentController@editRollno');
Route::patch('students/{student}/updaterollno', 'StudentController@updateRollNo');
Route::get('students/{student}/edithon', 'StudentController@editHonour');
Route::patch('students/{student}/updatehon', 'StudentController@updateHonour');
Route::resource('students', 'StudentController');
Route::get('consolidated-student-list', 'Reports\Student\ConsolidatedStudentController@index');
Route::get('student-category-wise-report', 'Reports\Student\StudentCategoryWiseController@index');
Route::post('students-timetable/update-timetable', 'StudentTimeTableController@updateStudentTimeTable');
Route::post('students-timetable/timetable', 'StudentTimeTableController@getStudentTimeTable');
Route::post('students-timetable/import', 'StudentTimeTableController@importExcelSheet');
Route::resource('students-timetable', 'StudentTimeTableController');

Route::resource('rmvstudents', 'RemoveStudentController');

Route::resource('students.course', 'StudentCourseController');
Route::resource('students.subjects', 'StudentSubjectController');

//Document Attachement Routes
Route::get('attachment/{adm_id}/{file_type}', 'AttachmentController@show')->name('office.get.image');
Route::get('attachment/{adm_id}', 'AttachmentController@index');
Route::patch('attachment/{attachment}/{admission_id}', 'AttachmentController@store');
Route::resource('attachment', 'AttachmentController');
Route::post('user-upload', 'UserController@addUserupload');
Route::get('user-upload', 'UserController@getupload');
Route::get('user-image/{id}', 'UserController@showUserImage');

//Authentication routes
Auth::routes();
Route::get('groups/{grp_id}/permissions', 'GroupController@permissions');
Route::post('groups/{grp_id}/addpermissions', 'GroupController@addPermissions');
Route::post('groups/{grp_id}/rmvpermissions', 'GroupController@removePermissions');
Route::resource('groups', 'GroupController');

Route::resource('permissions', 'PermissionController');

Route::get('roles/{role_id}/permissions', 'RoleController@showPermissions');
Route::post('roles/{role_id}/permissions', 'RoleController@savePermissions');
Route::resource('roles', 'RoleController');

Route::get('users/updtpassword', 'UserController@chngPassword');
Route::patch('users/updtpassword', 'UserController@updatePassword');
Route::resource('users', 'UserController');
//Route::get('logout', 'Auth\LoginController@logout');
//Route::get('/home', 'HomeController@index');

Route::resource('checktrans', 'CheckTransactionController');
Route::resource('trans', 'Payments\TransController');
Route::resource('paytmtrans', 'Payments\PaytmTransController');
Route::resource('atomtrans', 'Payments\AtomTransController');
Route::resource('sbipaytrans', 'Payments\SbiPayTransController');
Route::post('sbipaypushres', 'Payments\SbiPayTransController@pushres');

Route::get('long-term-asset', 'Inventory\LongTermAssetController@index');

//donation
// Route::resource('donations', 'DonationController');

Route::get('donations/create', function () {
    return view('donation.create');
});


//inventory
Route::post('get-item', 'Inventory\ItemController@getItem');
Route::resource('items', 'Inventory\ItemController');
Route::resource('items_categories', 'Inventory\ItemCategoryController');
Route::resource('items_sub_categories', 'Inventory\ItemSubCategoryController');
Route::post('get-vendor', 'Inventory\VendorController@getVendor');
Route::resource('vendors', 'Inventory\VendorController');
// Route::post('get-stores', 'Inventory\PurchaseController@getstore');
Route::resource('purchases', 'Inventory\PurchaseController');
Route::resource('issues', 'Inventory\IssueController');
Route::resource('purchase-returns', 'Inventory\PurchaseReturnController');
Route::resource('returns', 'Inventory\ReturnController');
Route::resource('damages', 'Inventory\DamagesController');
Route::get('stock/details', 'Inventory\StockController@show');
Route::resource('stock-register', 'Inventory\StockController');
Route::resource('opening-stocks', 'Inventory\OpeningStockController');

// Toolbars for Permissions
Route::get('staff-toolbar', function () {
    return view('blank.staff-toolbar');
});
Route::get('maintanence', function () {
    return view('blank.maintanence');
});
Route::get('admission-formm', function () {
    return view('blank.admission-form');
});
Route::get('admission-entries', function () {
    return view('blank.admission-entries');
});
Route::get('admissions', function () {
    return view('blank.admissions');
});
Route::get('hostel-toolbar', function () {
    return view('blank.hostel-toolbar');
});
Route::get('students-toolbar', function () {
    return view('blank.students-toolbar');
});
Route::get('maintanence-toolbar', function () {
    return view('blank.maintanence-toolbar');
});
Route::get('col-balance-toolbar', function () {
    return view('blank.col-balance-toolbar');
});
Route::get('bill-cancellation', function () {
    return view('blank.bill-cancellation');
});
Route::get('receipt-toolbar', function () {
    return view('blank.receipt-toolbar');
});
Route::get('misc-toolbar', function () {
    return view('blank.misc-toolbar');
});
Route::get('academic-toolbar', function () {
    return view('blank.academic-toolbar');
});
Route::get('alumnies-toolbar', function () {
    return view('blank.alumnies-toolbar');
});
Route::get('items-toolbar', function () {
    return view('blank.items-toolbar');
});
Route::get('vendors-toolbar', function () {
    return view('blank.vendors-toolbar');
});
Route::get('purchases-toolbar', function () {
    return view('blank.purchases-toolbar');
});
Route::get('issues-toolbar', function () {
    return view('blank.issues-toolbar');
});
Route::get('purchase-returns-toolbar', function () {
    return view('blank.purchase-returns-toolbar');
});
Route::get('returns-toolbar', function () {
    return view('blank.returns-toolbar');
});
Route::get('damages-toolbar', function () {
    return view('blank.damages-toolbar');
});
Route::get('opening-stocks-toolbar', function () {
    return view('blank.opening-stocks-toolbar');
});
Route::get('maintanence-toolbarr', function () {
    return view('blank.maintanence-toolbarr');
});
Route::get('messages-toolbar', function () {
    return view('blank.messages-toolbar');
});
Route::get('users-toolbar', function () {
    return view('blank.users-toolbar');
});
Route::get('daybook-report', function () {
    return view('blank.daybook-report');
});
Route::get('sms-report', function () {
    return view('blank.sms-report');
});
Route::get('examination-toolbar', function () {
    return view('blank.examination-toolbar');
});

Route::get('staff-report-toolbar', function () {
    return view('blank.staff-report-toolbar');
});

Route::get('placement-toolbar', function () {
    return view('blank.placement-toolbar');
});

Route::get('placement-report-toolbar', function () {
    return view('blank.placement-report-toolbar');
});



// Route::get('activities-toolbar', function () {
//     return view('blank.activities-toolbar');
// });

Route::resource('night-out', 'NightOut\NightOutController');
Route::post('night-out-return/show', 'NightOut\NightOutReturnController@show');
Route::resource('night-out-return', 'NightOut\NightOutReturnController');

Route::resource('nirf-report', 'NIRFReportController');
// student login
Route::resource('no-dues', 'Online\NoDuesController');
//above url disabled by verma as suman sir's call

Route::post('otp', 'Online\NoDuesController@sendOtp');
Route::get('email2/verify/{token}', 'Online\NoDuesController@verify')->name('students.email2.verify');


// Activities
Route::resource('agency-types', 'Activity\AgencyTypeController');
Route::resource('orgnization', 'Activity\OrgnizationController');
Route::get('activities/{org}/orgnization', 'Activity\ActivityController@getOrnization');
Route::resource('activities', 'Activity\ActivityController');


// Route::get('regional/{roll_no}', 'RegionalCentre\RegionalCentreController@getStudent');
Route::resource('regional-centres', 'RegionalCentre\RegionalCentreController');
// Route::resource('pre-registration', 'PreRegistrationController');
// Route::get('student-refund-requests-print/{id}', 'Online\StudentRefundRequestController@refundPrint');
Route::get('get-std-details', 'Online\StudentRefundRequestController@getStdDetail');
// Route::resource('student-refund-requests', 'Online\StudentRefundRequestController');

Route::resource('paper-dwnld', 'PuPaperController');

Route::get('item-staff-loc-stock', 'Inventory\ItemStaffLocWiseStockController@index');
Route::get('depart-list', 'Reports\Staff\ResearchReportController@getDepartment');
Route::get('research-report', 'Reports\Staff\ResearchReportController@index');
Route::get('course-attended-report', 'Reports\Staff\CourseAttendedReportController@index');
Route::get('qualification-report', 'Reports\Staff\QualificationReportController@index');
Route::get('promotion-due-report', 'Reports\Staff\PromotionDueReportController@index');

// Placement
Route::resource('placement-companies', 'Placement\CompanyController');
Route::get('upload-thumbnail/{id}', 'Placement\PlacementStudentController@getAttachmentShow');
Route::post('uploads/{place_stu_id}', 'Placement\PlacementStudentController@saveResources');
Route::get('get-student/{roll_no}/{session}', 'Placement\PlacementStudentController@getPlacementStudent');
Route::get('student-details/{id}/{btn_name}', 'Placement\PlacementStudentController@getPlacementStudentEdit');
Route::resource('student-details', 'Placement\PlacementStudentController');

Route::post('placement-resource-attachment', 'Placement\PlacementController@saveResources');
Route::get('show-thumbnail/{id}', 'Placement\PlacementController@getAttachmentShow');
Route::post('placement-attachment/{id}', 'Placement\PlacementController@attachment');
Route::get('placement-upload/{place_id}', 'Placement\PlacementController@getPlacementUpload');
Route::get('get-depatment/{staff}', 'Placement\PlacementController@getDepartment');
Route::resource('placements', 'Placement\PlacementController');

//placement Report
Route::resource('placement-std-wise-report', 'Reports\Placement\PlacementRecordStdWiseReportController');
Route::resource('placement-drive-wise-report', 'Reports\Placement\PlacementRecordDriveWiseReportController');

// Route::get('upload-thumbnail/{id}', 'Resource\UploadAttachmentController@getAttachmentThumbnail');
// Route::post('uploads/{place_stu_id}', 'Resource\UploadAttachmentController@store');
// Route::resource('uploads', 'Resource\UploadAttachmentController');

// Route::get('attachments-thumbnail/{id}', 'Resource\UploadAttachmentController@getAttachmentThumbnail');
// Route::resource('attachments', 'Resource\UploadAttachmentController');
Route::post('stu-crt-pass-reject', 'StudentCrtPassController@getStudentRejectSave');
Route::get('stu-crt-pass-reject/{id}', 'StudentCrtPassController@getStudentRejectShow');
Route::post('issue-date', 'StudentCrtPassController@getStudentIssueDateSave');
Route::get('issue-date/{id}', 'StudentCrtPassController@getStudentIssueDateShow');
Route::resource('stu-crt-passes', 'StudentCrtPassController');

Route::get('report-card-print/{id}/{course}/{exam}/{sem}', 'SendStudentResultController@getStudentCardPrint');
Route::resource('send-stu-result-email', 'SendStudentResultController');
Route::resource('send-email', 'SendMailStudentController');

Route::resource('app-setting', 'AppSettingController');
Route::get('subject-courses/{course_id}', 'SubjectCombinationController@getSubject');
Route::get('sub-combination', 'SubjectCombinationController@getStudentCombination');
Route::resource('subject-combination', 'SubjectCombinationController');


// Route::resource('refund-requests-details', 'StudentRefund\StudentRefundDetailController');


