<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Printings;

use TCPDF;

class AdmformPrint extends PrintPdf {

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

  public function makepdf(\App\AdmissionForm $adm) {
    $this->admform = $adm;
    $this->subject = $adm->admSubs;
    $this->attachments = $adm->attachments;
    $this->pdf->SetMargins($this->lm, $this->tm);
    $this->main();
    return $this->pdf;
  }

  private function header($title = '') {
    $pdf = $this->pdf;
    $this->pdf->ln(5);
    $pdf->Image(public_path("/dist/img/college-logo.png"), $this->lm + 2, $this->tm, 20, 30, 'PNG', '', '', true, 100, '', false, false, 0, false, false, false);
    $this->addCell(0, 5, "Mehr Chand Mahajan DAV College For Women", 0, 'C', 1, 'T', 16, 'B');
    $this->addCell(0, 5, "Sector 36-A, Chandigarh", 0, 'C', 1, 'T', 16, 'B');
    $this->pdf->ln(2);
    $this->addCell(0, 5, "APPLICATION FORM FOR ADMISSION (SESSION 2017-18) ", 0, 'C', 1, 'T', 12, '');
    $this->addCell(180, 0, "Online Form No.: ", 0, 'R', 0, 'T', 12, '');
    $this->addCell(40, 0, $this->admform->id, 0, 'L', 1, 'T', 12, 'B');
    $this->pdf->ln($this->gap);
    $this->addCell(80, 0, "CLASS:", 0, 'R', 0, 'T', 12, 'B');
    $this->addCell(40, 0, $this->admform->course->course_name, 0, 'L', 1, 'T', 12, '');
    $this->pdf->ln(5);

    $topY = $pdf->getY();
    $pdf->ln(3);
    $pdf->setX($pdf->getX() + 10);
    $this->addCell(35, 0, "Relevant Category : ", 0, 'L', 0, 'T', $this->fontsize, 'B');
    $this->addCell(($this->pageWidth / 2) - 50, 0, $this->admform->geo_cat, 0, 'L', 0, 'T', $this->fontsize, '');
    $this->pdf->ln($this->gap);

    $pdf->setX($pdf->getX() + 90);
    $this->addCell(20, 0, "Pool : ", 0, 'L', 0, 'T', $this->fontsize, 'B');
    $this->addCell(0, 0, $this->admform->loc_cat . " Pool", 0, 'L', 1, 'T', $this->fontsize, '');
    $this->pdf->ln($this->gap);

    $pdf->setX($pdf->getX() + 10);
    $this->addCell(30, 0, "Category : ", 0, 'L', 0, 'T', $this->fontsize, 'B');
    $this->addCell(($this->pageWidth / 2) - 50, 0, ($this->admform->category ? $this->admform->category->name : ''), 0, 'L', 0, 'T', $this->fontsize, '');
    $this->pdf->ln($this->gap);

    $pdf->setX($pdf->getX() + 90);
    $this->addCell(35, 0, "Reserved Category : ", 0, 'L', 0, 'T', $this->fontsize, 'B');
    $this->addCell(0, 0, ($this->admform->res_category ? $this->admform->res_category->name : ''), 0, 'L', 1, 'T', $this->fontsize, '');
    $this->pdf->ln($this->gap);

    $pdf->setX($pdf->getX() + 10);
    $this->addCell(30, 0, "Nationality: ", 0, 'L', 0, 'T', $this->fontsize, 'B');
    $this->addCell(($this->pageWidth / 2) - 50, 0, $this->admform->nationality, 0, 'L', 0, 'T', $this->fontsize, '');
    $this->pdf->ln($this->gap);

    $pdf->setX($pdf->getX() + 90);
    $this->addCell(20, 0, "Religion: ", 0, 'L', 0, 'T', $this->fontsize, 'B');
    $this->addCell(0, 0, $this->admform->religion, 0, 'L', 1, 'T', $this->fontsize, '');
    $pdf->ln(3);
    $this->pdf->Rect($this->lm, $topY, $this->pageWidth, $pdf->getY() - $topY);
    $this->pdf->ln(8);

    $file = $this->getPhoto();
    if ($file)
      $pdf->Image(storage_path() . "/app/images/photograph" . '_' . $this->admform->id . '.' . $file->file_ext, 140, 70, 50, 50, '', '', '', true, 100, '', false, false, 0, false, false, false);

    $this->addCell(50, 0, "Candidate Name: ", 0, 'L', 0, 'T', $this->fontsize, 'B');
    $this->addCell(($this->pageWidth / 2) - 50, 0, $this->admform->name, 0, 'L', 1, 'T', $this->fontsize, '');
    $this->pdf->ln($this->gap);

    $this->addCell(50, 0, "Gender: ", 0, 'L', 0, 'T', $this->fontsize, 'B');
    $this->addCell(($this->pageWidth / 2) - 50, 0, $this->admform->gender, 0, 'L', 1, 'T', $this->fontsize, '');
    $this->pdf->ln($this->gap);

    $this->addCell(50, 0, "Date Of Birth: ", 0, 'L', 0, 'T', $this->fontsize, 'B');
    $this->addCell(($this->pageWidth / 2) - 50, 0, $this->admform->dob, 0, 'L', 1, 'T', $this->fontsize, '');
    $this->pdf->ln($this->gap);

    $this->addCell(50, 0, "Blood Group: ", 0, 'L', 0, 'T', $this->fontsize, 'B');
    $this->addCell(($this->pageWidth / 2) - 50, 0, $this->admform->blood_grp, 0, 'L', 1, 'T', $this->fontsize, '');
    $this->pdf->ln($this->gap);

    $this->addCell(50, 0, "Father's Name: ", 0, 'L', 0, 'T', $this->fontsize, 'B');
    $this->addCell(($this->pageWidth / 2) - 50, 0, $this->admform->father_name, 0, 'L', 1, 'T', $this->fontsize, '');
    $this->pdf->ln($this->gap);

    $this->addCell(50, 0, "Mother's Name: ", 0, 'L', 0, 'T', $this->fontsize, 'B');
    $this->addCell(($this->pageWidth / 2) - 50, 0, $this->admform->mother_name, 0, 'L', 1, 'T', $this->fontsize, '');
    $this->pdf->ln($this->gap);

    $this->addCell(50, 0, "Mobile No: ", 0, 'L', 0, 'T', $this->fontsize, 'B');
    $this->addCell(($this->pageWidth / 2) - 50, 0, $this->admform->mobile, 0, 'L', 1, 'T', $this->fontsize, '');
    $this->pdf->ln($this->gap);

    $this->addCell(50, 0, "Permanent Address: ", 0, 'L', 0, 'T', $this->fontsize, 'B');
    $this->addMCell((120) - 50, 0, $this->admform->per_address . ' ' . $this->admform->city, 0, 'L', 1, 'T', $this->fontsize, '');
    $this->pdf->ln(5);

    $this->addCell(0, 5, "Course Information", 0, 'L', 1, 'T', 14, 'B');
    $this->pdf->ln($this->gap);
    $this->addCell(50, 0, "Course Name: ", 0, 'L', 0, 'T', $this->fontsize, 'B');
    $this->addCell(($this->pageWidth / 2) - 50, 0, $this->admform->course->course_name, 0, 'L', 1, 'T', $this->fontsize, '');
    $this->pdf->ln($this->gap);

    $this->addCell(50, 0, "Selected Subjects: ", 0, 'L', 0, 'T', $this->fontsize, 'B');
    $this->addCell(($this->pageWidth / 2) - 50, 0, 'Compulsory', 0, 'L', 1, 'T', $this->fontsize, 'BU');
    $this->pdf->ln($this->gap);
    foreach ($this->getCompSubject() as $cmp) {
      $this->addCell(50, 0, "", 0, 'L', 0, 'T', $this->fontsize, '');
      $this->addCell(20, 0, $cmp->subject->subject, 0, 'L', 1, 'T', $this->fontsize, '');
    }
    foreach ($this->getOptSubjects('C') as $opt) {
      $this->addCell(50, 0, "", 0, 'L', 0, 'T', $this->fontsize, '');
      $this->addCell(30, 0, $opt->subject->subject, 0, 'L', 1, 'T', $this->fontsize, '');
    }
    $this->pdf->ln($this->gap);
    $this->addCell(50, 0, "", 0, 'L', 0, 'T', $this->fontsize, 'B');

    $this->addCell(($this->pageWidth / 2) - 50, 0, 'Optional', 0, 'L', 1, 'T', $this->fontsize, 'BU');
    foreach ($this->getOptSubjects() as $opt) {
      $this->addCell(50, 0, "", 0, 'L', 0, 'T', $this->fontsize, '');
      $this->addCell(30, 0, $opt->subject->subject, 0, 'L', 1, 'T', $this->fontsize, '');
    }
    $this->pdf->ln($this->gap);

    $this->addCell(0, 5, "Academic Detail", 0, 'L', 1, 'T', 14, 'B');
    $this->pdf->ln($this->gap);
    $this->addCell(0, 5, "Other Detail", 0, 'L', 1, 'T', 12, 'B');
    $this->pdf->ln($this->gap);
    $this->addCell(50, 0, "Gap Year:", 0, 'L', 0, 'T', $this->fontsize, 'B');
    $this->addCell(($this->pageWidth / 2) - 50, 0, $this->admform->gap_year, 0, 'L', 1, 'T', $this->fontsize, '');
    $this->pdf->ln($this->gap);
    $this->addCell(50, 0, "Migrating Details:", 0, 'L', 0, 'T', $this->fontsize, 'B');
    $this->addCell(($this->pageWidth / 2) - 50, 0, $this->admform->migrate_detail, 0, 'L', 1, 'T', $this->fontsize, '');
    $this->pdf->ln($this->gap);
    $this->addCell(50, 0, "Disqualification Details:", 0, 'L', 0, 'T', $this->fontsize, 'B');
    $this->addCell(($this->pageWidth / 2) - 50, 0, $this->admform->disqualify_detail, 0, 'L', 1, 'T', $this->fontsize, '');
    $this->pdf->ln(5);

    $lhForAttachments = 7;
    $this->addCell(0, 5, "Document Attached", 0, 'L', 1, 'T', 14, 'B');
    foreach (docAttached(['photograph', 'signature']) as $key => $value) {
      $this->addCell(130, $lhForAttachments, $value['desc'], 1, 'L', 0, 'M', $this->fontsize, 'B', 'true');
//      $this->addCell(20, $lhForAttachments, $this->getAttachFile($value['name']), 1, 'L', 1, 'T', $this->fontsize, '');
      $pdf->SetFont('zapfdingbats', '', 14);
      $this->pdf->writeHTMLCell(20, $lhForAttachments, '', '', $this->getAttachFile($value['name']), 1, 1, 0, true, true);
//      $pdf->writeHTMLCell(80, 10, 10, 9, '3', $border=1, $ln=0, $fill=0, $reseth=true, $align='', $autopadding=true);
      $pdf->SetFont($this->fontName, '', $this->fontSize);
      $this->pdf->ln($this->gap);
    }

    $this->pdf->ln(10);
    $this->addNewPage('P', 'A4');
    $this->pdf->ln(10);
    $this->addCell(0, 5, "DECLARATION", 0, 'C', 1, 'T', 12, '');
    $this->pdf->ln($this->gap);
    $this->addMCell(0, 0, $this->getSNo() . "I solemnly declare that the above facts are true to the best of my knowledge and brief and nothing has been concealed therein.I undertake to abide by the rules and regulations of college.  ", 0, 'L', 1, 'T', $this->fontsize, '');
    $this->pdf->ln($this->gap);
    $this->addMCell(0, 0, $this->getSNo() . "I seek admission with the permission of my Parents/Guardian, who agree to be jointly responsible for prompt payment of dues and for my conduct..  ", 0, 'L', 1, 'T', $this->fontsize, '');
    $this->pdf->ln($this->gap);
    $this->addMCell(0, 0, $this->getSNo() . "I will not take part, instigate or induce other students to stage strike, agitation or create indiscipline. If I do so, I may be fined, expelled or rusticated for any activity subversive to the college discipline.  ", 0, 'L', 1, 'T', $this->fontsize, '');
    $this->pdf->ln($this->gap);
    $this->addMCell(0, 0, $this->getSNo() . "I am fully aware that ragging, smoking and drinking liquor is strictly prohibited in the college/Hostel. If I am found guilty of indulging in these activities, I shall be liable to punishment and expulsion from hostel/college..  ", 0, 'L', 1, 'T', $this->fontsize, '');
    $this->pdf->ln($this->gap);
    $this->addMCell(0, 0, $this->getSNo() . "I shall not use mobile phone in the college..  ", 0, 'L', 1, 'T', $this->fontsize, '');
    $this->pdf->ln($this->gap);
    $this->addMCell(0, 0, $this->getSNo() . "I have not been involved in any criminal activity and have never been convicted under any criminal offence. No criminal proceedings are pending against me at the time of submission of the application. Further, I will not posses or carry any weapon on the college campus and if any weapon is recovered from me, I understand that I can be rusticated for such an offence.  ", 0, 'L', 1, 'T', $this->fontsize, '');
    $this->pdf->ln($this->gap);
    $this->addMCell(0, 0, "( Any mis-statement/concealment of facts by the applicant will result in cancellation of admission, no refund will be made and appropriate action will be taken against the applicant ) ", 0, 'L', 1, 'T', $this->fontsize, 'B');
    $this->pdf->ln(25);

    $this->addMCell($this->pageWidth / 3, 0, "Dated.." . '', 0, 'C ', 0, 'T', $this->fontsize, 'B');

    $this->addMCell($this->pageWidth / 3, 0, "Full Signature Of Parents/Guardian" . '', 0, 'C', 0, 'T', $this->fontsize, 'B');

    $email = ($std_user = $this->admform->std_user) ? $std_user->email : '';
    $file = $this->getPhoto('signature');
    if ($file)
      $pdf->Image(storage_path() . "/app/images/signature" . '_' . $this->admform->id . '.' . $file->file_ext, 150, 110, 50, 10, '', '', '', true, 100, '', false, false, 0, false, false, false);

    $this->addMCell($this->pageWidth / 3, 0, "Signature Of Student \n" . "Email: $email\n" . '', 0, 'C', 1, 'T', $this->fontsize, 'B');

    $this->pdf->ln(5);
    $this->pdf->Line($this->lm, $this->pdf->getY(), $this->pageWidth + $this->lm, $this->pdf->getY());
    $this->pdf->ln(5);

    $this->addCell(0, 5, "For Office Use Only", 0, 'C', 1, 'T', 12, 'B');
    $this->pdf->ln(5);

    $this->addMCell($this->pageWidth / 2, 0, "Certified That the student Is Eligible for Admission  to  " . $this->admform->course->course_name . "\n" . "Deficiency If Any: \n", 0, 'C ', 0, 'T', $this->fontsize, '');
    $this->addMCell($this->pageWidth / 2, 0, "( Recommended for Provisional Admission )", 0, 'C', 1, 'T', $this->fontsize, '');
    $this->pdf->ln(20);

    $this->addMCell($this->pageWidth / 2, 0, "(Signature of Teacher with Date)", 0, 'C ', 0, 'T', $this->fontsize, '');
    $this->addMCell($this->pageWidth / 2, 0, "( Signature Of Convener with Date )", 0, 'C', 1, 'T', $this->fontsize, '');
    $this->pdf->ln(5);

    $this->addMCell($this->pageWidth / 2, 0, "----------------------------\nName of Teacher", 0, 'C ', 0, 'T', $this->fontsize, '');
    $this->addMCell($this->pageWidth / 2, 0, "----------------------------\nName Of Convener", 0, 'C', 1, 'T', $this->fontsize, '');
    $this->pdf->ln(2);

    $this->addMCell($this->pageWidth / 2, 0, "", 0, 'C ', 0, 'T', $this->fontsize, '');
    $this->addMCell($this->pageWidth / 2, 0, "Admission Committee", 0, 'C', 1, 'T', $this->fontsize, 'B');

    $this->hight = $this->getNetHeight() - $this->footerHight;
  }

  private function setCopy($copyno) {
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

  private function main($title = '') {
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

  private function getSNo() {
    return $this->sno++ . '.  ';
  }

  private function getAttachFile($name) {
//    dd($this->admform->attachments);
    if ($file = $this->admform->attachments->where('file_type', $name)->first())
//      return "&#10004";
      return \TCPDF_FONTS::unichr(52);
    else
      return "";
//    return "&#10004";
  }

  private function getCompSubject() {
    return $this->admform->course->subjects->where('sub_type', 'C');
  }

  private function getOptSubjects($type = 'O') {
    $subjects = $this->admform->admSubs;
    return $subjects->filter(function($item, $key) use($type) {
        if ($type == 'O') {
          if ($item->sub_group_id == 0 || $item->subjectGroup->type == $type)
            return TRUE;
        }elseif ($type == 'C') {
          if ($item->sub_group_id > 0 && $item->subjectGroup->type == $type)
            return TRUE;
        }
      });

    return $opt_subjects;
  }

  private function getPhoto($type = 'photograph') {
    return $this->admform->attachments->where('file_type', $type)->first();
  }

}
