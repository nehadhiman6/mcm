<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of MonthlyReport
 *
 * @author Ani
 */

namespace App\Printings;

use TCPDF;

class RecPrint extends PrintPdf
{
    protected $feercpt = null;
    protected $feercptdets = null;
    protected $student = null;
    protected $pdf = null;
    protected $hight = 0;
    protected $pageno = 0;
    protected $nextpage = '';
    protected $feerecdetid = 0;
    protected $copyno = 0;
    protected $footerHight = 0;

    public function makepdf(\App\FeeRcpt $feercpt)
    {
        $this->feercpt = $feercpt;
        $this->feercpt->load('feeRcptDets.subhead');
        $this->feercptdets = $feercpt->billRcptDets;
        if ($feercpt->student) {
            $this->student = $feercpt->student;
        }
        if ($feercpt->outsider) {
            $this->student = $feercpt->outsider;
        }
        $this->main();
        return $this->pdf;
    }

    private function header($title = '')
    {
        $pdf = $this->pdf;
        // $this->pdf->setX(5);
        $pdf->Image(public_path("/dist/img/mcm-logo.png"), $this->lm, $this->tm, 15, 12, 'PNG', '', '', true, 100, '', false, false, 0, false, false, false);
        $this->pdf->ln(5);
        $this->addCell(0, 0, config("college.college_name"), 0, 'C', 1, 'T', 0, 'B');
        $this->addCell(0, 0, "SECTOR - 36, CHANDIGARH", 0, 'C', 1, 'T', 0, '');
        if (strpos($this->feercpt->fee_type, 'Hostel') === false) {
            $this->addCell(0, 0, "COLLEGE FEE VOUCHER-CUM-RECEIPT", 0, 'C', 1, 'T', 0, 'B');
        } else {
            $this->addCell(0, 0, "HOSTEL FEE VOUCHER-CUM-RECEIPT", 0, 'C', 1, 'T', 0, 'B');
        }
        $this->pdf->ln(4);
        if ($this->copyno == 1) {
            $this->addCell(0, 0, "COLLEGE COPY", 0, 'C', 1, 'T', 0, 'B');
        }
        if ($this->copyno == 2) {
            $this->addCell(0, 0, "BANK COPY", 0, 'C', 1, 'T', 0, 'B');
        }
        if ($this->copyno == 3) {
            $this->addCell(0, 0, "STUDENT COPY", 0, 'C', 1, 'T', 0, 'B');
        }
        $pdf->Line($this->lm, $this->lastY, $this->lm + 140, $this->lastY);
        $this->pdf->ln(2);
        $this->addCell(50, 0, "Receipt No.: " . $this->feercpt->id, 0, 'L', 0, 'T', 0, 'B');
        $this->addCell(40, 0, "Dated : " . $this->feercpt->rcpt_date, 0, 'R', 1, 'T', 0, 'B');
        if ($this->feercpt->outsider_id > 0) {
            $this->addMCell(0, 0, "Institute: " . getInstitutes()[data_get($this->student, 'institute', 0)], 0, 'L', 1, 'T', 0, '');
        }
        $this->addMCell(0, 0, "Name: " . data_get($this->student, 'name', ''), 0, 'L', 1, 'T', 0, '');
        $this->addMCell(0, 0, "Father's Name : " . data_get($this->student, 'father_name', ''), 0, 'L', 1, 'T', 0, '');
        $this->addMCell(100, 0, "Course: " . (data_get($this->student, 'course') ? $this->student->course->course_name : data_get($this->student, 'course_name', '')), 0, 'L', 1, 'T', 0, '');
        $this->addMCell(100, 0, "Adm No.: " . data_get($this->student, 'adm_no'), 0, 'L', 1, 'T', 0, '');
        $this->addMCell(100, 0, "Roll No.: " . data_get($this->student, 'roll_no'), 0, 'L', 1, 'T', 0, '');
        //$this->addCell(40, 0, "Class: " . getObjKey($this->student->coursename, "course_name", ''), 0, 'L', 1, 'T', 0, '');
        $this->addMCell(0, 0, "Remarks : " . $this->feercpt->details, 0, 'L', 1, 'T', 0, '');
        $pdf->Line($this->lm, $this->lastY, $this->lm + 140, $this->lastY);
        $pdf->ln(2);
        $this->hight = $this->getNetHeight() - $this->footerHight;

//    dd($this->pdf->getX());
//    dd("here");
    }

