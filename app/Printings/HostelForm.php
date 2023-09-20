<?php

namespace App\Printings;

use Illuminate\Database\Eloquent\Model;
use TCPDF;

class HostelForm extends PrintPdf
{
    protected $admform = null;
    protected $subject = null;
    protected $pdf = null;
    protected $hight = 0;
    protected $pageno = 0;
    protected $nextpage = '';
    protected $copyno = 0;
    protected $footerHight = 0;
    protected $sno = 1;
    protected $gap = 1;
    protected $fontsize = 11;
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
        $this->addCell(0, 5, "Hostel Admission Form  ", 0, 'C', 1, 'T', 12, '');
        $this->addCell(0, 5, "SESSION " . get_fy_label(), 0, 'C', 1, 'T', 12, '');
        $this->addCell(170, 0, "Online Form No.: ", 0, 'R', 0, 'T', 12, '');
        $this->addMCell(40, 0, $this->admform->HostelData->fee_paid == 'Y'?$this->admform->id:"Fees Not Paid", 0, 'L', 1, 'T', 12, 'B');
        $this->pdf->ln($this->gap);
    
        $topY = $pdf->getY();
        if ($this->admform->lastyr_rollno) {
            $this->addCell(175, 0, 'Roll No : '.$this->admform->lastyr_rollno, 0, 'R', 1, 'T', 10, '');
        } else {
            $this->addCell(190, 0, 'TO BE ALLOTED BY OFFICE', 0, 'R', 1, 'T', 10, '');
            $this->addCell(190, 0, 'Roll No........................................', 0, 'R', 1, 'T', 10, '');
        }
        $this->pdf->Rect($this->lm +145, $topY - 1, $this->pageWidth-150, $pdf->getY() - $topY+2);

        $this->addCell(15, 0, "Class: ", 0, 'L', 0, 'T', 12, 'B');
        $this->addCell(30, 0, $this->admform->course->course_name, 0, 'L', 1, 'T', 12, '');
        $this->pdf->ln($this->gap);

        //   $this->addCell(65, 0, "Pool: ", 0, 'L', 0, 'T', 12, 'B');
        //   $this->addCell(30, 0, $this->admform->loc_cat  . " Pool", 0, 'L', 1, 'T', 12, '');
        //   $this->pdf->ln($this->gap);
      
      
        $previous_exam = '';
        foreach ($this->admform->academics as $exam) {
            if ($exam->last_exam == "Y") {
                $previous_exam = $exam;
            }
        }
  
        $file = $this->getPhoto();
        // $pdf->Image(public_path("/dist/img/avatar2.png"), 157, 55, 50, 50, '', '', '', true, 100, '', false, false, 0, false, false, false);
        if ($file) {
            $pdf->Image(storage_path() . "/app/images/photograph" . '_' . $this->admform->id . '.' . $file->file_ext, 160, 55, 40, 50, '', '', '', true, 100, '', false, false, 0, false, false, false);
        }
        //demo photo
        //commented photo
        $pdf->setX($pdf->getX());
  
        $this->addCell(55, 0, "1. Student's Name: ", 0, 'L', 0, 'T', $this->fontsize, 'B');
        $this->addCell(($this->pageWidth / 2) - 50, 0, $this->admform->name, 0, 'L', 1, 'T', $this->fontsize, '');
        $this->pdf->ln($this->gap);

        $this->addCell(55, 0, "2. Date Of Birth: ", 0, 'L', 0, 'T', $this->fontsize, 'B');
        $this->addCell(($this->pageWidth / 2) - 50, 0, $this->admform->dob, 0, 'L', 1, 'T', $this->fontsize, '');
        $this->pdf->ln($this->gap);
  
        $this->addCell(55, 0, "3. Father's Name: ", 0, 'L', 0, 'T', $this->fontsize, 'B');
        $this->addCell(($this->pageWidth / 2) - 50, 0, $this->admform->father_name, 0, 'L', 1, 'T', $this->fontsize, '');
        $this->pdf->ln($this->gap);
  
        $this->addCell(55, 0, "4. Mother's Name: ", 0, 'L', 0, 'T', $this->fontsize, 'B');
        $this->addCell(($this->pageWidth / 2) - 50, 0, $this->admform->mother_name, 0, 'L', 1, 'T', $this->fontsize, '');
        $this->pdf->ln($this->gap);

        $this->addCell(55, 0, "5. Nationality: ", 0, 'L', 0, 'T', $this->fontsize, 'B');
        $this->addCell(($this->pageWidth / 2) - 50, 0, $this->admform->nationality, 0, 'L', 1, 'T', $this->fontsize, '');
        $this->pdf->ln($this->gap);

        $this->addCell(55, 0, "6. Father's Profession: ", 0, 'L', 0, 'T', $this->fontsize, 'B');
        $this->addCell(($this->pageWidth / 2) - 50, 0, $this->admform->father_occup, 0, 'L', 1, 'T', $this->fontsize, '');
        $this->pdf->ln($this->gap);

        $this->addCell(55, 0, "7. Father's Annual income: ", 0, 'L', 0, 'T', $this->fontsize, 'B');
        $this->addCell(($this->pageWidth / 2) - 50, 0, strtoupper($this->admform->annual_income), 0, 'L', 1, 'T', $this->fontsize, '');
        $this->pdf->ln($this->gap);

        $address = preg_replace('/[\n\r]/', ' ', $this->admform->per_address);
        $this->addCell(55, 0, "8. Permanent Address: ", 0, 'L', 0, 'T', $this->fontsize, 'B');
        $this->addMCell(($this->pageWidth / 2)-8, 20, $address . ' ' . $this->admform->city, 0, 'L', 1, 'T', $this->fontsize, '');
        $pdf->setX($pdf->getX()+55);
        $this->addCell(10, 0, "State:  ", 0, 'L', 0, 'T', $this->fontsize, 'B');
        $this->addMCell((140), 0, data_get($this->admform->permanentState, 'state'), 0, 'L', 1, 'T', $this->fontsize, '');
       
