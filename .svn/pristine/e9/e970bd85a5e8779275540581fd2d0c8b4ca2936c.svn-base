<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Printings;

use TCPDF;

class NoDuesSlipPrint extends PrintPdf
{
    protected $gap = 10;

    public function makepdf(\App\AdmissionForm $student)
    {
        $this->student = $student;
        // $this->admform = $adm;
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

    private function header(){
        $pdf = $this->pdf;
        $this->pdf->ln(5);
        $this->GetYPos(true);
        $this->addCols([]);
        $pdf->Image(public_path("/img/logo.jpg"), $this->lm + 0, $this->tm+ 7,22, 19, 'JPG', '', '', true, 100, '', false, false, 0, false, false, false);
        $this->pdf->ln(8);
        $this->addCell(0, 5, "MEHR CHAND MAHAJAN D.A.V COLLEGE FOR WOMEN", 0, 'C', 1, 'T', 14,'U,B','');
        // $this->addHLine();
        $this->addCell(0, 5, "SECTOR 36-A, CHANDIGARH-160 036 PHONE : 2603355 FAX : 0172-2613047", 0, 'C', 1, 'T', 11);
        $this->pdf->ln(5);
        $this->pdf->ln($this->gap);
        $this->addCell(0, 5, "NO DUES SLIP", 0, 'C', 1, 'T', 14, 'B');
        // $this->addCell(0, 5, "(COLLEGE STUDENTS)", 0, 'C', 1, 'T', 9, '');
        $this->addCell(0, 5, "COLLEGE STUDENTS (SESSION " .get_fy_label().")", 0, 'C', 1, 'T', 10, '');
    }

    private function content(){
        
        $pdf = $this->pdf;
        $student = $this->student;
        $this->pdf->ln(10);
        $this->GetYPos(true);
        $this->addCols([30,50,30,30,20,20]);
        $this->addCell($this->getColW(1), $this->lineHeight, "Name", 0, 'C', 0, 'T', 10, 'B');
        $this->addCell($this->getColW(2), $this->lineHeight, $student->name, 0, 'L', 0, 'T', 10, '');
        $this->addCell($this->getColW(3), $this->lineHeight, "Class ", 0, 'R', 0, 'T', 10, 'B');
        $this->addCell($this->getColW(4), $this->lineHeight, $student->student->course->course_name, 0, 'L', 1, 'T', 10, '');

        $this->pdf->ln(10);
        $this->addCell($this->getColW(1), $this->lineHeight, "Roll No", 0, 'C', 0, 'T', 10, 'B');
        $this->addCell($this->getColW(2), $this->lineHeight, $student->student->roll_no, 0, 'L', 1, 'T', 10, '');

        $file = $this->getPhoto();
        $stu= $this->student->admEntry->admform->id;
        // dd($stu);
        if ($file)
            $pdf->Image(storage_path() . "/app/images/photograph" . '_' . $stu . '.' . $file->file_ext, 154, 66, 30, 30, '', '', '', true, 100, '', false, false, 0, false, false, false);
        
        $this->pdf->ln(20);
        $this->pdf->ln($this->gap);
        $this->addCell($this->getColW(1), $this->lineHeight, "LIBRARIAN", 0, 'R', 0, 'T', 10,'B');
        $this->addCell($this->getColW(2,5), $this->lineHeight, "", 0, 'R', 0, 'T', 10,'B');
        $this->addCell($this->getColW(6), $this->lineHeight, "FEE CLERK", 0, 'R', 0, 'T', 10,'B');

        $this->pdf->ln(10);
        $this->pdf->ln($this->gap);
        $this->addCell($this->getColW(1,5), $this->lineHeight, "", 0, 'R', 0, 'T', 10,'B');
        $this->addCell($this->getColW(6), $this->lineHeight, "PRINCIPAL", 0, 'R', 0, 'T', 10,'B');
       
    }

    private function getPhoto($type = 'photograph') {
        $stu= $this->student->admEntry->admform;
        // dd($stu->attachments->where('file_type', $type)->first());
        return $stu->attachments->where('file_type', $type)->first();
      }
}
