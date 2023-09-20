<?php

namespace App\Printings;

use TCPDF;

abstract class PrintPdf {

  protected $pdf = '';
  protected $bill = '';
  protected $pageWidth = 195;
  //protected $pageWidth = 290;
  protected $lm = 5;
  protected $ls = 2;
  protected $tm = 5;
  protected $rm = 5;
  protected $bm = 0;
  protected $fontName = 'times';
  protected $fontSize = 10;
  protected $topY = 0;
  protected $pTopY = 0;
  protected $lastY = 0;
  protected $pLastY = 0;
  protected $lineHeight = 0;
  protected $bottomMargin = 15;
  protected $rightPos = 0;
  protected $colno = 1;
  protected $cols = array();
  protected $curr = 'Rs.';
  protected $detHeight = 0;

  public function __construct() {
    $this->pdf = new \TCPDF();
    $pdf = $this->pdf;
    $pdf->SetAutoPageBreak(FALSE);
    $pdf->SetMargins($this->lm, $this->tm);
    $pdf->setPrintHeader(false);
    $margins = $this->pdf->getMargins();
    $this->bm = $margins['bottom'];
    $this->bm = 10;

//		$pdf->setPrintFooter(false);
//    $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);


    $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
    $pdf->SetFont($this->fontName, '', $this->fontSize);
    $pdf->SetFillColor(0, 0, 0, 20);
  }

  protected function getColW($colno, $colno1 = 0) {
    if ($colno < 1 || $colno > count($this->cols) - 1)
      return 0;
    if ($colno1 == 0 || $colno1 <= $colno)
      return $this->cols[$colno] - $this->cols[$colno - 1];
    else {
      $cwidth = 0;
      for ($i = $colno; $i <= $colno1; $i++) {
        $cwidth += $this->getColW($i);
      }
      return $cwidth;
    }
  }

  protected function SetYPos($ypos) {
    $pdf = $this->pdf;
    $pdf->SetY($ypos);
    $this->lastY = $this->pdf->GetY();
    return $this->lastY;
  }

  protected function GetYPos($setTopY = FALSE, $lastY = 0, $h_adj = 0, $updt_y_pos = 0) {
    if ($updt_y_pos > 0) {
      $this->lastY = $lastY;
      $this->pdf->setY($lastY);
    }
    $pdf = $this->pdf;
    if ($lastY == 0 || $lastY < $this->pdf->GetY())
      $lastY = $this->pdf->GetY();
    $lastY += $h_adj;
    if ($lastY <= $this->lastY) {
      $lastY = $this->lastY;
    } else {
      $this->pLastY = $this->lastY;
      $this->lastY = $lastY;
    }
    if ($setTopY)
      $this->topY = $lastY;
    $this->pdf->setY($lastY, false);
    return $lastY;
  }

  protected function LineItem($txt, $box = 0, $opt = 'M', $align = 'L', $pdf = null, $border = 0, $fill = false) {
    if (!$pdf) {
      $pdf = $this->pdf;
    }
    if ($this->colno == 1) {
      $this->pTopY = $this->lastY;
      $this->pLastY = $this->lastY;
    }
    $w = $this->cols[$this->colno] - $this->cols[$this->colno - 1];
    $x = $this->cols[$this->colno - 1];
    $pdf->SetXY($x, $this->lastY);
    if ($opt == 'M') {
      $pdf->MultiCell($w, $this->lineHeight, $txt, $border, $align, $fill, 1);
    } elseif ($opt == 'C') {
      $pdf->Cell($w, $this->lineHeight, $txt, $border, 1, $align, $fill);
    } elseif ($opt == 'H') {
      $pdf->writehtmlCell($w, $this->lineHeight, $x, $this->lastY, $txt, $border, 1, $fill, true, 'L');
    }
    if ($this->pLastY < $pdf->GetY())
      $this->pLastY = $pdf->GetY();
    $this->colno++;
    if ($this->colno >= count($this->cols)) {
      $this->colno = 1;
      if ($box == 1) {
        $pdf->Rect($this->lm, $this->pTopY, $this->cols[count($this->cols) - 1] - $this->cols[0], $this->pLastY - $this->pTopY);
        $cols = $this->cols;
        for ($i = 0; $i < count($cols); $i++) {
          $pdf->Line($cols[$i], $this->pTopY, $cols[$i], $this->pLastY);
        }
      }
      $this->lastY = $this->pLastY;
      $pdf->setY($this->pLastY);
    }
  }

  protected function addCell($w = 0, $h = 0, $txt = "", $border = 0, $align = 'L', $ln = 1, $valign = 'T', $fontSize = 0, $fontStyle = "", $fill = false, $resetheight = false) {
    $pdf = $this->pdf;
    $fSize = $pdf->getFontSizePt();
    $fStyle = $pdf->getFontStyle();
    if ($w == -1)
      $w = $this->pageWidth;
    if ($h == 0)
      $h = $this->lineHeight;
    if ($fontSize != 0) {
      $pdf->setFontSize($fontSize);
      if ($h == 5)
        $h = 0;
    }
    if ($fontStyle != "")
      $pdf->setFont('', $fontStyle);
    $this->pdf->Cell($w, $h, $txt, $border, $ln, $align, $fill, '', 0, FALSE, 'T', $valign);
    if ($fontSize != 0) {
      $pdf->setFontSize($fSize);
    }
    if ($fontStyle != "") {
      $pdf->setFont('', $fStyle);
    }
    $this->GetYPos();
    if ($ln != 0)
      $this->detHeight = 0;
    if ($resetheight == true || $this->detHeight < $this->pdf->getLastH())
      $this->detHeight = $this->pdf->getLastH();
  }