        $this->pdf->ln($this->gap);
        $pdf->setX($pdf->getX()+55);
        $this->addCell(37, 0, "Mobile No. (Student): ", 0, 'L', 0, 'T', $this->fontsize, 'B');
        $this->addCell((20), 0, $this->admform->mobile, 0, 'L', 1, 'T', $this->fontsize, '');
        $this->pdf->ln($this->gap);
        $pdf->setX($pdf->getX()+55);
        $this->addCell(37, 0, "Mobile No. (Father): ", 0, 'L', 0, 'T', $this->fontsize, 'B');
        $this->addCell((20), 0, $this->admform->father_mobile, 0, 'L', 1, 'T', $this->fontsize, '');
        $this->pdf->ln($this->gap);
        $pdf->setX($pdf->getX()+55);
        $this->addCell(37, 0, "Mobile No. (Mother): ", 0, 'L', 0, 'T', $this->fontsize, 'B');
        $this->addCell((20), 0, $this->admform->mother_mobile, 0, 'L', 1, 'T', $this->fontsize, '');
        $this->pdf->ln($this->gap);

        $this->addCell(55, 0, "9. Name of local Guardian: ", 0, 'L', 0, 'T', $this->fontsize, 'B');
        $this->addCell(($this->pageWidth / 2) - 50, 0, $this->admform->hostelData->guardian_name, 0, 'L', 1, 'T', $this->fontsize, '');
        $this->pdf->ln(3);

        $pdf->setX($pdf->getX()+5);

        $guardian_address = preg_replace('/[\n\r]/', ' ', $this->admform->hostelData->guardian_address);
        $this->addCell(70, 0, "i) Address of Local Guardian: ", 0, 'L', 0, 'T', $this->fontsize, 'B');
        $this->addMCell((120), 0, $guardian_address, 0, 'L', 1, 'T', $this->fontsize, '');
        $this->pdf->ln($this->gap);

        $pdf->setX($pdf->getX()+5);

        $this->addCell(70, 0, "ii) Telephone No.(Office): ", 0, 'L', 0, 'T', $this->fontsize, 'B');
        $this->addMCell((120), 0, $this->admform->hostelData->guardian_phone, 0, 'L', 1, 'T', $this->fontsize, '');
        $this->pdf->ln($this->gap);

        $pdf->setX($pdf->getX()+5);
        $this->addCell(70, 0, "iii) Telephone No.(Residence): ", 0, 'L', 0, 'T', $this->fontsize, 'B');
        $this->addMCell((120), 0, $this->admform->hostelData->guardian_phone, 0, 'L', 1, 'T', $this->fontsize, '');
        $this->pdf->ln($this->gap);
      
        $pdf->setX($pdf->getX()+5);
        $this->addCell(70, 0, "iv) Relationship with Local Guardian: ", 0, 'L', 0, 'T', $this->fontsize, 'B');
        $this->addMCell((120), 0, $this->admform->hostelData->guardian_relationship, 0, 'L', 1, 'T', $this->fontsize, '');
        $this->pdf->ln(2);
      
        $this->addCell(55, 0, "10. If you were in Hostel of this college earlier, give particulars ", 0, 'L', 1, 'T', $this->fontsize, 'B');
        $this->pdf->ln(2);
   
        $pdf->setX($pdf->getX()+15);
        $this->addCell(($this->pageWidth / 2) - 68, 0, "Hostel Block:", 0, 'L', 0, 'T', $this->fontsize, 'B');
        $this->addCell(35, 0, ($this->admform->HostelData ?  $this->admform->HostelData->prv_hostel_block : 'NA'), 0, 'L', 0, 'T', $this->fontsize, '');
        $this->addCell(35, 0, "Room No.:", 0, 'L', 0, 'T', $this->fontsize, 'B');
        $this->addCell(35, 0, ($this->admform->HostelData ?  $this->admform->HostelData->prv_room_no: 'NA'), 0, 'L', 1, 'T', $this->fontsize, '');
        // for next line
        $this->pdf->ln($this->gap);
        $pdf->setX($pdf->getX()+15);
        $this->addCell(($this->pageWidth / 2) - 68, 0, "Class:", 0, 'L', 0, 'T', $this->fontsize, 'B');
        $this->addCell(35, 0, ($this->admform->HostelData ?  $this->admform->HostelData->prv_class : 'NA'), 0, 'L', 0, 'T', $this->fontsize, '');
        $this->addCell(35, 0, "College Roll No.:", 0, 'L', 0, 'T', $this->fontsize, 'B');
        $this->addCell(35, 0, ($this->admform->HostelData ?  $this->admform->HostelData->prv_roll_no: 'NA'), 0, 'L', 1, 'T', $this->fontsize, '');
        // for next line
        $this->pdf->ln(2);

        $this->addCell(90, 0, "11. If you have any serious ailment, give particulars:- ", 0, 'L', 0, 'T', $this->fontsize, 'B');
        $this->addMCell(($this->pageWidth / 2) - 15, 0, ($this->admform->HostelData ?  $this->admform->HostelData->serious_ailment: 'NA'), 0, 'L', 1, 'T', $this->fontsize, '');
        $this->pdf->ln($this->gap);
        $pdf->setX($pdf->getX()+5);
        $this->addCell(90, 0, "(Non-disclosure of Medical information will lead to suspension from Hostel) ", 0, 'L', 1, 'T', $this->fontsize);
        $this->pdf->ln($this->gap);

        $this->addCell(125, 0, "12. Do you belong to Scheduled caste/ Scheduled Tribe/ Backward Class:", 0, 'L', 0, 'T', $this->fontsize, 'B');
        $this->addCell(($this->pageWidth / 2) - 15, 0, ($this->admform->HostelData ?  ($this->admform->HostelData->schedule_backward_tribe == 'Y' ? 'Yes' : 'No') : 'NA'), 0, 'L', 1, 'T', $this->fontsize, '');
        // $pdf->setX($pdf->getX()+5);
        // $this->addCell(90, 0, " ", 0, 'L', 1, 'T', $this->fontsize);
        $this->pdf->ln(2);
        $remarks = '';
        $count = 0;
        if($this->admform->vaccinated == 'Not Yet'){
            $remarks = ' ( ' . $this->admform->vaccination_remarks .' )';
            $count = strlen($remarks);
        }
        $this->addCell(80, 0, "13. Have you been Vaccinated for COVID-19 :", 0, 'L', 0, 'T', $this->fontsize, 'B');
        $this->addMCell(($this->pageWidth / 2) , 0, $this->admform->vaccinated .$remarks, 0, 'L', 1, 'T', 10, '');
        $this->pdf->ln(1);
        // dd($this->admform);
        $ac = '';
        if($this->admform->HostelData){
            // dd($this->admform->HostelData->ac_room);
            if($this->admform->HostelData->ac_room == 'Y'){
                $ac = 'Yes';
            }
            else{
                $ac = 'No';
            }
        }
        if($this->admform->course->course_year == '1'){
            $this->addCell(80, 0, "14. Do you want to apply for AC Room ? :", 0, 'L', 0, 'T', $this->fontsize, 'B');
            $this->addMCell(($this->pageWidth / 2) , 0, $ac.' (*First cum first serve basis)', 0, 'L', 1, 'T', 10, '');
        }
        
