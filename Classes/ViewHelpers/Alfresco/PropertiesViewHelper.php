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




class Tx_AtolCmisList_ViewHelpers_Alfresco_PropertiesViewHelper extends Tx_Fluid_Core_ViewHelper_AbstractViewHelper {


  /**
  *
  * @param Tx_AtolCmis_CMIS_Object $obj object to be actionned
  * @param string $propertyName object to be actionned
  * @return string Html to be displayed
  *
  **/
  public function render($obj,$propertyName){ 
    //Default value

    /*$table='<table>';
    foreach($obj->getProperties() as $p){
      $table .= '<tr><td>'.$p->getPropertyName().'</td><td>'.$p->getPropertyValue().'</td>';
    }
    $table .= '</table>';*/
    
    $output='';
   
    if($p=$obj->getProperties($propertyName)){
      $output = $p->getPropertyValue();    
    }
     
    return $output ;
  }
  

  
		
}
