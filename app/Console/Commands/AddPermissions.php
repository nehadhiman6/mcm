<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Permission;

class AddPermissions extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'permissions:check';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Checks and adds permissions in the database.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->addPermission(['name' => 'ALLOT-SECTION', 'label' => 'Allots section to students']);
        $this->addPermission(['name' => 'MANUAL-FORM-ADM', 'label' => 'Admition of Students who has purchased prospectus. ']);
        $this->addPermission(['name' => 'CHANGE-HONOUR', 'label' => 'Can change student honours subject. ']);
        $this->addPermission(['name' => 'inv-request', 'label' => 'Allow access for Request(Inventory). ']);
        $this->addPermission(['name' => 'inv-edit-request', 'label' => 'Allow access to edit Request(Inventory). ']);
        $this->addPermission(['name' => 'HOSTEL-INSTALLMENTS', 'label' => 'Allow access to debit hostel installments']);
        $this->addPermission(['name' => 'see-courses-subjects', 'label' => 'Allow see all courses and subjects in drop-down event if user is teacher. ']);
        $this->addPermission(['name' => 'edit-own-staff-details', 'label' => 'Allow staff to add/edit their details. ']);

        // ADMISSION FORMS
        $this->addPermission(['name' => 'ADMISSION-FORMS', 'label' => 'ADMISSION FORM LIST']);
        $this->addPermission(['name' => 'NEW-ADMISSION-FORMS', 'label' => 'NEW ADMISSION FORM']);
        $this->addPermission(['name' => 'EDIT-ADMISSION-FORMS', 'label' => 'EDIT ADMISSION FORM']);
        $this->addPermission(['name' => 'PREVIEW-ADMISSION-FORMS', 'label' => 'PREVIEW ADMISSION FORM']);
        $this->addPermission(['name' => 'SUBJECT-WISE-STRENGTH', 'label' => 'SUBJECT WISE STRENGTH LIST']);
        $this->addPermission(['name' => 'SUBJECT-WISE-STRENGTH-DETAIL', 'label' => 'SUBJECT WISE STRENGTH DETAIL']);
        $this->addPermission(['name' => 'online-transactions', 'label' => 'ONLINE TRANSACTIONS LIST']);
        $this->addPermission(['name' => 'payments-report', 'label' => 'PAYMENT REPORT']);

        // ADMISSION ENTRIES
        $this->addPermission(['name' => 'ADMISSION-ENTRY', 'label' => 'ADMISSION ENTRY LIST']);
        $this->addPermission(['name' => 'NEW-ADMISSION-ENTRY', 'label' => 'NEW ADMISSION ENTRY']);
        $this->addPermission(['name' => 'EDIT-ADMISSION-ENTRY', 'label' => 'EDIT ADMISSION ENTRY']);
        $this->addPermission(['name' => 'EMAIL-ADMISSION-ENTRY', 'label' => 'EMAIL ADMISSION ENTRY']);
        $this->addPermission(['name' => 'PRINT-SLIP-ADMISSION-ENTRY', 'label' => 'PRINT SLIP OF ADMISSION ENTRY']);

        // CONSENTS
        $this->addPermission(['name' => 'CONSENTS', 'label' => 'CONSENTS LIST']);
        $this->addPermission(['name' => 'NEW-CONSENT-ENTRY', 'label' => 'NEW CONSENT ENTRY']);
        $this->addPermission(['name' => 'EDIT-CONSENT-ENTRY', 'label' => 'EDIT CONSENT ENTRY']);

        $this->addPermission(['name' => 'discrepancy-entry', 'label' => 'Discrepancy Form']);


        // ADMISSIONS
        $this->addPermission(['name' => 'NEW-ADMISSION', 'label' => 'ADMISSION LIST (ADMISSIONS)']);
        $this->addPermission(['name' => 'ADMISSION-REGISTER', 'label' => 'ADMISSION REGISTER LIST']);
        $this->addPermission(['name' => 'CENTRALIZED-STUDENT', 'label' => 'CENTRALIZED STUDENT LIST']);

        // HOSTEL
        $this->addPermission(['name' => 'HOSTEL-STUDENTS-LIST', 'label' => 'HOSTEL STUDENTS LIST']);
        $this->addPermission(['name' => 'HOSTEL-ADMISSION', 'label' => 'HOSTEL']);
        $this->addPermission(['name' => 'HOSTEL-OUTSIDER-LIST', 'label' => 'HOSTEL OUTSIDER LIST']);
        $this->addPermission(['name' => 'HOSTEL-OUTSIDER-FORM', 'label' => 'HOSTEL OUTSIDER FORM']);
        $this->addPermission(['name' => 'HOSTEL-OUTSIDER-LEDGER', 'label' => 'HOSTEL OUTSIDER LEDGER']);

        // STUDENTS
        $this->addPermission(['name' => 'STUDENT-LIST', 'label' => 'STUDENTS LIST']);
        $this->addPermission(['name' => 'EDIT-STUDENT-LIST', 'label' => 'EDIT STUDENT LIST']);
        $this->addPermission(['name' => 'CHANGE-CRS-SUB', 'label' => 'CHANGE COURSE/SUBJECT IN STUDENT LIST']);
        $this->addPermission(['name' => 'CHANGE-ROLLNO', 'label' => 'CHANGE ROLL NUMBER IN STUDENT LIST']);
        $this->addPermission(['name' => 'STUDENT-LEDGER', 'label' => 'STUDENT LEDGER']);
        $this->addPermission(['name' => 'PRINT-STUDENT-LEDGER', 'label' => 'RECEIPT STUDENT LEDGER']);
        $this->addPermission(['name' => 'STUDENT-STRENGTH', 'label' => 'STUDENT STRENGTH LIST']);
        $this->addPermission(['name' => 'HOSTEL-STRENGTH', 'label' => 'STUDENT STRENGTH LIST']);
        $this->addPermission(['name' => 'STUDENT-SUBJECTS', 'label' => 'STUDENT SUBJECTS LIST']);
        $this->addPermission(['name' => 'STUDENT-SUBJECTS', 'label' => 'STUDENT SUBJECTS LIST']);
        $this->addPermission(['name' => 'SUBJECT-WISE-STRENGTH', 'label' => 'SUBJECT WISE STRENGTH LIST']);
        $this->addPermission(['name' => 'REMOVE-STUDENT', 'label' => 'REMOVE STUDENT']);
        $this->addPermission(['name' => 'REMOVED-STUDENTS-LIST', 'label' => 'REMOVE STUDENT LIST']);

        // FEE ADMINISTRATION -> MAINTANENCE
        $this->addPermission(['name' => 'FEE-STRUCTURE', 'label' => 'REMOVE STUDENT LIST']);
        $this->addPermission(['name' => 'SUBJECT-CHARGES', 'label' => 'SUBJECT CHARGES LIST']);
        $this->addPermission(['name' => 'ADD-SUBJECT-CHARGES', 'label' => 'ADD SUBJECT CHARGES LIST']);
        $this->addPermission(['name' => 'EDIT-SUBJECT-CHARGES', 'label' => 'EDIT SUBJECT CHARGES LIST']);
        $this->addPermission(['name' => 'INSTALLMENTS', 'label' => 'INSTALLMENTS LIST']);
        $this->addPermission(['name' => 'EDIT-INSTALLMENTS', 'label' => 'EDIT INSTALLMENTS LIST']);
        $this->addPermission(['name' => 'ADD-INSTALLMENTS', 'label' => 'ADD INSTALLMENTS LIST']);
        $this->addPermission(['name' => 'FEEHEADS', 'label' => 'FEEHEAD LIST']);
        $this->addPermission(['name' => 'EDIT-FEEHEADS', 'label' => 'EDIT FEEHEAD LIST']);
        $this->addPermission(['name' => 'ADD-FEEHEADS', 'label' => 'ADD FEEHEAD LIST']);
        $this->addPermission(['name' => 'SUBHEADS-FEEHEADS', 'label' => 'ADD SUBHEADS IN FEEHEAD LIST']);
        $this->addPermission(['name' => 'CONCESSIONS', 'label' => 'CONCESSIONS LIST']);
        $this->addPermission(['name' => 'EDIT-CONCESSION', 'label' => 'EDIT CONCESSIONS LIST']);
        $this->addPermission(['name' => 'ADD-CONCESSION', 'label' => 'ADD CONCESSIONS LIST']);
        $this->addPermission(['name' => 'SUBHEAD-FEE-STRUCTURE', 'label' => 'SUBHEAD FEE STRUCTURE LIST']);
        $this->addPermission(['name' => 'COPY-FEE-STRUCTURE', 'label' => 'COPY FEE STRUCTURE LIST']);

        // Collection/Balance Reports
        $this->addPermission(['name' => 'FEE-COLLECTION', 'label' => 'FEE COLLECTION LIST']);
        $this->addPermission(['name' => 'DETAIL-FEE-COLLECTION', 'label' => 'DETAIL FEE COLLECTION LIST']);
        $this->addPermission(['name' => 'FUND-WISE-COLLECTION', 'label' => 'FUND WISE COLLECTION LIST']);
        $this->addPermission(['name' => 'FEEHEAD-WISE-DETAIL-FUND-WISE-COLLECTION', 'label' => 'FEEHEAD WISE DETAIL IN FUND WISE COLLECTION LIST']);
        $this->addPermission(['name' => 'SUBHEAD-WISE-DETAIL-FUND-WISE-COLLECTION', 'label' => 'SUBHEAD WISE DETAIL IN FUND WISE COLLECTION LIST']);
        $this->addPermission(['name' => 'SW-FEE-DETAILS', 'label' => 'SW FEE DETAILS LIST']);
        $this->addPermission(['name' => 'PENDING-BALANCE', 'label' => 'PENDING BALANCE LIST']);
        $this->addPermission(['name' => 'FUND-WISE-BALANCE', 'label' => 'FUND WISE BALANCE LIST']);
        $this->addPermission(['name' => 'FEEHEAD-WISE-DETAIL-FUND-WISE-BALANCE', 'label' => 'FEEHEAD WISE DETAIL IN FUND WISE BALANCE LIST']);
        $this->addPermission(['name' => 'SUBHEAD-WISE-DETAIL-FUND-WISE-BALANCE', 'label' => 'SUBHEAD WISE DETAIL IN FUND WISE BALANCE LIST']);
        $this->addPermission(['name' => 'CONCESSION-REPORT', 'label' => 'CONCESSION REPORT']);

        // bills and receipts
        $this->addPermission(['name' => 'BILL-CANCELLATION', 'label' => 'BILL CANCELLATION REPORT']);
        $this->addPermission(['name' => 'ONLINE-TRANSACTION-STATUS', 'label' => 'ONLINE TRANSACTION STATUS REPORT']);
        $this->addPermission(['name' => 'FEE-INSTALLMENTS', 'label' => 'FEE INSTALLMENTS REPORT']);
        $this->addPermission(['name' => 'HOSTEL-FEE-INSTALLMENTS', 'label' => 'HOSTEL FEE INSTALLMENTS REPORT']);
        $this->addPermission(['name' => 'CENTERALIZED-FEE-INSTALLMENTS', 'label' => 'CENTERALIZED FEE INSTALLMENTS REPORT']);
        $this->addPermission(['name' => 'STUDENT-SUBJECT-CHARGES', 'label' => 'STUDENT SUBJECT CHARGES LIST']);
        $this->addPermission(['name' => 'ADD-SUBJECT-CHARGES', 'label' => 'ADD SUBJECT CHARGES']);

        // RECEIPTS
        $this->addPermission(['name' => 'COLLEGE-RECEIPT', 'label' => 'COLLEGE RECEIPT']);
        $this->addPermission(['name' => 'HOSTEL-RECEIPT', 'label' => 'HOSTEL RECEIPT']);
        $this->addPermission(['name' => 'OUTSIDER-HOSTEL-RECEIPT', 'label' => 'OUTSIDER HOSTEL RECEIPT']);
        $this->addPermission(['name' => 'MISCELLANEOUS-INSTALLMENTS', 'label' => 'MISCELLANEOUS INSTALLMENTS']);

        // MISC DEBIT
        $this->addPermission(['name' => 'MISCELLANEOUS-DEBIT', 'label' => 'MISCELLANEOUS DEBIT']);
        $this->addPermission(['name' => 'MISCELLANEOUS-DEBIT-HOSTEL', 'label' => 'MISCELLANEOUS DEBIT HOSTEL']);
        $this->addPermission(['name' => 'MISCELLANEOUS-DEBIT-OUTSIDER', 'label' => 'MISCELLANEOUS DEBIT OUTSIDER']);

        // Academics
        $this->addPermission(['name' => 'SECTIONS-LIST', 'label' => 'SECTIONS LIST']);
        $this->addPermission(['name' => 'EDIT-SECTIONS', 'label' => 'EDIT SECTIONS LIST']);
        $this->addPermission(['name' => 'ADD-SECTIONS', 'label' => 'ADD SECTIONS']);
        $this->addPermission(['name' => 'SECTION-DETAIL', 'label' => 'SECTION DETAIL LIST']);
        $this->addPermission(['name' => 'EDIT-SECTION-DETAIL', 'label' => 'EDIT SECTIONS DETAIL']);
        $this->addPermission(['name' => 'SECTION-ALLOTMENT', 'label' => 'ALLOT SECTION']);
        $this->addPermission(['name' => 'SUBJECT-WISE-STUDENT-STRENGTH', 'label' => 'SUBJECT WISE STRENGTH (ACADEMICS)']);
        $this->addPermission(['name' => 'SECTIONS-SWSS', 'label' => 'SECTIONS IN SUBJECT WISE STRENGTH (ACADEMICS)']);
        $this->addPermission(['name' => 'TEACHERS-SWSS', 'label' => 'TEACHERS IN SUBJECT WISE STRENGTH (ACADEMICS)']);
        $this->addPermission(['name' => 'ATTENDANCE', 'label' => 'ATTENDANCE LIST']);
        $this->addPermission(['name' => 'EDIT-ATTENDANCE', 'label' => 'EDIT ATTENDANCE']);
        $this->addPermission(['name' => 'DAILY-ATTENDANCE', 'label' => 'DAILY ATTENDANCE LIST']);
        $this->addPermission(['name' => 'ATTENDANCE-REPORT', 'label' => 'ATTENDANCE REPORT LIST']);
        $this->addPermission(['name' => 'STUDENT-MARKS', 'label' => 'STUDENT MARKS REPORT']);
        $this->addPermission(['name' => 'MARKS-REPORT-CLASS-WISE', 'label' => 'MARKS REPORT (CLASS)']);
        $this->addPermission(['name' => 'MARKS-REPORT-STUDENT-WISE', 'label' => 'MARKS REPORT (STUDENT)']);
        $this->addPermission(['name' => 'MARKS-REPORT-SUBJECT-WISE', 'label' => 'MARKS LIST']);
        $this->addPermission(['name' => 'add-time-table', 'label' => 'STUDENT TIMETABLE']);
        $this->addPermission(['name' => 'ALUMNI-LIST', 'label' => 'ALUMNI LIST (ALUMNI LIST)']);
        $this->addPermission(['name' => 'ALUMNI-EVENT-LIST', 'label' => 'ALUMNI MEET LIST (ALUMNI LIST)']);
        $this->addPermission(['name' => 'ADD-ALUMNI-EVENT', 'label' => 'ALUMNI MEET LIST(ALUMNI MEET)']);
        $this->addPermission(['name' => 'EDIT-ALUMNI-EVENT', 'label' => 'EDIT ALUMNI MEET (ALUMNI MEET)']);
        $this->addPermission(['name' => 'ACTIVE-ALUMNI-EVENT', 'label' => 'ACTIVE IN-ACTIVE ALUMNI MEET (ALUMNI MEET)']);
        $this->addPermission(['name' => 'alumni-sms-mail', 'label' => 'Allow access to send mail and sms to alumni students(Alumni).']);
        $this->addPermission(['name' => 'send-regsms-alumni', 'label' => 'Allow access to send registered mail and sms to alumni students(Alumni).']);

        // inventory
        $this->addPermission(['name' => 'inv-item', 'label' => 'Allow access for item List(Inventory).']);
        $this->addPermission(['name' => 'add-inv-item', 'label' => 'Allow access for add item(Inventory).']);
        $this->addPermission(['name' => 'inv-edit-item', 'label' => 'Allow access to edit item(Inventory).']);
        $this->addPermission(['name' => 'inv-item-category', 'label' => 'Allow access for item Category List(Inventory).']);
        $this->addPermission(['name' => 'add-inv-item-category', 'label' => 'Allow access for add item Category(Inventory).']);
        $this->addPermission(['name' => 'inv-edit-item-category', 'label' => 'Allow access to edit item Category(Inventory).']);
        $this->addPermission(['name' => 'inv-sub-item-category', 'label' => 'Allow access for item Sub Category List(Inventory).']);
        $this->addPermission(['name' => 'add-inv-sub-item-category', 'label' => 'Allow access for add item Sub Category(Inventory).']);
        $this->addPermission(['name' => 'inv-edit-sub-item-category', 'label' => 'Allow access to edit item Category(Inventory).']);
        $this->addPermission(['name' => 'inv-vendor', 'label' => 'Allow access for vendor(Inventory).']);
        $this->addPermission(['name' => 'add-inv-vendor', 'label' => 'Allow access for add vendor(Inventory).']);
        $this->addPermission(['name' => 'inv-edit-vendor', 'label' => 'Allow access to edit vendor(Inventory).']);
        $this->addPermission(['name' => 'inv-purchase', 'label' => 'Allow access for Purchase List(Inventory). ']);
        $this->addPermission(['name' => 'add-inv-purchase', 'label' => 'Allow access for Add Purchase(Inventory). ']);
        $this->addPermission(['name' => 'inv-edit-purchase', 'label' => 'Allow access to edit Purchase(Inventory). ']);
        $this->addPermission(['name' => 'inv-issue', 'label' => 'Allow access for Issue List(Inventory). ']);
        $this->addPermission(['name' => 'add-inv-issue', 'label' => 'Allow access for Add Issue(Inventory). ']);
        $this->addPermission(['name' => 'inv-edit-issue', 'label' => 'Allow access to edit Issue(Inventory). ']);
        $this->addPermission(['name' => 'inv-purchase-return', 'label' => 'Allow access for Purchase Return List(Inventory).']);
        $this->addPermission(['name' => 'add-inv-purchase-return', 'label' => 'Allow access for Add Purchase Return(Inventory).']);
        $this->addPermission(['name' => 'inv-edit-purchase-return', 'label' => 'Allow access to edit Purchase Return(Inventory). ']);
        $this->addPermission(['name' => 'inv-return', 'label' => 'Allow access for Return List (Inventory).']);
        $this->addPermission(['name' => 'add-inv-return', 'label' => 'Allow access for Add Return (Inventory).']);
        $this->addPermission(['name' => 'inv-edit-return', 'label' => 'Allow access to edit Return (Inventory).']);
        $this->addPermission(['name' => 'inv-damage', 'label' => 'Allow access for Damage List(Inventory).']);
        $this->addPermission(['name' => 'add-inv-damage', 'label' => 'Allow access for Add Damage(Inventory).']);
        $this->addPermission(['name' => 'inv-edit-damage', 'label' => 'Allow access to edit Damage(Inventory).']);
        $this->addPermission(['name' => 'inv-stock-register', 'label' => 'Allow access for stock-register(Inventory). ']);
        $this->addPermission(['name' => 'opening-stocks', 'label' => 'Allow access for Opening Stocks List(Inventory). ']);
        $this->addPermission(['name' => 'add-opening-stocks', 'label' => 'Allow access for Add Opening Stocks List(Inventory). ']);
        $this->addPermission(['name' => 'modify-opening-stock', 'label' => 'Allow access to Edit/Update opening stock(Inventory). ']);
        $this->addPermission(['name' => 'long-term-asset', 'label' => 'Long Term Asset Report(Inventory). ']);

        // Maintanenece
        $this->addPermission(['name' => 'RESERVED-CATEGORIES', 'label' => 'RESERVED CATEGORIES']);
        $this->addPermission(['name' => 'ADD-RESERVED-CATEGORIES', 'label' => 'ADD RESERVED CATEGORIES']);
        $this->addPermission(['name' => 'EDIT-RESERVED-CATEGORIES', 'label' => 'EDIT RESERVED CATEGORIES']);
        $this->addPermission(['name' => 'CATEGORIES', 'label' => 'CATEGORIES']);
        $this->addPermission(['name' => 'ADD-CATEGORIES', 'label' => 'ADD CATEGORIES']);
        $this->addPermission(['name' => 'EDIT-CATEGORIES', 'label' => 'EDIT CATEGORIES']);
        $this->addPermission(['name' => 'BOARD-UNIV', 'label' => 'BOARD UNIVERSITY']);
        $this->addPermission(['name' => 'ADD-BOARD-UNIV', 'label' => 'ADD BOARD UNIVERSITY']);
        $this->addPermission(['name' => 'EDIT-BOARD-UNIV', 'label' => 'EDIT BOARD UNIVERSITY']);
        $this->addPermission(['name' => 'COURSES', 'label' => 'COURSES']);
        $this->addPermission(['name' => 'ADD-COURSES', 'label' => 'ADD COURSES']);
        $this->addPermission(['name' => 'EDIT-COURSES', 'label' => 'EDIT COURSES']);
        $this->addPermission(['name' => 'EDIT-COURSES-TWO', 'label' => 'EDIT COURSES BOTTOM TABLE']);
        $this->addPermission(['name' => 'SUBJECT-COURSES', 'label' => 'SUBJECT COURSES']);
        $this->addPermission(['name' => 'ADD-ON-COURSES', 'label' => 'ADD ON COURSES']);
        $this->addPermission(['name' => 'SUBJECTS', 'label' => 'SUBJECTS']);
        $this->addPermission(['name' => 'ADD-SUBJECTS', 'label' => 'ADD SUBJECTS']);
        $this->addPermission(['name' => 'EDIT-SUBJECTS', 'label' => 'EDIT SUBJECTS']);
        $this->addPermission(['name' => 'CITIES', 'label' => 'CITIES']);
        $this->addPermission(['name' => 'ADD-CITIES', 'label' => 'ADD CITIES']);
        $this->addPermission(['name' => 'EDIT-CITIES', 'label' => 'EDIT CITIES']);
        $this->addPermission(['name' => 'STATES', 'label' => 'STATES']);
        $this->addPermission(['name' => 'ADD-STATES', 'label' => 'ADD STATES']);
        $this->addPermission(['name' => 'EDIT-STATES', 'label' => 'EDIT STATES']);
        $this->addPermission(['name' => 'LOCATION-LIST', 'label' => 'LOCATION LIST']);
        $this->addPermission(['name' => 'ADD-LOCATIONS', 'label' => 'ADD LOCATIONS']);
        $this->addPermission(['name' => 'EDIT-LOCATIONS', 'label' => 'EDIT LOCATIONS']);
        $this->addPermission(['name' => 'ALUMNI-EXPORT', 'label' => 'ALUMNI EXPORT']);
        $this->addPermission(['name' => 'ALUMNI-EXPORT-BUTTON', 'label' => 'ALUMNI EXPORT BUTTON']);
        $this->addPermission(['name' => 'FEEDBACK-SECTIONS', 'label' => 'FEEDBACK SECTIONS']);
        $this->addPermission(['name' => 'ADD-FEEDBACK-SECTIONS', 'label' => 'ADD FEEDBACK SECTIONS']);
        $this->addPermission(['name' => 'EDIT-FEEDBACK-SECTIONS', 'label' => 'EDIT FEEDBACK SECTIONS']);
        $this->addPermission(['name' => 'FEEDBACK-QUESTIONS', 'label' => 'FEEDBACK QUESTIONS']);
        $this->addPermission(['name' => 'ADD-FEEDBACK-QUESTIONS', 'label' => 'ADD FEEDBACK QUESTIONS']);
        $this->addPermission(['name' => 'EDIT-FEEDBACK-QUESTIONS', 'label' => 'EDIT FEEDBACK QUESTIONS']);
        $this->addPermission(['name' => 'COURSE-ATTACHMENT', 'label' => 'COURSE ATTACHMENT(TIMETABLE SUMMARY ETC.)']);
        // Send SMS
        $this->addPermission(['name' => 'MESSAGES', 'label' => 'MESSAGES (MAINTANENCE)']);
        $this->addPermission(['name' => 'SEND-MESSAGES', 'label' => 'SEND TO ALL MESSAGES (MAINTANENCE)']);
        $this->addPermission(['name' => 'MESSAGES-STAFF', 'label' => 'MESSAGES STAFF (MAINTANENCE)']);
        $this->addPermission(['name' => 'SEND-MESSAGES-STAFF', 'label' => 'SEND TO ALL MESSAGES STAFF (MAINTANENCE)']);

        // USERS
        $this->addPermission(['name' => 'USERS', 'label' => 'USERS']);
        $this->addPermission(['name' => 'MODIFY-USERS', 'label' => 'MODIFY USERS']);
        $this->addPermission(['name' => 'ROLES', 'label' => 'ROLES']);
        $this->addPermission(['name' => 'MODIFY-ROLES', 'label' => 'MODIFY ROLES PERMISSIONS']);
        $this->addPermission(['name' => 'GROUPS', 'label' => 'GROUPS']);
        $this->addPermission(['name' => 'MODIFY-GROUPS', 'label' => 'MODIFY GROUPS']);
        $this->addPermission(['name' => 'MODIFY-GROUP-PERMISSION', 'label' => 'MODIFY ROLES PERMISSIONS']);

        // Day book report
        $this->addPermission(['name' => 'prospectus-fees', 'label' => 'Online Prospectus Fee (Day Book Reports)']);
        $this->addPermission(['name' => 'idcard-report', 'label' => 'Id Card (Day Book Reports)']);
        $this->addPermission(['name' => 'daybook', 'label' => 'Day Book (Day Book Reports)']);
        $this->addPermission(['name' => 'daybook2', 'label' => 'Day Book 2 (Day Book Reports)']);
        $this->addPermission(['name' => 'dbsummary', 'label' => 'DB Summary (Day Book Reports)']);
        $this->addPermission(['name' => 'feeheadwise-coll', 'label' => 'FW Collection (Day Book Reports)']);
        $this->addPermission(['name' => 'subheadwise-coll', 'label' => 'SW Collection (Day Book Reports)']);
        $this->addPermission(['name' => 'student-feedback-report', 'label' => 'Student Feedback (Day Book Reports)']);

        //Student
        $this->addPermission(['name' => 'student-category-wise-report', 'label' => 'Students Category Wise Report ']);
        $this->addPermission(['name' => 'consolidated-students', 'label' => 'Consolidated Students Report']);

        //Examination
        $this->addPermission(['name' => 'date-sheet-list', 'label' => 'Date sheets List (Examinations)']);
        $this->addPermission(['name' => 'date-sheet-modify', 'label' => 'Modify Date sheets (Examinations)']);
        $this->addPermission(['name' => 'seat-plan-button', 'label' => 'Seating plan button (Examinations) ']);
        $this->addPermission(['name' => 'exam-location-list', 'label' => 'Exam Locations List (Examinations)']);
        $this->addPermission(['name' => 'exam-location-modify', 'label' => 'Modify Exam Locations (Examinations)']);
        $this->addPermission(['name' => 'seating-plan-list', 'label' => 'Seating plans List(Examinations)']);
        $this->addPermission(['name' => 'seating-plan-location', 'label' => 'Seating plan Locations List(Examinations)']);
        $this->addPermission(['name' => 'uni-roll-no', 'label' => 'Add/update University Roll No(Examinations)']);
        $this->addPermission(['name' => 'exam-master', 'label' => 'Add/update Exam Master(Examinations)']);
        $this->addPermission(['name' => 'exam-master-list', 'label' => 'Allow to Exam master List (Examinations)']);

        $this->addPermission(['name' => 'pu-marks-entry', 'label' => 'Add/update PU Exam Entry(Examinations)']);
        $this->addPermission(['name' => 'pu-exam-report', 'label' => 'Allow to PU Exam Report(Examinations)']);
        
        // Others
        $this->addPermission(['name' => 'installment-debit-list', 'label' => 'Installment Debit Report']);
        $this->addPermission(['name' => 'academic-sections', 'label' => 'Allow to see/modify academics section.']);
        $this->addPermission(['name' => 'academic-section-details', 'label' => 'Allow to see/modify academics section details.']);
        $this->addPermission(['name' => 'assign-section-to-all', 'label' => 'Allow to assign all students a section.']);
        $this->addPermission(['name' => 'hostel-allocation', 'label' => 'Hostel Room Allocation .']);
        $this->addPermission(['name' => 'hostel-allocation-list', 'label' => 'Hostel allocation list preview .']);
        $this->addPermission(['name' => 'hostel-attendance', 'label' => 'Hostel Attendance.']);
        $this->addPermission(['name' => 'night-out-entry', 'label' => 'Hostel Night Out Entry.']);
        $this->addPermission(['name' => 'night-out-return-entry', 'label' => 'Hostel Night Out Return Entry.']);
        $this->addPermission(['name' => 'staff-list', 'label' => 'Staff List']);
        $this->addPermission(['name' => 'staff-modify', 'label' => 'Add/Update Staff']);
        $this->addPermission(['name' => 'staff-joining-date', 'label' => 'Allow to change MCM Joining Date in Staff']);
        $this->addPermission(['name' => 'staff-courses', 'label' => 'Add/Update Staff Course']);
        $this->addPermission(['name' => 'staff-promotion', 'label' => 'Add/Update Staff Promotion']);
        $this->addPermission(['name' => 'designation-list', 'label' => 'Designation List']);
        $this->addPermission(['name' => 'designation-modify', 'label' => 'Add/Update Designation']);
        $this->addPermission(['name' => 'department-list', 'label' => 'Department List']);
        $this->addPermission(['name' => 'department-modify', 'label' => 'Add/Update Department']);
        $this->addPermission(['name' => 'faculty-list', 'label' => 'Faculty List']);
        $this->addPermission(['name' => 'faculty-modify', 'label' => 'Add/Update Faculty']);
        $this->addPermission(['name' => 'nirf-report', 'label' => 'NIRF Report']);
        $this->addPermission(['name' => 'all-store-loc-access', 'label' => 'All Store Locations']);
        $this->addPermission(['name' => 'open-final-submission', 'label' => 'Resets status of Admission Form Final Submission']);
        $this->addPermission(['name' => 'attachment-submission', 'label' => 'Admission Form (Open Attachment Form)']);
        $this->addPermission(['name' => 'scrutinize-form', 'label' => 'Admission Form (Scrutinize and Un-scrutinize Form)']);
        $this->addPermission(['name' => 'adm-discrepancy', 'label' => 'Admission Form (Discrepancy Form)']);
        $this->addPermission(['name' => 'scrutinize-hostel', 'label' => 'Admission Form (Scrutinize Hostel and Un-scrutinize Hostel Form)']);
 
        // activity
        $this->addPermission(['name' => 'activity', 'label' => 'Allow access for Activity(Activity).']);
        $this->addPermission(['name' => 'agency', 'label' => 'Allow access for Organization/Sponsor/Activity(Activity).']);
        $this->addPermission(['name' => 'agency-types', 'label' => 'Allow access for add Organization/Sponsor/Activity(Activity).']);
        $this->addPermission(['name' => 'agency-types-modify', 'label' => 'Allow access to modify Organization/Sponsor/Activity(Activity).']);
        $this->addPermission(['name' => 'orgnization', 'label' => 'Allow access for Organization(Activity).']);
        $this->addPermission(['name' => 'add-orgnization', 'label' => 'Allow access for add Organization(Activity).']);
        $this->addPermission(['name' => 'orgnization-modify', 'label' => 'Allow access for modify Organization(Activity).']);
        $this->addPermission(['name' => 'activities', 'label' => 'Allow access to Activity button(Activity).']);
        $this->addPermission(['name' => 'add-activities', 'label' => 'Allow access to add Activity(Activity).']);
        $this->addPermission(['name' => 'activities-modify', 'label' => 'Allow access for modify Activity(Activity).']);
        $this->addPermission(['name' => 'activities-remove', 'label' => 'Allow access for Delete Activity(Activity).']);
        
        // student refund request
        $this->addPermission(['name' => 'refund-requests-details', 'label' => 'Refund Request List(Refund).']);
        $this->addPermission(['name' => 'approve', 'label' => 'Approved Refund(Refund).']);
        $this->addPermission(['name' => 'cancel', 'label' => 'Cancled Refund(Refund).']);
        $this->addPermission(['name' => 'student-refunds', 'label' => 'Refunds Release(Refund).']);
        $this->addPermission(['name' => 'refund-requests-print', 'label' => 'Refund Request Print(Refund).']);

        // placement
        $this->addPermission(['name' => 'placements', 'label' => 'Allow access to Placement(Placements).']);
        $this->addPermission(['name' => 'add-placements', 'label' => 'Allow access to add Placement(Placements).']);
        $this->addPermission(['name' => 'placements-modify', 'label' => 'Allow access for modify Placement(Placements).']);
        $this->addPermission(['name' => 'placement-student-details', 'label' => 'Allow access to Student Details(Placements).']);

        $this->addPermission(['name' => 'placement-companies', 'label' => 'Allow access to Placement Companies(Placements).']);
        $this->addPermission(['name' => 'add-placement-companies', 'label' => 'Allow access to add Placement Companies(Placements).']);
        $this->addPermission(['name' => 'placement-companies-modify', 'label' => 'Allow access for modify Placement Companies(Placements).']);

        // Placement Report

        $this->addPermission(['name' => 'placement-report', 'label' => 'Allow access to Placement Reports(Placements).']);
        $this->addPermission(['name' => 'placement-std-wise-report', 'label' => 'Allow access to Placement Student Wise Report(Placement Reports).']);
        $this->addPermission(['name' => 'placement-drive-wise-report', 'label' => 'Allow access to Placement Drive Wise Report(Placement Reports).']);



        // Student Crt Passes
        $this->addPermission(['name' => 'stu-crt-passes', 'label' => 'Allow access to Student Certificate Pass(Students).']);
        $this->addPermission(['name' => 'add-stu-crt-passes', 'label' => 'Allow access to add Student Certificate Pass(Students).']);
        $this->addPermission(['name' => 'stu-crt-passes-modify', 'label' => 'Allow access for Student Certificate Pass(Students).']);
        $this->addPermission(['name' => 'issue-date', 'label' => 'Allow access to Issue Date Student Certificate Pass(Students).']);
        $this->addPermission(['name' => 'stu-crt-pass-reject', 'label' => 'Allow access to Reject Student Certificate Pass(Students).']);
    
        //new permission
        $this->addPermission(['name' => 'send-stu-result-email', 'label' => 'Allow access to Student Result Email (Messaging(SMS/Email).']);
        $this->addPermission(['name' => 'send-stu-email', 'label' => 'Allow access to Email (Messaging(SMS/Email).']);
        $this->addPermission(['name' => 'app-setting', 'label' => 'Allow access to Student college/hostel Key Control.']);
        // Staff Reports
        $this->addPermission(['name' => 'research-report', 'label' => 'Allow access to Research Report (Staff Reports).']);
        $this->addPermission(['name' => 'course-attended-report', 'label' => 'Allow access to Course Attended Report (Staff Reports).']);
        $this->addPermission(['name' => 'qualification-report', 'label' => 'Allow access to Qualification Report (Staff Reports).']);
        $this->addPermission(['name' => 'promotion-due-report', 'label' => 'Allow access to Promotion Due Report (Staff Reports).']);

        $this->addPermission(['name' => 'sub-combination', 'label' => 'Allow access for add Subject Combination.']);
        $this->addPermission(['name' => 'sub-combination-modify', 'label' => 'Allow access to modify Subject Combination.']);
    }

    private function addPermission($permission)
    {
        $p = Permission::firstOrCreate(['name' => $permission['name']], ['label' => $permission['label']]);
    }
}