        if($count > 50){
            $this->pdf->ln(2);
        }
        else{
            if($this->admform->course->course_year != '1'){
                $this->pdf->ln(4);
            }
            else{
                $this->pdf->ln(2);
            }
            
        }
        
        
        $this->addCell(0, 5, "LAST BOARD/UNIVERSITY RESULT", 0, 'L', 1, 'T', 12, 'B');
        $this->pdf->ln($this->gap);



        // $tbl = <<<EOD
        // <table  border="1" width = "100%">
        // <tr>
//     <td rowspan="2" width="80" align= "center">EXAMINATION</td>
//     <td rowspan="2" width="40" align= "center">YEAR</td>
//     <td rowspan="2" width="60" width = "20%" align= "center">UNIVERSITY/BOARD</td>
//     <td rowspan="2" width="40"align= "center">ROLL NO.</td>
//     <td rowspan="2" width="80" align= "center">SCHOOL/ COLLEGE</td>
//     <td rowspan="2" width="80" align= "center">PASSED/ FAILED/ COMP </td>
//     <td width="70" align= "center">MARKS OBTAINED</td>
//     <td width="40" align= "center" rowspan = "2">%</td>
        // </tr>
        // <tr>
        // <td  width="70" align= "center">TOTAL MARKS</td>
        // </tr>
        // </table>
        // EOD;

        //  $pdf->writeHTML($tbl, true, false, false, false, '');

        $this->addMCell(35, 12, "EXAMINATION", 1, 'C', 0, 'M', '', 'B');
        $this->addMCell(15, 12, "YEAR ", 1, 'C', 0, 'M', '', 'B');
        $this->addMCell(35, 12, " UNIVERSITY/BOARD ", 1, 'C', 0, 'M', '', 'B');
        $this->addMCell(18, 12, "ROLL NO.", 1, 'C', 0, 'M', '', 'B');
        $this->addMCell(25, 12, "SCHOOL/ COLLEGE ", 1, 'C', 0, 'M', '', 'B');
        $this->addMCell(35, 12, "PASSED/ FAILED/ COMP.\n ATTACH COPY OF RESULT ", 1, 'C', 0, 'M', '', 'B');
        $this->addMCell(15, 12, "Marks ", 1, 'C', 0, 'M', '', 'B');
        $this->addMCell(15, 12, "% ", 1, 'C', 1, 'M', '', 'B');
      
        foreach ($this->admform->academics as $academic) {
            if ($academic->last_exam == 'Y') {
                $this->addMCell(35, 15, $academic->exam, 1, 'C', 0, 'M', '', '');
                $this->addMCell(15, 15, $academic->year, 1, 'C', 0, 'M', '', '');
                $this->addMCell(35, 15, ($academic->board)? $academic->board->name:$academic->other_board, 1, 'C', 0, 'M', '', '');
                $this->addMCell(18, 15, $academic->rollno, 1, 'C', 0, 'M', '', '');
                $this->addMCell(25, 15, $academic->institute, 1, 'C', 0, 'M', '', '');
                $this->addMCell(35, 15, $academic->result, 1, 'C', 0, 'M', '', '');
                $this->addMCell(15, 15, $academic->marks_obtained, 1, 'C', 0, 'M', '', '');
                $this->addMCell(15, 15, $academic->marks_per, 1, 'C', 1, 'M', '', '');
            }
        }

        $this->pdf->ln(5);
        // $this->addCell(125, 0, "13. Documents to be attached:", 0, 'L', 1, 'T', $this->fontsize, 'B');
        // $pdf->setX($pdf->getX()+15);
        // $this->addCell(90, 0, "i) Date of Birth ", 0, 'L', 1, 'T', $this->fontsize, 'B');
        // $pdf->setX($pdf->getX()+15);
        // $this->addCell(90, 0, "ii) Photocopy of Detailed Marksheet", 0, 'L', 1, 'T', $this->fontsize, 'B');
        $this->addCell(0, 0, "Checking In-Charge", 0, 'R', 1, 'T', $this->fontsize, 'B');

        $this->pdf->Line($this->lm, $this->pdf->getY(), $this->pageWidth + $this->lm, $this->pdf->getY(), '', 1);
        $this->pdf->ln();
        $file = $this->getPhoto('parent_signature');
        if ($file) {
            $pdf->Image(storage_path() . "/app/images/parent_signature" . '_' . $this->admform->id . '.' . $file->file_ext, 10, 253, 50, 10, '', '', '', true, 100, '', false, false, 0, false, false, false);
        }

        $file = $this->getPhoto('signature');
        if ($file) {
            $pdf->Image(storage_path() . "/app/images/signature" . '_' . $this->admform->id . '.' . $file->file_ext, 70, 253, 50, 10, '', '', '', true, 100, '', false, false, 0, false, false, false);
        }
        $this->pdf->ln(4);
        $this->addCell(($this->pageWidth / 2) - 30, 5, "Parent's / Guardian's Signature", 0, 'L', 0, 'T', 10, 'B');
        $this->addCell(($this->pageWidth / 2) - 50, 5, "Student's Signature", 0, 'L', 0, 'T', 10, 'B');
        $this->addCell(0, 5, " Convener Hostel Committee", 0, 'R', 1, 'T', 10, 'B');
        $this->pdf->ln(4);

        $this->addCell(($this->pageWidth / 2) - 30, 5, "Date", 0, 'L', 0, 'T', 10, '');
        $this->addCell(($this->pageWidth / 2) - 50, 5, "For Office Use Only", 0, 'L', 0, 'T', 10, 'B');
        $this->pdf->ln(8);
      
        $this->addCell(78, 0, "Received Rupees.................................................... ", 0, 'L', 0, 'T', $this->fontsize, '');
        $this->addCell(75, 0, "Vide Receipt no.................................................. ", 0, 'L', 0, 'T', $this->fontsize, '');
        $this->addCell(90, 0, "date.................................... ", 0, 'L', 1, 'T', $this->fontsize, '');
      
