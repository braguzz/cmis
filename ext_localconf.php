<?php
if (!defined ('TYPO3_MODE')) 	die ('Access denied.');

require_once(t3lib_extMgm::extPath('atol_cmis_libs') . 'cmis/AtolCmis_cmis_repository_wrapper.php');

Tx_Extbase_Utility_Extension::configurePlugin(
  $_EXTKEY,
  'AtolCmisList',																																											
  array('CmisList' => 'list,show'),
  array('CmisList' => '')
);

$TYPO3_CONF_VARS['FE']['eID_include']['tx_atolcmislist_download'] = 'EXT:'.$_EXTKEY.'/Classes/eID/Download.php';	
$TYPO3_CONF_VARS['FE']['eID_include']['tx_atolcmislist_rendition'] = 'EXT:'.$_EXTKEY.'/Classes/eID/Rendition.php';	


?>
