<?php


class tx_atolcmislist_classes_flexforms{	  
  /**
  * Flexform userFunc. Displays :
  *   - Input textfield for the folder name 
  *   - Clickable Icon - ExtJS Window
  *   - Hidden field used in FE
  */
  function getFolderNameField($PA, $fobj){
    $hiddenName = $PA['itemFormElName'];
    $value = explode(';;_tx_;;',htmlspecialchars($PA['itemFormElValue']));
    
    $includeJs = $this->includeJsLib();
    $input = '<input
                id="'.$hiddenName.'_0"
                type="text"
                value="'.$value[0].'"
                readonly="readonly"
                />';
                
    //Translation for title ?
    $clickableIcon = '<span 
      class="t3-icon t3-icon-actions t3-icon-actions-insert t3-icon-insert-record"
      style="margin-left: 5px;margin-bottom: 3px;cursor:pointer"
      onclick="'.$this->getIconJs($hiddenName).'"
      title="Get Folder"
      />';
    
    $hidden = '<input 
                type="hidden" 
                name="'.$PA['itemFormElName'].'"
                value="'.($PA['itemFormElValue'] ? $PA['itemFormElValue'] : ';;_tx_;;').'"
                />';
    
    $output= '<span>'.$includeJs.$input.$clickableIcon.$hidden.'</span>';

    return '<div>'.$output.'</div>';
  }

  /**
  * Obsolete
  */
  function getInputJs($hn){
    $js ="var oID= document.editform['".$hn."'].value.split(';;_tx_;;')[0]; 
          document.editform['".$hn."'].value=oID+';;_tx_;;'+this.value;" ;
    return $js;
  }
  
  //Get the onClick() Js for the icon
  function getIconJs($hn){
    $js="
      Ext.ns('TYPO3.AtolCmis');
      TYPO3.AtolCmis.openDial('$hn');";
    return $js;
  }
  
  //We need some Js for the pop up
  function includeJsLib(){
    $ret='';
    $path = t3lib_extMgm::extRelPath('atol_cmis_list').'Resources/Public/JavaScript/';
    $uxPath = $path.'Ux/TreeGrid/';
    
    $jsFiles[]=$uxPath.'TreeGridSorter.js';
    $jsFiles[]=$uxPath.'TreeGridColumnResizer.js';
    $jsFiles[]=$uxPath.'TreeGridNodeUI.js';
    $jsFiles[]=$uxPath.'TreeGridLoader.js';
    $jsFiles[]=$uxPath.'TreeGridColumns.js';
    $jsFiles[]=$uxPath.'TreeGrid.js';
    $jsFiles[]=$path.'cmisTree.js';
    $cssFile=$uxPath.'treegrid.css';
    
    foreach($jsFiles as $jf){
      $ret.='<script src="'.$jf.'" type="text/javascript"></script>';
    }
    $ret.='<link href="'.$cssFile.'" type="text/css" rel="stylesheet" />';
    
    return $ret;
  }
}

?>