        $this->pdf->ln($this->gap);
        // $this->addCell(90, 0, "Date of leaving the Hostel:.............................................. ", 0, 'L', 1, 'T', $this->fontsize, 'B');
        
        // Page number
        $this->SetYPos(-8);
        $this->addCell(0, 5, 'Page ' . $this->getPageNo(), 0, 'R', 1, 'T', 10, 'B');
 

        // new Page
        $this->addNewPage('P', 'A4');
        $this->pdf->ln(3);
        if (!$this->admform->lastyr_rollno) {
            $this->addCell(0, 5, "Room-Mate Preference", 0, 'C', 1, 'T', 12, 'B');
            $this->pdf->ln($this->gap);
            $this->addCell(0, 5, "FOR FRESH ADMISSIONS ONLY", 0, 'C', 1, 'T', 12, 'BU');
            $this->pdf->ln($this->gap);
            $this->addCell(0, 5, "Please indicate Room-Mates Choice (if any)", 0, 'C', 1, 'T', 14, 'BI');
            $this->pdf->ln($this->gap);

            $this->addMCell(30, 8, "", 1, 'C', 0, 'M', '', 'B');
            $this->addMCell(54, 8, "I", 1, 'C', 0, 'M', '', 'B');
            $this->addMCell(54, 8, "II", 1, 'C', 0, 'M', '', 'B');
            $this->addMCell(54, 8, "III", 1, 'C', 1, 'M', '', 'B');
        
            $this->addMCell(30, 8, "Name", 1, 'C', 0, 'M', '', 'B');
            $this->addMCell(54, 8, "", 1, 'C', 0, 'M', '', 'B');
            $this->addMCell(54, 8, "", 1, 'C', 0, 'M', '', 'B');
            $this->addMCell(54, 8, "", 1, 'C', 1, 'M', '', 'B');
        
            $this->addMCell(30, 8, "Class", 1, 'C', 0, 'M', '', 'B');
            $this->addMCell(54, 8, "", 1, 'C', 0, 'M', '', 'B');
            $this->addMCell(54, 8, "", 1, 'C', 0, 'M', '', 'B');
            $this->addMCell(54, 8, "", 1, 'C', 1, 'M', '', 'B');

            $this->addMCell(30, 8, "Roll No.", 1, 'C', 0, 'M', '', 'B');
            $this->addMCell(54, 8, "", 1, 'C', 0, 'M', '', 'B');
            $this->addMCell(54, 8, "", 1, 'C', 0, 'M', '', 'B');
            $this->addMCell(54, 8, "", 1, 'C', 1, 'M', '', 'B');

            $this->addMCell(30, 8, "Place", 1, 'C', 0, 'M', '', 'B');
            $this->addMCell(54, 8, "", 1, 'C', 0, 'M', '', 'B');
            $this->addMCell(54, 8, "", 1, 'C', 0, 'M', '', 'B');
            $this->addMCell(54, 8, "", 1, 'C', 1, 'M', '', 'B');

            $this->addMCell(30, 8, "Relation(if any)", 1, 'C', 0, 'M', '', 'B');
            $this->addMCell(54, 8, "", 1, 'C', 0, 'M', '', 'B');
            $this->addMCell(54, 8, "", 1, 'C', 0, 'M', '', 'B');
            $this->addMCell(54, 8, "", 1, 'C', 1, 'M', '', 'B');

            $this->addMCell(30, 8, "Signature", 1, 'C', 0, 'M', '', 'B');
            $this->addMCell(54, 8, "", 1, 'C', 0, 'M', '', 'B');
            $this->addMCell(54, 8, "", 1, 'C', 0, 'M', '', 'B');
            $this->addMCell(54, 8, "", 1, 'C', 1, 'M', '', 'B');
        }

        $this->pdf->ln(8);
        $this->addCell(70, 5, "", 0, 'C', 0, 'T', 12, 'B');
        $this->addCell(50, 5, "DECLARATION", 1, 'C', 0, 'T', 12, 'B');
        $this->addCell(0, 5, "", 0, 'C', 1, 'T', 12, 'B');
        $this->pdf->ln(3);
        $this->addCell(0, 0, "1. I pledge to abide by the rules and regulations of the Hostel and the college. ", 0, 'M', 1, 'T', 10, 'B');
        $this->addCell(0, 0, "2. I will not go against the discipline, unity and healthy  atmosphere of the Hostel. ", 0, 'M', 1, 'T', 10, 'B');
        $this->addCell(0, 0, "3. I shall not damage movable and immovable property of the Hostel. ", 0, 'M', 1, 'T', 10, 'B');
        $this->addCell(0, 0, "4. I shall not keep any guest in my room. ", 0, 'M', 1, 'T', 10, 'B');
        $this->addCell(0, 0, "5. I shall not stay out for night without the prior permission of the Warden/Principal. ", 0, 'M', 1, 'T', 10, 'B');
        $this->addCell(0, 0, "6. I shall not leave station/Hostel without prior permission of the concerned authority. ", 0, 'M', 1, 'T', 10, 'B');
        $this->addCell(0, 0, "7. I shall not keep any electric appliance, hard cash or valuable in my room. ", 0, 'M', 1, 'T', 10, 'B');
        $this->addCell(0, 0, "8. I shall attend all the Hostel functions, meetings and havans. ", 0, 'M', 1, 'T', 10, 'B');
        $this->addCell(0, 0, "9. I shall not bring any vehicle to the Hostel premises. ", 0, 'M', 1, 'T', 10, 'B');
        $this->addCell(0, 0, "10. I shall positively submit Medical Certificate at the time of Hostel entry. ", 0, 'M', 1, 'T', 10, 'B');
        $this->addCell(0, 0, "11. I shall not violate Hostel or College rules, if found a defaulter, I may be expelled. ", 0, 'M', 1, 'T', 10, 'B');
        $this->addCell(0, 0, "12. I shall not indulge in ragging as I am aware that ragging is punishable by law.", 0, 'M', 1, 'T', 10, 'B');
        $this->addCell(0, 0, "13. I have carefully read all the instructions and confirm to abide by them. ", 0, 'M', 1, 'T', 10, 'B');
        $this->addCell(0, 0, "14. I shall ensure minimum of requisite 75% attendence in the Hostel & all the subjects in the college.", 0, 'M', 1, 'T', 10, 'B');
      
