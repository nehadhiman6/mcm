<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Printings;

use TCPDF;

class StudentId extends PrintPdf
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
    protected $gap = 1;
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
        $pdf->Image(public_path("/dist/img/college-logo.png"), $this->lm + 2, $this->tm, 15, 25, 'PNG', '', '', true, 100, '', false, false, 0, false, false, false);
        $this->addCell(0, 5, "Date: " . $this->admentry->valid_till, 0, 'R', 1, 'T', 11, 'B');
        $this->pdf->ln(2);
        $this->addCell(0, 5, config("college.college_name") . ", Sector 26, Chandigarh", 0, 'C', 1, 'T', 13, 'B');
        $this->pdf->ln(2);
        $this->addCell(0, 5, "ADMISSION ENTRY SLIP (SESSION " . get_fy_label() . ") ", 0, 'C', 1, 'T', 12, '');
        $this->pdf->ln($this->gap);

        $this->getSlipCopy();

        $this->pdf->ln(10);
        $this->addMCell($this->pageWidth / 2, 0, $this->admentry->user_created->name . "\n( Issued By )", 0, 'C ', 0, 'T', $this->fontsize, '');
        $this->addMCell($this->pageWidth / 2, 0, "( Candidate Signature )\n", 0, 'C', 1, 'T', $this->fontsize, '');


        //    if ($this->admentry->centralized == 'N') {
        //      $this->pdf->ln(5);
        //      $this->addCell(15, 0, "Note: ", 0, 'L', 0, 'T', $this->fontsize, 'B');
        //      $this->addMCell(0, 0, "The Receipt is Valid till 12:00 AM ," . today() . "  revisit office for renewal of Receipt.", 0, 'L', 1, 'T', $this->fontsize, '');
        //    }
        $this->pdf->ln(5);
        $this->pdf->Line($this->lm, $this->pdf->getY(), $this->pageWidth + $this->lm, $this->pdf->getY());

        $this->pdf->ln(5);
        $this->addCell(0, 5, "Student Copy", 0, 'C', 1, 'T', 12, 'B');

        $pdf->Image(public_path("/dist/img/college-logo.png"), $this->lm + 2, $this->pdf->getY() - 5, 15, 25, 'PNG', '', '', true, 100, '', false, false, 0, false, false, false);
        //    $pdf->Image(public_path("/dist/img/college-logo.png"), 10, 140, 15, 25, '', '', '', true, 100, '', false, false, 0, false, false, false);
        $this->addCell(0, 5, "Date: " . $this->admentry->valid_till, 0, 'R', 1, 'T', 11, 'B');
        $this->pdf->ln(2);
        $this->addCell(0, 5, config("college.college_name") . ", Sector 26, Chandigarh", 0, 'C', 1, 'T', 13, 'B');
        $this->pdf->ln(2);
        $this->addCell(0, 5, "ADMISSION ENTRY SLIP (SESSION " . get_fy_label() . ") ", 0, 'C', 1, 'T', 12, '');
        $this->pdf->ln($this->gap);

        $this->getSlipCopy(true);
        if ($this->admentry->centralized == 'N') {
            $this->pdf->ln(5);
            $this->addCell(15, 0, "Note: ", 0, 'L', 0, 'T', $this->fontsize, 'B');
            $this->addMCell(0, 0, "Candidate can pay fee as Follows.", 0, 'L', 1, 'T', $this->fontsize, '');
            $pdf->setX($pdf->getX() + 12);
            $this->addMCell(0, 0, "1. Cash at FEE Counter upto 3 PM " . $this->admentry->valid_till, 0, 'L', 1, 'T', $this->fontsize, '');
            $pdf->setX($pdf->getX() + 12);
            $this->addMCell(0, 0, "2. Online Mode till 12:00 midnight " . $this->admentry->valid_till . '. You can deposit the fee online by logging into your account on https://admissions.sggscollege.co.in/stulogin.', 0, 'L', 1, 'T', $this->fontsize, '');
            $this->pdf->ln(5);
            $this->addMCell(0, 0, "IF FEE IS NOT RECEIVED BY ANY OF THE ABOVE MENTIONED MODE, THEN ADMISSION PROCESS WILL BE CANCELLED AUTOMATICALLY WITHOUT ANY PRIOR INTIMATION ", 0, 'L', 1, 'T', $this->fontsize, 'B');
        }
        $this->pdf->ln(5);
        if ($this->admentry->centralized == 'N') {
            $this->addMCell(0, 0, "Pay Your Admission Fees Here https://admissions.sggscollege.co.in/payadmfees/create.", 0, 'L', 1, 'T', $this->fontsize, 'B');
        }
        if ($this->admentry->centralized == 'Y' || $this->admentry->manual_formno > 0) {
            $this->addMCell(0, 0, "Activate your account here ( https://admissions.sggscollege.co.in/student/activation/link )And Complete Your Admission Form.", 0, 'L', 1, 'T', $this->fontsize, 'B');
        }
        $this->pdf->ln(2);
        $this->addMCell(0, 0, "( All Students must Complete Online Data/Photograph etc. regarding admission Form Within Three (03) days after depositing the Fee.)", 0, 'L', 1, 'T', $this->fontsize, 'B');

        $this->pdf->ln(15);
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
        $this->addMCell($this->pageWidth / 2 - 20, 0, "Online Form No.: " . $this->admform->id, 0, 'C ', 0, 'T', $this->fontsize, '');

        $this->addMCell($this->pageWidth / 2, 0, "Class: " . $this->admform->course->course_name, 0, 'C', 1, 'T', $this->fontsize, '');

        $this->pdf->ln(8);
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
        $this->addCell(40, 0, "Selected Subjects: ", 0, 'L', 0, 'T', $this->fontsize, 'BU');
        $this->addCell(40, 0, 'Compulsory Optional Subjects', 0, 'C', 1, 'T', $this->fontsize, 'B');
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
        $this->addCell(45, 0, "", 0, 'L', 0, 'T', $this->fontsize, 'B');

        $this->addCell(40, 0, 'Elective Subjects', 0, 'L', 1, 'T', $this->fontsize, 'B');
        foreach ($this->getOptSubjects() as $opt) {
            $this->addCell(45, 0, "", 0, 'L', 0, 'T', $this->fontsize, '');
            $this->addCell(30, 0, $opt->subject->subject, 0, 'L', 1, 'T', $this->fontsize, '');
        }
        $this->pdf->ln($this->gap);

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

        return $opt_subjects;
    }
}
