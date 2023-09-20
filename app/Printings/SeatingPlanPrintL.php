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


class SeatingPlanPrint extends PrintPdf
{
    protected $pdf = null;
    protected $basepdf = null;
    protected $height = 0;
    protected $pageno = 0;
    protected $nextpage = '';
    protected $copyno = 0;
    protected $footerHeight = 0;
    protected $seating_plan_students=null;
    protected $locations = [];

    public function makepdf($seating_plan_students)
    {
        $this->seating_plan_students = $seating_plan_students;
        $this->basepdf = new BasePdf();
        $this->basepdf->makePdf("P","A4");
        $this->main();
        return $this->pdf;
    }


    private function main($title = '')
    {
        $pdf = $this->pdf;
        $this->setExamLocations();
        $this->pageno = 0;
        $this->footerHeight = 130;
        foreach($this->locations as $location){
            $this->pageno++;
            $this->nextpage = "N";
            $this->addNewPage("L", "A4");
            $this->pdf->SetAutoPageBreak(true, 5);
            $this->setCopy(1,$location);
        }
    }

    private function setExamLocations(){
        foreach($this->seating_plan_students as $key=>$seating_student){
            $arr = array_filter($this->locations ,function($location) use($seating_student) { 
               return $location['id'] === $seating_student['seating_plan']['exam_loc_id'] && $location['date'] === $seating_student['seating_plan']['date']; 
            });
            if(count($arr) == 0){
                $object = [
                    'id'=>$seating_student['seating_plan']['exam_loc_id'],
                    'date'=>$seating_student['seating_plan']['date'],
                    'session'=>$seating_student['seating_plan']['session'],
                    'center'=>$seating_student['seating_plan']['exam_location']['center'],
                    'exam_location'=>$seating_student['seating_plan']['exam_location'],
                    'student_seating'=>[],
                    'courses'=>[],
                    'seating_plan_staff'=>[]
                ];
                array_push($this->locations, $object);
            }
            
        }

        foreach($this->locations as $loc_key=>$location){
            foreach($this->seating_plan_students as $key=>$seating_student){
                if($location['date'] == $seating_student['seating_plan']['date'] && $location['id'] == $seating_student['seating_plan']['exam_loc_id']){
                    $object = [
                        'row_no'   =>   $seating_student['row_no'],
                        'seat_no'  =>   $seating_student['seat_no'],
                        'student'  =>   $seating_student['student'],
                        'seating_plan_id' =>  $seating_student['seating_plan_id'],
                        'course'   => $seating_student['seating_plan']['subject_section']['course']['course_name'],
                        'section' => $seating_student['seating_plan']['subject_section']['section']['section'],
                    ];
                    array_push($this->locations[$loc_key]['student_seating'],$object);

                    $course = array_filter($this->locations[$loc_key]['courses'] ,function($course) use($seating_student) { 
                        return $course['course_id'] == $seating_student['seating_plan']['subject_section']['course_id'] && $course['subject_id'] == $seating_student['seating_plan']['subject_section']['subject_id']; 
                    });
                   
                    $teacher_name = $seating_student['seating_plan']['subject_section']['teacher'] ?  $seating_student['seating_plan']['subject_section']['teacher']['name'] .'' .$seating_student['seating_plan']['subject_section']['teacher']['middle_name'].''.$seating_student['seating_plan']['subject_section']['teacher']['last_name']:'';
                    if(count($course) == 0){
                        $object = [
                            'course_id'  =>   $seating_student['seating_plan']['subject_section']['course_id'],
                            'course_name'=>   $seating_student['seating_plan']['subject_section']['course']['course_name'],
                            'subject_id' =>   $seating_student['seating_plan']['subject_section']['subject_id'],
                            'subject'    =>   $seating_student['seating_plan']['subject_section']['subject']['subject'],
                            'section'=>   $seating_student['seating_plan']['subject_section']['section']['section'],
                            'teacher'=>   $teacher_name
                                    ];
                        array_push($this->locations[$loc_key]['courses'],$object);
                    }

                    foreach($seating_student['seating_plan']['seating_plan_staff'] as $duty_staff){
                        $staff_arr = array_filter($this->locations[$loc_key]['seating_plan_staff'] ,function($staff) use($duty_staff) { 
                            return $staff['staff_id'] == $duty_staff['staff_id'];
                        });
                        if(count($staff_arr) == 0){
                            array_push($this->locations[$loc_key]['seating_plan_staff'],  $duty_staff);
                        }
                    }
                }
            }
        }

        foreach($this->locations as $loc_key=>$location){
            $last_seat_no = 0;
            foreach($location['exam_location']['exam_loc_dets'] as $key=>$det){
                $det['seat_nos'] = [];
                $arr=[];
                for($i = $last_seat_no+1; $i <= $last_seat_no+ $det['seats_in_row']; $i++){
                    array_push( $arr ,$i);
                }
                $det['seat_nos'] = $arr;
                $last_seat_no = $last_seat_no + $det['seats_in_row'] ;
            }
        }
        // dd($this->locations[0]);
      
    }

    private function setCopy($copyno, $location)
    {
        $pdf = $this->pdf;
        $this->copyno = $copyno;
        $this->header($location);
        $this->footer("E");
    }