        $this->pdf->ln(15);

        $email = ($std_user = $this->admform->std_user) ? $std_user->email : '';
        $file = $this->getPhoto('signature');
        if ($file) {
            if (!$this->admform->lastyr_rollno) {
                $pdf->Image(storage_path() . "/app/images/signature" . '_' . $this->admform->id . '.' . $file->file_ext, 150, 165, 50, 10, '', '', '', true, 100, '', false, false, 0, false, false, false);
            } else {
                $pdf->Image(storage_path() . "/app/images/signature" . '_' . $this->admform->id . '.' . $file->file_ext, 150, 90, 50, 10, '', '', '', true, 100, '', false, false, 0, false, false, false);
            }
        }
        // $this->pdf->ln(8);
        $this->addMCell(($this->pageWidth / 2 - 20), 5, "Date: .................", 0, 'L', 0, 'T', 11, 'B');
        $this->addMCell(($this->pageWidth / 2), 5, "Signature of Student", 0, 'R', 1, 'T', 11, 'B');
        $this->pdf->ln($this->gap);
      
        $this->pdf->ln(8);
        $this->addCell(48, 5, "", 0, 'C', 0, 'T', 12, 'B');
        $file = $this->getPhoto('parent_signature');
        if ($file) {
            $pdf->Image(storage_path() . "/app/images/parent_signature" . '_' . $this->admform->id . '.' . $file->file_ext, 10, 235, 50, 10, '', '', '', true, 100, '', false, false, 0, false, false, false);
        }
        $this->addCell(90, 5, "PARENT'S/ GUARDIAN'S DECLARATION", 1, 'C', 0, 'T', 12, 'B');
        $this->addCell(0, 5, "", 0, 'C', 1, 'T', 12, 'B');
        $this->pdf->ln(3);
     

        $this->pdf->ln($this->gap);
        $this->addCell(($this->pageWidth / 2) - 98, 5, "I", 0, 'L', 0, 'T', 11, '');
        $this->addCell(($this->pageWidth / 2) - 28, 5, "_____________________________________", 0, 'L', 0, 'T', 11, '');
        $this->addCell(($this->pageWidth / 2) - 25, 5, "father/mother/guardian of " .  $this->admform->name, 0, 'L', 1, 'T', 11, '');
        $father_declaration = "declare that I have read all the rules and regulations thoroughly and undertake the responsibility for the proper conduct "
                              ."of my daughter/ward and her maintenance of requisite attendance in all the subjects during her stay in the Hostel. The authorities may expel "
                              ."her from the Hostel or college if she does not abide by the rules. In the interest of my own daughter/ward, I shall keep in touch with "
                              ."the warden and teachers periodically.";
        $this->addMCell(0, 5, $father_declaration, 0, 'L', 1, 'T', 11, '');
        $this->addMCell(0, 5, "Note: It is mandatory for the parent to come along with their ward at the time of Hostel entry.", 0, 'L', 1, 'T', 11, 'B');
    
        $this->pdf->ln(15);
        $this->addMCell(($this->pageWidth / 2), 5, "Signature of Parent's/Guardian", 0, 'L', 1, 'T', 11, 'B');
        $this->pdf->ln($this->gap);
      
        $this->addMCell(($this->pageWidth / 2) + 20, 5, "Date:.....................", 0, 'L', 0, 'T', 11, 'B');
        $this->addMCell(($this->pageWidth / 2)- 30, 5, "Address:.......................................................................................................................", 0, 'R', 1, 'T', 11, 'B');
        $this->pdf->ln(5);

        // Page number
        $this->SetYPos(-8);
        $this->addCell(0, 5, 'Page ' . $this->getPageNo(), 0, 'R', 1, 'T', 10, 'B');
        // new Page
        $this->addNewPage('P', 'A4');
        $this->pdf->ln(3);

        $this->pdf->ln(5);
        $pdf->Image(public_path("/dist/img/mcm-logo.png"), $this->lm + 2, $this->tm, 25, 25, 'PNG', '', '', true, 100, '', false, false, 0, false, false, false);
        $this->addCell(($this->pageWidth / 2) + 65, 5, "Mehr Chand Mahajan DAV College For Women", 0, 'C', 1, 'T', 16, 'B');
        $this->addCell(($this->pageWidth / 2) + 65, 5, "Sector 36-A, Chandigarh", 0, 'C', 1, 'T', 16, 'B');
        $this->pdf->ln(4);
        $this->addCell(($this->pageWidth / 2) + 65, 5, "Visitor's Form  ", 0, 'C', 1, 'T', 14, 'B');
        $this->addCell(($this->pageWidth / 2) + 65, 5, "To be submitted at the time of Hostel Entry  ", 0, 'C', 1, 'T', 13, '');
        $this->addCell(($this->pageWidth / 2) + 65, 5, "(Medical Certificate to be attached) ", 0, 'C', 1, 'T', 13, '');
        // $this->addCell(($this->pageWidth / 2) + 65, 5, "Online Form No.:" .$this->admform->HostelData->fee_paid == 'Y'?$this->admform->id:"Fees Not Paid", 0, 'C', 1, 'T', 13, '');

        //   $this->addCell(65, 0, "Pool: ", 0, 'L', 0, 'T', 12, 'B');
        //   $this->addCell(30, 0, $this->admform->loc_cat  . " Pool", 0, 'L', 1, 'T', 12, '');
        //   $this->pdf->ln($this->gap);
       
       
        $previous_exam = '';
        foreach ($this->admform->academics as $exam) {
            if ($exam->last_exam == "Y") {
                $previous_exam = $exam;
            }
        }
   
        $file = $this->getPhoto();
        // $pdf->Image(public_path("/dist/img/avatar2.png"), 157, 55, 50, 50, '', '', '', true, 100, '', false, false, 0, false, false, false);
        if ($file) {
            $pdf->Image(storage_path() . "/app/images/photograph" . '_' . $this->admform->id . '.' . $file->file_ext, 160, 10, 40, 45, '', '', '', true, 100, '', false, false, 0, false, false, false);
        }
        //demo photo
        //commented photo
        $this->pdf->ln(10);
        $this->addCell(35, 0, "Name of student: ", 0, 'L', 0, 'T', $this->fontsize, 'B');
        $this->addCell(45, 0, $this->admform->name, 0, 'L', 0, 'T', $this->fontsize, '');

