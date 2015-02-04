<?php
/***************************************************************
*  Copyright notice
*
*  (c) 2011 Nicolas Forgeot <nfo@atolcd.com>
*  All rights reserved
*
*  This script is part of the TYPO3 project. The TYPO3 project is
*  free software; you can redistribute it and/or modify
*  it under the terms of the GNU General Public License as published by
*  the Free Software Foundation; either version 2 of the License, or
*  (at your option) any later version.
*
*  The GNU General Public License can be found at
*  http://www.gnu.org/copyleft/gpl.html.
*
*  This script is distributed in the hope that it will be useful,
*  but WITHOUT ANY WARRANTY; without even the implied warranty of
*  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
*  GNU General Public License for more details.
*
*  This copyright notice MUST APPEAR in all copies of the script!
 ***************************************************************/
 
require_once(PATH_tslib.'class.tslib_eidtools.php');
tslib_eidtools::connectDB();

$oID = t3lib_div::_GP('oID');
$sID = t3lib_div::_GP('sID');

if(!empty($oID)) {
  //set the server settings
  $where =  "deleted = 0 and hidden = 0 and uid = ".$sID;
  $rows = $GLOBALS['TYPO3_DB']->exec_SELECTgetRows('*', 'tx_atolcmis_repository', $where);
  $firstRepository = $rows ? $rows[0] : false;
  if($firstRepository){
    $client = new AtolCMIS_cmis_repository_wrapper($firstRepository['url'], $firstRepository['login'], $firstRepository['password']); 
    
    //Get the object
    $options = array( OPT_RENDITION_FILTER => "*");
    $doc = $client->getObject($oID, $options); 	

    $dp = date_parse($doc->properties['cmis:lastModificationDate']);
    $date = date('r', mktime($dp['hour'], $dp['minute'], $dp['second'], $dp['month'], $dp['day'], $dp['year']));
    header('Last-Modified: ' . $date);
    header('Content-type: ' . $doc->properties['cmis:contentStreamMimeType']);
    header('Content-Transfer-Encoding: binary');
    header('Content-Length: ' . $doc->properties['cmis:contentStreamLength']);
    header('Content-Disposition: attachment; filename="' . $doc->properties['cmis:contentStreamFileName'] . '"');
    header('filename="' . $doc->properties['cmis:contentStreamFileName'] . '"');
    flush();
    echo $client->getContentStream($oID);
    flush();		
    exit();
  }
}
	