    private function header($location)
    {
        $pdf = $this->pdf;
        $this->lineHeight = 5;
// dd($location);
        $this->GetYPos(true);
        $this->addHLine();
        $this->pdf->ln(2);

        $this->addCell(0, 5, strtoupper("Mehr Chand Mahajan DAV College For Women"), 0, 'C', 1, 'T', 14, 'B');
        $this->addHLine();
        $this->pdf->ln(1);

        $this->addCell(0, 5,'Location: ' .$location['exam_location']['location']['location'], 0, 'C', 1, 'T', 11 );

        $this->GetYPos(true);
        $this->addCols([100,100]);
        $this->addCell($this->getColW(1), 0,getCenterName($location['center']) . '  '.getSessionName($location['session']), 0, 'C', 0, 'T', 11);
        $this->addCell($this->getColW(2), 0,'(Total Seats : '. $location['exam_location']['seating_capacity'].' ,  Seats Occupied : ' . count($location['student_seating']) . ')', 0, 'C', 0, 'T', 11);
        $this->addCell($this->getColW(3), 0, 'Date : ' .$location['date'], 0, 'C', 0, 'T', 11, 'B');
        $this->pdf->ln(5);
        
        // $this->addHLine();
        $this->drawBox($this->pdf->getY(),false);
        
        $this->GetYPos(true);

        $this->addCols([200]);
       
        $count =0;
        $course_str='';
        foreach($location['courses'] as $course){
           $course_str =   $course_str . 'Course: '. $course['course_name'].', Subject: ' . $course['subject'].', Section: '. $course['section'].'' . ', Teacher: '. $course['teacher'] .chr(10);
           $count++;
        }

        $teachers='';
        foreach($location['seating_plan_staff'] as $key=>$staff){
            $teachers =   $teachers .' '. $staff['staff']['name'];
            if($key < count($location['seating_plan_staff'])-1){
                $teachers = $teachers . ',';
            }
        }
        
        $this->addMCell($this->getColW(1), 0,$course_str , 0, 'L', 0, 'T', 10);
        $this->addMCell($this->getColW(2), 0,'Duty Teachers: '. $teachers, 0, 'L', 0, 'T', 10);
        $this->pdf->ln(14);
        $this->addHLine();
        $this->drawBox($this->pdf->getY(),false);
        $this->GetYPos(true);
        //  add columns rows of seats
        // custom columns division according to number of rows

        $no_of_rows = $location['exam_location']['no_of_rows'];
        $rows = [];
        for($i = 0; $i< $no_of_rows;$i++){
            array_push($rows,288/$no_of_rows);
        }

        $this->addCols($rows);
        for($i = 1; $i<= $no_of_rows;$i++){
            $this->addCell($this->getColW($i), 0, 'Row ' .$i, 0, 'C', 0, 'T', 11, 'B');
        }
        
        $this->pdf->ln(6);
        $this->drawBox($this->pdf->getY(),false);
        $this->GetYPos(true);

        // $this->addCols($rows);
        // $this->pdf->ln(6);
        $html = 
        '<table style="">
            <tr>';
            foreach($location['exam_location']['exam_loc_dets'] as $det){
                $html .=
                '<td>
                    <table>';
                    $course_name = '';
                    
                    foreach($det['seat_nos'] as $seat){
                        $html .='<tr align="center"><td style="border-top-color:#000000;border-top-width:1px;border-top-style:solid;font-size:11px;  height: 25px;">';
                        $added = false;
                        $course = count($location['courses']) > 1 ? true:false;
                        
                        foreach($location['student_seating'] as $student){
                            if($student['seat_no'] == $seat){
                                $student_course = $student['course'].'-'.$student['section'];
                                $comp  = strcmp($student_course,$course_name);
                                if($course == true &&  $comp != 0){
                                    $course_name = $student_course;
                                    $html .= '('.$student_course . ')<br> ';
                                }
                                $html .= $student['student']['roll_no']; 
                                $added = true;
                            }
                        }
                        if($added == false){
                            $html .='--';  
                        }
                        $html .='';  
                        $html .='</td></tr>';
                    }

                $html .='</table>
                </td>';
            }

        $html .=   
            '</tr>
        </table>';
        
        // output the HTML content
        $pdf->writeHTML($html, true, false, true, false, '');
        $this->addHLine();
        $this->drawBox($this->pdf->getY(),false);
        $this->GetYPos(true);

        $total = '';
        foreach($location['courses'] as $course){
            $count = 0;
            foreach($location['student_seating'] as $student_seating){
                if($course['course_name'] ==  $student_seating['course'] && $course['section'] ==  $student_seating['section']){
                    $count++;
                }
            }
            $total .= ' ('.$course['course_name'] .'-'.$course['section'] .' : '.$count.')';
        }
        $this->addCell($this->getColW(''), 0, $total, 0, 'C', 0, 'T', 11, 'B');
        $this->pdf->ln(6);
        $this->addHLine();
        
        
    }

    private function details($title = '')
    {
        
    }

    private function footer($type="R")
    {
        
    }

    private function startNewPage()
    {
        // $this->footerHeight = 130;
        $this->footer();
        $this->secHeight = 0;
        $this->pageno++;
        $this->addNewPage("L", "A4");
        $this->header();
    }

}