        $lastyr_rollno = $this->admform->lastyr_rollno ?  $this->admform->lastyr_rollno:"............................";
        $this->addCell(18, 0, "Roll No.: ", 0, 'L', 0, 'T', $this->fontsize, 'B');
        $this->addCell(35, 0, $lastyr_rollno, 0, 'L', 1, 'T', $this->fontsize, '');
       


        $this->pdf->ln($this->gap);
        $email = ($std_user = $this->admform->std_user) ? $std_user->email : '';
        $this->addCell(35, 0, "Mobile No.: ", 0, 'L', 0, 'T', $this->fontsize, 'B');
        $this->addCell(45, 0, $this->admform->mobile, 0, 'L', 0, 'T', $this->fontsize, '');
        $this->addCell(35, 0, "Student's Email.: ", 0, 'L', 0, 'T', $this->fontsize, 'B');
        $this->addCell(35, 0, $email, 0, 'L', 1, 'T', $this->fontsize, '');

        $this->pdf->ln($this->gap);
        $this->addCell(35, 0, "Block No.: ", 0, 'L', 0, 'T', $this->fontsize, 'B');
        $this->addCell(45, 0, "...............................", 0, 'L', 0, 'T', $this->fontsize, '');
        $this->addCell(35, 0, "Room No.: ", 0, 'L', 0, 'T', $this->fontsize, 'B');
        $this->addCell(35, 0, "...............................", 0, 'L', 1, 'T', $this->fontsize, '');
        $this->pdf->ln($this->gap);
        $this->addCell(35, 0, "Class: ", 0, 'L', 0, 'T', $this->fontsize, 'B');
        $this->addCell(45, 0, $this->admform->course->course_name, 0, 'L', 1, 'T', $this->fontsize, '');

        $this->pdf->ln(13);
        $this->addCell(($this->pageWidth / 2), 0, "Parent's Particulars", 0, 'C', 0, 'T', 14, 'B');
        $pdf->setX(($this->pageWidth / 2) + 20);
        $this->addCell(($this->pageWidth / 2)/2 + 10, 0, "Local Guardian's Particulars", 0, 'C', 1, 'T', 14, 'B');
        $this->pdf->ln(3);

        $this->addCell(($this->pageWidth / 2)/2 - 10, 0, "Father's Name :", 0, 'L', 0, 'T', $this->fontsize, 'B');
        $this->addCell(($this->pageWidth / 2)/2 + 10, 0, $this->admform->father_name, 0, 'L', 0, 'T', $this->fontsize, '');
        $this->addCell(($this->pageWidth / 2)/2 - 10, 0, "Relation :", 0, 'L', 0, 'T', $this->fontsize, 'B');
        $this->addCell(($this->pageWidth / 2)/2 - 10, 0, $this->admform->hostelData->guardian_relationship, 0, 'L', 1, 'T', $this->fontsize, '');
        $this->pdf->ln(3);

        $this->addCell(($this->pageWidth / 2)/2 - 10, 0, "Phone No :", 0, 'L', 0, 'T', $this->fontsize, 'B');
        $this->addCell(($this->pageWidth / 2)/2 + 10, 0, $this->admform->father_mobile, 0, 'L', 0, 'T', $this->fontsize, '');
        $this->addCell(($this->pageWidth / 2)/2 - 10, 0, "LG's Name (Mr.) :", 0, 'L', 0, 'T', $this->fontsize, 'B');
        $this->addCell(($this->pageWidth / 2)/2 - 10, 0, $this->admform->hostelData->guardian_name, 0, 'L', 1, 'T', $this->fontsize, '');
        $this->pdf->ln(3);

        $this->addCell(($this->pageWidth / 2)/2 - 10, 0, "Mother's Name :", 0, 'L', 0, 'T', $this->fontsize, 'B');
        $this->addCell(($this->pageWidth / 2)/2 + 10, 0, $this->admform->mother_name, 0, 'L', 0, 'T', $this->fontsize, '');
        $this->addCell(($this->pageWidth / 2)/2 - 10, 0, "Phone No.:", 0, 'L', 0, 'T', $this->fontsize, 'B');
        $this->addCell(($this->pageWidth / 2)/2 - 10, 0, $this->admform->hostelData->guardian_mobile, 0, 'L', 1, 'T', $this->fontsize, '');
        $this->pdf->ln(3);


        $this->addCell(($this->pageWidth / 2)/2 - 10, 0, "Phone No. :", 0, 'L', 0, 'T', $this->fontsize, 'B');
        $this->addCell(($this->pageWidth / 2)/2 + 10, 0, $this->admform->mother_mobile, 0, 'L', 0, 'T', $this->fontsize, '');
        $this->addCell(($this->pageWidth / 2)/2 - 10, 0, "LG's Name(Mrs).:", 0, 'L', 0, 'T', $this->fontsize, 'B');
        $this->addCell(($this->pageWidth / 2)/2 - 10, 0, "__________________", 0, 'L', 1, 'T', $this->fontsize, '');
        $this->pdf->ln(3);
   
        $g_address = preg_replace('/[\n\r]/', ' ', $this->admform->hostelData->guardian_address);
        $this->addCell(($this->pageWidth / 2)/2-10, 0, "Parent's Email :", 0, 'L', 0, 'T', $this->fontsize, 'B');
        $this->addMCell(($this->pageWidth / 2)/2, 0, $this->admform->father_email, 0, 'L', 0, 'T', $this->fontsize, '');
        $pdf->setX($pdf->getX()+10);
        $this->addCell(($this->pageWidth / 2)/2 - 10, 0, "Phone No. :", 0, 'L', 0, 'T', $this->fontsize, 'B');
        $this->addCell(($this->pageWidth / 2)/2 - 10, 0, "__________________", 0, 'L', 1, 'T', $this->fontsize, '');
        $pdf->setX(($this->pageWidth / 2) +10);
       
        $this->pdf->ln(5);

        $address = preg_replace('/[\n\r]/', ' ', $this->admform->per_address."\n". data_get($this->admform, 'city') . " \nState: ".data_get($this->admform->permanentState, 'state'));
        $this->addCell(($this->pageWidth / 2)/2 - 10, 0, "Permanent Address:", 0, 'L', 0, 'T', $this->fontsize, 'B');
        $this->addMCell(($this->pageWidth / 2)/2 -10, 0, $address, 0, 'L', 0, 'T', $this->fontsize, '');
        $pdf->setX($pdf->getX()+20);
        $this->addCell(($this->pageWidth / 2)/2 - 10, 0, "Permanent Address:", 0, 'L', 0, 'T', $this->fontsize, 'B');
        $this->addMCell(($this->pageWidth / 2)/2 - 10, 0, $g_address, 0, 'L', 1, 'T', $this->fontsize, '');
        