    private function details()
    {
        $pdf = $this->pdf;
        $intX = 0;
        if ($this->feerecdetid != -1) {
            foreach ($this->feercptdets as $value) {
                //  dd($value->subhead);
                if ($intX == 0 && ($this->feerecdetid == 0 || $this->feerecdetid == $value->id)) {
                    $intX = 1;
                }
                if ($intX == 1) {
                    if ($this->lastY + $this->lineHeight > $this->hight) {
                        if ($this->copyno == 3) {
                            $this->feerecdetid = $value->id;
                            $this->nextpage = "Y";
                            $this->pdf->setY($this->getNetHeight() - $this->footerHight);
                            $this->addCell(0, 0, "Continued to next page.....", "0", 'R', 0, 'T', 0, 'BI');
                        }
                        return;
                    }
                    $this->addCell(50, 0, $value->feeHead->name, "0", 'L', 0, 'T', 0, '');
                    $this->addCell(40, 0, number_format($value->amount, 2), "0", 'R', 1, 'T', 0, '');
                }
            }
            if ($this->lastY + $this->lineHeight > $this->hight) {
                if ($this->copyno == 3) {
                    $this->feerecdetid = -1;
                    $this->nextpage = "Y";
                }
                return;
            }
        }
        $pdf->Line($this->lm, $this->lastY, $this->lm + 90, $this->lastY);
        $this->addCell(65, 0, "Total : ", "0", 'R', 0, 'T', 0, 'B');
        $this->addCell(25, 0, number_format($this->feercpt->amount, 2), "0", 'R', 1, 'T', 0, 'B');
        $pdf->Line($this->lm, $this->lastY, $this->lm + 90, $this->lastY);
        $this->footer();
    }

    private function footer()
    {
        $pdf = $this->pdf;
        $this->SetYPos($this->getNetHeight() - $this->footerHight);
        $pdf->Line($this->lm, $this->lastY, $this->lm + 140, $this->lastY);
        $this->addMCell(0, 0, "Rs." . figToWord($this->feercpt->amount), 0, 'L', 1, 'T', 0, '');
        $this->addMCell(0, 0, $this->feercpt->pay_mode_desc, 0, 'L', 1, 'T', 0, '');
        $pdf->Line($this->lm, $this->lastY, $this->lm + 140, $this->lastY);
        $pdf->ln(2);
        $this->addCell(0, 0, "For MCM COLLEGE", 0, 'R', 1, 'T', 0, '');
        $this->pdf->ln(10);
        $this->addCell(0, 0, "Authorised Signatory", 0, 'R', 0, 'T', 0, '');

//    dd($this->pdf->getX());
//    dd("here");
    }

    private function setCopy($copyno)
    {
        $pdf = $this->pdf;
        $this->copyno = $copyno;
        if ($copyno == 1) {
            $this->pdf->line($this->lm + 93, $this->tm, $this->lm + 93, $this->tm + $this->getNetHeight());
            $this->pdf->line($this->lm + 190, $this->tm, $this->lm + 190, $this->tm + $this->getNetHeight());
            $this->setMargin("R", $this->rm + 197);
        } elseif ($copyno == 2) {
            $this->setMargin("L", $this->lm + 97);
            $this->setMargin("R", $this->rm - 97);
            $this->pdf->setY($this->tm);
            $this->resetY();
        } elseif ($copyno == 3) {
            $this->setMargin("L", $this->lm + 97);
            $this->setMargin("R", $this->rm - 100);
            $this->pdf->setY($this->tm);
            $this->resetY();
        }
        $this->header();
        $this->details();
//    $this->footer();
    }

    private function main($title = '')
    {
        $pdf = $this->pdf;
        $this->pageno = 0;
        $this->footerHight = 40;
        do {
            $this->pageno++;
            $this->nextpage = "N";
            $this->addNewPage("L", "A4");
            $this->setCopy(1);
            $this->setCopy(2);
            $this->setCopy(3);
        } while ($this->nextpage == "Y");
    }
}
