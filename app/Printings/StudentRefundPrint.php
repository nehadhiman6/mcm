<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Printings;

use TCPDF;

class StudentRefundPrint extends PrintPdf
{
    protected $gap = 10;

    public function makepdf(\App\Models\StudentRefund\StudentRefundRequset $refund)
    {
        $this->refund = $refund;
        $refund = $this->refund->load('student.course','student_refund.released_by','approved_by','student.std_user','student.attachments');
        // dd($refund);
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
        $ch= $this->refund->fund_type == "C" ? 'College Refund' :'Hostel Withdrawl'; 
        $this->addCell(0, 5, "".$ch." Form", 0, 'C', 1, 'T', 14, 'B');
        // $this->addCell(0, 5, "(COLLEGE STUDENTS)", 0, 'C', 1, 'T', 9, '');
        // $this->addCell(0, 5, "COLLEGE STUDENTS (SESSION " .get_fy_label().")", 0, 'C', 1, 'T', 10, '');
    }

    private function content(){
        
        $pdf = $this->pdf;
        $refund = $this->refund;
        $this->pdf->ln(8);
        $this->GetYPos(true);
        $this->addCols([30,140]);
        $this->addCell($this->getColW(1), $this->lineHeight, "", 0, 'T', 0, 'T', 10, 'B');
        $this->addCell($this->getColW(2), $this->lineHeight, "The Principal,", 0, 'L', 0, 'T', 12, '');
        $this->addCell($this->getColW(3), $this->lineHeight, "", 0, 'T', 1, 'T', 10, 'B');

        $this->addCell($this->getColW(1), $this->lineHeight, "", 0, 'T', 0, 'T', 10, 'B');
        $this->addCell($this->getColW(2), $this->lineHeight, "MCM DAV College for Women", 0, 'L', 0, 'T', 12, '');
        $this->addCell($this->getColW(3), $this->lineHeight, "", 0, 'T', 1, 'T', 10, 'B');

        $this->addCell($this->getColW(1), $this->lineHeight, "", 0, 'T', 0, 'T', 10, 'B');
        $this->addCell($this->getColW(2), $this->lineHeight, "Sector 36 A, Chandigarh", 0, 'L', 0, 'T', 12, '');
        $this->addCell($this->getColW(3), $this->lineHeight, "", 0, 'T', 1, 'T', 10, 'B');

        $this->pdf->ln(4);
            $ch= $refund->fund_type == "C" ? 'College' :'Hostel'; 
        $this->addCell($this->getColW(1), $this->lineHeight, "", 0, 'T', 0, 'T', 10, 'B');
        $this->addCell($this->getColW(2), $this->lineHeight, "Sub: Refund of ".$ch." Fee for Class ".$refund->student->course->course_name." Roll  No ".$refund->student->roll_no, 0, 'L', 0, 'T', 12, '');
        $this->addCell($this->getColW(3), $this->lineHeight, "", 0, 'T', 1, 'T', 10, 'B');
        $this->pdf->ln(6);
        $this->addCell($this->getColW(1), $this->lineHeight, "", 0, 'T', 0, 'T', 10, 'B');
        $this->addCell($this->getColW(2), $this->lineHeight, "Respected Madam,", 0, 'T', 1, 'T', 12, '');
        $this->pdf->ln(4);
        $this->GetYPos(true);
        $this->addCols([30,140]);
        $this->addCell($this->getColW(1), $this->lineHeight, "", 0, 'L', 0, 'T', 10, 'B');
        
        $this->addMCell($this->getColW(2), $this->lineHeight, "Kindly refund my ".$ch." fee as per details given below:", 0, 'L', 0, 'T', 12, '');
        $this->addCell($this->getColW(3), $this->lineHeight, "", 0, 'L', 1, 'T', 10, 'B');
        $this->pdf->ln(4);
        $this->addCell($this->getColW(1), $this->lineHeight, "", 0, 'L', 0, 'T', 10, 'B');
        $this->addMCell($this->getColW(2), $this->lineHeight, "Basic Details:", 0, 'U', 0, 'T', 12, 'B');
        $this->addCell($this->getColW(3), $this->lineHeight, "", 0, 'L', 1, 'T', 10, 'B');
        // $this->pdf->ln(4);
        // $this->addCell($this->getColW(1), $this->lineHeight, "", 0, 'L', 0, 'T', 10, 'B');
        // $ah = $refund->fund_type == "C" ? 'admission' :'Hostel Seat';
        // $this->addMCell($this->getColW(2), $this->lineHeight, "I want to withdraw my ".$ah." due to the following reason", 0, 'J', 0, 'T', 12, '');
        // $this->addCell($this->getColW(3), $this->lineHeight, "", 0, 'L', 1, 'T', 10, 'B');
        // $this->pdf->ln(4);
        // $this->addCell($this->getColW(1), $this->lineHeight, "", 0, 'L', 0, 'T', 10, 'B');
        // $this->addMCell($this->getColW(2), $this->lineHeight,$refund->reason_of_refund , 0, 'U', 0, 'T', 12, '');
        // $this->addCell($this->getColW(3), $this->lineHeight, "", 0, 'L', 1, 'T', 10, 'B');
        // $this->pdf->ln(4);
        // $this->pdf->ln(4);
        // $this->addCell($this->getColW(1), $this->lineHeight, "", 0, 'L', 0, 'T', 10, 'B');
        // $this->addMCell($this->getColW(2), $this->lineHeight, "You are requested to refund my ".$ch." fee.", 0, 'L', 0, 'T', 12, '');
        // $this->addCell($this->getColW(3), $this->lineHeight, "", 0, 'L', 1, 'T', 10, 'B');
        
        // $this->pdf->ln(4);
        // $this->addCell($this->getColW(1), $this->lineHeight, "", 0, 'L', 0, 'T', 10, 'B');
        // $this->addMCell($this->getColW(2), $this->lineHeight, "Thanking you,", 0, 'L', 0, 'T', 12, '');
        // $this->addCell($this->getColW(3), $this->lineHeight, "", 0, 'L', 1, 'T', 10, 'B');
        $this->pdf->ln(4);
        $this->GetYPos(true);
        $this->addCols([30,35,40,35,40]);
        $this->addCell($this->getColW(1), $this->lineHeight, "", 0, 'L', 0, 'T', 10, 'B');
        $this->addMCell($this->getColW(2), $this->lineHeight, "Student Name:", 0, 'L', 0, 'T', 12, '');
        $this->addMCell($this->getColW(3), $this->lineHeight, $refund->student->name, 0, 'L', 0, 'T', 12, '');
        $this->addCell($this->getColW(4), $this->lineHeight, "Email ID:", 0, 'L', 0, 'T', 12, '');
        $this->addCell($this->getColW(5), $this->lineHeight, $refund->student->std_user->email, 0, 'L', 0, 'T', 12, '');
        $this->addCell($this->getColW(6), $this->lineHeight, "", 0, 'L', 1, 'T', 10, 'B');
        $this->pdf->ln(6);
        $this->addCell($this->getColW(1), $this->lineHeight, "", 0, 'L', 0, 'T', 10, 'B');
        $this->addMCell($this->getColW(2), $this->lineHeight, "Class:", 0, 'L', 0, 'T', 12, '');
        $this->addCell($this->getColW(3), $this->lineHeight, $refund->student->course->course_name, 0, 'L', 0, 'T', 12, '');
        $this->addMCell($this->getColW(4),$this->lineHeight, "Fee Deposited:", 0, 'L', 0, 'T', 12, '');
        $this->addMCell($this->getColW(5), $this->lineHeight, "Rs. ".$refund->amount, 0, 'L', 0, 'T', 12, '');
        $this->addCell($this->getColW(6), $this->lineHeight, "", 0, 'L', 1, 'T', 10, 'B');

        $this->pdf->ln(6);
        $this->addCell($this->getColW(1), $this->lineHeight, "", 0, 'L', 0, 'T', 10, 'B');
        $this->addMCell($this->getColW(2), $this->lineHeight, "Roll No.:", 0, 'L', 0, 'T', 12, '');
        $this->addCell($this->getColW(3), $this->lineHeight, $refund->student->roll_no, 0, 'L', 0, 'T', 12, '');
        $this->addCell($this->getColW(4), $this->lineHeight, "Date of Deposit", 0, 'L', 0, 'T', 12, '');
        $this->addCell($this->getColW(5), $this->lineHeight, $refund->fee_deposite_date, 0, 'L', 0, 'T', 12, '');
        $this->addCell($this->getColW(6), $this->lineHeight, "", 0, 'L', 1, 'T', 10, 'B');

        $this->pdf->ln(6);
        $this->addCell($this->getColW(1), $this->lineHeight, "", 0, 'L', 0, 'T', 10, 'B');
        $this->addMCell($this->getColW(2,3), $this->lineHeight, "Reason of withdrawal/Refund:", 0, 'L', 0, 'T', 12, '');
        $this->addMCell($this->getColW(4,5), $this->lineHeight, $refund->reason_of_refund, 0, 'L', 0, 'T', 12, '');
        $this->addCell($this->getColW(6), $this->lineHeight, "", 0, 'L', 1, 'T', 10, 'B');
        $this->pdf->ln(10);
        $this->GetYPos(true);
        $this->addCols([30,140]);
        $this->addCell($this->getColW(1), $this->lineHeight, "", 0, 'L', 0, 'T', 10, 'B');
        $this->addMCell($this->getColW(2), $this->lineHeight, "Bank Details:", 0, 'U', 0, 'T', 12, 'B');
        $this->addCell($this->getColW(3), $this->lineHeight, "", 0, 'L', 1, 'T', 10, 'B');

        $this->pdf->ln(4);
        $this->GetYPos(true);
        $this->addCols([30,35,40,35,40]);
        $this->addCell($this->getColW(1), $this->lineHeight, "", 0, 'L', 0, 'T', 10, 'B');
        $this->addMCell($this->getColW(2), $this->lineHeight, "Bank & Branch :", 0, 'L', 0, 'T', 12, '');
        $this->addMCell($this->getColW(3), $this->lineHeight, $refund->bank_name, 0, 'L', 0, 'T', 12, '');
        $this->addCell($this->getColW(4), $this->lineHeight, "A/c Holder Name:", 0, 'L', 0, 'T', 12, '');
        $this->addCell($this->getColW(5), $this->lineHeight, $refund->account_holder_name, 0, 'L', 0, 'T', 12, '');
        $this->addCell($this->getColW(6), $this->lineHeight, "", 0, 'L', 1, 'T', 10, 'B');
        $this->pdf->ln(6);
        $this->addCell($this->getColW(1), $this->lineHeight, "", 0, 'L', 0, 'T', 10, 'B');
        $this->addMCell($this->getColW(2), $this->lineHeight, "IFSC No:", 0, 'L', 0, 'T', 12, '');
        $this->addCell($this->getColW(3), $this->lineHeight, $refund->ifsc_code, 0, 'L', 0, 'T', 12, '');
        $this->addMCell($this->getColW(4),$this->lineHeight, "Account No:", 0, 'L', 0, 'T', 12, '');
        $this->addMCell($this->getColW(5), $this->lineHeight, $refund->bank_ac_no, 0, 'L', 0, 'T', 10, '');
        $this->addCell($this->getColW(6), $this->lineHeight, "", 0, 'L', 1, 'T', 10, 'B');

        $this->pdf->ln(6);
        $this->GetYPos(true);
        $this->addCols([30,140]);
        $this->addCell($this->getColW(1), $this->lineHeight, "", 0, 'L', 0, 'T', 10, 'B');
        $this->addMCell($this->getColW(2), $this->lineHeight, "I certify that above information is correct to the best of my knowledge. I also accept that, College will not be liable or responsible for any wrong payments, in case there is discrepancy in the information provided by me in refund request.", 0, 'U', 0, 'T', 12, '');
        $this->addCell($this->getColW(3), $this->lineHeight, "", 0, 'L', 1, 'T', 10, 'B');
        $this->pdf->ln(18);
        $this->addCell($this->getColW(1), $this->lineHeight, "", 0, 'L', 0, 'T', 10, 'B');
        $this->addMCell($this->getColW(2), $this->lineHeight, "Thanking You ", 0, 'U', 0, 'T', 12, '');
        $this->addCell($this->getColW(3), $this->lineHeight, "", 0, 'L', 1, 'T', 10, 'B');

        $this->pdf->ln(6);
        $this->GetYPos(true);
        $this->addCols([30,35,40,35,40]);
        $this->addCell($this->getColW(1), $this->lineHeight, "", 0, 'L', 0, 'T', 10, 'B');
        $this->addMCell($this->getColW(2), $this->lineHeight, "Student Name:", 0, 'L', 0, 'T', 12, '');
        $this->addMCell($this->getColW(3), $this->lineHeight, $refund->student->name, 0, 'L', 0, 'T', 12, '');
        $this->addCell($this->getColW(4), $this->lineHeight, " Father's Name:", 0, 'L', 0, 'T', 12, '');
        $this->addCell($this->getColW(5), $this->lineHeight, $refund->student->father_name, 0, 'L', 0, 'T', 12, '');
        $this->addCell($this->getColW(6), $this->lineHeight, "", 0, 'L', 1, 'T', 10, 'B');
        $this->pdf->ln(4);
        $this->addCell($this->getColW(1), $this->lineHeight, "", 0, 'L', 0, 'T', 10, 'B');
        $this->addCell($this->getColW(2), $this->lineHeight, "Contact No", 0, 'L', 0, 'T', 12, '');
        $this->addCell($this->getColW(3), $this->lineHeight, $refund->student->mobile, 0, 'L', 0, 'T', 12, '');
        // $this->addCell($this->getColW(3), $this->lineHeight, "", 0, 'L', 0, 'T', 12, '');
        $this->addMCell($this->getColW(4),$this->lineHeight, "Address:", 0, 'L', 0, 'T', 12, '');
        $this->addMCell($this->getColW(5), $this->lineHeight, $refund->student->per_address, 0, 'L', 0, 'T', 10, '');
        $this->addCell($this->getColW(6), $this->lineHeight, "", 0, 'L', 1, 'T', 10, 'B');

        $this->pdf->ln(4);
        $this->addCell($this->getColW(1), $this->lineHeight, "", 0, 'L', 0, 'T', 10, 'B');
        $file = $this->getPhoto('signature');
        // if ($file)
        $pdf->Image(storage_path() . "/app/images/signature" . '_' . $this->refund->student->admission_id . '.' . $file->file_ext, 36, 225, 50, 10, '', '', '', true, 100, '', false, false, 0, false, false, false);
        $this->addMCell($this->getColW(2,3), $this->lineHeight, "", 0, 'L', 0, 'T', 12, '');
        // $this->addMCell($this->getColW(4), $this->lineHeight, "Date:", 0, 'L', 0, 'T', 12, '');
        // $this->addCell($this->getColW(5), $this->lineHeight, $refund->request_date, 0, 'L', 0, 'T', 12, '');        
        $this->addCell($this->getColW(4,6), $this->lineHeight, "", 0, 'L', 1, 'T', 10, 'B');

        $this->pdf->ln(4);
        $this->addCell($this->getColW(1), $this->lineHeight, "", 0, 'L', 0, 'T', 10, 'B');
        
        $this->addCell($this->getColW(2), $this->lineHeight, "Student Signature ( ".$refund->request_date." )", 0, 'L', 0, 'T', 12, '');
        $this->addMCell($this->getColW(3,6), $this->lineHeight, "", 0, 'L', 0, 'T', 12, '');
       


    if($refund->fund_type == "C"){
        $this->pdf->ln(10);
        $this->addCell($this->getColW(1,6), $this->lineHeight, "FOR OFFICE USE ONLY", 0, 'C', 1, 'T', 10, 'B');
        
        $this->pdf->ln(4);
        $this->addCell($this->getColW(1), $this->lineHeight, "", 0, 'L', 0, 'T', 10, 'B');
        $this->addCell($this->getColW(2,4), $this->lineHeight, "1. Signature of the Convener Admission", 0, 'L', 0, 'T', 12, '');
        $this->addCell($this->getColW(5), $this->lineHeight, ".............................................", 0, 'L', 0, 'T', 12, 'B');
        $this->addCell($this->getColW(6), $this->lineHeight, "", 0, 'L', 1, 'T', 10, 'B');

        $this->pdf->ln(4);
        $this->addCell($this->getColW(1), $this->lineHeight, "", 0, 'L', 0, 'T', 10, 'B');
        $this->addCell($this->getColW(2,4), $this->lineHeight, "2. Signature of the official Concerned (Administrative Branch)", 0, 'L', 0, 'T', 12, '');
        $this->addCell($this->getColW(5), $this->lineHeight, ".....................................................", 0, 'L', 0, 'T', 12, 'B');
        $this->addCell($this->getColW(6), $this->lineHeight, "", 0, 'L', 1, 'T', 10, 'B');

        $this->pdf->ln(4);
        $this->addCell($this->getColW(1), $this->lineHeight, "", 0, 'L', 0, 'T', 10, 'B');
        $this->addCell($this->getColW(2,4), $this->lineHeight, "3. Signature of Fee Clerk", 0, 'L', 0, 'T', 12, '');
        $this->addCell($this->getColW(5), $this->lineHeight, "....................................................", 0, 'L', 0, 'T', 12, 'B');
        $this->addCell($this->getColW(6), $this->lineHeight, "", 0, 'L', 1, 'T', 10, 'B');

        // $this->pdf->ln(8);
        // $this->addCell($this->getColW(1), $this->lineHeight, "", 0, 'L', 0, 'T', 10, 'B');
        // $this->addCell($this->getColW(2,4), $this->lineHeight, "Checked & Passed For Rs", 0, 'R', 0, 'T', 12, '');
        // $this->addCell($this->getColW(5), $this->lineHeight, "....................................................", 0, 'L', 0, 'T', 12, 'B');
        // $this->addCell($this->getColW(6), $this->lineHeight, "", 0, 'L', 1, 'T', 10, 'B');
    }
        if($refund->fund_type == "H"){
            $this->pdf->ln(25);
            $this->addCell($this->getColW(1), $this->lineHeight, "", 0, 'L', 0, 'T', 10, 'B');
            $this->addMCell($this->getColW(2,3), $this->lineHeight, "Signature Hostel Suptt/Warden", 0, 'L', 0, 'T', 12, '');
            $this->addCell($this->getColW(4,5), $this->lineHeight, "Signature Dean Admission", 0, 'R', 0, 'T', 12, '');
            
            $this->addCell($this->getColW(6), $this->lineHeight, "", 0, 'L', 1, 'T', 10, 'B');


            $this->pdf->ln(10);
            $this->addCell($this->getColW(1), $this->lineHeight, "", 0, 'L', 0, 'T', 10, 'B');
            $this->addMCell($this->getColW(2,5), $this->lineHeight, "Signature Fee Clerk", 0, 'C', 0, 'T', 12, '');
            $this->addCell($this->getColW(6), $this->lineHeight, "", 0, 'L', 1, 'T', 10, 'B');
        }
        
    }

    private function getPhoto($type = 'photograph') {
        return $this->refund->student->attachments->where('file_type', $type)->first();
    }
}
