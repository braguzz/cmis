<?php
$html = <<<EOF
	<style>
    table {
	font: 11px/24px Verdana, Arial, Helvetica, sans-serif;
	border-collapse: collapse;
	}
	th {
	padding: 0 0.5em;
	text-align: left;
	background-color:#e7e7e7;
	color:#000000;
	font-weight:bold;
	}
	tr.yellow td {
	border-top: 1px solid #FB7A31;
	border-bottom: 1px solid #FB7A31;
	background: #FFC;
	}
	td {
	border-bottom: 1px solid #808080;
	border-left: 1px solid #CCC;
	border-right: 1px solid #CCC;
	
	padding: 1em 1em;
	}
	td:first-child {
	//width: 190px;
	}
	td+td {
	border-left: 1px solid #CCC;
	text-align: center;
	}
	h6 {
	text-align: right;
}
	</style>
EOF;
//$html .= '<h1>generi</h1>';
$html .= '<table  cellspacing="0" cellpadding="1" border="1">';
$html .= '<thead><tr>';
$html .= '<th>id</th>';
$html .= '<th>title</th>';
$html .= '</tr></thead>';
 foreach ($generi as $genere) : 
 $html .= '<tr>';
        $html.='<td>' . $this->Number->format($genere->id).'</td>';
        $html.='<td>' . h($genere->title).'</td>';

 $html .= '</tr>';
endforeach; 
$html .= '</table>';
        $author = 'Regione Toscana';
	$this->Pdf->core->SetAuthor($author);
        $this->Pdf->core->SetCreator(PDF_CREATOR); //TCPDF
	$this->Pdf->core->SetTitle('generi');
	$this->Pdf->core->SetSubject('generi');
	$this->Pdf->core->SetKeywords('generi');
	// set default header data
	$this->Pdf->core->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, 'generi', '');
	// set header and footer fonts
	$this->Pdf->core->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
	$this->Pdf->core->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
	// set default monospaced font
	$this->Pdf->core->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
	// set margins
	$this->Pdf->core->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
	$this->Pdf->core->SetHeaderMargin(PDF_MARGIN_HEADER);
	$this->Pdf->core->SetFooterMargin(PDF_MARGIN_FOOTER);
	// set auto page breaks
	$this->Pdf->core->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
	// set image scale factor
	$this->Pdf->core->setImageScale(PDF_IMAGE_SCALE_RATIO);
	// set font
	$this->Pdf->core->SetFont('helvetica', '', 8);
	// add a page
	$this->Pdf->core->AddPage('P','A4');
     
        $now = date("d/m/Y h:m:s");
	$html .= '<h6>Stampato il ' . $now . '</h6>';
	$this->Pdf->core->writeHTML($html, true, false, false, false, '');
        ob_end_clean();
	$this->Pdf->core->Output('Export_generi.pdf', 'D');      

