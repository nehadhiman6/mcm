<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Printings;

use TCPDF;

class AdmEntrySlip extends PrintPdf
{
    protected $admentry = null;
    protected $admform = null;
    protected $pdf = null;
    protected $hight = 0;
    protected $pageno = 0;
    // protected $pageWidth = 100;
    protected $nextpage = '';
    protected $copyno = 0;
    protected $footerHight = 0;
    protected $sno = 1;
    protected $gap = .5;
    protected $fontsize = 10;
    protected $lm = 10;

    public function makepdf(\App\AdmissionEntry $adm)
    {
        $this->admentry = $adm;
        $this->admform = $adm->admform;
        $this->student = $adm->admform->student;
        $this->stduser = \App\StudentUser::findOrFail($adm->admform->std_user_id);
        $this->pdf->SetMargins($this->lm, $this->tm);
        $this->main();
        return $this->pdf;
    }

    private function header($title = '')
    {
        $pdf = $this->pdf;
        $this->addCell(0, 5, "Office Copy", 0, 'C', 1, 'T', 12, 'B');
        $this->pdf->ln(2);
        $pdf->Image(public_path("/dist/img/mcm-logo.png"), $this->lm + 2, $this->tm, 25, 25, 'PNG', '', '', true, 100, '', false, false, 0, false, false, false);
        $this->addCell(0, 5, "Date: " . $this->admentry->updated_at->format('d-m-Y'), 0, 'R', 1, 'T', 11, 'B');
        $this->pdf->ln(2);
        $this->addCell(0, 5, "Mehr Chand Mahajan DAV College For Women", 0, 'C', 1, 'T', 16, 'B');
        // $this->addCell(0, 5, "Sri Guru Gobind Singh College, Sector 26, Chandigarh", 0, 'C', 1, 'T', 13, 'B');
        $this->pdf->ln(2);
        $this->addCell(0, 5, "ADMISSION ENTRY SLIP (SESSION " . get_fy_label() . ")", 0, 'C', 1, 'T', 12, '');
        $this->pdf->ln($this->gap);

        $this->getSlipCopy();

        $this->addMCell($this->pageWidth / 2, 0, $this->admentry->user_created->name . "\n( Issued By )", 0, 'C ', 0, 'T', $this->fontsize, '');
        $this->addMCell($this->pageWidth / 2, 0, "( Candidate Signature )\n", 0, 'C', 1, 'T', $this->fontsize, '');
        $this->pdf->ln(10);


        //    if ($this->admentry->centralized == 'N') {
        //      $this->pdf->ln(5);
        //      $this->addCell(15, 0, "Note: ", 0, 'L', 0, 'T', $this->fontsize, 'B');
        //      $this->addMCell(0, 0, "The Receipt is Valid till 12:00 AM ," . today() . "  revisit office for renewal of Receipt.", 0, 'L', 1, 'T', $this->fontsize, '');
        //    }
        $this->pdf->ln(5);
        $this->pdf->Line($this->lm, $this->pdf->getY(), $this->pageWidth + $this->lm, $this->pdf->getY());

        $this->pdf->ln(7);
        $this->addCell(0, 5, "Student Copy", 0, 'C', 1, 'T', 12, 'B');

        $pdf->Image(public_path("/dist/img/mcm-logo.png"), $this->lm + 2, $this->pdf->getY() - 5, 25, 25, 'PNG', '', '', true, 100, '', false, false, 0, false, false, false);
        //    $pdf->Image(public_path("/dist/img/college-logo.png"), 10, 140, 15, 25, '', '', '', true, 100, '', false, false, 0, false, false, false);
        $this->addCell(0, 5, "Date: " . $this->admentry->updated_at->format('d-m-Y'), 0, 'R', 1, 'T', 11, 'B');
        $this->pdf->ln(1);
        $this->addCell(0, 5, "Mehr Chand Mahajan DAV College For Women", 0, 'C', 1, 'T', 16, 'B');
        // $this->addCell(0, 5, "Sri Guru Gobind Singh College, Sector 26, Chandigarh", 0, 'C', 1, 'T', 13, 'B');
        $this->pdf->ln(1);
        $this->addCell(0, 5, "ADMISSION ENTRY SLIP (SESSION " . get_fy_label() . ") ", 0, 'C', 1, 'T', 12, '');
        $this->pdf->ln($this->gap);

        $this->getSlipCopy(true);
        if ($this->admentry->centralized == 'N') {
            $this->pdf->ln(3);
            $this->addCell(15, 0, "Please check student dashboard for latest update (if any) on subjects alotted. ", 0, 'L', 1, 'T', $this->fontsize, 'I');
            $this->addCell(15, 0, "Note: ", 0, 'L', 0, 'T', $this->fontsize, 'B');
            $this->addMCell(0, 0, "Candidate can pay fee through online mode till noon " . $this->admentry->valid_till.". Login at  http://admissions.mcmdav.com/stulogin and Pay Admission Fee.", 0, 'L', 1, 'T', $this->fontsize, '');
            // $pdf->setX($pdf->getX() + 8);
            // $this->addMCell(0, 0, "1. Cash at FEE Counter upto 3 PM " . $this->admentry->valid_till, 0, 'L', 1, 'T', $this->fontsize, '');
            $pdf->setX($pdf->getX() + 8);
            // $this->addMCell($this->pageWidth - 10, 0, "1. Online Mode till mid night " . $this->admentry->valid_till . '. Pay Admission Fees** http://admissions.mcmdav.com/payadmfees/create.', 0, 'L', 1, 'T', $this->fontsize, '');
            $this->pdf->ln(3);
            // $this->addMCell(0, 0, "IF FEE IS NOT RECEIVED BY ANY OF THE ABOVE MENTIONED MODE, THEN ADMISSION PROCESS WILL BE CANCELLED AUTOMATICALLY WITHOUT ANY PRIOR INTIMATION ", 0, 'L', 1, 'T', $this->fontsize, 'B');
        }
        $this->pdf->ln(5);
        // if ($this->admentry->centralized == 'Y' || $this->admentry->manual_formno > 0) {
        //     $pdf->setX($pdf->getX() + 8);
        //     $this->addMCell($this->pageWidth - 10, 0, " **   Pay the Fee on link given above by providing Online Form No.", 0, 'L', 1, 'T', $this->fontsize, '');
        //     $pdf->setX($pdf->getX() + 8);
        //     $this->addMCell($this->pageWidth - 10, 0, " ***  After paying admission fees activate your account using http://admissions.mcmdav.com/student/activation/link then fill the    ", 0, 'L', 1, 'T', $this->fontsize, '');
        //     $pdf->setX($pdf->getX() + 9);
        //     $this->addMCell($this->pageWidth - 10, 0, " College Admission Form as per instructions available at http://admissions.mcmdav.com/stulogin using Email and password mentioned above.", 0, 'L', 1, 'T', $this->fontsize, '');
        // }
         if ($this->admentry->centralized == 'Y' || $this->admentry->manual_formno > 0) {
            $pdf->setX($pdf->getX() + 8);
            $this->addMCell($this->pageWidth - 10, 0, " **   Read the instructions given at https://mcmdavcwchd.edu.in/centralized-admission-procedure/ ", 0, 'L', 1, 'T', $this->fontsize, '');
            $pdf->setX($pdf->getX() + 8);
            $this->addMCell($this->pageWidth - 10, 0, " for login details. After login to student portal, pay Processing Fee and Admission Fee to confirm your seat.", 0, 'L', 1, 'T', $this->fontsize, '');
            // $pdf->setX($pdf->getX() + 9);
            // $this->addMCell($this->pageWidth - 10, 0, " College Admission Form as per instructions available at http://admissions.mcmdav.com/stulogin using Email and password mentioned above.", 0, 'L', 1, 'T', $this->fontsize, '');
        }
        //    if ($this->admentry->centralized == 'N') {
        //      $this->addMCell(0, 0, "You can log into your account on http://admissions.mcmdav.com/stulogin.", 0, 'L', 1, 'T', $this->fontsize, 'B');
        //    }
        // $this->pdf->ln(2);
        // $this->addMCell(0, 0, "(All Students must Complete Online Data/Photograph etc. regarding Admission Form within three days after depositing the Fee.)", 0, 'L', 1, 'T', $this->fontsize, 'B');

        $this->pdf->ln(13);
        $this->addMCell($this->pageWidth / 2, 0, $this->admentry->user_created->name . "\n( Issued By )\n", 0, 'C ', 0, 'T', $this->fontsize, '');
        $this->addMCell($this->pageWidth / 2, 0, "( Candidate Signature )\n", 0, 'C', 1, 'T', $this->fontsize, '');
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

    private function getSlipCopy($printPass = false)
    {
        $pdf = $this->pdf;

        $pdf->setX($pdf->getX() + 20);
        $this->addMCell($this->pageWidth / 3 - 20, 0, "Online Form No.: " . $this->admform->id, 0, 'C ', 0, 'T', $this->fontsize, '');
        $this->addMCell($this->pageWidth / 3 - 20, 0, "Roll No.: " . $this->admform->lastyr_rollno, 0, 'C ', 0, 'T', $this->fontsize, '');

        $this->addMCell($this->pageWidth / 3, 0, "Class: " . $this->admform->course->course_name, 0, 'C', 1, 'T', $this->fontsize, '');

        $this->pdf->ln(3);
        $pdf->setX($pdf->getX() + 10);
        $this->addCell(30, 0, "Candidate Name: ", 0, 'L', 0, 'T', $this->fontsize, 'B');
        $this->addCell(($this->pageWidth / 2), 0, $this->admform->name, 0, 'L', 1, 'T', $this->fontsize, '');
        $this->pdf->ln($this->gap);
        if ($this->admentry->centralized == 'Y') {
            $pdf->setX($pdf->getX() + 10);
            $this->addCell(30, 0, "Roll No: ", 0, 'L', 0, 'T', $this->fontsize, 'B');
            $this->addCell(($this->pageWidth / 2), 0, $this->student->roll_no, 0, 'L', 1, 'T', $this->fontsize, '');
            $this->pdf->ln($this->gap);
        }
        $pdf->setX($pdf->getX() + 10);
        $this->addCell(30, 0, "Father's Name: ", 0, 'L', 0, 'T', $this->fontsize, 'B');
        $this->addCell(($this->pageWidth / 2), 0, $this->admform->father_name, 0, 'L', 1, 'T', $this->fontsize, '');
        $this->pdf->ln($this->gap);

        $pdf->setX($pdf->getX() + 10);
        $this->addCell(30, 0, "Email: ", 0, 'L', 0, 'T', $this->fontsize, 'B');
        $this->addCell(($this->pageWidth / 2), 0, $this->stduser->email . ($printPass ? ' (Password: ' . $this->stduser->initial_password . ' )' : ''), 0, 'L', 1, 'T', $this->fontsize, '');
        $this->pdf->ln($this->gap);

        $pdf->setX($pdf->getX() + 10);
        $this->addCell(30, 0, "Phone: ", 0, 'L', 0, 'T', $this->fontsize, 'B');
        $this->addCell(($this->pageWidth / 2), 0, $this->admform->mobile, 0, 'L', 1, 'T', $this->fontsize, '');
        $this->pdf->ln($this->gap);

        $pdf->setX($pdf->getX() + 10);
        $this->addCell(40, 0, "Subjects: ", 0, 'L', 0, 'T', $this->fontsize, 'BU');
        $this->addCell(40, 0, 'Compulsory (as per syllabus)', 0, 'C', 1, 'T', $this->fontsize, 'B');
        $this->pdf->ln($this->gap);
        //    foreach ($this->getCompSubject() as $cmp) {
        //      $this->addCell(45, 0, "", 0, 'L', 0, 'T', $this->fontsize, '');
        //      $this->addCell(30, 0, $cmp->subject->subject, 0, 'L', 1, 'T', $this->fontsize, '');
        //    }
        foreach ($this->getOptSubjects('C') as $opt) {
            $this->addCell(45, 0, "", 0, 'L', 0, 'T', $this->fontsize, '');
            $this->addCell(30, 0, $opt->subject->subject, 0, 'L', 1, 'T', $this->fontsize, '');
        }
        $this->pdf->ln($this->gap);
        // $this->addCell(5, 0, "", 0, 'L', 0, 'T', $this->fontsize, 'B');

        if ($this->getOptSubjects()->count() > 0) {
            $pdf->setX($pdf->getX() + 10);
            $this->addCell(35, 0, 'Elective Subjects', 0, 'L', 0, 'T', $this->fontsize, 'B');
            foreach ($this->getOptSubjects() as $key => $opt) {
                $has_subjects = true;
                if ($key > 0) {
                    $this->addCell(45, 0, "", 0, 'L', 0, 'T', $this->fontsize, '');
                }
                $this->addCell(30, 0, $opt->subject->subject, 0, 'L', 1, 'T', $this->fontsize, '');
            }
        }
        $this->pdf->ln($this->gap);

        $pdf->setX($pdf->getX() + 10);
        $this->addCell(40, 0, "Honour Subject: ", 0, 'L', 0, 'T', $this->fontsize, 'B');
        $this->addCell(35, 0, data_get($this->admentry->honour_sub, 'subject', '--NA--'), 0, 'C', 1, 'T', $this->fontsize, 'B');
        $this->pdf->ln($this->gap);

        $pdf->setX($pdf->getX() + 10);
        $this->addCell(40, 0, "Addon Course: ", 0, 'L', 0, 'T', $this->fontsize, 'B');
        $this->addCell(35, 0, data_get($this->admentry->add_on_course, 'course_name', '--NA--'), 0, 'C', 1, 'T', $this->fontsize, 'B');
        $this->pdf->ln($this->gap);
        if (!$printPass) {
            $this->pdf->ln(40);
        }
        if ($this->admentry->centralized == 'Y') {
            $this->pdf->ln(5);
            $this->addMCell($this->pageWidth / 3, 0, "Admission Receipt No\n" . $this->admentry->adm_rec_no, 0, 'C ', 0, 'T', $this->fontsize, '');
            $this->addMCell($this->pageWidth / 3, 0, "Receipt Date\n" . $this->admentry->rcpt_date, 0, 'C', 0, 'T', $this->fontsize, '');
            $this->addMCell($this->pageWidth / 3, 0, "Amount\n" . $this->admentry->amount, 0, 'C', 1, 'T', $this->fontsize, '');
        }
    }

    private function setCopy($copyno)
    {
        $pdf = $this->pdf;
        $this->copyno = $copyno;
        if ($copyno == 1) {
            $this->pdf->line($this->lm + 200, $this->tm, $this->lm + 142, $this->tm + $this->getNetHeight());
        //$this->setMargin("R", $this->rm + 57);
        } elseif ($copyno == 2) {
            $this->setMargin("L", $this->lm + 147);
            $this->setMargin("R", $this->rm - 147);
            $this->SetYPos($this->tm);
            $this->resetY();
        }
        $this->header();
    }

    private function getCompSubject()
    {
        return $this->admform->course->subjects->where('sub_type', 'C');
    }

    private function getOptSubjects($type = 'O')
    {
        $subjects = $this->admform->admSubs;
        return $subjects->filter(function ($item, $key) use ($type) {
            if ($type == 'O') {
                if ($item->sub_group_id == 0 || $item->subjectGroup->type == $type) {
                    return true;
                }
            } elseif ($type == 'C') {
                if ($item->sub_group_id > 0 && $item->subjectGroup->type == $type) {
                    return true;
                }
            }
        });

        // return $opt_subjects;
    }
}