        $this->pdf->ln(3);

        

        $this->addCell(($this->pageWidth / 2)/2 - 10, 0, "", 0, 'L', 0, 'T', $this->fontsize, 'B');
        $this->addMCell(($this->pageWidth / 2)/2 + 10, 0, "", 0, 'L', 0, 'T', $this->fontsize, '');
        $pdf->setX(($this->pageWidth / 2) +10);
        $this->addCell(($this->pageWidth / 4 - 10), 0, "LG's Email.:", 0, 'l', 0, 'T', $this->fontsize, 'B');
        $this->addMCell(($this->pageWidth / 2)/2- 10, 0, $this->admform->hostelData->guardian_email, 0, 'L', 1, 'T', $this->fontsize, '');


        $this->pdf->Rect($this->lm +5, $topY+52, $this->pageWidth-110, 100);
        $this->pdf->Rect($this->lm +($this->pageWidth / 2), $topY+52, $this->pageWidth-110, 100);
        $this->pdf->ln(5);
       
        $this->pdf->Rect($this->lm + 5, $topY+160, $this->pageWidth-160, 50);
        $this->pdf->Rect($this->lm +54, $topY+160, $this->pageWidth-160, 50);
        $this->pdf->Rect($this->lm +103, $topY+160, $this->pageWidth-160, 50);
        $this->pdf->Rect($this->lm +152, $topY+160, $this->pageWidth-160, 50);

        $this->SetYPos(-80);
        $this->addMCell(($this->pageWidth / 4)-8, 5, "PHOTOGRAPH\nOF\n FATHER", 0, 'C', 0, 'T', 10, 'B');
        $this->addMCell(($this->pageWidth / 4), 5, "PHOTOGRAPH\nOF\n MOTHER", 0, 'C', 0, 'T', 10, 'B');
        $this->addMCell(($this->pageWidth / 4), 5, "PHOTOGRAPH\nOF\n LG (1)", 0, 'C', 0, 'T', 10, 'B');
        $this->addMCell(($this->pageWidth / 4), 5, "PHOTOGRAPH\nOF\nLG(2)", 0, 'C', 1, 'T', 10, 'B');

        $this->SetYPos(-30);
        $this->addMCell(($this->pageWidth / 4)-10, 5, "..................................", 0, 'C', 0, 'T', 11, 'B');
        $this->addMCell(($this->pageWidth / 4), 5, " ......................................", 0, 'C', 0, 'T', 11, 'B');
        $this->addMCell(($this->pageWidth / 4), 5, "........................................", 0, 'C', 0, 'T', 11, 'B');
        $this->addMCell(($this->pageWidth / 4), 5, "..........................................", 0, 'C', 1, 'T', 11, 'B');

        $this->pdf->ln($this->gap);
        $this->SetYPos(-25);
        $this->addMCell(($this->pageWidth / 4)-10, 5, "Signature of Father", 0, 'C', 0, 'T', 10, 'B');
        $this->addMCell(($this->pageWidth / 4), 5, " Signature of Mother", 0, 'C', 0, 'T', 10, 'B');
        $this->addMCell(($this->pageWidth / 4), 5, "Signature Local Guardian (1)", 0, 'C', 0, 'T', 10, 'B');
        $this->addMCell(($this->pageWidth / 4), 5, "Signature Local Guardian (2)", 0, 'C', 1, 'T', 10, 'B');

        $this->SetYPos(-18);
        $this->addCell(0, 5, "Date:..................................", 0, 'L', 1, 'T', 11, 'B');
        
        // Page number
        $this->SetYPos(-8);
        $this->addCell(0, 5, 'Page ' . $this->getPageNo(), 0, 'R', 1, 'T', 10, 'B');

