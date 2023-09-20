<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Printings;

use TCPDF;

class AdmFeeReceipt extends PrintPdf
{
    protected $admfee = null;
    protected $stduser = null;
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

    public function makepdf(\App\Payment $adm)
    {
        $this->admfee = $adm;
        $this->stduser = $adm->std_user;
        $this->admform = $adm->std_user->adm_form;
        $this->pdf->SetMargins($this->lm, $this->tm);
        $this->main();
        return $this->pdf;
    }

    private function header($title = '')
    {
        $pdf = $this->pdf;
        $pdf->Image(public_path("/dist/img/mcm-logo.png"), $this->lm + 2, $this->tm, 25, 25, 'PNG', '', '', true, 100, '', false, false, 0, false, false, false);
        $this->addCell(0, 5, "Date: " . $this->admfee->trntime, 0, 'R', 1, 'T', 11, 'B');
        $this->pdf->ln(2);
        $this->addCell(0, 5, "MCM College, Sector 36, Chandigarh", 0, 'C', 1, 'T', 13, 'B');
        $this->pdf->ln(2);
        $this->addCell(0, 5, "ONLINE ADMISSION FEE RECEIPT (SESSION " . get_fy_label() . ")", 0, 'C', 1, 'T', 12, '');
        $this->pdf->ln($this->gap);

        $pdf = $this->pdf;

        $this->pdf->ln(8);
        $pdf->setX($pdf->getX() + 40);

        $this->addCell(40, 0, "e-Receipt: ", 0, 'C', 1, 'T', $this->fontsize, 'B');
        // $this->addCell(($this->pageWidth / 2), 0, "Status", 0, 'L', 1, 'T', $this->fontsize, '');
        $this->pdf->ln($this->gap);

        $pdf->setX($pdf->getX() + 40);
        $this->addCell(50, 0, "Online Transaction Ref. No.: ", 0, 'L', 0, 'T', $this->fontsize, 'B');
        $this->addCell(($this->pageWidth / 2), 0, $this->admfee->trcd, 0, 'L', 1, 'T', $this->fontsize, '');
        $this->pdf->ln($this->gap);

        $pdf->setX($pdf->getX() + 40);
        $this->addCell(40, 0, "Transaction Date: ", 0, 'L', 0, 'T', $this->fontsize, 'B');
        $this->addCell(($this->pageWidth / 2), 0, $this->admfee->trntime, 0, 'L', 1, 'T', $this->fontsize, '');
        $this->pdf->ln($this->gap);

        $pdf->setX($pdf->getX() + 40);
        $this->addCell(40, 0, "Name Of The Student: ", 0, 'L', 0, 'T', $this->fontsize, 'B');
        $this->addCell(($this->pageWidth / 2), 0, $this->admform->name, 0, 'L', 1, 'T', $this->fontsize, '');
        $this->pdf->ln($this->gap);

        $pdf->setX($pdf->getX() + 40);
        $this->addCell(40, 0, "Course: ", 0, 'L', 0, 'T', $this->fontsize, 'B');
        $this->addCell(($this->pageWidth / 2), 0, $this->admform->course->course_name, 0, 'L', 1, 'T', $this->fontsize, '');
        $this->pdf->ln($this->gap);

        if ($this->admform->student) {
            $pdf->setX($pdf->getX() + 40);
            $this->addCell(40, 0, "Adm No: ", 0, 'L', 0, 'T', $this->fontsize, 'B');
            $this->addCell(($this->pageWidth / 2), 0, $this->admform->student->adm_no, 0, 'L', 1, 'T', $this->fontsize, '');
            $this->pdf->ln($this->gap);

            $pdf->setX($pdf->getX() + 40);
            $this->addCell(40, 0, "Roll No: ", 0, 'L', 0, 'T', $this->fontsize, 'B');
            $this->addCell(($this->pageWidth / 2), 0, $this->admform->student->roll_no, 0, 'L', 1, 'T', $this->fontsize, '');
            $this->pdf->ln($this->gap);
        }
        $pdf->setX($pdf->getX() + 40);
        $this->addCell(40, 0, "Amount: ", 0, 'L', 0, 'T', $this->fontsize, 'B');
        $this->addCell(($this->pageWidth / 2), 0, $this->admfee->amt, 0, 'L', 1, 'T', $this->fontsize, '');
        $this->pdf->ln($this->gap);

        $total = $this->admfee->amt + $this->admfee->fine;
        $pdf->setX($pdf->getX() + 40);
        $this->addCell(40, 0, "Total Amount: ", 0, 'L', 0, 'T', $this->fontsize, 'B');
        $this->addCell(($this->pageWidth / 2), 0, $total, 0, 'L', 1, 'T', $this->fontsize, '');
        $this->pdf->ln($this->gap);

        $pdf->setX($pdf->getX() + 30);
        $this->pdf->ln(10);
        $this->addCell(15, 0, "Note: ", 0, 'L', 0, 'T', $this->fontsize, 'B');
        $this->addMCell(0, 0, "This is a computer generated slip and requires no signature.", 0, 'L', 1, 'T', $this->fontsize, 'B');
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
}
