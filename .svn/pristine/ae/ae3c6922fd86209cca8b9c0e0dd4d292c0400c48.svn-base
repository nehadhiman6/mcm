<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Printings;

use TCPDF;

class LeaveApplicationPrint extends PrintPdf
{
    protected $gap = 60;

    public function makepdf(\App\AdmissionForm $student)
    {
        $this->student = $student;
        // dd($this->student);
        // dd($this->student);
        // $this->subject = $student->admSubs;
        $this->pdf->SetMargins($this->lm, $this->tm);
        $this->main();
        return $this->pdf;
    }

    private function setCopy($copyno)
    {
        $pdf = $this->pdf;
        $this->copyno = $copyno;
        $this->header();
        $this->content();
        $this->header();
        $this->subContent();
        // $this->footer("E");
    }

    private function main($title = '')
    {
        $pdf = $this->pdf;
        $this->pageno = 0;
        $this->footerHeight = 20;
        do {
            $this->pageno++;
            $this->nextpage = "N";
            $this->addNewPage("P", "A4");
            $this->setCopy(0);
        } while ($this->nextpage == "Y");
    }

    private function header()
    {
        $pdf = $this->pdf;
        $this->pdf->ln(5);
        $this->GetYPos(true);
        $this->addCols([]);$pdf->Image(public_path("/img/logo.jpg"), $this->lm + 0, $this->tm+ 2,22, 19, 'JPG', '', '', true, 100, '', false, false, 0, false, false, false);
        $pdf->Image(public_path("/dist/img/om_2020-02-11.jpg"), $this->lm + 87, $this->tm + 0, 25, 10, 'JPG', '', '', true, 140, '', false);
        // $pdf->Image(public_path("/dist/img/mcm-logo.png"), $this->lm + 2, $this->tm, 25, 25, 'PNG', '', '', true, 100, '', false, false, 0, false, false, false);
        $this->pdf->ln(8);
        $this->addCell(0, 5, "Leave Application Form", 0, 'C', 1, 'T', 14, 'B');
        $this->addCell(0, 5, "MEHR CHAND MAHAJAN D.A.V COLLEGE FOR WOMEN", 0, 'C', 1, 'T', 14, 'B');
        $this->addHLine();
        $this->addCell(0, 5, "SECTOR 36-A, CHANDIGARH-160 036 PHONE : 2603355 FAX : 0172-2613047", 0, 'C', 1, 'T', 10);
    }

    private function content()
    {
        $pdf = $this->pdf;
        $student = $this->student;
        $this->pdf->ln(10);
        $this->GetYPos(true);
        $this->addCols([30,60,20,40,20]);
        $this->addCell($this->getColW(1), $this->lineHeight, "Name", 0, 'L', 0, 'T', 10, 'B');
        $this->addCell($this->getColW(2), $this->lineHeight, $student->name, 0, 'L', 0, 'T', 10, '');
        $this->addCell($this->getColW(3), $this->lineHeight, "Class & Section", 0, 'R', 0, 'T', 10, 'B');
        $this->addCell($this->getColW(4), $this->lineHeight, $student->student->course->course_name, 0, 'C', 0, 'T', 10, '');
        $this->addCell($this->getColW(5), $this->lineHeight, "Roll No", 0, 'R', 0, 'T', 10, 'B');
        $this->addCell($this->getColW(6), $this->lineHeight, $student->student->roll_no, 0, 'C', 1, 'T', 10, '');

        $this->pdf->ln(2);
        $this->addCell($this->getColW(1), $this->lineHeight, "Reason of leave", 0, 'L', 0, 'T', 10, 'B');
        $this->addCell($this->getColW(2,6), $this->lineHeight, "................................................................................................................................................................................................", 0, 'L', 1, 'T', 10, '');

        $this->pdf->ln(2);
        $this->addCell($this->getColW(1), $this->lineHeight, "No. of Days", 0, 'L', 0, 'T', 10, 'B');
        $this->addCell($this->getColW(2), $this->lineHeight, ".............................................................", 0, 'L', 0, 'T', 10, '');
        $this->addCell($this->getColW(3), $this->lineHeight, "from", 0, 'R', 0, 'T', 10, 'B');
        $this->addCell($this->getColW(4), $this->lineHeight, "............................................", 0, 'L', 0, 'T', 10, '');
        $this->addCell($this->getColW(5), $this->lineHeight, "to", 0, 'R', 0, 'T', 10, 'B');
        $this->addCell($this->getColW(6), $this->lineHeight, ".................................", 0, 'L', 1, 'T', 10, '');

        $this->pdf->ln(2);
        $this->addCell($this->getColW(1,2), $this->lineHeight, "Date of submission of application        .....................................", 0, 'L', 0, 'T', 10, 'B');
        $this->addCell($this->getColW(3), $this->lineHeight, ".................................", 0, 'L', 0, 'T', 10, '');
        $this->addCell($this->getColW(4), $this->lineHeight, "Full Signature", 0, 'R', 0, 'T', 10, 'B');
        $this->addCell($this->getColW(5,6), $this->lineHeight, "........................................................", 0, 'L', 1, 'T', 10, '');

        $this->pdf->ln(2);
        $this->addCell($this->getColW(1,2), $this->lineHeight, "Recommendation of guardian(if local)    .................................", 0, 'L', 0, 'T', 10, 'B');
        $this->addCell($this->getColW(3,6), $this->lineHeight, "............................................................................................................................", 0, 'L', 1, 'T', 10, '');

        $this->pdf->ln(2);
        $this->addCell($this->getColW(1,2), $this->lineHeight, "Recommendation of Tour Or sanctioning authority", 0, 'L', 0, 'T', 10, 'B');
        $this->addCell($this->getColW(3,6), $this->lineHeight, "...........................................................................................................................", 0, 'L', 1, 'T', 10, '');
        $this->pdf->ln(2);
        $this->addCell($this->getColW(1,6), $this->lineHeight, "..................................................................................................................................................................................................................................", 0, 'L', 1, 'T', 10, '');

        $this->pdf->ln(2);
        $this->addCell($this->getColW(1), $this->lineHeight, "Date of entry (for office)", 0, 'L', 0, 'T', 10, 'B');
        $this->addCell($this->getColW(1,6), $this->lineHeight, "         .........................................................................", 0, 'L', 1, 'T', 10, '');
        $this->pdf->ln(10);
        
        $this->pdf->ln($this->gap);
        $this->addCols([]);$pdf->Image(public_path("/img/logo.jpg"), $this->lm + 0, $this->tm+ 160,22, 19, 'JPG', '', '', true, 100, '', false, false, 0, false, false, false);
        $pdf->Image(public_path("/dist/img/cut_2020-02-11.png"), $this->lm + 0, $this->tm + 140, 200, 8, 'PNG', '', '', true, 140, '', false);
        // $this->pdf->ln($this->gap);
        $pdf->Image(public_path("/dist/img/om_2020-02-11.jpg"), $this->lm + 87, $this->tm + 160, 25, 10, 'JPG', '', '', true, 140, '', false);

        
    }

