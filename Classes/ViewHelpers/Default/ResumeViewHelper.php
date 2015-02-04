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

/**
* @return Summary of the document, $notSet otherwise
*/


class Tx_AtolCmisList_ViewHelpers_Default_ResumeViewHelper extends Tx_Fluid_Core_ViewHelper_AbstractViewHelper {

  /**
  *
  * @param Tx_AtolCmis_CMIS_Object $obj object to be actionned
  *  
  * Not part of Cmis. Need to check several properties/aspects.
  **/
  public function render($obj){
    $output;
    $notSet='<i>Aucun resumé pour ce document ...</i>';
    //Nuxeo -> ?
    if($o=$obj->getProperties('dc:description')){
      $output=$o->getPropertyValue();
    }
    //Alfresco : cm:summary
    else if($o=$obj->getAspectProperties('cm:summary')){
       $output=$o->getValue();
    }
    
    return $output ? $output : $notSet;
  }
  

		
}
