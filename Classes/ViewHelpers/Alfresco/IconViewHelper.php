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
* Shortcut for <alf:rendition obj={"obj"} rk="alf:icon16/32" />
*
*/


class Tx_AtolCmisList_ViewHelpers_Alfresco_IconViewHelper extends Tx_Fluid_Core_ViewHelper_AbstractViewHelper {

  /**
   * @var tslib_cObj
   */
  protected $contentObject;

  /**
   * @var Tx_Extbase_Configuration_ConfigurationManagerInterface
   */
  protected $configurationManager;

  /**
   * @param Tx_Extbase_Configuration_ConfigurationManagerInterface $configurationManager
   * @return void
   */
  public function injectConfigurationManager(Tx_Extbase_Configuration_ConfigurationManagerInterface $configurationManager) {
    $this->configurationManager = $configurationManager;
    $this->contentObject = $this->configurationManager->getContentObject();
  }

  public function initializeObject() {
    $this->settings = $this->configurationManager->getConfiguration(Tx_Extbase_Configuration_ConfigurationManagerInterface::CONFIGURATION_TYPE_SETTINGS);
  }

  /**
  * Tx_AtolCmis_CMIS_Rendition
  * @param  $obj Tx_AtolCmis_CMIS_Object object to be actionned
  * @param integer $size Size of the Icon
  * @return string output
  *
  **/
  public function render($obj,$size=0){
    
    $oID=urlencode($obj->getProperties('cmis:objectId')->getPropertyValue());
    $params=explode(';;_tx_;;',$this->settings['repositoryFolder']);
    $sID=$params[2];
    $src='';
    $rk = $size ? "alf:icon32" : "alf:icon16" ;
    
    
    if($rendition=$obj->getRenditions($rk)){
      //Take too much time with eID ...
      //$src='?eID=tx_atolcmis_rendition&sID='.$sID.'&oID='.$oID.'&rK='.$rendition->getKind();          
      $src = $rendition->getHref();
      $output = '<img src="'.$src.'" alt=""/>';
    }    
    return $output;
    
  }

		
}
