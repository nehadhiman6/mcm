<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Printings;

use App\Student;
use TCPDF;

class StudentCardPrint extends PrintPdf
{
    protected $gap = 10;

    public function makepdf($student_id,$exam_detail,$exam,$sam,$student_detail)
    {
        // dd($sam);
        $student = Student::find($student_id)->load('course');
        $this->student_detail = $student_detail;
        $this->student = $student;
        $this->exam_detail = $exam_detail;
        $this->exam = $exam;
        $this->sam = $sam;
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
        $this->addCell(0, 5, "Result Card", 0, 'C', 1, 'T', 14, 'B');
        // $this->addCell(0, 5, "(COLLEGE STUDENTS)", 0, 'C', 1, 'T', 9, '');
        $this->addCell(0, 5, "(SESSION " .get_fy_label().")", 0, 'C', 1, 'T', 10, '');
    }

    private function content(){
        
        $pdf = $this->pdf;
        $student = $this->student;


        $this->pdf->ln(10);
        $this->GetYPos(true);
        $this->addCols([30,50,30,30,20]);
        $this->addCell($this->getColW(1), $this->lineHeight, "Examination", 0, 'C', 0, 'T', 10, 'B');
        $exam_name = '';
        foreach(getExaminations() as $key=>$examination){
            // dd($this->exam);
            if($key == $this->exam){
                $exam_name = $examination;
            }
        }
        // dd($this->sam);
        // dd($this->getSem($this->sam));
        $this->addCell($this->getColW(2,3), $this->lineHeight, $exam_name, 0, 'L', 0, 'T', 10, '');
        $this->addCell($this->getColW(4), $this->lineHeight, "Semester", 0, 'R', 0, 'T', 10, 'B');
        $this->addCell($this->getColW(5,6), $this->lineHeight, $this->getSem($this->sam), 0, 'L', 1, 'T', 10, '');
        $this->pdf->ln(4);
        $this->addCell($this->getColW(1), $this->lineHeight, "Name", 0, 'C', 0, 'T', 10, 'B');
        $this->addCell($this->getColW(2,3), $this->lineHeight, $student->name, 0, 'L', 0, 'T', 10, '');
        $this->addCell($this->getColW(4), $this->lineHeight, "Class ", 0, 'R', 0, 'T', 10, 'B');
        $this->addCell($this->getColW(5,6), $this->lineHeight, $student->course->course_name, 0, 'L', 1, 'T', 10, '');

        $this->pdf->ln(4);
        $this->addCell($this->getColW(1), $this->lineHeight, "Roll No", 0, 'C', 0, 'T', 10, 'B');
        $this->addCell($this->getColW(2,3), $this->lineHeight, $student->roll_no, 0, 'L', 1, 'T', 10, '');
        $this->pdf->ln(4);
        $this->addMCell(66, 12, "Subject", 1, 'C', 0, 'M', '', 'B');
        $this->addMCell(66, 12, "Maximum Marks", 1, 'C', 0, 'M', '', 'B');
        $this->addMCell(66, 12, "Obtained Marks ", 1, 'C', 1, 'M', '', 'B');
      
        foreach ($this->student_detail as $std) {
            // dd($std);
            $this->addMCell(66, 12, $std->uni_code, 1, 'C', 0, 'M', '', '');
            $this->addMCell(66, 12, $std->max_marks, 1, 'C', 0, 'M', '', '');
            $this->addMCell(66, 12, number_format($this->getMarks($std->marks_id), 2), 1, 'C', 1, 'M', '', '');
        }
        $this->addMCell(66, 12, "", 1, 'C', 0, 'M', '', 'B');
        $this->addMCell(66, 12, "Result", 1, 'C', 0, 'M', '', 'B');
        $this->addMCell(66, 12, $this->getPassResult($this->student_detail[0]->marks_details,$this->student_detail), 1, 'C', 1, 'M', '', 'B');
        
    }

    public function getMarks($marks_id){
        // dd($id);
        $mar = 0;
        foreach ($this->student_detail[0]->marks_details as $marks) {
            // dd($marks);
            if($marks_id == $marks->id){
                if($marks->examdetail->have_sub_papers == 'Y'){
                    // dd($marks);
                    if($marks->subPapersMarks && count($marks->subPapersMarks) > 0){
                        // dd('ssdfs');
                        $mar = 0.00;
                        foreach($marks->subPapersMarks as $ele){
                            $mar += $ele->marks;
                        }
                    }
                }
                else{
                    $mar = $marks->marks;
                }
            }
        }
        // dd($mar);
        return $mar;
    }

    public function getPassResult($marks_detail,$detail){
        $result = '';
        foreach($marks_detail as $mark_detail){
            foreach($detail as $det){
                if($mark_detail->id == $det->marks_id){
                    $min_marks = $det->min_marks;
                    // dd($mark_detail);
                    if($det->have_sub_papers == 'Y'){
                        if($mark_detail->subPapersMarks && count($mark_detail->subPapersMarks) > 0){
                            $marks = 0;
                            foreach($mark_detail->subPapersMarks as $ele){
                                $marks += floatval($ele->marks);
                            }
                            if(floatval($min_marks) > floatval($marks)){
                                $result != ""? $result .=', ':'';
                                $result .=  $det->uni_code;
                            }
                        }
                    }
                    else{
                        if(floatval($min_marks) > floatval($mark_detail->marks)){
                            $result != ""? $result .=', ':'';
                            $result .=  $det->uni_code;
                        }
                    }
                }
                
            }
        }
        // dd($result);
        
        $result == "" ? $result = "PASS":'';
        return "[" . $result . "]";
       
    }

    public function getSem($sem){
            switch ($sem)
            {
                case 1: 
                    return "First";
                case 2: 
                    return "Second";
                case 3: 
                    return "Third";
                case 4: 
                    return "Fourth";
                case 5: 
                    return "Fifth";
                case 6: 
                    return "Sixth";
                default: 
                    return "Select Course First";
            }
    }

}