    private function subContent()
    {
        $pdf = $this->pdf;
        $student = $this->student;
        $this->pdf->ln(8);
        $this->GetYPos(true);
        $this->addCols([30,40,30,40,30]);
        $this->addCell($this->getColW(1), $this->lineHeight, "Name", 0, 'L', 0, 'T', 10, 'B');
        $this->addCell($this->getColW(2), $this->lineHeight, $student->name, 0, 'L', 0, 'T', 10, '');
        $this->addCell($this->getColW(3), $this->lineHeight, "Class & Section", 0, 'R', 0, 'T', 10, 'B');
        $this->addCell($this->getColW(4), $this->lineHeight, $student->student->course->course_name, 0, 'C', 0, 'T', 10, '');
        $this->addCell($this->getColW(5), $this->lineHeight, "Roll No", 0, 'R', 0, 'T', 10, 'B');
        $this->addCell($this->getColW(6), $this->lineHeight, $student->student->roll_no, 0, 'C', 1, 'T', 10, '');

        $this->pdf->ln(2);
        $this->addCell($this->getColW(1), $this->lineHeight, "Reason", 0, 'L', 0, 'T', 10, 'B');
        $this->addCell($this->getColW(2,6), $this->lineHeight, "................................................................................................................................................................................................", 0, 'L', 1, 'T', 10, '');

        $this->pdf->ln(2);
        $this->addCell($this->getColW(1), $this->lineHeight, "No. of Days", 0, 'L', 0, 'T', 10, 'B');
        $this->addCell($this->getColW(2), $this->lineHeight, "...............................", 0, 'L', 0, 'T', 10, '');
        $this->addCell($this->getColW(3), $this->lineHeight, "from", 0, 'R', 0, 'T', 10, 'B');
        $this->addCell($this->getColW(4), $this->lineHeight, "............................................", 0, 'L', 0, 'T', 10, '');
        $this->addCell($this->getColW(5), $this->lineHeight, "to", 0, 'R', 0, 'T', 10, 'B');
        $this->addCell($this->getColW(6), $this->lineHeight, ".................................", 0, 'L', 1, 'T', 10, '');

        $this->pdf->ln(2);
        $this->addCell($this->getColW(1,3), $this->lineHeight, "Certified that the application was received by me on", 0, 'L', 0, 'T', 10, 'B');
        $this->addCell($this->getColW(4,6), $this->lineHeight, ".................................................................................................................", 0, 'L', 1, 'T', 10, '');

        $this->pdf->ln(2);
        $this->addCell($this->getColW(1,3), $this->lineHeight, "it was incomplete/complete", 0, 'L', 1, 'T', 10, 'B');

        $this->pdf->ln(5);
        $this->addCell($this->getColW(1,6), $this->lineHeight, "Full Signature", 0, 'R', 1, 'T', 10, 'B');
       

        $this->pdf->ln(5);
        $this->addCell($this->getColW(1), $this->lineHeight, "Date", 0, 'L', 0, 'T', 10, 'B');
        $this->addCell($this->getColW(2,3), $this->lineHeight, "...........................", 0, 'L', 1, 'T', 10, '');

    }


}