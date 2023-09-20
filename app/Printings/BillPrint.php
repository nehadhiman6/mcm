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

class BillPrint extends PrintPdf {

  protected $feebill = null;
  protected $feebilldets = null;
  protected $student = null;
  protected $pdf = null;
  protected $hight = 0;
  protected $pageno = 0;
  protected $nextpage = '';
  protected $feebilldetid = 0;
  protected $copyno = 0;
  protected $footerHight = 0;

  public function makepdf(\App\FeeBill $feebill) {
    $this->feebill = $feebill;
    $this->feebill->load('feebilldets.subhead');
    $this->feebilldets = $feebill->feeBillDets;
    $this->student = $feebill->student;
    $this->main();
    return $this->pdf;
  }

  public function makeMultipleBillsPdf($fee_bills) {
    $fee_bills->chunk(50, function($bills) {
      foreach ($bills as $bill) {
        $this->feebill = $bill;
        $this->feebilldets = $bill->feeBillDets;
        $this->student = $bill->student;
        $this->main();
      }
    });
    return $this->pdf;
  }

  private function header($title = '') {
   $pdf = $this->pdf;
//    $pdf->Image(public_path("/dist/img/lps.png"), $this->lm + 2, $this->tm, 30, 25, 'PNG', '', '', true, 100, '', false, false, 0, false, false, false);
    $this->pdf->setX($this->lm + 54);
    $this->addCell(0, 0, '', 0, 'L', 1, 'T', 0, 'B');
    $this->pdf->setX($this->lm + 54);
    $this->addCell(0, 0, " BANK", 0, 'L', 1, 'T', 0, 'B');
    $this->pdf->setX($this->lm + 54);
    $this->addCell(0, 0, "SCO: 538, SECTOR 70", 0, 'L', 1, 'T', 0, 'B');
    $this->pdf->setX($this->lm + 54);
    $this->addCell(0, 0, "MOHALI PIN - 160070", 0, 'L', 1, 'T', 0, 'B');
    $this->pdf->ln(4);
    $this->addCell(0, 0, "Received for Credit of A/c No. 010994600000521", 0, 'C', 1, 'T', 0, 'B');
    $this->pdf->ln(3);
    $this->addCell(0, 0, "GURU GOBIND SINGH COLLEGE", 0, 'C', 1, 'T', 12, 'B');
    $this->pdf->ln(3);
    $this->addCell(0, 0, "Bank Ph No.: 0172-3026511-14", 0, 'L', 0, 'T', 0, 'B');
    $this->pdf->setX($this->lm + 50);
    $this->addCell(15, 0, "Due Date", 0, 'L', 0, 'T', 0, 'B');
   // $this->addCell(10, 0, $this->feebill->billDueDate(), 0, 'L', 1, 'T', 0, 'B');
    $this->addCell(0, 0, "the sum of Rs.: (In fig.) " . number_format($this->feebill->bill_amt, 2), 0, 'L', 1, 'T', 0, '');
    $this->addMCell(0, 0, "Rupees (In words): " . figToWord($this->feebill->bill_amt), 0, 'L', 1, 'T', 0, '');
    $this->pdf->ln(3);
    $this->addMCell(0, 0, "In respect of Adm No. " . $this->student->adm_no, 0, 'L', 1, 'T', 0, '');
    $this->addMCell(0, 0, "Name: " . $this->student->name, 0, 'L', 1, 'T', 0, '');
    $this->addMCell(0, 0, "S/D of Sh. " . $this->student->father_name, 0, 'L', 1, 'T', 0, '');
    $this->addMCell(0, 0, "Mobile: " . $this->student->mobile, 0, 'L', 1, 'T', 0, '');
    $this->pdf->ln(3);
    //$this->addCell(50, 0, "Class: " . getObjKey($this->student->coursename, "course_name", ''), 0, 'L', 0, 'T', 0, '');
    //$this->addCell(40, 0, "Section: " . getObjKey($this->student, "section", ''), 0, 'R', 1, 'T', 0, '');
    $this->addCell(0, 0, "Details of the amount deposited", "", 'L', 1, 'T', 0, 'B');
    $pdf->Line($this->lm, $this->lastY, $this->lm + 90, $this->lastY);
    $this->addCell(15, 0, "Particulars", "", 'L', 0, 'T', 0, 'B');
    $this->pdf->setX($this->lm + 84);
    $this->addCell(6, 0, "Rs", "", 'R', 1, 'T', 0, 'B');
    $pdf->Line($this->lm, $this->lastY, $this->lm + 90, $this->lastY);
    $this->hight = $this->getNetHeight() - $this->footerHight;

//    dd($this->pdf->getX());
//    dd("here");
  }

