<?php

namespace App\Printings;

use TCPDF;

class BasePdf
{
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
    public $testHeight = 0;

    public function makePdf($orientation = 'P', $paper = "A5")
    {
        $this->pdf = new \TCPDF();
        $pdf = $this->pdf;
        $pdf->SetAutoPageBreak(false);
        $pdf->SetMargins($this->lm, $this->tm);
        $pdf->setPrintHeader(false);
        $margins = $this->pdf->getMargins();
        $this->bm = $margins['bottom'];
        $this->bm = 5;

        $pdf->setFooterFont(array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
        $pdf->SetFont($this->fontName, '', $this->fontSize);
        $pdf->SetFillColor(0, 0, 0, 20);
        $pdf->AddPage($orientation, $paper);


    }

    public function addMCell($w = 0, $h = 0, $txt = "", $border = 0, $align = 'L', $ln = 1, $valign = 'T', $fontSize = 0, $fontStyle = "", $fill = false,$resetheight = false)
    {

        $pdf = $this->pdf;
        $fSize = $pdf->getFontSizePt();
        $fStyle = $pdf->getFontStyle();
        if ($w == 0) {
            $w = $this->pageWidth;
        }
        if ($h == 0) {
            $h = $this->lineHeight;
        }
        if ($fontSize != 0) {
            $pdf->setFontSize($fontSize);
            $h = 0;
        }
        if ($fontStyle != "") {
            $pdf->setFont('', $fontStyle);
        }
        $this->pdf->MultiCell($w, $h, $txt, $border, $align, $fill, $ln, '', '', true, 0, false, true, 0, $valign);
        if ($fontSize != 0) {
            $pdf->setFontSize($fSize);
        }
        if ($fontStyle != "") {
            $pdf->setFont('', $fStyle);
        }
        if ($resetheight == true || $this->testHeight < $this->pdf->getLastH()) {
            $this->testHeight = $this->pdf->getLastH();
        }
    }

}
