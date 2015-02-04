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
define ("WIDTH",400);


/**
* Visualize an document.
* Try several mimeType on rendition & document
*/
class Tx_AtolCmisList_ViewHelpers_Default_VisuViewHelper extends Tx_Fluid_Core_ViewHelper_AbstractViewHelper {
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
  *
  * @param Tx_AtolCmis_CMIS_Object $obj object to be actionned
  *
  **/
  public function render($obj){

    $oID=urlencode($obj->getId());
    $params=explode(';;_tx_;;',$this->settings['repositoryFolder']);
    $sID=$params[2];
    $width= $this->settings['width'] ? $this->settings['width'] : WIDTH;
    $height=$width*29.7/21;
    $output='';
    $notSet='';
    //Check Type for rendering


    if($obj->getProperties('dc:title')&&$obj->getType()=='image'){
        //Image - Nuxeo
        $output=$this->getImage($oID,$sID,$obj->getProperties('dc:title')->getPropertyValue());
    }
    else{
      //On suppose Alfresco
      if($rendition=$obj->getRenditions('alf:webpreview')){
          $src='?eID=tx_atolcmislist_rendition&sID='.$sID.'&oID='.$oID.'&rK='.$rendition->getKind();
          $output='<embed id="webpreview" src="'.$src.'" type="application/x-shockwave-flash" height="'.$height.'" width="'.$width.'"/>' ;
      }

      //No flash rendition, check for image
      if(strlen($output)===0&&$obj->getType()=='image'){
          $output=$this->getImage($oID,$sID,$obj->getName());
      }
    }
    $output = $output ? $output : $notSet;
    return $output ;
  }


  public function getImage($oID,$sID,$name){
    //Get the image size - Need the full url
    $host = t3lib_div::getIndpEnv('TYPO3_REQUEST_HOST');
    $src='?eID=tx_atolcmislist_download&sID='.$sID.'&oID='.$oID;
    
    $size = getimagesize($host.$src);
    //Get the configuration
    $width= $this->settings['width'] ? $this->settings['width'] : WIDTH;
    
    if($size[0]>$width)
      $width=$width;
    else
      $width=$size[0];
    
    $output='<img src="'.$src.'" title="'.$name.'" width="'.$width.'"/>' ;

    return $output;
  }
}
