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




class Tx_AtolCmisList_ViewHelpers_Nuxeo_ThumbnailViewHelper extends Tx_Fluid_Core_ViewHelper_AbstractViewHelper {
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
  * As nuxeo rendition are ugly, it returns the image with 100px width 
  * if its an image
  * @param  $obj Tx_AtolCmis_CMIS_Object object to be actionned
  * @return string output
  *
  **/
  public function render($obj){   
  
    $oID=urlencode($obj->getProperties('cmis:objectId')->getPropertyValue());
    $params=explode(';;_tx_;;',$this->settings['repositoryFolder']);
    $sID=$params[2];
    $src='';

    if($obj->getType()=='image'){
        $src='?eID=tx_atolcmislist_download&sID='.$sID.'&oID='.$oID;
        $output = '<a href="'.$this->getLink($oID).'" /><img src="'.$src.'" alt="" width="100px"/></a>';
    }    
    return $output;

  }	
  
  public function getLink($oID){
    $uriBuilder=$this->controllerContext->getUriBuilder();
    $uri = $uriBuilder->reset()
                      ->uriFor('show',array('oID'=>$oID));
    
    return $uri;
  }
}
