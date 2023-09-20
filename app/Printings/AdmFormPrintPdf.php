<?php

namespace App\Printings;

use Log;
use TCPDF;
use DateTime;
use App\AdmissionSubPreference;
use App\AdmisssionSubCombination;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use App\Models\SubCombination\SubjectCombinationDetail;

class AdmFormPrintPdf extends PrintPdf
{
    //
    protected $admform = null;
    protected $subject = null;
    protected $pdf = null;
    protected $hight = 0;
    protected $pageno = 0;
    protected $nextpage = '';
    protected $copyno = 0;
    protected $footerHight = 0;
    protected $sno = 1;
    protected $sno_u = 1;
    protected $sno_rag = 1;
    protected $gap = 1;
    protected $fontsize = 10;
    protected $lm = 10;
    protected $page_no = 1;
    protected $total_page = 0;
    public function makepdf(\App\AdmissionForm $adm)
    {
        $this->admform = $adm;
        $this->subject = $adm->admSubs;
        $this->attachments = $adm->attachments;
        $this->pdf->SetMargins($this->lm, $this->tm);
        $this->main();
        return $this->pdf;
    }

    private function header($title = '')
    {
        $pdf = $this->pdf;
        $this->pdf->ln(5);
        $pdf->Image(public_path("/dist/img/mcm-logo.png"), $this->lm + 2, $this->tm, 25, 25, 'PNG', '', '', true, 100, '', false, false, 0, false, false, false);
        $this->addCell(0, 5, "Mehr Chand Mahajan DAV College For Women", 0, 'C', 1, 'T', 16, 'B');
        $this->addCell(0, 5, "Sector 36-A, Chandigarh", 0, 'C', 1, 'T', 16, 'B');
        $this->pdf->ln(2);
        $this->addCell(0, 5, "College Admission Form (SESSION " .get_fy_label().") ", 0, 'C', 1, 'T', 12, '');
        $this->addCell(170, 0, "Online Form No.: ", 0, 'R', 0, 'T', 12, '');
        $this->addMCell(40, 0, $this->admform->fee_paid == 'Y' ? $this->admform->id : "Fees Not Paid", 0, 'L', 1, 'T', 12, 'B');
        $this->pdf->ln($this->gap);
        $this->pdf->ln(1);

        $topY = $pdf->getY();
        if ($this->admform->lastyr_rollno) {
            $this->addCell(175, 0, 'Roll No : ' . $this->admform->lastyr_rollno, 0, 'R', 1, 'T', 10, '');
        } else {
            $this->addCell(190, 0, 'TO BE ALLOTED BY OFFICE', 0, 'R', 1, 'T', 10, '');
            $this->addCell(190, 0, 'Roll No........................................', 0, 'R', 1, 'T', 10, '');
        }
        $this->pdf->Rect($this->lm + 145, $topY - 1, $this->pageWidth - 150, $pdf->getY() - $topY + 2);

        $this->addCell(60, 0, "Application for admission to: ", 0, 'L', 0, 'T', 12, 'B');
        $this->addCell(30, 0, $this->admform->course->course_name, 0, 'L', 1, 'T', 12, '');
        $this->pdf->ln($this->gap);

        $this->addCell(60, 0, "Pool : ", 0, 'L', 0, 'T', $this->fontsize, 'B');

        $this->addCell(65, 0, $this->admform->loc_cat != null ? $this->admform->loc_cat : 'NA', 0, 'L', 1, 'T', $this->fontsize, '');
        $this->pdf->ln($this->gap);

        // $this->addCell(0, 5, "Reserved Category", 0, 'L', 1, 'T', 14, 'BIU');
        $this->pdf->ln($this->gap);
        $this->addCell(60, 0, "Reserved Category : ", 0, 'L', 0, 'T', $this->fontsize, 'B');
        $this->addMCell(80, 0, ($this->admform->res_category ? $this->admform->res_category->name : ''), 0, 'L', 1, 'T', $this->fontsize, '');
        $this->pdf->ln($this->gap);
        $cat = [];
        $add_res = $this->admform->add_res_cats ? $this->admform->add_res_cats : '';
        $add_res =  explode(',', $add_res);
        foreach (getResCategory() as $key=>$res) {
            foreach ($add_res as $add) {
                if($add != '' && $key != ''){
                    if ($key == $add) {
                    
                        $cat[]= $res;
                    }
                }
                
            }
        }
        // dd($cat);
        $add_res_cat = implode(",", $cat);
        if ($this->admform->course->course_id == 'MSC-CHEM' && $this->admform->course->course_year == '1') {
            $this->addCell(60, 0, "Additional Reserved Category : ", 0, 'L', 0, 'T', $this->fontsize, 'B');
            $this->addMCell(80, 0, $add_res_cat, 0, 'L', 1, 'T', $this->fontsize, '');
            $this->pdf->ln($this->gap);
        }

        $this->addCell(60, 0, "Category : ", 0, 'L', 0, 'T', $this->fontsize, 'B');
        $this->addCell(65, 0, ($this->admform->category ? $this->admform->category->name : ''), 0, 'L', 1, 'T', $this->fontsize, '');
        $this->pdf->ln($this->gap);

        $previous_exam = '';
        foreach ($this->admform->academics as $exam) {
            if ($exam->last_exam == "Y") {
                $previous_exam = $exam;
            }
        }
        // dd($previous_exam);
        // $topY = $pdf->getY();
        // $pdf->ln(3);
        // $pdf->setX($pdf->getX() + 10);
        // $this->addCell(35, 0, "Relevant Category : ", 0, 'L', 0, 'T', $this->fontsize, 'B');
        // $this->addCell(($this->pageWidth / 2) - 50, 0, $this->admform->geo_cat, 0, 'L', 0, 'T', $this->fontsize, '');
        // $this->pdf->ln($this->gap);

        // $pdf->setX($pdf->getX() + 90);
        // $this->addCell(20, 0, "Pool : ", 0, 'L', 0, 'T', $this->fontsize, 'B');
        // $this->addCell(0, 0, $this->admform->loc_cat . " Pool", 0, 'L', 1, 'T', $this->fontsize, '');
        // $this->pdf->ln($this->gap);

        // $pdf->setX($pdf->getX() + 10);
        // $this->addCell(30, 0, "Category : ", 0, 'L', 0, 'T', $this->fontsize, 'B');
        // $this->addCell(($this->pageWidth / 2) - 50, 0, ($this->admform->category ? $this->admform->category->name : ''), 0, 'L', 0, 'T', $this->fontsize, '');
        // $this->pdf->ln($this->gap);

        // $pdf->setX($pdf->getX() + 90);
        // $this->addCell(35, 0, "Reserved Category : ", 0, 'L', 0, 'T', $this->fontsize, 'B');
        // $this->addCell(0, 0, ($this->admform->res_category ? $this->admform->res_category->name : ''), 0, 'L', 1, 'T', $this->fontsize, '');
        // $this->pdf->ln($this->gap);



        // $pdf->ln(3);
        // $this->pdf->Rect($this->lm, $topY, $this->pageWidth, $pdf->getY() - $topY);
        // $this->pdf->ln(8); // $pdf->ln(3);
        // $this->pdf->Rect($this->lm, $topY, $this->pageWidth, $pdf->getY() - $topY);
        // $this->pdf->ln(8);

        // $this->addCell(0, 5, "Previous Examination Details:", 0, 'L', 1, 'T', 12, 'I');

        $this->addCell(60, 0, "Previous Examination passed in year : ", 0, 'L', 0, 'T', $this->fontsize, 'B');
        $this->addCell(($this->pageWidth / 2) - 50, 0, data_get($previous_exam, 'year', ''), 0, 'L', 1, 'T', $this->fontsize, '');
        $this->pdf->ln($this->gap);

        // $pdf->setX($pdf->getX() + 90);
        $this->addCell(60, 0, "Gap year : ", 0, 'L', 0, 'T', $this->fontsize, 'B');
        $this->addCell(0, 0, $this->admform->gap_year ?  $this->admform->gap_year : 'NA', 0, 'L', 1, 'T', $this->fontsize, '');
        $this->pdf->ln($this->gap);
        $prev_exam = (data_get($previous_exam, 'marks_obtained', ''));

        if ($prev_exam) {
            $this->addCell(60, 0, "Marks in previous examination: ", 0, 'L', 0, 'T', $this->fontsize, 'B');
            $this->addCell(($this->pageWidth / 2) - 75, 0, data_get($previous_exam, 'marks_obtained', '') . '/' . data_get($previous_exam, 'total_marks', ''), 0, 'L', 0, 'T', $this->fontsize, '');
        // $this->pdf->ln($this->gap);
        } else {
            $this->addCell(60, 0, "Marks in previous examination: ", 0, 'L', 0, 'T', $this->fontsize, 'B');
            $this->addCell(($this->pageWidth / 2) - 75, 0, '---', 0, 'L', 0, 'T', $this->fontsize, '');
        }
        // $pdf->setX($pdf->getX() + 10);
        $this->addCell(30, 0, "Percentage: ", 0, 'L', 0, 'T', $this->fontsize, 'B');
        $this->addCell(0, 0, data_get($previous_exam, 'marks_per', ''), 0, 'L', 1, 'T', $this->fontsize, '');
        $this->pdf->ln($this->gap);

        $this->addCell(60, 0, "Old College Roll No. : ", 0, 'L', 0, 'T', $this->fontsize, 'B');
        $this->addCell(($this->pageWidth / 2) - 75, 0, $this->admform->lastyr_rollno ? $this->admform->lastyr_rollno : '', 0, 'L', 0, 'T', $this->fontsize, '');
        // $this->pdf->ln($this->gap);

        // $pdf->setX($pdf->getX() + 90);
        $this->addCell(30, 0, "Session: ", 0, 'L', 0, 'T', $this->fontsize, 'B');
        $this->addCell(0, 0, data_get($previous_exam, 'year', ''), 0, 'L', 1, 'T', $this->fontsize, '');
        $this->pdf->ln($this->gap);



        $mode_conv = 'No';
        if ($this->admform->conveyance == 'Y') {
            $mode_conv = "Yes";
        }


        $this->addCell(60, 0, "Conveyance (Scooter/Motorcycle)  : ", 0, 'L', 0, 'T', $this->fontsize, 'B');
        $this->addCell(($this->pageWidth / 2) - 75, 0, $mode_conv, 0, 'L', 0, 'T', $this->fontsize, '');
        // $this->pdf->ln(0);

        // $pdf->setX($pdf->getX() + 90);
        $this->addCell(30, 0, "Vehicle No.: ", 0, 'L', 0, 'T', $this->fontsize, 'B');
        $this->addCell(0, 0, $this->admform->veh_no, 0, 'L', 1, 'T', $this->fontsize, '');
        $this->pdf->ln($this->gap);

        $this->addCell(60, 0, "PU Roll No.  : ", 0, 'L', 0, 'T', $this->fontsize, 'B');
        $this->addCell(($this->pageWidth / 2) - 75, 0, $this->admform->pu_regno ? $this->admform->pu_regno : 'NA', 0, 'L', 0, 'T', $this->fontsize, '');

        $this->addCell(35, 0, "PU Reg. / PUPIN No.: ", 0, 'L', 0, 'T', $this->fontsize, 'B');
        $this->addCell(0, 0, $this->admform->pupin_no ? $this->admform->pupin_no : 'NA', 0, 'L', 1, 'T', $this->fontsize, '');
        $this->pdf->ln($this->gap);

        if ($this->admform->ocet_rollno) {
            $this->addCell(60, 0, "O-CET Roll No. : ", 0, 'L', 0, 'T', $this->fontsize, 'B');
            $this->addCell(($this->pageWidth / 2) - 75, 0, $this->admform->ocet_rollno ? $this->admform->ocet_rollno : '', 0, 'L', 0, 'T', $this->fontsize, '');
        }

        $this->addCell(60, 0, "Boarder/Day Scholar : ", 0, 'L', 0, 'T', $this->fontsize, 'B');
        $this->addCell(0, 0, $this->admform->boarder, 0, 'L', 1, 'T', $this->fontsize, '');
        $this->pdf->ln($this->gap);

        // $this->addCell(65, 0, "Registration No. : ", 0, 'L', 0, 'T', $this->fontsize, 'B');
        // $this->addCell(($this->pageWidth / 2) - 50, 0, $this->admform->dob, 0, 'L', 1, 'T', $this->fontsize, '');
        // $this->pdf->ln($this->gap);



        $file = $this->getPhoto();
        // $pdf->Image(public_path("/dist/img/avatar2.png"), 157, 55, 50, 50, '', '', '', true, 100, '', false, false, 0, false, false, false);
        if ($file) {
            $pdf->Image(storage_path() . "/app/images/photograph" . '_' . $this->admform->id . '.' . $file->file_ext, 160, 55, 40, 50, '', '', '', true, 100, '', false, false, 0, false, false, false);
        }
        //demo photo
        //commented photo
        $pdf->setX($pdf->getX());
        $this->pdf->ln($this->gap);
        $this->pdf->ln($this->gap);


        $this->addCell(0, 5, "Applicant's Details", 0, 'L', 1, 'T', 14, 'BIUU');
        $this->pdf->ln($this->gap);

        $pdf->setX($pdf->getX());
        $this->addCell(35, 0, "Name: ", 0, 'L', 0, 'T', $this->fontsize, 'B');
        $this->addCell(($this->pageWidth / 2) - 35, 0, $this->admform->name, 0, 'L', 0, 'T', $this->fontsize, '');
        // $this->pdf->ln($this->gap);

        $this->addCell(35, 0, "Date of birth: ", 0, 'L', 0, 'T', $this->fontsize, 'B');
        $this->addCell(($this->pageWidth / 2) - 35, 0, $this->admform->dob, 0, 'L', 1, 'T', $this->fontsize, '');
        $this->pdf->ln($this->gap);

        $pdf->setX($pdf->getX());
        $this->addCell(35, 0, "Gender: ", 0, 'L', 0, 'T', $this->fontsize, 'B');
        $this->addCell(($this->pageWidth / 2) - 35, 0, $this->admform->gender, 0, 'L', 0, 'T', $this->fontsize, '');
        // $this->pdf->ln($this->gap);

        $this->addCell(35, 0, "Blood Group: ", 0, 'L', 0, 'T', $this->fontsize, 'B');
        $this->addCell(($this->pageWidth / 2) - 35, 0, $this->admform->blood_grp, 0, 'L', 1, 'T', $this->fontsize, '');
        $this->pdf->ln($this->gap);


        $pdf->setX($pdf->getX());
        $this->addCell(35, 0, "Minority Status: ", 0, 'L', 0, 'T', $this->fontsize, 'B');
        $this->addCell(($this->pageWidth / 2) - 35, 0, $this->admform->minority == 'Y' ? 'Yes' : 'No', 0, 'L', 0, 'T', $this->fontsize, '');

        $this->addCell(35, 0, "Religion: ", 0, 'L', 0, 'T', $this->fontsize, 'B');
        $this->addCell(($this->pageWidth / 2) - 35, 0, strtoupper($this->admform->religion) == "OTHERS" ? $this->admform->other_religion : $this->admform->religion ? $this->admform->religion : 'NA', 0, 'L', 1, 'T', $this->fontsize, '');
        $this->pdf->ln($this->gap);


        $pdf->setX($pdf->getX());
        $this->addCell(35, 0, "Nationality: ", 0, 'L', 0, 'T', $this->fontsize, 'B');
        $this->addCell(($this->pageWidth / 2) - 35, 0, $this->admform->nationality, 0, 'L', 0, 'T', $this->fontsize, '');

        $this->addCell(35, 0, "Aadhar No.: ", 0, 'L', 0, 'T', $this->fontsize, 'B');
        $this->addCell(($this->pageWidth / 2) - 35, 0, $this->admform->aadhar_no, 0, 'L', 1, 'T', $this->fontsize, '');
        $this->pdf->ln($this->gap);


        $pdf->setX($pdf->getX());
        $this->addCell(35, 0, "Contact ", 0, 'L', 0, 'T', $this->fontsize, 'B');
        $this->addCell(($this->pageWidth / 2) - 35, 0, $this->admform->mobile, 0, 'L', 0, 'T', $this->fontsize, '');

        $this->addCell(35, 0, "EPIC No: ", 0, 'L', 0, 'T', $this->fontsize, 'B');
        $this->addCell(($this->pageWidth / 2) - 35, 0, $this->admform->epic_no, 0, 'L', 1, 'T', $this->fontsize, '');
        $this->pdf->ln($this->gap);


        $pdf->setX($pdf->getX());

        $email = ($std_user = $this->admform->std_user) ? $std_user->email : '';
        $this->addCell(35, 0, "Email ID: ", 0, 'L', 0, 'T', $this->fontsize, 'B');
        $this->addCell(($this->pageWidth / 2) - 35, 0, $email, 0, 'L', 0, 'T', $this->fontsize, '');

        $this->addCell(35, 0, "State: ", 0, 'L', 0, 'T', $this->fontsize, 'B');
        $this->addCell(($this->pageWidth / 2) - 35, 0, data_get($this->admform->permanentState, 'state', ''), 0, 'L', 1, 'T', $this->fontsize, '');
        $this->pdf->ln($this->gap);

        $pdf->setX($pdf->getX());
        // $pdf->setX($pdf->getX()+55)



        $per_address = preg_replace('/[\n\r]/', ' ', $this->admform->per_address);
        $this->addCell(35, 0, "Permanent Address: ", 0, 'L', 0, 'T', $this->fontsize, 'B');
        $this->addMCell(($this->pageWidth / 2) - 35, 0, $per_address, 0, 'L', 0, 'T', $this->fontsize, '');

        $corr_address = preg_replace('/[\n\r]/', ' ', $this->admform->corr_address);
        $this->addMCell(35, 0, "Address for Correspondence: ", 0, 'L', 0, 'T', $this->fontsize, 'B');
        $this->addMCell(($this->pageWidth / 2) - 35, 0, $corr_address, 0, 'L', 1, 'T', $this->fontsize, '');
        $this->pdf->ln(4);

        $this->addCell(35, 0, "Belongs to BPL: ", 0, 'L', 0, 'T', $this->fontsize, 'B');
        $this->addCell(($this->pageWidth / 2) - 35, 0, $this->admform->belongs_bpl == 'Y' ? 'Yes' : "No", 0, 'L', 0, 'T', $this->fontsize, '');

        $this->addCell(35, 0, "Annual Income: ", 0, 'L', 0, 'T', $this->fontsize, 'B');
        $this->addCell(($this->pageWidth / 2) - 35, 0, $this->admform->annual_income, 0, 'L', 1, 'T', $this->fontsize, '');
        $this->pdf->ln(2);
        $remarks = '';
        if ($this->admform->vaccinated == 'Not Yet') {
            $remarks = ' ( ' . $this->admform->vaccination_remarks .' )';
        }
        // $this->addCell(70, 0, "Have you been Vaccinated for COVID-19 :", 0, 'L', 0, 'T', $this->fontsize, 'B');
        // $this->addMCell(($this->pageWidth / 2) -2, 0, $this->admform->vaccinated.$remarks, 0, 'L', 1, 'T', 9, '');
        $this->addCell(70, 0, "ABC ID (Academic Bank Of Credits) :", 0, 'L', 0, 'T', $this->fontsize, 'B');
        $this->addMCell(($this->pageWidth / 2) -2, 0, $this->admform->abc_id, 0, 'L', 1, 'T', 9, '');
        
        if($this->admform->course->final_year == "Y" && $this->admform->course->status == 'PGRAD'){
            $mcm_graduate = ' ';
            if($this->admform->mcm_graduate == 'Y'){
                $mcm_graduate = 'Yes';
            }
            else{
                $mcm_graduate = 'No';
            }
            $this->addCell(115, 0, "Are You Graduated (UG) from MCM DAV CW, Sector 36, Chandigarh :", 0, 'L', 0, 'T', $this->fontsize, 'B');
            $this->addMCell(($this->pageWidth / 2) -2, 0, $mcm_graduate, 0, 'L', 1, 'T', 9, '');
        }
        
        $this->pdf->ln(2);
        $this->pdf->ln($this->gap);


        $this->addCell(0, 5, "Special Achievements", 0, 'L', 1, 'T', 14, 'BIU');
        $this->pdf->ln($this->gap);

        $this->addCell(35, 0, "Cultural : ", 0, 'L', 0, 'T', $this->fontsize, 'B');
        $this->addCell(($this->pageWidth / 2) - 35, 0, ($this->admform->cultural == 'Y' ? 'Yes' : 'No'), 0, 'L', 0, 'T', $this->fontsize, '');

        $this->addCell(35, 0, "Sports : ", 0, 'L', 0, 'T', $this->fontsize, 'B');
        $this->addCell(($this->pageWidth / 2) - 35, 0, ($this->admform->sports == 'Y' ? 'Yes' : 'No'), 0, 'L', 1, 'T', $this->fontsize, '');
        $this->pdf->ln($this->gap);

        $this->addCell(35, 0, "Academic : ", 0, 'L', 0, 'T', $this->fontsize, 'B');
        $this->addCell(($this->pageWidth / 2) - 35, 0, ($this->admform->academic == 'Y' ? 'Yes' : 'No'), 0, 'L', 1, 'T', $this->fontsize, '');
        $this->pdf->ln($this->gap);

        if ($this->admform->academic == 'Y' || $this->admform->sports == 'Y' || $this->admform->cultural == 'Y') {
            $this->addCell(40, 0, "Achievement Remarks : ", 0, 'L', 0, 'T', $this->fontsize, 'B');
            $this->addMCell(($this->pageWidth / 2) + 30, 0, ($this->admform->spl_achieve ? $this->admform->spl_achieve  : ''), 0, 'L', 1, 'T', $this->fontsize, '');
            $this->pdf->ln($this->gap);
        }
        $this->pdf->ln($this->gap);

        $pdf->setX($pdf->getX());
        $this->addCell(0, 5, "Father's Details", 0, 'L', 1, 'T', 14, 'BIU');
        $this->pdf->ln($this->gap);

        $this->addCell(35, 0, "Name: ", 0, 'L', 0, 'T', $this->fontsize, 'B');
        $this->addMCell(($this->pageWidth / 2) - 35, 0, $this->admform->father_name, 0, 'L', 0, 'T', $this->fontsize, '');


        $this->addMCell(35, 0, "Occupation: ", 0, 'L', 0, 'T', $this->fontsize, 'B');
        $this->addCell(($this->pageWidth / 2) - 35, 0, $this->admform->father_occup, 0, 'L', 1, 'T', $this->fontsize, '');
        $this->pdf->ln($this->gap);


        // $this->pdf->ln($this->gap);
        $father_office_address = preg_replace('/[\n\r]/', ' ', $this->admform->f_office_addr);
        $this->addCell(35, 0, "Email ID: ", 0, 'L', 0, 'T', $this->fontsize, 'B');
        $this->addCell(($this->pageWidth / 2) - 35, 0, $this->admform->father_email, 0, 'L', 0, 'T', $this->fontsize, '');

        $this->addCell(35, 0, "Office Address: ", 0, 'L', 0, 'T', $this->fontsize, 'B');
        $this->addMCell(($this->pageWidth / 2) - 35, 0, $father_office_address, 0, 'L', 1, 'T', $this->fontsize, '');
        $this->pdf->ln($this->gap);

        $this->addCell(35, 0, "Contact no: ", 0, 'L', 0, 'T', $this->fontsize, 'B');
        $this->addCell(($this->pageWidth / 2) - 35, 0, $this->admform->father_mobile, 0, 'L', 1, 'T', $this->fontsize, '');
        $this->pdf->ln($this->gap);
        $this->pdf->ln($this->gap);

        $pdf->setX($pdf->getX());
        $this->addCell(0, 5, "Mother's Details", 0, 'L', 1, 'T', 14, 'BIU');
        $this->pdf->ln($this->gap);


        $this->addCell(35, 0, "Name: ", 0, 'L', 0, 'T', $this->fontsize, 'B');
        $this->addCell(($this->pageWidth / 2) - 35, 0, $this->admform->mother_name, 0, 'L', 0, 'T', $this->fontsize, '');

        $this->addCell(35, 0, "Occupation: ", 0, 'L', 0, 'T', $this->fontsize, 'B');
        $this->addCell(35, 0, $this->admform->mother_occup, 0, 'L', 1, 'T', $this->fontsize, '');
        $this->pdf->ln($this->gap);

        // $this->pdf->ln($this->gap);
        $this->addCell(35, 0, "Email ID: ", 0, 'L', 0, 'T', $this->fontsize, 'B');
        $this->addCell(($this->pageWidth / 2) - 35, 0, $this->admform->mother_email, 0, 'L', 0, 'T', $this->fontsize, '');

        $this->addCell(35, 0, "Office Address: ", 0, 'L', 0, 'T', $this->fontsize, 'B');
        $this->addMCell(($this->pageWidth / 2) - 35, 0, $this->admform->mother_address, 0, 'L', 1, 'T', $this->fontsize, '');
        $this->pdf->ln($this->gap);

        // $this->pdf->ln($this->gap);

        $this->addCell(35, 0, "Contact no: ", 0, 'L', 0, 'T', $this->fontsize, 'B');
        $this->addCell(($this->pageWidth / 2) - 35, 0, $this->admform->mother_mobile, 0, 'L', 1, 'T', $this->fontsize, '');
        $this->pdf->ln($this->gap);
        $this->pdf->ln($this->gap);


        $pdf->setX($pdf->getX());
        $this->addCell(0, 5, "Guardian's Details", 0, 'L', 1, 'T', 14, 'BIU');
        $this->pdf->ln($this->gap);


        $this->addCell(35, 0, "Name: ", 0, 'L', 0, 'T', $this->fontsize, 'B');
        $this->addCell(($this->pageWidth / 2) - 35, 0, $this->admform->guardian_name, 0, 'L', 0, 'T', $this->fontsize, '');


        $this->addCell(35, 0, "Occupation: ", 0, 'L', 0, 'T', $this->fontsize, 'B');
        $this->addCell(($this->pageWidth / 2) - 35, 0, $this->admform->guardian_occup, 0, 'L', 1, 'T', $this->fontsize, '');
        $this->pdf->ln($this->gap);

        $this->addCell(35, 0, "Email ID: ", 0, 'L', 0, 'T', $this->fontsize, 'B');
        $this->addCell(($this->pageWidth / 2) - 35, 0, $this->admform->guardian_email, 0, 'L', 0, 'T', $this->fontsize, '');

        $guardian_office_address = preg_replace('/[\n\r]/', ' ', $this->admform->g_office_addr);
        $this->addCell(35, 0, "Office Address: ", 0, 'L', 0, 'T', $this->fontsize, 'B');
        $this->addMCell(($this->pageWidth / 2) - 35, 0, $guardian_office_address, 0, 'L', 1, 'T', $this->fontsize, '');
        $this->pdf->ln($this->gap);


        // $this->pdf->ln($this->gap);

        $this->addCell(35, 0, "Contact no: ", 0, 'L', 0, 'T', $this->fontsize, 'B');
        $this->addCell(($this->pageWidth / 2) - 35, 0, $this->admform->guardian_mobile, 0, 'L', 1, 'T', $this->fontsize, '');
        $this->pdf->ln($this->gap);


        // $this->addCell(55, 0, "Address for Correspondence: ", 0, 'L', 0, 'T', $this->fontsize, 'B');
        // $this->addMCell((140), 0, $corr_address .' ' . $this->admform->corr_city, 0, 'L', 1, 'T', $this->fontsize, '');
        // $pdf->setX($pdf->getX()+55);
        // $this->addCell(10, 0, "State: ", 0, 'L', 0, 'T', $this->fontsize, 'B');
        // $this->addMCell((140), 0, data_get($this->admform->corresState, 'state', ''), 0, 'L', 1, 'T', $this->fontsize, '');
        // $this->pdf->ln($this->gap);

        // $father_office_address = preg_replace('/[\n\r]/', ' ', $this->admform->f_office_addr);
        // $this->addCell(55, 0, "Father's Office Address: ", 0, 'L', 0, 'T', $this->fontsize, 'B');
        // $this->addMCell((145), 0, $father_office_address, 0, 'L', 1, 'T', $this->fontsize, '');
        // $this->pdf->ln($this->gap);

        // $guardian_office_address = preg_replace('/[\n\r]/', ' ', $this->admform->g_office_addr);
        // $this->addCell(55, 0, "Guardian's Office Address: ", 0, 'L', 0, 'T', $this->fontsize, 'B');
        // $this->addMCell((145), 0, $guardian_office_address, 0, 'L', 1, 'T', $this->fontsize, '');
        // $this->pdf->ln($this->gap);


        // $this->addCell(55, 0, "Telephone Numbers: ", 0, 'L', 0, 'T', $this->fontsize, 'B');
        // $this->addCell(($this->pageWidth / 2) - 68, 0, "Residence:", 0, 'L', 0, 'T', $this->fontsize, 'B');
        // $this->addCell(35, 0, $this->admform->mother_phone, 0, 'L', 0, 'T', $this->fontsize, '');
        // $this->addCell(35, 0, "Office:", 0, 'L', 0, 'T', $this->fontsize, 'B');
        // $this->addCell(35, 0, $this->admform->father_phone, 0, 'L', 1, 'T', $this->fontsize, '');
        // // for next line
        // $this->pdf->ln($this->gap);
        // //for offset
        // $pdf->setX($pdf->getX()+55);
        // $this->addCell(($this->pageWidth / 2) - 68, 0, "Mobile (Father):", 0, 'L', 0, 'T', $this->fontsize, 'B');
        // $this->addCell(35, 0, $this->admform->father_mobile, 0, 'L', 0, 'T', $this->fontsize, '');
        // $this->addCell(35, 0, "Mobile (Mother):", 0, 'L', 0, 'T', $this->fontsize, 'B');
        // $this->addCell(35, 0, $this->admform->mother_mobile, 0, 'L', 1, 'T', $this->fontsize, '');
        // $this->pdf->ln($this->gap);
        // //for offset


        // $pdf->setX($pdf->getX()+55);
        // $this->addCell(($this->pageWidth / 2) - 68, 0, "Guardian:", 0, 'L', 0, 'T', $this->fontsize, 'B');
        // $this->addCell(35, 0, $this->admform->guardian_mobile, 0, 'L', 0, 'T', $this->fontsize, '');

        // $this->pdf->ln($this->gap);

        $added = false;
        if ($this->admform->spl_achieve && ($this->admform->academic == 'Y' || $this->admform->sports == 'Y' || $this->admform->cultural == 'Y')) {
            // Page number
            $this->SetYPos(-8);
            $this->addCell(0, 5, 'Page ' . $this->getPageNo(), 0, 'R', 1, 'T', 10, 'B');

            // new Page
            $this->addNewPage('P', 'A4');
            $this->pdf->ln(5);
            $added = true;
        }
        $this->addCell(0, 5, "Sports Category", 0, 'L', 1, 'T', 14, 'BIU');
        $this->pdf->ln($this->gap);
        // $this->addCell(55, 0, "Reserved Category : ", 0, 'L', 0, 'T', $this->fontsize, 'B');
        // $this->addCell(($this->pageWidth / 2) - 50, 0, ($this->admform->res_category ? $this->admform->res_category->name : ''), 0, 'L', 1, 'T', $this->fontsize, '');
        // $this->pdf->ln($this->gap);

        // $this->addCell(55, 0, "Category : ", 0, 'L', 0, 'T', $this->fontsize, 'B');
        // $this->addCell(($this->pageWidth / 2) - 50, 0, ($this->admform->category ? $this->admform->category->name : ''), 0, 'L', 1, 'T', $this->fontsize, '');
        // $this->pdf->ln($this->gap);

        $this->addCell(35, 0, "Sports Seat : ", 0, 'L', 0, 'T', $this->fontsize, 'B');
        $this->addCell(($this->pageWidth / 2) - 35, 0, ($this->admform->sports_seat == 'Y' ? 'Yes' : 'No'), 0, 'L', 0, 'T', $this->fontsize, '');
       

        $this->addCell(35, 0, "Sport Name : ", 0, 'L', 0, 'T', $this->fontsize, 'B');
        $this->addCell(($this->pageWidth / 2) - 35, 0, ($this->admform->sport_name ?  $this->admform->sport_name : 'NA'), 0, 'L', 1, 'T', $this->fontsize, '');
        $this->pdf->ln($this->gap);

        $pdf->setX($pdf->getX() + 35);
        $this->addCell(35, 0, "(Admission against sports seat will be as per Panjab University Rules)", 0, 'L', 0, 'T', 10);
        $this->pdf->ln(2);
        $this->pdf->ln($this->gap);



        if ($added == false) {
            // Page number
            $this->SetYPos(-8);
            $this->addCell(0, 5, 'Page ' . $this->getPageNo(), 0, 'R', 1, 'T', 10, 'B');

            // new Page
            $this->addNewPage('P', 'A4');
            $this->pdf->ln(5);
        }

        $this->addCell(0, 5, "Course Information", 0, 'L', 1, 'T', 14, 'BIU');
        $this->pdf->ln($this->gap);

        $this->addCell(55, 0, "Course Name: ", 0, 'L', 0, 'T', $this->fontsize, 'B');
        // dd($this->admform->course->subjects);
        $this->addCell(($this->pageWidth / 2) - 50, 0, $this->admform->course->course_name, 0, 'L', 1, 'T', $this->fontsize, '');
        $this->pdf->ln($this->gap);

        //medium

        $this->addCell(55, 0, "Medium: ", 0, 'L', 0, 'T', $this->fontsize, 'B');
        $this->addCell(($this->pageWidth / 2) - 50, 0, $this->admform->medium, 0, 'L', 1, 'T', $this->fontsize);
        $this->pdf->ln($this->gap);

        //selected Subjects
        $this->addCell(55, 0, "Selected Subjects: ", 0, 'L', 0, 'T', $this->fontsize, 'B');
        $this->addCell(($this->pageWidth / 2) - 50, 0, 'Compulsory (as per syllabus)', 0, 'L', 1, 'T', $this->fontsize, 'BU');
        $this->pdf->ln($this->gap);
        
        $count = [];
        for ($i=1; $i <= 6 ;$i++) {
            $count[$i] = 0;
            foreach ($this->getCompSubject() as $cmp) {
                if ($cmp->semester == $i) {
                    if ($count[$i] == 0) {
                        $this->addCell(55, 0, "Semester ". $i, 0, 'L', 1, 'T', $this->fontsize, 'B');
                    }
                    $count[$i]++;

                    $this->addCell(55, 0, "", 0, 'L', 0, 'T', $this->fontsize, '');
                    $this->addMCell(($this->pageWidth / 2) - 50, 0, $count[$i].'. '.$cmp->subject->subject, 0, 'L', 1, 'T', $this->fontsize, '');
                    $this->pdf->ln($this->gap);
                }
            }
        }
        

        $this->addMCell(55, 0, 'Subjects:', 0, 'L', 1, 'T', $this->fontsize, 'B');
        foreach ($this->getCompSubject() as $key=>$cmp) {
            $sr_no = $key+1;
            if ($cmp->semester == '') {
                $this->addCell(55, 0, "", 0, 'L', 0, 'T', $this->fontsize, '');
                $this->addMCell(($this->pageWidth / 2) - 50, 0, $sr_no.'. '.$cmp->subject->subject, 0, 'L', 1, 'T', $this->fontsize, '');
                $this->pdf->ln($this->gap);
            }
        }

        foreach ($this->getOptSubjects('C') as $opt) {
            $this->addCell(55, 0, "", 0, 'L', 0, 'T', $this->fontsize, '');
            $this->addCell(30, 0, $opt->subject->subject, 0, 'L', 1, 'T', $this->fontsize, '');
        }
        $this->pdf->ln($this->gap);
        // $this->addCell(55, 0, "", 0, 'L', 0, 'T', $this->fontsize, 'B');
        $pdf->setX($pdf->getX() + 55);

        $this->addCell(($this->pageWidth / 2) - 50, 0, 'Electives', 0, 'L', 1, 'T', $this->fontsize, 'BU');
        $has_honours = 'N';
        foreach ($this->getOptSubjects() as $opt) {
            if ($this->admform->course->honours_link == 'Y' || ($this->admform->course->honours_link == 'N' && $opt->course_subject && $opt->course_subject->honours == 'N')) {
                $this->addCell(55, 0, "", 0, 'L', 0, 'T', $this->fontsize, '');
                $this->addCell(30, 0, $opt->subject->subject, 0, 'L', 1, 'T', $this->fontsize, '');
            }
            if ($this->admform->course->honours_link == 'N' && $opt->course_subject && $opt->course_subject->honours == 'Y') {
                $has_honours = 'Y';
            }
        }

        if ($this->admform->course_id == 14) {
            $pdf->setX($pdf->getX() + 55);
            $this->addCell(($this->pageWidth / 2) - 50, 0, 'Subject Preferences', 0, 'L', 1, 'T', $this->fontsize, 'BU');
            // foreach ($this->getSubPrferences() as $pref) {
            //     $this->addCell(55, 0, 'Preference '.$pref->preference_no, 0, 'L', 0, 'T', $this->fontsize, '');
            //     $this->addCell(30, 0, $pref->preference, 0, 'L', 1, 'T', $this->fontsize, '');
            // }
            // $combination_ids = AdmisssionSubCombination::where('admission_id','=',$this->admform->id)->pluck('sub_combination_id')->toArray();
            $subs = SubjectCombinationDetail::join('sub_combination','sub_combination_dets.sub_combination_id','=','sub_combination.id')
                        ->join('admission_sub_combination','sub_combination.id','=','admission_sub_combination.sub_combination_id')
                        ->join(getSharedDb().'subjects','subjects.id','=','sub_combination_dets.subject_id')
                        ->select('sub_combination.id','sub_combination.combination','sub_combination.code','admission_sub_combination.preference_no',
                        DB::raw("group_concat(subjects.subject) as subject") )->groupBy('sub_combination.id','sub_combination.combination')->where('admission_id','=',$this->admform->id)->get()->toArray();
                        // dd($subs);
            foreach ($subs as $sub) {
                $this->addCell(55, 0, 'Preference '.$sub['preference_no'], 0, 'L', 0, 'T', $this->fontsize, '');
                $this->addCell(30, 0, $sub['code'].':- '. $sub['subject'], 0, 'L', 1, 'T', $this->fontsize, '');
            }
        }
        

        $pdf->setX($pdf->getX() + 35);

        if (count($this->admform->honours) > 0) {
            $this->addCell(($this->pageWidth / 2) - 80, 0, 'Preference', 0, 'L', 0, 'T', $this->fontsize, 'B');
        } else {
            $pdf->setX($pdf->getX() + 20);
        }
        $this->addCell(($this->pageWidth / 2) - 50, 0, 'Honours', 0, 'L', 1, 'T', $this->fontsize, 'BU');

        $old_hon_sub = [];
        if ($this->admform->lastyr_rollno && $this->admform->course->course_year > 1) {
            $student_data = \App\PrvStudent::where('roll_no', $this->admform->lastyr_rollno)->first();
            if ($student_data) {
                $old_hon_sub = $student_data->getOldHonSub();
            }
            if (count($old_hon_sub) > 0) {
                $this->addCell(55, 0, "", 0, 'L', 0, 'T', $this->fontsize, '');
                $this->addCell(($this->pageWidth / 2) - 50, 0, $old_hon_sub[0]->subject, 0, 'L', 1, 'T', $this->fontsize, '');
            }
        }
        if (count($this->admform->honours) < 1 && $has_honours == 'N' && count($old_hon_sub) == 0) {
            $pdf->setX($pdf->getX() + 55);
            $this->addCell(($this->pageWidth / 2) - 50, 0, 'No Honours Subjects', 0, 'L', 1, 'T', $this->fontsize, '');
        }
        if ($this->admform->course->honours_link == 'Y') {
            foreach ($this->admform->honours as $honour) {
                $pdf->setX($pdf->getX() + 35);

                $this->addCell(($this->pageWidth / 2) - 80, 0, $honour->preference, 0, 'C', 0, 'T', $this->fontsize, '');
                $this->addCell(30, 0, $honour->subject->subject, 0, 'L', 1, 'T', $this->fontsize, '');
            }
        } else {
            foreach ($this->getOptSubjects() as $opt) {
                if ($opt->course_subject && $opt->course_subject->honours == 'Y') {
                    $pdf->setX($pdf->getX() + 55);
                    $this->addCell(30, 0, $opt->subject->subject, 0, 'L', 1, 'T', $this->fontsize, '');
                }
            }
        }
        // add on course
        $pdf->setX($pdf->getX() + 55);
        $this->addCell(($this->pageWidth / 2) - 50, 0, 'Add-On course', 0, 'L', 1, 'T', $this->fontsize, 'BU');
        if ($this->admform->addOnCourse) {
            $this->addCell(55, 0, "", 0, 'L', 0, 'T', $this->fontsize, '');
            $this->addCell(30, 0, $this->admform->addOnCourse->course_name, 0, 'L', 1, 'T', $this->fontsize);
        }

        if ($this->admform->course->course_year == 2) {
            $this->addCell(0, 5, "Note: Honours subject will be allotted in BA / BSc / BCom in third semester on merit basis at the time of admission in the College.", 0, 'L', 1, 'T', 10, 'B');
        }

        $this->pdf->ln($this->gap);
        if (count($this->getCompSubject()) >= 12) {
            // Page number
            $this->SetYPos(-8);
            $this->addCell(0, 5, 'Page ' . $this->getPageNo(), 0, 'R', 1, 'T', 10, 'B');
            /************************************NEW PAGE STARTS HERE ************************** */
            $this->addNewPage('P', 'A4');
        }

        $this->addCell(0, 5, "Academic Record", 0, 'L', 1, 'T', 14, 'BIU');
        $this->pdf->ln($this->gap);
        
        $this->addMCell(22, 15, "Examination Passed", 1, 'C', 0, 'M', '', 'B');
        $this->addMCell(25, 15, "Board/ University ", 1, 'C', 0, 'M', '', 'B');
        $this->addMCell(18, 15, "School/ College ", 1, 'C', 0, 'M', '', 'B');
        $this->addMCell(18, 15, "Roll No.", 1, 'C', 0, 'M', '', 'B');
        $this->addMCell(15, 15, "Year of Passing ", 1, 'C', 0, 'M', '', 'B');
        $this->addMCell(20, 15, "Marks Obtained/Max marks. ", 1, 'C', 0, 'M', '', 'B');
        $this->addMCell(15, 15, "Division ", 1, 'C', 0, 'M', '', 'B');
        $this->addMCell(19, 15, "Percentage ", 1, 'C', 0, 'M', '', 'B');
        $this->addMCell(18, 15, "Subjects Studied ", 1, 'C', 0, 'M', '', 'B');
        $this->addMCell(22, 15, "Result/Reappear Subject(s) ", 1, 'C', 1, 'M', '', 'B');

        $count_acade = 1;
        foreach ($this->admform->academics as $academic) {
            if ($academic->cgpa == 'Y') {
                $marks = $academic->marks_obtained . ' / ' . $academic->total_marks .' (CGPA)';
            } else {
                $marks = $academic->marks_obtained . ' / ' . $academic->total_marks;
            }
            $this->addMCell(22, 20, $academic->exam, 1, 'C', 0, 'M', '', '');
            $this->addMCell(25, 20, ($academic->board) ? $academic->board->name : $academic->other_board, 1, 'C', 0, 'M', '', '');
            $this->addMCell(18, 20, $academic->intitute_state ?  $academic->institute . ', ' .  $academic->intitute_state->state : $academic->institute, 1, 'C', 0, 'M', '', '');
            $this->addMCell(18, 20, $academic->rollno, 1, 'C', 0, 'M', '', '');
            $this->addMCell(15, 20, $academic->year, 1, 'C', 0, 'M', '', '');
            $this->addMCell(20, 20, $marks, 1, 'C', 0, 'M', '', '');
            $this->addMCell(15, 20, $academic->division, 1, 'C', 0, 'M', '', '');
            $this->addMCell(19, 20, $academic->marks_per, 1, 'C', 0, 'M', '', '');
            $this->addMCell(18, 20, $academic->subjects, 1, 'C', 0, 'M', '', '');
            $this->addMCell(22, 20, $academic->result == "COMPARTMENT" ? $academic->reappear_subjects : $academic->result, 1, 'C', 1, 'M', '', '');

            $count_acade++;
            if ($count_acade == 10) {
                break;
            }
        }

        if (count($this->admform->academics) >= 3 && $this->admform->course->status == 'PGRAD' || count($this->getCompSubject()) >= 10 && $this->admform->course->status == 'PGRAD') {
            // Page number
            $this->SetYPos(-8);
            $this->addCell(0, 5, 'Page ' . $this->getPageNo(), 0, 'R', 1, 'T', 10, 'B');
            /************************************NEW PAGE STARTS HERE ************************** */
            $this->addNewPage('P', 'A4');
        }
        if ($this->admform->course->status == 'PGRAD') {
            $this->pdf->ln(4);
            $this->addCell(0, 5, "FOR POSTGRADUATE STUDENTS ONLY*", 0, 'C', 1, 'T', 11, 'B');
            $this->addCell(0, 5, "(Details of the Subject in which applying for Masters)", 0, 'C', 1, 'T', 9, 'BIU');
            $this->pdf->ln($this->gap);

            $this->addMCell(48, 10, " ", 1, 'C', 0, 'M', '', 'B');
            $this->addMCell(65, 10, "Subject", 1, 'C', 0, 'M', '', 'B');
            $this->addMCell(25, 10, "Marks ", 1, 'C', 0, 'M', '', 'B');
            $this->addMCell(25, 10, "Max. marks ", 1, 'C', 0, 'M', '', 'B');
            $this->addMCell(25, 10, "Percentage", 1, 'C', 1, 'M', '', 'B');

            $class = $this->admform->becholorDegreeDetails ? $this->admform->becholorDegreeDetails->bechelor_degree : "..........";
            $this->addMCell(48, 10, "Bachelor's Degree \nClass " . $class, 1, 'C', 0, 'M', '', 'B');
            $this->addMCell(65, 10, $this->admform->becholorDegreeDetails ? $this->admform->becholorDegreeDetails->subjects : '', 1, 'C', 0, 'M', '', '');
            $this->addMCell(25, 10, $this->admform->becholorDegreeDetails ? $this->admform->becholorDegreeDetails->marks_obtained : '', 1, 'C', 0, 'M', '', '');
            $this->addMCell(25, 10, $this->admform->becholorDegreeDetails ? $this->admform->becholorDegreeDetails->total_marks : '', 1, 'C', 0, 'M', '', '');
            $this->addMCell(25, 10, $this->admform->becholorDegreeDetails ? $this->admform->becholorDegreeDetails->percentage : '', 1, 'C', 1, 'M', '', '');

            $this->addMCell(48, 10, "Honours", 1, 'C', 0, 'M', '', 'B');
            $this->addMCell(65, 10, $this->admform->becholorDegreeDetails ? $this->admform->becholorDegreeDetails->honour_subject : '', 1, 'C', 0, 'M', '', '');
            $this->addMCell(25, 10, $this->admform->becholorDegreeDetails ? $this->admform->becholorDegreeDetails->honour_marks : '', 1, 'C', 0, 'M', '', '');
            $this->addMCell(25, 10, $this->admform->becholorDegreeDetails ? $this->admform->becholorDegreeDetails->honour_total_marks : '', 1, 'C', 0, 'M', '', '');
            $this->addMCell(25, 10, $this->admform->becholorDegreeDetails ? $this->admform->becholorDegreeDetails->honour_percentage : '', 1, 'C', 1, 'M', '', '');

            $this->addMCell(48, 15, "Elective \n (Aggregate of 6 Semesters\nin Subject applied for)", 1, 'C', 0, 'M', '', 'B');
            $this->addMCell(65, 15, $this->admform->becholorDegreeDetails ? $this->admform->becholorDegreeDetails->elective_subject : '', 1, 'C', 0, 'M', '', '');
            $this->addMCell(25, 15, $this->admform->becholorDegreeDetails ? $this->admform->becholorDegreeDetails->ele_obtained_marks : '', 1, 'C', 0, 'M', '', '');
            $this->addMCell(25, 15, $this->admform->becholorDegreeDetails ? $this->admform->becholorDegreeDetails->ele_total_marks : '', 1, 'C', 0, 'M', '', '');
            $this->addMCell(25, 15, $this->admform->becholorDegreeDetails ? $this->admform->becholorDegreeDetails->ele_percentage : '', 1, 'C', 1, 'M', '', '');
            $this->addMCell(188, 5, "Old Student Seeking Admission in Semester III  ", 1, 'C', 1, 'M', '', 'B');

            $this->addMCell(48, 10, "PG Semester I", 1, 'C', 0, 'M', '', 'B');
            $this->addMCell(65, 10, $this->admform->becholorDegreeDetails ? $this->admform->becholorDegreeDetails->pg_sem1_subject : '', 1, 'C', 0, 'M', '', '');
            $this->addMCell(25, 10, $this->admform->becholorDegreeDetails ? $this->admform->becholorDegreeDetails->pg_sem1_obtained_marks : '', 1, 'C', 0, 'M', '', '');
            $this->addMCell(25, 10, $this->admform->becholorDegreeDetails ? $this->admform->becholorDegreeDetails->pg_sem1_total_marks : '', 1, 'C', 0, 'M', '', '');
            $this->addMCell(25, 10, $this->admform->becholorDegreeDetails ? $this->admform->becholorDegreeDetails->pg_sem1_percentage : '', 1, 'C', 1, 'M', '', '');
            $this->addMCell(48, 10, "PG Semester II", 1, 'C', 0, 'M', '', 'B');
            $this->addMCell(65, 10, $this->admform->becholorDegreeDetails ? $this->admform->becholorDegreeDetails->pg_sem2_subject : '', 1, 'C', 0, 'M', '', '');
            if ($this->admform->becholorDegreeDetails) {
                if ($this->admform->becholorDegreeDetails->pg_sem2_result == "PASS") {
                    $this->addMCell(25, 10, $this->admform->becholorDegreeDetails ? $this->admform->becholorDegreeDetails->pg_sem2_obtained_marks : '', 1, 'C', 0, 'M', '', '');
                    $this->addMCell(25, 10, $this->admform->becholorDegreeDetails ? $this->admform->becholorDegreeDetails->pg_sem2_total_marks : '', 1, 'C', 0, 'M', '', '');
                    $this->addMCell(25, 10, $this->admform->becholorDegreeDetails ? $this->admform->becholorDegreeDetails->pg_sem2_percentage : '', 1, 'C', 1, 'M', '', '');
                } else {
                    $this->addMCell(75, 10, $this->admform->becholorDegreeDetails ? $this->admform->becholorDegreeDetails->pg_sem2_result : '', 1, 'C', 1, 'M', '', '');
                }
            } else {
                $this->addMCell(75, 10, '', 1, 'C', 1, 'M', '', '');
            }
            // dd($this->admform);
            $this->pdf->ln(3);
        
            $this->addCell(0, 2, "For Admission to MSC I Chemistry", 0, 'L', 1, 'T', 11, 'IB');
            $this->addCell(($this->pageWidth / 2) - 79, 5, "OCET Roll No.", 0, 'L', 0, 'T', 9, '');
            $this->addCell(($this->pageWidth / 2) - 68, 5, "____________________", 0, 'L', 0, 'T', 9, '');
            $this->addCell(($this->pageWidth / 2) - 93, 5, "Score", 0, 'L', 0, 'T', 9, '');
            $this->addCell(($this->pageWidth / 2) - 83, 5, "__________", 0, 'L', 0, 'T', 9, '');
            $this->addCell(($this->pageWidth / 2) - 62, 5, "50% of the marks in OCET", 0, 'L', 0, 'T', 9, '');
            $this->addCell(($this->pageWidth / 2) - 68, 5, "____________________", 0, 'L', 0, 'T', 9, '');
            $this->addCell(($this->pageWidth / 2) - 68, 5, "50% of the marks in BSc", 0, 'L', 0, 'T', 9, '');
            $this->addCell(0, 5, "_____", 0, 'L', 1, 'T', 12, '');
            $this->pdf->Line($this->lm, $this->pdf->getY(), $this->pageWidth + $this->lm, $this->pdf->getY());
        }
        
        
        // ****************************************FOREIGN ONLY************************************************/

        $this->pdf->ln(1);
        if (count($this->admform->academics) >= 3) {
            // Page number
            $this->SetYPos(-8);
            $this->addCell(0, 5, 'Page ' . $this->getPageNo(), 0, 'R', 1, 'T', 10, 'B');

            /************************************NEW PAGE STARTS HERE ************************** */
            $this->addNewPage('P', 'A4');
        }

        $this->pdf->ln(2);
        
        $this->addCell(0, 5, "FOR FOREIGN STUDENTS ONLY", 0, 'C', 1, 'T', 11, 'B');
        $this->pdf->ln($this->gap);
        // dd($this->admform);
        $this->addCell(($this->pageWidth / 2) - 65, 5, "Citizen of", 0, 'L', 0, 'T', 10, '');
        $this->addCell(($this->pageWidth / 2) - 70, 5, $this->admform->foreign_national == 'Y' ? $this->admform->nationality : 'NA', 0, 'L', 0, 'T', 10, 'B');
        $this->addCell(($this->pageWidth / 2) - 65, 5, "Passport No.", 0, 'L', 0, 'T', 10, '');
        $this->addCell(($this->pageWidth / 2) - 70, 5, $this->admform->foreign_national == 'Y' ? $this->admform->passportno : 'NA', 0, 'L', 0, 'T', 10, 'B');
        $this->addCell(($this->pageWidth / 2) - 65, 5, "Valid Upto", 0, 'L', 0, 'T', 10, '');
        $this->addCell(0, 5, $this->admform->foreign_national == 'Y' ? $this->admform->passport_validity : 'NA', 0, 'L', 1, 'T', 10, 'B');
        $this->pdf->ln($this->gap);

        $this->addCell(($this->pageWidth / 2) - 65, 5, "Student Visa No.", 0, 'L', 0, 'T', 10, '');
        $this->addCell(($this->pageWidth / 2) - 70, 5, $this->admform->foreign_national == 'Y' ? $this->admform->visa : 'NA', 0, 'L', 0, 'T', 10, 'B');
        $this->addCell(($this->pageWidth / 2) - 65, 5, "Valid Upto ", 0, 'L', 0, 'T', 10, '');
        $this->addCell(($this->pageWidth / 2) - 70, 5, $this->admform->foreign_national == 'Y' ? $this->admform->visa_validity : 'NA', 0, 'L', 0, 'T', 10, 'B');
        $this->addCell(($this->pageWidth / 2) - 65, 5, "Residential Permit No", 0, 'L', 0, 'T', 10, '');
        $this->addCell(0, 5, $this->admform->foreign_national == 'Y' ? $this->admform->res_permit : 'NA', 0, 'L', 1, 'T', 10, 'B');
        $this->pdf->ln($this->gap);

        $this->addCell(($this->pageWidth / 2) - 65, 5, "Permit validity", 0, 'L', 0, 'T', 10, '');
        $this->addCell(($this->pageWidth / 2) - 70, 5, $this->admform->foreign_national == 'Y' ? $this->admform->res_validity : 'NA', 0, 'L', 0, 'T', 10, 'B');
        $this->addCell(($this->pageWidth / 2) - 65, 5, "ICSSR Sponsor ", 0, 'L', 0, 'T', 10, '');
        $this->addCell(($this->pageWidth / 2) - 70, 5, $this->admform->foreign_national == 'Y' ? ($this->admform->icssr_sponser == 'Y' ? 'Yes' : 'No') : 'NA', 0, 'L', 0, 'T', 10, 'B');
        $this->addCell(($this->pageWidth / 2) - 65, 5, "Equivalence Certificate", 0, 'L', 0, 'T', 10, '');
        $this->addCell(0, 5, $this->admform->foreign_national == 'Y' ? ($this->admform->equivalence_certificate == 'Y' ? 'Yes' : 'No') : 'NA', 0, 'L', 1, 'T', 10, 'B');
        $this->pdf->ln(8);

        $this->addCell(0, 5, "(Name & Signature of Dean, Foreign Students)", 0, 'R', 1, 'T', 10, 'B');
        $this->pdf->ln($this->gap);
        $this->pdf->Line($this->lm, $this->pdf->getY(), $this->pageWidth + $this->lm, $this->pdf->getY());
        $this->pdf->ln($this->gap);


        if (count($this->admform->academics) < 3) {
            // Page number
            $this->SetYPos(-8);
            $this->addCell(0, 5, 'Page ' . $this->getPageNo(), 0, 'R', 1, 'T', 10, 'B');

            /************************************NEW PAGE STARTS HERE ************************** */
            $this->addNewPage('P', 'A4');
        }

        //********************************************** MIGRATION ONLY**********************************************/
        $this->pdf->ln(2);
        $this->addCell(0, 5, "FOR MIGRATION CASES ONLY", 0, 'C', 1, 'T', 11, 'B');
        $this->pdf->ln($this->gap);
        // dd($this->admform);
        $this->addCell(($this->pageWidth / 2) - 55, 5, "Migration certificate", 0, 'L', 0, 'T', 10, '');
        $this->addCell(($this->pageWidth / 2) - 70, 5, $this->admform->migration == 'Y' ? $this->admform->migration_certificate == 'W' ? 'AWaited' : 'Attached' : 'NA', 0, 'L', 1, 'T', 10, 'B');
        $this->pdf->ln($this->gap);

        $this->addCell(($this->pageWidth / 2) - 55, 5, "Former Board / University.", 0, 'L', 0, 'T', 10, '');
        $this->addCell(($this->pageWidth / 2) - 70, 5, $this->admform->migration == 'Y' ? $this->admform->migrate_from : '', 0, 'L', 0, 'T', 10, 'B');
        $this->addCell(($this->pageWidth / 2) - 55, 5, "Deficient Subject(s) ", 0, 'L', 0, 'T', 10, '');
        $this->addCell(($this->pageWidth / 2) - 70, 5, $this->admform->migration == 'Y' ? $this->admform->migrate_deficient_sub : '', 0, 'L', 1, 'T', 10, 'B');
        $this->pdf->ln(2);

        $this->addMCell(0, 5, "In case of deficient subjects you have to clear the subjects within the permissible chances.", 0, 'L', 0, 'T', 10, '');

        $this->pdf->ln(17);
        $this->addCell(($this->pageWidth / 2) - 50, 5, "(Signature of Student)", 0, 'L', 0, 'T', 10, '');
        $this->addCell(($this->pageWidth / 2) - 50, 5, "(Signature of Parent/Guardian)", 0, 'L', 0, 'T', 10, '');
        $this->addCell(0, 5, "(Name & Signature of Dean, Migration)", 0, 'R', 1, 'T', 10, 'B');
        $this->pdf->ln($this->gap);
        $this->pdf->Line($this->lm, $this->pdf->getY(), $this->pageWidth + $this->lm, $this->pdf->getY());

        $this->pdf->ln($this->gap);
        /*************************************MIGRATION ENDS HERE**********************************/





        // //********************************************** ALUMANI ONLY**********************************************/
        // $this->pdf->ln(2);
        // $this->addCell(0, 5, "ALUMNI ", 0, 'C', 1, 'T', 11, 'B');
        // $this->addCell(0, 5, "(Ex-Students of Mehr Chand Mahajan DAV College for Women) ", 0, 'C', 1, 'T', 10, 'B');
        // $this->pdf->ln($this->gap);
        // // dd($this->admform);
        // $this->addCell(($this->pageWidth / 2) - 10, 5, "Is any one of your relatives an ex-student of this College?", 0, 'L', 0, 'T', 10, '');
        // $this->addCell(0, 5, $this->admform->alumani ? 'Yes' : 'No', 0, 'L', 1, 'T', 10, 'B');
        // $this->pdf->ln($this->gap);

        // $this->addCell(($this->pageWidth / 2) - 55, 5, "Name", 0, 'L', 0, 'T', 10, '');
        // $this->addCell(($this->pageWidth / 2) - 70, 5, $this->admform->alumani  ? $this->admform->alumani->name : 'NA', 0, 'L', 0, 'T', 10, 'B');
        // $this->addCell(($this->pageWidth / 2) - 55, 5, "Passing out Year ", 0, 'L', 0, 'T', 10, '');
        // $this->addCell(($this->pageWidth / 2) - 70, 5, $this->admform->alumani  ? $this->admform->alumani->passing_year : 'NA', 0, 'L', 1, 'T', 10, 'B');
        // $this->pdf->ln($this->gap);

        // $this->addCell(($this->pageWidth / 2) - 55, 5, "Occupation", 0, 'L', 0, 'T', 10, '');
        // $this->addCell(($this->pageWidth / 2) - 70, 5, $this->admform->alumani  ? $this->admform->alumani->occupation : 'NA', 0, 'L', 0, 'T', 10, 'B');
        // $this->addCell(($this->pageWidth / 2) - 55, 5, "Designation ", 0, 'L', 0, 'T', 10, '');
        // $this->addCell(($this->pageWidth / 2) - 70, 5, $this->admform->alumani  ? $this->admform->alumani->designation : 'NA', 0, 'L', 1, 'T', 10, 'B');
        // $this->pdf->ln($this->gap);

        // $this->addCell(($this->pageWidth / 2) - 55, 5, "Contact No.", 0, 'L', 0, 'T', 10, '');
        // $this->addCell(($this->pageWidth / 2) - 70, 5, $this->admform->alumani  ? $this->admform->alumani->contact : 'NA', 0, 'L', 0, 'T', 10, 'B');
        // $this->addCell(($this->pageWidth / 2) - 55, 5, "E-mail ID", 0, 'L', 0, 'T', 10, '');
        // $this->addCell(($this->pageWidth / 2) - 70, 5, $this->admform->alumani  ? $this->admform->alumani->email : 'NA', 0, 'L', 1, 'T', 10, 'B');
        // $this->pdf->ln($this->gap);

        // $this->addCell(($this->pageWidth / 2) - 55, 5, "Any Other Information", 0, 'L', 0, 'T', 10, '');
        // $this->addMCell(($this->pageWidth / 2) - 70, 5, $this->admform->alumani  ? $this->admform->alumani->other : 'NA', 0, 'L', 1, 'T', 10, '');
        // $this->pdf->ln($this->gap);

        $this->pdf->Line($this->lm, $this->pdf->getY(), $this->pageWidth + $this->lm, $this->pdf->getY());
        $this->pdf->ln(3);
        $this->addMCell(0, 5, "Certified that the admission form has been checked and the student has been found eligible for admission to " . $this->admform->course->course_name . " " . "class provisionally. \n", 0, 'C ', 1, 'T', $this->fontsize, '');
        $this->pdf->ln(8);

        $this->addCell(($this->pageWidth / 2) + 25, 5, "Date:.....................", 0, 'L', 0, 'T', 10, '');
        $this->addCell(($this->pageWidth / 2) - 55, 5, "Signature of the Scrutineer:...............................", 0, 'L', 1, 'T', 10, '');
        $pdf->setX($pdf->getX() + 130);
        $this->addCell(($this->pageWidth / 2) - 55, 5, "Name of the Scrutineer:................................", 0, 'L', 1, 'T', 10, '');

        $this->addCell(($this->pageWidth / 2) - 50, 5, "(Recommended  for Provisional Admission)....................................", 0, 'L', 0, 'T', 10, '');
        $this->addCell(($this->pageWidth / 2) - 55, 5, "", 0, 'L', 0, 'T', 10, '');
        $this->pdf->ln(12);
        $this->addCell(($this->pageWidth / 2) - 50, 5, "Name & Signature of Convener, Admission Committee", 0, 'L', 0, 'T', 10, '');
        $this->addCell(($this->pageWidth / 2) - 55, 5, "", 0, 'L', 0, 'T', 10, '');
        $this->addCell(0, 5, "(Signature of Principal/Dean, Admissions)", 0, 'R', 1, 'T', 10, 'B');
        $this->addCell(0, 5, "..........................................................", 0, 'R', 1, 'T', 10, 'B');
        $this->pdf->ln($this->gap);
        $this->pdf->Line($this->lm, $this->pdf->getY(), $this->pageWidth + $this->lm, $this->pdf->getY());

        /*************************************MIGRATION ENDS HERE**********************************/

        if (count($this->admform->academics) >= 5) {
            // Page number
            $this->SetYPos(-8);
            $this->addCell(0, 5, 'Page ' . $this->getPageNo(), 0, 'R', 1, 'T', 10, 'B');

            /************************************NEW PAGE STARTS HERE ************************** */
            $this->addNewPage('P', 'A4');
        }
        /*************************************DOCUMENTS TO BE ATTACHED************************** */
        $this->addCell(0, 5, "DOCUMENTS TO BE ATTACHED ", 0, 'C', 1, 'T', 11, 'B');
        $this->addCell(0, 5, "1. Students must bring their original documents whenever notified by the College authorities.", 0, 'L', 1, 'T', 10, '');
        $this->addCell(0, 5, "2. Attach one extra photograph with the form.", 0, 'L', 1, 'T', 10, '');
        $this->addCell(0, 5, "3. New students should upload following documents in original:", 0, 'L', 1, 'T', 10, 'B');
        $this->pdf->ln($this->gap);
        $left_column = "i) \t\tDetailed Marks Certificate of all the results" . "\n\t\t\t\t\t\t\t" . "mentioned in the Academic Record column." . "\n" .
            "ii)  Date of Birth Certificate." . "\n" .
            "iii)\tCharacter Certificate by College/School last" . "\n\t\t\t\t\t\t" . "attended." . "\n" .
            "iv)\tProof for seeking exemption in Punjabi " . "\n\t\t\t\t\t\t" . "Compulsory.(Class X Marksheet)" . "\n" .
            "" . "\t\t\t\t\t\t" . "(only for Undergraduate Students)" . "\n" .
            "v)\t\tANTI-RAGGING UNDERTAKING, at the end of the form, must be signed by students and Parents/Guardians" . "\n" .
            "vi)\t\tAffidavit:" . "\n" .
            "\t\t\t\t\ta) Gap year (if Any)" . "\n" .
            "\t\t\t\t\tb) Girl Child Affidavit (on a stamp paper worth Rs. " . "\n\t\t\t\t\t" . "20/-) duly attested by a first class magistrate. Parents " . "\t\t\t\t\t" . "must declare that the benefit is being obtained for " . "\n\t\t\t\t\t" . "only one girl child in case of two girl children." . "\n" .
            "\n";
        $right_column = "\t\t\t\t\t\tc) Reserved Category (if any)." . "\n" .
            "vii)\t\tRelevant Certificates required (if applicable):" . "\n" .
            "\t\t\t\t\t\ta) Migration Certificate (for students of the other " . "\n\t\t\t\t\t\t" . "Boards / Universities). Check College prospectus for more details." . "\n" .
            "\t\t\t\t\t\tb) Cancer, AIDS and Thalassaemia patients seeking addmission must " . "\t\t\t\t\t\t" . "attach a certificate of proof from National  " . "\n\t\t\t\t\t" . "Medical Institutes like PGI, AIIMS etc." . "\n" .
            "\t\t\t\t\t\tc) Achievement in sports if seeking admission " . "\n\t\t\t\t\t\t" . "against sports seat." . "\n" .
            "\t\t\t\t\t\td) Eligibility Certificate (for foreign students only)." . "\n" .
            "\t\t\t\t\t\te) BPL Certificate (if Applicable)." . "\n" .

            "viii)\tStudents seeking admission in Postgraduate " . "\n\t\t\t\t\t\t" . "Course Semester I must attach :" . "\n" .
            "\t\t\t\t\t\ta) Detailed mark sheets of all the six semesters of " . "\n\t\t\t\t\t\t" . " the graduate  degree." . "\n" .
            "\t\t\t\t\t\tb) Honours mark sheet must also be attached with " . "\n\t\t\t\t\t\t" . "the admission form." . "\n" .
            "\n";

        // MultiCell($w, $h, $txt, $border=0, $align='J', $fill=0, $ln=1, $x='', $y='', $reseth=true, $stretch=0, $ishtml=false, $autopadding=true, $maxh=0)

        // set color for background
        // $pdf->SetFillColor(255, 255, 200);
        // set color for text
        // $pdf->SetTextColor(0, 63, 127);
        // set color for background
        // $pdf->SetFillColor(215, 235, 255);
        $pdf->setX($pdf->getX() + 5);
        // write the first column
        $pdf->MultiCell(82, 0, $left_column, 0, 'J', 0, 0, '', '', true, 0, false, true, 0);
        $pdf->setX($pdf->getX() + 10);
        // $pdf->setX($pdf->getX() + 2);

        // write the second column
        $pdf->MultiCell(82, 0, $right_column, 0, 'J', 0, 1, '', '', true, 0, false, true, 0);
        $this->addCell(0, 3, "4 . Old students should upload Detailed Marks Sheets of all preceding semester examinations.", 0, 'L', 1, 'T', 10, '');

        $this->pdf->ln($this->gap);
        // MultiCell($w, $h, $txt, $border=0, $align='J', $fill=0, $ln=1, $x='', $y='', $reseth=true, $stretch=0, $ishtml=false, $autopadding=true, $maxh=0)
        $this->addCell(0, 3, "NOTE:", 0, 'L', 1, 'T', 10, 'B');
        $this->addCell(0, 3, "\t1 . The candidates should understand that the admission if granted would be provisional and subject to confirmation by Panjab University.", 0, 'L', 1, 'T', 10, '');
        $this->addCell(0, 3, "\t2 . Incomplete application form or form with incorrect, misleading or deliberately concealed information is liable to be rejected.", 0, 'L', 1, 'T', 10, '');


        /*************************************Documents to be attached ENDS HERE************ ******** */
        $this->pdf->ln(10);
        $this->SetYPos(-8);
        // Page number
        $this->addCell(0, 5, 'Page ' . $this->getPageNo(), 0, 'R', 1, 'T', 10, 'B');

        $this->addNewPage('P', 'A4');
        $this->pdf->ln(10);
        $this->addCell(0, 5, "DECLARATION", 0, 'C', 1, 'T', 12, 'B');
        $this->pdf->ln($this->gap);
        // $this->addMCell(0, 0, $this->getSNo() . "I hereby declare that I have noted all the information and instructions given in the College Prospectus.  ", 0, 'L', 1, 'T', $this->fontsize, '');
        $this->addMCell(0, 0, $this->getSNo() . "I hereby declare that I have noted all the information and instructions given in the College Prospectus.", 0, 'L', 1, 'T', $this->fontsize, '');
        $this->pdf->ln($this->gap);
        // $this->addMCell(0, 0, $this->getSNo() . "I pledge to abide by the rules and regulations of the College and the University and not to associate myself with any activity that goes against the discipline of the institution.  ", 0, 'L', 1, 'T', $this->fontsize, '');
        $this->addMCell(0, 0, $this->getSNo() . "I pledge to abide by the rules and regulations of the College and the University and not to associate myself with any activity that goes against the discipline of the Institution.", 0, 'L', 1, 'T', $this->fontsize, '');
        
        $this->pdf->ln($this->gap);
        // $this->addMCell(0, 0, $this->getSNo() . "I declare that the facts stated above are true and that I have not so far been admitted to any affiliated College in the class to which I am seeking admission in this College. ", 0, 'L', 1, 'T', $this->fontsize, '');
        $this->addMCell(0, 0, $this->getSNo() . "I declare that the facts stated above are true and that I have not so far been admitted to any affiliated College in the class to which I am seeking admission in this College.", 0, 'L', 1, 'T', $this->fontsize, '');
        
        $this->pdf->ln($this->gap);
        $this->addMCell(0, 0, $this->getSNo() . "I solemnly declare that I have not been disqualified by any University for the class that I am seeking admission to in this College.", 0, 'L', 1, 'T', $this->fontsize, '');
        // $this->addMCell(0, 0, $this->getSNo() . "I solemnly declare that I have not been disqualified by any University for the class to which I am seeking admission in this College.  ", 0, 'L', 1, 'T', $this->fontsize, '');
        
        $this->pdf->ln($this->gap);
        // $this->addMCell(0, 0, $this->getSNo() . "I will have no claim to admission if found ineligible by Panjab University.  ", 0, 'L', 1, 'T', $this->fontsize, '');
        $this->addMCell(0, 0, $this->getSNo() . "I will have no claim to admission if found ineligible by Panjab University.", 0, 'L', 1, 'T', $this->fontsize, '');
        
       
        $this->pdf->ln($this->gap);
        $this->addMCell(0, 0, $this->getSNo() . "I will adhere to all the academic rules and regulations of the College including attendance, examination, 
        internal assessment or any other requirements of the course.", 0, 'L', 1, 'T', $this->fontsize, '');
        $this->pdf->ln($this->gap);
        $this->addMCell(0, 0, $this->getSNo() . "I shall not resort to ragging in any form at any place and shall abide by the rules / laws prescribed by the 
        Government of India, Indian law and the College authorities for the purpose from time to time.", 0, 'L', 1, 'T', $this->fontsize, '');
        $this->pdf->ln($this->gap);
        $this->addMCell(0, 0, $this->getSNo() . "I will submit an Online Anti-Ragging Undertaking every academic year at the Anti-Ragging Web Portal of 
        Government of India: <b>www.antiragging.in</b>", 0, 'L', 1, 'T', $this->fontsize, '');
       

        $this->pdf->ln($this->gap);
        $this->addMCell(0, 0, "IT IS MY PERSONAL RESPONSIBILITY TO INFORM THE COLLEGE OFFICE OF ANY CHANGE IN MY ADDRESS / PHONE NUMBER OR THAT OF MY PARENTS / GUARDIANS. THE COLLEGE IS NOT RESPONSIBLE FOR ANY GAP IN COMMUNICATION IN CASE MY PERSONAL INFORMATION IS NOT UPDATED BY ME.", 0, 'L', 1, 'T', $this->fontsize, '');
        $this->pdf->ln($this->gap);
        $this->addMCell(0, 0, "All information provided by me is correct and any misrepresentation of facts / information found hereafter may lead to my expulsion from the College.  ", 0, 'L', 1, 'T', $this->fontsize, 'B');
        $this->pdf->ln(4);

        $this->addMCell($this->pageWidth / 3, 0, "Dated..........." . '', 0, 'C ', 0, 'T', $this->fontsize, 'B');

        $pdf->setX($pdf->getX() + 55);
        $email = ($std_user = $this->admform->std_user) ? $std_user->email : '';
        $file = $this->getPhoto('signature');
        if ($file) {
            $pdf->Image(storage_path() . "/app/images/signature" . '_' . $this->admform->id . '.' . $file->file_ext, 162, 110, 50, 10, '', '', '', true, 100, '', false, false, 0, false, false, false);
        }
        $this->pdf->ln(4);
        $pdf->setX($pdf->getX() + 120);
        $this->addMCell($this->pageWidth / 3, 0, "Signature of Student \n" . "Email ID: $email\n" . '', 0, 'R', 1, 'T', $this->fontsize, 'B');

        $this->pdf->Line($this->lm, $this->pdf->getY(), $this->pageWidth + $this->lm, $this->pdf->getY());
        $this->pdf->ln(2);


        $this->addCell(0, 5, "UNDERTAKING", 0, 'C', 1, 'T', 12, 'B');
        $this->pdf->ln(2);
        $this->addMCell(($this->pageWidth - 10), 0, "I, " . $this->admform->name . " seeking admission to " . $this->admform->course->course_name . " have gone through the prospectus of the College/Hostel and hereby submit that I am aware of the following rules and regulations of the College :  ", 0, 'L', 1, 'T', $this->fontsize, '');
        $this->pdf->ln($this->gap);
        $this->addMCell(($this->pageWidth - 40), 0, $this->getSNoU() . "Minimum 75% attendance in every subject (theory and practical) is mandatory.  ", 0, 'L', 1, 'T', $this->fontsize, '');
        $this->pdf->ln($this->gap);
        $this->addMCell(($this->pageWidth - 10), 0, $this->getSNoU() . "Mid-semester test is compulsory and minimum 25% marks in aggregate of all subjects in MST is required. ", 0, 'L', 1, 'T', $this->fontsize, '');
        $this->pdf->ln($this->gap);
        $this->addMCell(($this->pageWidth - 10), 0, $this->getSNoU() . "No lectures will be granted for medical leave or any other leave. The leave will only ensure that the student's name will remain on the College rolls and will not be struck off.  ", 0, 'L', 1, 'T', $this->fontsize, '');
        $this->pdf->ln($this->gap);
        $this->addMCell(($this->pageWidth - 10), 0, $this->getSNoU() . "The name of the student will be struck off the College rolls in case of absence for a continuous period of 7 days without leave from the College authorities.  ", 0, 'L', 1, 'T', $this->fontsize, '');
        $this->pdf->ln($this->gap);
        $this->addMCell(($this->pageWidth - 10), 0, $this->getSNoU() . "Non-fulfilment of any or all of the above mentioned conditions will lead to student being made private or detained in the final examination.  ", 0, 'L', 1, 'T', $this->fontsize, '');
        $this->pdf->ln($this->gap);
        $this->addMCell(($this->pageWidth - 10), 0, $this->getSNoU() . "All the academic rules and regulations of the College including those about attendance, examination, internal assessment and / or any other requirements of the course have to be adhered to by the student.  ", 0, 'L', 1, 'T', $this->fontsize, '');
        $this->pdf->ln($this->gap);
        $this->addMCell(($this->pageWidth - 10), 0, $this->getSNoU() . "All fees and dues have to be paid as per schedule notified by the College from time to time.  ", 0, 'L', 1, 'T', $this->fontsize, '');
        $this->pdf->ln($this->gap);
        $this->addMCell(($this->pageWidth - 10), 0, $this->getSNoU() . "Identity card provided by the College must always be with the student and produced by her to any faculty member, security personnel and staff on demand. ", 0, 'L', 1, 'T', $this->fontsize, '');
        $this->pdf->ln($this->gap);
        $this->addCell(($this->pageWidth - 10), 0, $this->getSNoU() . "The notice board has to be read daily and College shall not be responsible for conveying any information to an individual student.  ", 0, 'L', 1, 'T', $this->fontsize, '');
        // $this->pdf->ln($this->gap);
        $this->addMCell(($this->pageWidth - 10), 0, $this->getSNoU() . "All rules and regulations and code of conduct of the College as amended from time to time with  respect to academics, discipline, lab/workshop, library, transport, vehicle parking etc. have to be abided by the student failing which disciplinary action can be taken by the College authorities.  ", 0, 'L', 1, 'T', $this->fontsize, '');
        $this->pdf->ln($this->gap);
        $this->addMCell(($this->pageWidth - 10), 0, $this->getSNoU() . "A student is liable to be penalized for any kind of indiscipline, use of abusive language, misbehaviour, disobedience or any act of physical violence. No outsider will be allowed in the  premises to intervene on behalf of the defaulting student. The student found guilty can even be rusticated from the College.  ", 0, 'L', 1, 'T', $this->fontsize, '');
        $this->pdf->ln($this->gap);
        $this->addMCell(($this->pageWidth - 10), 0, $this->getSNoU() . "Tampering with staff vehicles will lead to strict disciplinary action against the student found guilty of doing the same. ", 0, 'L', 1, 'T', $this->fontsize, '');
        $this->pdf->ln($this->gap);
        $this->addMCell(($this->pageWidth - 10), 0, $this->getSNoU() . "The College bears no responsibility for any loss of or damage to students' vehicles or their parts/accessories.  ", 0, 'L', 1, 'T', $this->fontsize, '');
        $this->pdf->ln($this->gap);
        $this->addMCell(($this->pageWidth - 10), 0, $this->getSNoU() . "The use of mobile phones in the restricted zones of the campus will incur serious disciplinary action and may even lead to expulsion from the College. ", 0, 'L', 1, 'T', $this->fontsize, '');
        $this->pdf->ln($this->gap);
        $this->addMCell(($this->pageWidth - 10), 0, $this->getSNoU() . "The College bears no responsibility for any kind of compensation in case of any damage to or loss of cash   or valuables including mobile phone, jewellery or personal belongings.", 0, 'L', 1, 'T', $this->fontsize, '');

        $pdf->setX($pdf->getX() + 55);
        $email = ($std_user = $this->admform->std_user) ? $std_user->email : '';
        $file = $this->getPhoto('signature');
        if ($file) {
            $pdf->Image(storage_path() . "/app/images/signature" . '_' . $this->admform->id . '.' . $file->file_ext, 165, 270, 50, 10, '', '', '', true, 100, '', false, false, 0, false, false, false);
        }

        $this->pdf->ln(4);
        $this->addMCell($this->pageWidth / 2 + 90, 0, "Signature of Student \n" . "Email ID: $email\n" . '', 0, 'R', 1, 'T', $this->fontsize, 'B');

        // Page number
        $this->SetYPos(-8);
        $this->addCell(0, 5, 'Page ' . $this->getPageNo(), 0, 'R', 1, 'T', 10, 'B');


        /************************************NEW PAGE STARTS HERE ************************** */
        $this->addNewPage('P', 'A4');

        $this->addCell(0, 5, "ANTI-RAGGING UNDERTAKING", 0, 'C', 1, 'T', 12, 'B');
        $this->pdf->ln(5);
        $lastyr_rollno = $this->admform->lastyr_rollno ? $this->admform->lastyr_rollno : "____________";
        // $this->admform->submission_time
        $day = '_______________';
        $month = '____________';
        $year= '_____________';
        if($this->admform->submission_time != null){
            $timestamp = strtotime($this->admform->submission_time);
            $day = date('w', $timestamp);
            $month = date("F",$timestamp);
            $year= date("Y",$timestamp);
        }
        
        $this->addMCell(($this->pageWidth - 10), 0, "I, " . $this->admform->name . ", D/o ( Father & Mother) " . $this->admform->father_name . " & " . $this->admform->mother_name . ", Roll No." .   $lastyr_rollno . ", student of Class " . $this->admform->course->course_name . ",  seeking admission to Mehr Chand Mahajan DAV College for Women, Chandigarh, do hereby undertake on this Day ".$day ." Month ".$month ." Year ".$year." the following: ", 0, 'L', 1, 'T', $this->fontsize, '');
        $this->pdf->ln(5);
        $this->addMCell(($this->pageWidth - 10), 0, $this->getSNoRag() . "That I have carefully read and understood the UGC Regulations pertaining to Curbing the Menace of Ragging in Higher Educational Institutions, 2009 available on www.ugc.ac.in and www.antiragging.in and the directives of the Hon’ble Supreme Court on Anti-Ragging and the measures proposed to be taken in the above reference (Available at www.mcmdavcwchd.edu.in)", 0, 'L', 1, 'T', $this->fontsize, '');
        $this->pdf->ln($this->gap);
        $this->addMCell(($this->pageWidth - 10), 0, $this->getSNoRag() . "That I understand the meaning of ragging, know that ragging in any form is a punishable offence and the same is banned by the Court of Law.", 0, 'L', 1, 'T', $this->fontsize, '');
        $this->pdf->ln($this->gap);
        $this->addMCell(($this->pageWidth - 10), 0, $this->getSNoRag() . "That I am fully aware of the administrative and penal action liable to be taken against me if I am found guilty of any action [active or passive] or involved in abetment of ragging.", 0, 'L', 1, 'T', $this->fontsize, '');
        $this->pdf->ln($this->gap);
        $this->addMCell(($this->pageWidth - 10), 0, $this->getSNoRag() . "That I have not been found guilty or charged for my involvement in any kind of incident of ragging in the past. However, I am aware that I may face disciplinary action / legal proceedings including expulsion from the College, if the above statement is found to be untrue or the facts are concealed at any stage in future.", 0, 'L', 1, 'T', $this->fontsize, '');
        $this->pdf->ln($this->gap);

        // $this->addMCell(($this->pageWidth - 10), 0, "I, " . $this->admform->name . ", W/D/o Mrs./Ms  " . $this->admform->father_name . " applying for admission to " . $this->admform->course->course_name . " have read a copy of the UGC Regulations on Curbing the Menace of Ragging in Higher Educational Institutions,2009, (herein after called the 'Regulations'). ", 0, 'L', 1, 'T', $this->fontsize, '');
        // $this->pdf->ln(5);
        // $this->addMCell(($this->pageWidth - 10), 0, $this->getSNoRag() . ") I have carefully read and fully understood the provisions in the said Regulations. ", 0, 'L', 1, 'T', $this->fontsize, '');
        // $this->pdf->ln($this->gap);
        // $this->addMCell(($this->pageWidth - 10), 0, $this->getSNoRag() . ") I have, in particular, perused clause 3 of the Regulations and am aware as to what constitutes ragging.", 0, 'L', 1, 'T', $this->fontsize, '');
        // $this->pdf->ln($this->gap);
        // $this->addMCell(($this->pageWidth - 10), 0, $this->getSNoRag() . ") I have also, in particular, perused clause 7 and clause 9.1 of the Regulations and am fully aware of the penal and administrative action that is liable to be taken against me in case I am found guilty of or abetting ragging, actively or passively, or being part of a conspiracy to promote ragging.", 0, 'L', 1, 'T', $this->fontsize, '');
        // $this->pdf->ln($this->gap);
        // $this->addMCell(($this->pageWidth - 10), 0, $this->getSNoRag() . ") I hereby solemnly aver and undertake that
        // a) I will not indulge in any behaviour or act that may be constituted as ragging under clause 3 of the Regulations.
        // b) I will not participate in or abet or propagate through any act of commission or omission that may be constituted as ragging under clause 3 of the Regulations.
        // ", 0, 'L', 1, 'T', $this->fontsize, '');
        $this->pdf->ln($this->gap);
        $this->addMCell(($this->pageWidth - 10), 0, $this->getSNoRag() . ") I hereby affirm that I shall not resort to ragging in any form at any place and shall abide by the rules / laws prescribed by the Indian law, Government of India and the College authorities for the purpose, from time to time.", 0, 'L', 1, 'T', $this->fontsize, '');
        $this->pdf->ln(5);
        $this->addMCell(($this->pageWidth - 10), 0,"Anti Ragging Undertaking Reference No: ".$this->admform->antireg_ref_no, 0, 'L', 1, 'T', $this->fontsize, 'B');
        $this->pdf->ln($this->gap);
        
        
        
        $pdf->setX($pdf->getX() + 55);
        $email = ($std_user = $this->admform->std_user) ? $std_user->email : '';
        $file = $this->getPhoto('signature');
        if ($file) {
            $pdf->Image(storage_path() . "/app/images/signature" . '_' . $this->admform->id . '.' . $file->file_ext, 160, 107, 50, 10, '', '', '', true, 100, '', false, false, 0, false, false, false);
        }
        $this->pdf->ln(14);
        $this->addMCell($this->pageWidth / 2 + 90, 0, "Signature of Student ", 0, 'R', 1, 'T', $this->fontsize, 'B');
        $this->pdf->ln(2);
        $this->addMCell($this->pageWidth / 2 + 90, 0, "Email ID: ".$email, 0, 'R', 1, 'T', $this->fontsize, 'B');
        // $this->pdf->ln($this->gap);
        // $this->pdf->ln(15);
        $file = $this->getPhoto('parent_signature');
        // if ($file) {
        //     $pdf->Image(storage_path() . "/app/images/parent_signature" . '_' . $this->admform->id . '.' . $file->file_ext, 150, 115, 50, 10, '', '', '', true, 100, '', false, false, 0, false, false, false);
        // }
        // $this->addCell($this->pageWidth / 2 + 90, "Signature of Parent/Guardian", 0, 'R', 1, 'T', 10, 'B');
        // $this->pdf->ln($this->gap);
        // $this->pdf->ln(3);
        // $this->addMCell(0, 5, "It is compulsory for every student and parent to submit an Online Anti-ragging undertaking every academic year at: www.antiragging.in / www.amanmovement.org", 0, 'L', 1, 'T', 10, 'B');

        // $this->pdf->ln(8);
       
        // $this->addCell(0, 5, "STATEMENT BY PARENTS /GUARDIAN", 0, 'C', 1, 'T', 13, 'B');
        // $this->addMCell(0, 5, "We hereby affirm that we have read the rules and regulations of the College/Hostel and promise to abide by them. We assure that " . $this->admform->name . " who is seeking admission to " . $this->admform->course->course_name . " has signed the undertaking in our presence and will conform to the above- stated standards in conduct and academics.", 0, 'L', 1, 'T', 10, '');
        // $this->pdf->ln(10);
        $this->addMCell(0, 5, "I hereby fully endorse the declaration made by my child / ward.", 0, 'L', 1, 'T', 10, '');
        if ($file) {
            $pdf->Image(storage_path() . "/app/images/parent_signature" . '_' . $this->admform->id . '.' . $file->file_ext, 150, 130, 50, 10, '', '', '', true, 100, '', false, false, 0, false, false, false);
        }
        $this->addMCell($this->pageWidth / 2 + 90, 0, "\n\n Signature of Parent/Guardian ", 0, 'R', 1, 'T', $this->fontsize, 'B');
        $this->pdf->ln(2);
        // $this->addMCell(50, 0, "Date:__________________ ", 0, 'C', 1, 'T', $this->fontsize, 'B');
        // $this->pdf->ln(3);

        $this->addMCell(0, 5, "It is compulsory for every student and parent to submit an Online Anti-ragging undertaking every academic year at: www.antiragging.in / www.amanmovement.org", 0, 'L', 1, 'T', 10, '');
        $this->pdf->ln(10);

        $this->pdf->Line($this->lm, $this->pdf->getY(), $this->pageWidth + $this->lm, $this->pdf->getY());

        $this->addCell(0, 5, "For Office Use Only", 0, 'C', 1, 'T', 12, 'B');
        $this->pdf->ln(8);

        $this->addMCell($this->pageWidth / 2, 0, "Certified that the student is Eligible for Admission  to  " . $this->admform->course->course_name . "\n" . "Deficiency if any: \n", 0, 'C ', 0, 'T', $this->fontsize, '');
        $this->addMCell($this->pageWidth / 2, 0, "( Recommended for Provisional Admission )", 0, 'C', 1, 'T', $this->fontsize, '');

        $this->pdf->ln(20);

        $this->addMCell($this->pageWidth / 2, 0, "(Signature of Teacher with Date)\nName of Teacher", 0, 'C ', 0, 'T', $this->fontsize, '');
        $this->addMCell($this->pageWidth / 2, 0, "( Signature of Convener with Date )\nName Of Convener", 0, 'C', 1, 'T', $this->fontsize, '');
        $this->pdf->ln(2);

        $this->addMCell($this->pageWidth / 2, 0, "", 0, 'C ', 0, 'T', $this->fontsize, '');
        $this->addMCell($this->pageWidth / 2, 0, "Admission Committee", 0, 'C', 1, 'T', $this->fontsize, 'B');
        //Page Number
        $this->SetYPos(-8);
        $this->addCell(0, 5, 'Page ' . $this->getPageNo(), 0, 'R', 1, 'T', 10, 'B');

        $this->hight = $this->getNetHeight() - $this->footerHight;
    }

    private function setCopy($copyno)
    {
        $pdf = $this->pdf;
        $this->copyno = $copyno;
        if ($copyno == 1) {
            $this->pdf->line($this->lm + 142, $this->tm, $this->lm + 142, $this->tm + $this->getNetHeight());
            $this->setMargin("R", $this->rm + 147);
        } elseif ($copyno == 2) {
            $this->setMargin("L", $this->lm + 147);
            $this->setMargin("R", $this->rm - 147);
            $this->SetYPos($this->tm);
            $this->resetY();
        }
        $this->header();
        // $this->details();
        //    $this->footer();
    }

    private function main($title = '')
    {
        $pdf = $this->pdf;
        $this->pageno = 0;
        $this->footerHight = 20;
        do {
            $this->pageno++;
            $this->nextpage = "N";
            $this->addNewPage("P", "A4");
            $this->setCopy(0);
            //   $this->setCopy(2);
        } while ($this->nextpage == "Y");
    }

    private function getSNo()
    {
        return $this->sno++ . '.  ';
    }

    private function getSNoU()
    {
        return $this->sno_u++ . '.  ';
    }
    private function getSNoRag()
    {
        return $this->sno_rag++ . '.  ';
    }


    private function getPageNo()
    {
        return $this->page_no++ . '.  ';
    }

    private function getAttachFile($name)
    {
        //    dd($this->admform->attachments);
        if ($file = $this->admform->attachments->where('file_type', $name)->first()) {
            //      return "&#10004";
            return \TCPDF_FONTS::unichr(52);
        } else {
            return "";
        }
        //    return "&#10004";
    }
    private function getCompSubject()
    {
        return $this->admform->course->subjects->where('sub_type', 'C');
    }

    private function getOptSubjects($type = 'O')
    {
        $subjects = $this->admform->admSubs()->with(['course_subject' => function ($q) {
            $q->where('course_id', '=', $this->admform->course_id);
        }])->get();
        return $subjects->filter(function ($item, $key) use ($type) {
            if ($type == 'O') {
                if ($item->sub_group_id == 0 || data_get($item->subjectGroup, 'type', '') == $type) {
                    return true;
                }
            } elseif ($type == 'C') {
                if ($item->sub_group_id > 0 && $item->subjectGroup && $item->subjectGroup->type == $type) {
                    return true;
                }
            }
        });
    }

    private function getSubPrferences()
    {
        return AdmissionSubPreference::join(getSharedDb() . 'subjects', 'admission_sub_prefs.subject_id', '=', 'subjects.id')
            ->where('admission_id', '=', $this->admform->id)
            ->where('preference_no', '!=', 1)
            ->groupBy('admission_sub_prefs.preference_no')
            ->orderBy('admission_sub_prefs.preference_no')
            ->select(['admission_sub_prefs.preference_no', DB::raw("group_concat(subjects.subject SEPARATOR '; ') as preference")])
            ->get();
    }

    private function getPhoto($type = 'photograph')
    {
        return $this->admform->attachments->where('file_type', $type)->first();
    }
}
