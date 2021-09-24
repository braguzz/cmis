<?php
use Cake\View\Helper\TimeHelper;

	function SalvaViaTempFile($objWriter)
	{
		//salva il file nella cartella /var/www/clients/client78/web89/web/dma/app/tmp/
		//con nome casuale, tipo 4823970511241361579.tmp, poi lo cancella 
		$filePath = TMP  . rand(0, getrandmax()) . rand(0, getrandmax()) . ".tmp"; 
		$objWriter->save($filePath); 
		readfile($filePath); 
		unlink($filePath);      //elimina il file *.tmp 
	} 

	//formati e stili 
	$formatoData1 = '%d/%m/%Y'; 
	$formatoData2 = '%d/%m/%Y %H:%M:%S'; 
	$formatoNumeri = '#,##0.00'; 
	$formatoPercento = '#0.00%'; 
	$stileNeretto = array('font' => array('bold' => true) ); 

	//prepara il foglio
	$foglioExcel = new PhpOffice\PhpSpreadsheet\Spreadsheet(); 

	$autore = $regtoscConf['pagetitle']; 
	//inserisce la descrizione nelle proprieta' del foglio excel
	$foglioExcel->getProperties() 
		->setCompany('Regione Toscana') 
		->setCreator($autore) 
		->setTitle("Tabella Artistis") 
		->setSubject("") 
		->setDescription("ESPORTATO IL: " . $this->Time->format(time(), $formatoData2) ); 

	//riga di intestazione 
	//$foglioExcel->setActiveSheetIndex(0)->setCellValue('A1', 'FILTRO: '. serialize($filtroRicerca)); 
	$foglioExcel->getActiveSheet()->mergeCells('A1:Z1'); 

	//intestazione delle colonne 
         	$intestazione = array( 
                    'id',
          
	            'name',
          
	            'strsql',
          
	            'db',
          
	            'menu',
          
		); 
       
	$foglioExcel->setActiveSheetIndex(0)->fromArray($intestazione, NULL, 'A2'); 


	//loop di riempimento delle celle con i dati  
	$rigaInizio = 3;  
	$riganum = $rigaInizio;  
 
 foreach ($reports as $report) : 
        $riga =$this->Number->format($report->id);
$foglioExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(1, $riganum, $riga); 
        $riga = h($report->name);
$foglioExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(2, $riganum, $riga); 
        $riga = h($report->strsql);
$foglioExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(3, $riganum, $riga); 
        $riga = h($report->db);
$foglioExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(4, $riganum, $riga); 
       $riga =$this->Number->format($report->menu);
$foglioExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(5, $riganum, $riga); 
 

$riganum++;
endforeach; 
        
   $col=6;      
        
        
        
        


	//riga dei totali 
	$rigaFine = $riganum - 1; 


	
        $colname='A';
        for ($coll = 1; $coll < $col; ++$coll) { 
        	//larghezza delle colonne automatica 
	$foglioExcel->getActiveSheet()->getColumnDimension($colname)->setAutoSize(true); 
        $colname++;
	   }
         $colname--; 
        //imposta il filtro automatico di EXCEL 
	$foglioExcel->getActiveSheet()->setAutoFilter('A2:' . $colname. '2'); 
	//celle di intestazione in NERETTO 
	$foglioExcel->getActiveSheet()->getStyle('A2:AZ2')->applyFromArray($stileNeretto); 
	//celle dei totali in NERETTO
	$foglioExcel->getActiveSheet()->getStyle('A' . $riganum . ':AZ' . $riganum)->applyFromArray($stileNeretto); 

	//formattazione delle celle 


	//titolo del foglio excel  
	$foglioExcel->setActiveSheetIndex(0)->setTitle($regtoscConf['pagetitle']);   
	$foglioExcel->setActiveSheetIndex(0);  

	header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');  
	header('Content-Disposition: attachment;filename="Export_report.xlsx"');      //nome del file    
	header('Cache-Control: max-age=0');  

	$objWriter = new PhpOffice\PhpSpreadsheet\Writer\Xlsx($foglioExcel);   
	$objWriter->setPreCalculateFormulas(true);          //forza il calcolo delle formule  

	SalvaViaTempFile($objWriter);  

	exit;
?>