        $this->hight = $this->getNetHeight() - $this->footerHight;

         
         // new Page
        $this->addNewPage('P', 'A4');
        $this->pdf->ln(3);
        $this->addCell(0, 5, "CERTIFICATE OF MEDICAL FITNESS ", 0, 'C', 1, 'T', 16, 'B');
        $this->pdf->ln(3);
        $this->addCell(0, 5, "(To be obtained only from Registered Medical Practitioner)", 0, 'C', 1, 'T', 12, 'B');
        $this->pdf->ln(3);
        $this->addCell(0, 5, "Duly filled and Signed-To be Submitted Physically only at the time of Hostel Entry", 0, 'C', 1, 'T', 11, 'B');
        // $this->addCell(0, 5, "PRINTED COPY TO BE SUBMITTED AT THE TIME OF HOSTEL ENTRY", 0, 'C', 1, 'T', 11, 'B');
        $this->pdf->ln(5);
        $this->addCell(31, 0, "Name of Candidate: ", 0, 'L', 0, 'T', $this->fontsize, '');
        $this->addCell(32, 0, "(in Block Letters): ", 0, 'L', 0, 'T', $this->fontsize, 'B');
        $this->addCell(80, 0, "..................................................................................................................................", 0, 'L', 1, 'T', $this->fontsize, '');
        $this->pdf->ln($this->gap);
        $this->addCell(29, 0, "College Roll No.: ", 0, 'L', 0, 'T', $this->fontsize, '');
        $this->addCell(67, 0, ".....................................................................", 0, 'L', 0, 'T', $this->fontsize, '');
        $this->addCell(24, 0, "Date of Birth: ", 0, 'L', 0, 'T', $this->fontsize, '');
        $this->addCell(67, 0, ".......................................................................", 0, 'L', 1, 'T', $this->fontsize, '');
        $this->pdf->ln($this->gap);
        $this->addCell(23, 0, "Father Name: ", 0, 'L', 0, 'T', $this->fontsize, '');
        $this->addCell(67, 0, ".....................................................................", 0, 'L', 0, 'T', $this->fontsize, '');
        $this->addCell(46, 0, "Signature of the Candidate", 0, 'L', 0, 'T', $this->fontsize, '');
        $this->addCell(70, 0, ".......................................................", 0, 'L', 1, 'T', $this->fontsize, '');
        $this->addCell(120, 0, "...................................................................................................................................................................................................", 0, 'L', 1, 'T', $this->fontsize, '');
        $this->pdf->ln(10);
        $this->addCell(0, 5, "Medical Report", 0, 'C', 1, 'T', 11, 'B');
        $this->pdf->ln(2);
        $this->addCell(24, 0, "Blood Group: ", 0, 'L', 0, 'T', $this->fontsize, '');
        $this->addCell(48, 0, "...............................................", 0, 'L', 0, 'T', $this->fontsize, '');
        $this->addCell(14, 0, "Height: ", 0, 'L', 0, 'T', $this->fontsize, '');
        $this->addCell(43, 0, "...........................................", 0, 'L', 0, 'T', $this->fontsize, '');
        $this->addCell(15, 0, "Weight: ", 0, 'L', 0, 'T', $this->fontsize, '');
        $this->addCell(43, 0, "...............................................", 0, 'L', 1, 'T', $this->fontsize, '');
        $this->pdf->ln($this->gap);
        $this->addCell(18, 0, "Vision: L: ", 0, 'L', 0, 'T', $this->fontsize, '');
        $this->addCell(70, 0, ".......................................................................", 0, 'L', 0, 'T', $this->fontsize, '');
        $this->addCell(4, 0, "R: ", 0, 'L', 0, 'T', $this->fontsize, '');
        $this->addCell(90, 0, "......................................................................................................", 0, 'L', 1, 'T', $this->fontsize, '');
        $this->pdf->ln($this->gap);
        $this->addCell(15, 0, "Hearing: ", 0, 'L', 0, 'T', $this->fontsize, '');
        $this->addCell(95, 0, "......................................................................................................................................................................................", 0, 'L', 1, 'T', $this->fontsize, '');
        $this->pdf->ln($this->gap);
        $this->addCell(57, 0, "Any Communicable/chronic disease: ", 0, 'L', 0, 'T', $this->fontsize, '');
        $this->addCell(90, 0, "...........................................................................................................................................", 0, 'L', 1, 'T', $this->fontsize, '');
        $this->pdf->ln($this->gap);
        $this->addCell(56, 0, "Any other disease/Medical History: ", 0, 'L', 0, 'T', $this->fontsize, '');
        $this->addCell(90, 0, "............................................................................................................................................", 0, 'L', 1, 'T', $this->fontsize, '');
        $this->pdf->ln($this->gap);
        $this->addCell(25, 0, "Allergies, if any ", 0, 'L', 0, 'T', $this->fontsize, '');
        $this->addCell(70, 0, ".......................................................................", 0, 'L', 0, 'T', $this->fontsize, '');
        $this->addCell(25, 0, "Any drug allergy", 0, 'L', 0, 'T', $this->fontsize, '');
        $this->addCell(7, 0, "..........................................................................", 0, 'L', 1, 'T', $this->fontsize, '');
        $this->pdf->ln($this->gap);
        $this->addCell(45, 0, "Family history of any illness", 0, 'L', 0, 'T', $this->fontsize, '');
        $this->addCell(146, 0, ".......................................................................................................................................................", 0, 'L', 1, 'T', $this->fontsize, '');
        $this->pdf->ln($this->gap);
        $this->addCell(54, 0, "Admitted in Hospital for long time ", 0, 'L', 0, 'T', $this->fontsize, '');
        $this->addCell(138, 0, "..............................................................................................................................................", 0, 'L', 1, 'T', $this->fontsize, '');
        $this->pdf->ln($this->gap);
        $this->addCell(30, 0, "Any other remarks", 0, 'L', 0, 'T', $this->fontsize, '');
        $this->addCell(162, 0, ".......................................................................................................................................................................", 0, 'L', 1, 'T', $this->fontsize, '');
        $this->addCell(120, 0, ".....................................................................................................................................................................................................", 0, 'L', 1, 'T', $this->fontsize, '');
        
        $this->pdf->ln(10);
        $this->addCell(28, 0, "I certify that Ms: ", 0, 'L', 0, 'T', $this->fontsize, '');
        $this->addCell(61, 0, "................................................................", 0, 'L', 0, 'T', $this->fontsize, '');
        $this->addCell(20, 0, " daughter of  ", 0, 'L', 0, 'T', $this->fontsize, '');
        $this->addCell(61, 0, "................................................................", 0, 'L', 0, 'T', $this->fontsize, '');
        $this->addCell(20, 0, " is physically, ", 0, 'L', 1, 'T', $this->fontsize, '');
        $this->addCell(70, 0, " mentally & psychologically fit/unfit for studying and staying in Mehr Chand Mahajan DAV College Hostel.", 0, 'L', 1, 'T', $this->fontsize, '');
        $this->pdf->ln(10);

        $this->addCell(70, 0, "Name & Signature of the Medical Officer with legible seal", 0, 'L', 1, 'T', $this->fontsize, '');
        $this->pdf->ln($this->gap);
        $this->addCell(32, 0, "Registration number ", 0, 'L', 0, 'T', $this->fontsize, '');
        $this->addCell(70, 0, ".......................................................................", 0, 'L', 0, 'T', $this->fontsize, '');
        $this->addCell(8, 0, "Date", 0, 'L', 0, 'T', $this->fontsize, '');
        $this->addCell(70, 0, "....................................................................................", 0, 'L', 1, 'T', $this->fontsize, '');
        $this->addCell(120, 0, ".....................................................................................................................................................................................................", 0, 'L', 1, 'T', $this->fontsize, '');
        $this->pdf->ln(10);
        $this->addCell(0, 5, "For Office use only", 0, 'C', 1, 'T', 12, 'B');
        $this->pdf->ln(10);
        $this->addCell(100, 0, "Checked By:", 0, 'L', 0, 'T', 11, '');
        $this->addCell(80, 0, "Remarks (if any):", 0, 'L', 1, 'T', 11, '');
        $this->pdf->ln($this->gap);
        $this->addCell(80, 0, "Checked On:", 0, 'L', 0, 'T', 11, '');

        // Page number
        $this->SetYPos(-8);
        $this->addCell(0, 5, 'Page ' . $this->getPageNo(), 0, 'R', 1, 'T', 10, 'B');
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
  
    private function getPhoto($type = 'photograph')
    {
        return $this->admform->attachments->where('file_type', $type)->first();
    }
}
