<?php
/***************************************************************
*  Copyright notice
*
*  (c) 2011 Alexandre Nicolas <ani@atolcd.com>
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




class Tx_AtolCmisList_ViewHelpers_Default_SizeViewHelper extends Tx_Fluid_Core_ViewHelper_AbstractViewHelper {


  /**
  *
  * @param Tx_AtolCmis_CMIS_Object $obj object to be actionned
  * @param string type Could be opt, ko, mo or null
  * @return string Html to be displayed
  *
  **/
  public function render($obj,$type=null){ 
 
    $output='';
   
    if($a=$obj->getProperties('cmis:contentStreamLength')){
      $size = intval($a->getPropertyValue());    
    }
    
    switch($type){
      case "opt":
        $output = $this->getOptSize($size);
      break;
      case "ko":
        $output = $size/(1024)+" Mo";
      break;
      case "mo":
        $output = $size/(1024*1024)+" Mo";
      break;
      default:
        $output = $size+" octets";
      break;
    
    }
    
    return $output ;
  }
  
  public function getOptSize($size){
    $type=array(' octets',' Ko',' Mo',' Go');
    $cpt = 0;
    $stop=false;
    while(!$stop&&$size>1024){
      $size = $size / 1024;
      if($cpt==3){
        $stop=true;
      }
      else{
        $cpt++;
      }
    }

    $output = (string)round($size,2).$type[$cpt];
    return $output;
  }
  

		
}