  private function details() {
    $pdf = $this->pdf;
    $total = 0;
    $intX = 0;
    if ($this->feebilldetid != -1) {
      foreach ($this->feebilldets as $value) {
        if ($intX == 0 && ($this->feebilldetid == 0 || $this->feebilldetid == $value->id)) {
          $intX = 1;
        }
        if ($intX == 1) {
          if ($this->lastY + $this->lineHeight > $this->hight) {
            if ($this->copyno == 3) {
              $this->feebilldetid = $value->id;
              $this->nextpage = "Y";
              $this->pdf->setY($this->getNetHeight() - $this->footerHight);
              $this->addCell(0, 0, "Continued to next page.....", "0", 'R', 0, 'T', 0, 'BI');
            }
            return;
          }
          $this->addCell(75, 0, $value->subhead->name, "0", 'L', 0, 'T', 0, '');
//          $this->addCell(15, 0, number_format($value->amount - $value->concession, 2), "0", 'R', 1, 'T', 0, '');
//          $total += $value->amount - $value->concession;
          $this->addCell(15, 0, number_format($value->amount, 2), "0", 'R', 1, 'T', 0, '');
          if ($value->spl_service)
            $this->addCell(90, 0, '(Service Details: ' . $value->spl_service->option_name . ')', "0", 'L', 1, 'T', 0, '');
          $total += $value->amount;
        }
      }
      if ($this->lastY + $this->lineHeight > $this->hight) {
        if ($this->copyno == 3) {
          $this->feebilldetid = -1;
          $this->nextpage = "Y";
        }
        return;
      }
    } else {
      $this->pdf->setY($this->getNetHeight() - $this->footerHight - $this->lineHeight);
    }
    if (floatval($this->feebill->concession) > 0) {
      $this->addCell(65, 0, "Less Concession : ", "0", 'R', 0, 'T', 0, 'B');
      $this->addCell(25, 0, number_format($this->feebill->concession, 2), "0", 'R', 1, 'T', 0, 'B');
    }
    $pdf->Line($this->lm, $this->lastY, $this->lm + 90, $this->lastY);
    $this->addCell(65, 0, "Total : ", "0", 'R', 0, 'T', 0, 'B');
    $this->addCell(25, 0, number_format($this->feebill->bill_amt, 2), "0", 'R', 1, 'T', 0, 'B');
    $pdf->Line($this->lm, $this->lastY, $this->lm + 90, $this->lastY);
    $this->footer();
  }

  private function footer() {
    $pdf = $this->pdf;
    $this->pdf->setY($this->getNetHeight() - $this->footerHight);
    $this->addCell(50, 0, "Sig. Depositor", 0, 'L', 0, 'T', 0, '');
    $this->addCell(40, 0, "Sig. Manager", 0, 'R', 1, 'T', 0, '');
    $this->pdf->ln(4);
    $this->addCell(0, 0, "Fee Slip No." . $this->feebill->id, 0, 'R', 1, 'T', 0, '');

//    dd($this->pdf->getX());
//    dd("here");
  }

  private function setCopy($copyno) {
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

  private function main($title = '') {
    $pdf = $this->pdf;
    $this->pageno = 0;
    $this->feebilldetid = 0;
    $this->footerHight = 15;
    if (floatval($this->feebill->concession) > 0)
      $this->footerHight += 3;
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
