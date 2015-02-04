<?php
if (!defined ('TYPO3_MODE')) 	die ('Access denied.');

t3lib_extMgm::addStaticFile($_EXTKEY, 'Configuration/TypoScript', 'Atol Cmis List');
Tx_Extbase_Utility_Extension::registerPlugin($_EXTKEY, 'AtolCmisList', 'Liste Cmis');

t3lib_div::loadTCA('tt_content');

$extensionName = t3lib_div::underscoredToUpperCamelCase($_EXTKEY);

//cmis list
$pluginSignature = strtolower($extensionName) . '_atolcmislist';
$TCA['tt_content']['types']['list']['subtypes_addlist'][$pluginSignature]='pi_flexform'; 
$TCA['tt_content']['types']['list']['subtypes_excludelist'][$pluginSignature]= 'layout,select_key,recursive';
t3lib_extMgm::addPiFlexFormValue($pluginSignature, 'FILE:EXT:atol_cmis_list/Configuration/Flexforms/flexform_list.xml');

#Php for dynamic flexforms
include_once(t3lib_extMgm::extPath($_EXTKEY).'Classes/Flexforms/class.tx_atolcmislist_classes_flexforms.php');

$TCA['sys_template']['ctrl']['adminOnly'] = 0;

if (TYPO3_MODE == 'BE') {
  t3lib_extMgm::registerExtDirectComponent(
    'TYPO3.AtolCmisList.Tree',
    t3lib_extMgm::extPath($_EXTKEY) . 'Classes/ExtDirect/Tree.php:Tx_AtolCmisList_ExtDirect_Tree'
  );
}

?>