  protected function addMCell($w = 0, $h = 0, $txt = "", $border = 0, $align = 'L', $ln = 1, $valign = 'T', $fontSize = 0, $fontStyle = "", $fill = false, $resetheight = false) {
    $pdf = $this->pdf;
    $fSize = $pdf->getFontSizePt();
    $fStyle = $pdf->getFontStyle();
    if ($w == 0)
      $w = $this->pageWidth;
    if ($h == 0)
      $h = $this->lineHeight;
    if ($fontSize != 0) {
      $pdf->setFontSize($fontSize);
      $h = 0;
    }
    if ($fontStyle != "")
      $pdf->setFont('', $fontStyle);
    if ($valign == 'T')
      $this->pdf->MultiCell($w, $h, $txt, $border, $align, $fill, $ln, '', '', true, 0, false, true, 0, $valign);
    else
      $this->pdf->MultiCell($w, $h, $txt, $border, $align, $fill, $ln, '', '', true, 0, false, true, $h, $valign);
    if ($fontSize != 0) {
      $pdf->setFontSize($fSize);
    }
    if ($fontStyle != "") {
      $pdf->setFont('', $fStyle);
    }
    if ($ln != 0)
      $this->detHeight = 0;
    if ($resetheight == true || $this->detHeight < $this->pdf->getLastH())
      $this->detHeight = $this->pdf->getLastH();
    $this->GetYPos();
  }

  protected function addLine($txt, $remCols, $box = 1) {
    $this->LineItem($txt);
    for ($i = 1; $i <= $remCols; $i++) {
      $this->LineItem('', $box, 'M', 'C');
    }
  }

  protected function addArrLine($txts, $border = 0, $align = 'L', $fill = '') {
    foreach ($txts as $txt) {
      $this->LineItem($txt, 0, 'M', $align, null, $border, $fill);
    }
  }

  protected function addCols($cols) {
    $w = 0;
    $this->cols = array();
    $this->cols[] = $this->lm;
    $w = $this->lm;
    foreach ($cols as $col) {
      $this->cols[] = $w + $col;
      $w = $w + $col;
    }
    $this->cols[] = ($this->lm + $this->pageWidth );
    //dd($this->cols);
  }

  protected function drawBox($ypos = 0) {
    $pdf = $this->pdf;
    $cols = $this->cols;
    $pdf->Rect($this->lm, $this->topY, $this->cols[count($this->cols) - 1] - $this->cols[0], $this->lastY - $this->topY);
    if ($ypos == 0)
      $ypos = $this->lastY;
    for ($i = 1; $i < count($cols) - 1; $i++) {
      $pdf->Line($cols[$i], $this->topY, $cols[$i], $ypos);
    }
  }

  protected function drawBoxLines($ypos = 0) {
    $pdf = $this->pdf;
    $cols = $this->cols;
//    $pdf->Rect($this->lm, $this->topY, $this->cols[count($this->cols) - 1] - $this->cols[0], $this->lastY - $this->topY);
    if ($ypos == 0)
      $ypos = $this->lastY;
    for ($i = 0; $i < count($cols); $i++) {
      $pdf->Line($cols[$i], $this->topY, $cols[$i], $ypos);
    }
  }

  protected function addHLine() {
    $pdf = $this->pdf;
    $pdf->Line($this->lm, $this->pdf->getY(), $this->pageWidth + $this->lm, $this->pdf->getY());
  }

  protected function addNewPage($orientation = 'P', $paper = "A5", $pdf = null) {
    if (!$pdf)
      $pdf = $this->pdf;
    $pdf->AddPage($orientation, $paper);
    $this->lm = 5;
    $this->tm = 5;
    $this->lm = 5;
    $this->pageWidth = $this->pdf->getPageWidth() - $this->lm - $this->rm;
    $this->lineHeight = 5;
    $this->pdf->SetX($this->lm);
    $this->pdf->SetY($this->tm, false);
    $this->resetY();
  }

  protected function resetY() {
    $this->topY = 0;
    $this->pTopY = 0;
    $this->lastY = 0;
    $this->pLastY = 0;
  }

  protected function getNetHeight() {
    $margins = $this->pdf->getMargins();
    return $this->pdf->getPageHeight() - $margins['top'] - $margins['bottom'];
  }

  protected function setMargin($type, $margin) {
    if (strtoupper($type) == "L") {
      $this->lm = $margin;
      $this->pdf->SetMargins($this->lm, $this->tm);
      $this->pageWidth = $this->pdf->getPageWidth() - $this->lm - $this->rm;
    } elseif (strtoupper($type) == "R") {
      $this->rm = $margin;
      $this->pdf->SetMargins($this->lm, $this->tm, $this->rm);
      $this->pageWidth = $this->pdf->getPageWidth() - $this->lm - $this->rm;
    }
  }

}
