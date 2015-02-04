<?php
/***************************************************************
*  Copyright notice
*
*  (c) 2011 Mathieu Sanchez <msa@atolcd.com>
*           Alexandre Nicolas <ani@atolcd.com>
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


class Tx_AtolCmisList_Cmis_Repository_ObjectRepository implements Tx_AtolCmisList_Cmis_Repository_ObjectRepositoryInterface {
  /**
   * @var Tx_Extbase_Persistence_ObjectStorage
   **/
  private $addedObjects;

  /**
  * @var Tx_Extbase_Object_ObjectManagerInterface
  **/
  protected $objectManager;

  public function __construct() {
    $this->addedObjects = new Tx_Extbase_Persistence_ObjectStorage();
  }

  /**
  * @param Tx_Extbase_Object_ObjectManagerInterface $objectManager
  **/
  public function injectObjectManager(Tx_Extbase_Object_ObjectManagerInterface $objectManager) {
    $this->objectManager = $objectManager;
  }

  /**
  * @var Tx_AtolCmisList_Cmis_Loader
  **/
  protected $loader;

  /**
  * @param Tx_AtolCmisList_Cmis_LoaderInterface $loader
  **/
  public function injectLoader(Tx_AtolCmisList_Cmis_LoaderInterface $loader) {
    $this->loader = $loader;
  }
  
  
  public function injectAddedObjects(Tx_Extbase_Persistence_ObjectStorage $addedObjects){
    $this->addedObjects=$addedObjects;
  }
  
  /**
  * @param string $objectId
  * @return Tx_AtolCmisLibs_Object
  **/
  public function findById($objectId) {
    
    $ret= $this->loader->getObject($objectId);
   
    if($ret->properties['cmis:baseTypeId']!='cmis:folder')
      $ret->renditions = $this->loader->getClient()->getAlternateLinksFromLastRequest();	
      
    $ret->aspects = $this->loader->getClient()->getAspects($objectId);
    $obj = $this->newObject($ret);
    $this->addedObjects->attach($obj);
    return $obj;
  }
  
  
  /**
  * @var string $folderId
  * @return Tx_Extbase_Persistence_ObjectStorage
  **/
  /*public function listObjects($folderId){
     $options = array(
      OPT_RENDITION_FILTER => "*"
    );
    $objs = $this->loader->listObjects($folderId);
    foreach($objs->objectList as $obj) {
		if($obj->properties['cmis:baseTypeId']!='cmis:folder'){ 
		  $obj->aspects = $this->loader->getClient()->getAspects($obj->properties['cmis:objectId'],$options);
		  $obj->renditions = $this->loader->getClient()->getAlternateLinksFromLastRequest();	
		  $this->addedObjects->attach($this->newObject($obj));
		}
		if($obj->properties['cmis:baseTypeId'] =='cmis:folder'){ 
                 $children = $this->listObjects($obj->id);
                 $obj->children = $children;
            }
		
		
    }
    return $this->addedObjects;
  }*/

 
    public function listObjects($folderId){
	$this->addedObjects = new Tx_Extbase_Persistence_ObjectStorage();
     $options = array(
      OPT_RENDITION_FILTER => "*"
    );
//	$options = array(
 //     OPT_RENDITION_FILTER => "*",
 //     "skipCount" => 0, // The same as "OFFSET" in a SQL Query, skip the first X (10 here) items
 //     "maxItems" => 10000 // The same as "LIMIT" in a SQL Query, retrieve this much (15 here) items
//);
	
    $cap=1;
	$capo=0;

    $objs = $this->loader->listObjects($folderId, $options);
//	$NumObjs = count($objs->objectList);

	$nF=0;
//	$NumObjs=contafigli($objs->objectList);
	$numFolder=0;
   	 $NumObjs = 0;
	foreach($objs->objectList as $obj) {
	//conta quanti oggetti ci sono
	if($obj->properties['cmis:baseTypeId']=='cmis:folder'){ 
	$numFolder++; 
	}
	$NumObjs++;
	}
	
	
	
	
	
	usort($objs->objectList, array("Tx_AtolCmisList_Cmis_Repository_ObjectRepository","sortByName")); // The function will automatically compare the items stored in $objs between them
//	usort($objs->objectList, array("Tx_AtolCmisList_Cmis_Repository_ObjectRepository","sortByFolder")); // The function will automatically compare the items stored in $objs between them

    foreach($objs->objectList as $obj) {

	$obj->aspects = $this->loader->getClient()->getAspects($obj->properties['cmis:objectId'],$options);
  
	$obj->properties['parentref'] = $folderId;
	
	$stringa = $folderId;
	$stringa = str_replace("/", "", $stringa);  
	$stringa = str_replace("workspace", "", $stringa);
	$stringa = str_replace(":", "", $stringa);
	$stringa = str_replace("-", "", $stringa);
	$obj->properties['ooid'] = $stringa;	
  $obj->properties['numobj'] = $NumObjs;	
  $obj->properties['ultimo'] = 0;
  $obj->properties['babboultimo'] = 0;
  if ($NumObjs==$cap)
{
$obj->properties['ultimo'] = 0;
}  
		    if($obj->properties['cmis:baseTypeId']=='cmis:folder'){ 
			    $nF++;
				if ($nF==$numFolder) {
				$obj->properties['lastFolder'] = 1;
				}
			//	$obj->properties['lastFolder'] = $nF;
								
				$obj->properties['cap'] = $cap;
				$obj->properties['capo'] = $capo;
				$figli=$this->contafigli($obj->id);
				$obj->properties['figli'] = $figli;
				
                $this->addedObjects->attach($this->newObject($obj));
	            $cap++;

                $children = $this->listObjects1($obj->id,$obj->properties['ultimo'],0);
                // TODO : Something like $obj->children = $children;
				 
				$obj->children = $children;
            }
			if($obj->properties['cmis:baseTypeId']!='cmis:folder'){ 
				$obj->properties['cap'] = $cap;
				$obj->properties['capo'] = 0;	
	            $cap++;				
				$obj->renditions = $this->loader->getClient()->getAlternateLinksFromLastRequest();	
				$this->addedObjects->attach($this->newObject($obj));
			}

    }
	
    return $this->addedObjects;
  }
  

     public function listObjects1($folderId,$babboUltimo,$capo){
     $options = array(
      OPT_RENDITION_FILTER => "*"
    );
    $cap=1;
	

    $objs = $this->loader->listObjects($folderId);
	$NumObjs = count($objs->objectList);
	usort($objs->objectList, array("Tx_AtolCmisList_Cmis_Repository_ObjectRepository","sortByName")); // The function will automatically compare the items stored in $objs between them
//	usort($objs->objectList, array("Tx_AtolCmisList_Cmis_Repository_ObjectRepository","sortByFolder")); // The function will automatically compare the items stored in $objs between them

    foreach($objs->objectList as $obj) {

	$obj->aspects = $this->loader->getClient()->getAspects($obj->properties['cmis:objectId'],$options);
  
	$obj->properties['parentref'] = $folderId;
	
	$stringa = $folderId;
	$stringa = str_replace("/", "", $stringa);  
	$stringa = str_replace("workspace", "", $stringa);
	$stringa = str_replace(":", "", $stringa);
	$stringa = str_replace("-", "", $stringa);
	$obj->properties['ooid'] = $stringa;	
	$obj->properties['numobj'] = $NumObjs;	
	$obj->properties['ultimo'] = 0;
  if ($NumObjs==$cap)
{
$obj->properties['ultimo'] = 1;
}  
		    if($obj->properties['cmis:baseTypeId']=='cmis:folder'){ 
				$obj->properties['cap'] = $cap;
				$capo++;
				$obj->properties['capo'] = $capo;
				$obj->properties['babboultimo'] = $babboUltimo;
				$figli=$this->contafigli($obj->id);
				$obj->properties['figli'] = $figli;
                $this->addedObjects->attach($this->newObject($obj));
	            $cap++;
                $children = $this->listObjects1($obj->id,$obj->properties['ultimo']+$babboUltimo,$capo);
                // TODO : Something like $obj->children = $children;
				 
				$obj->children = $children;
            }
			if($obj->properties['cmis:baseTypeId']!='cmis:folder'){ 
				$obj->properties['cap'] = $cap;
				$obj->properties['capo'] = $capo;
				$obj->properties['babboultimo'] = $babboUltimo;				
	            $cap++;				
				$obj->renditions = $this->loader->getClient()->getAlternateLinksFromLastRequest();	

				$this->addedObjects->attach($this->newObject($obj));
			}

    }
	
    return $this->addedObjects;
  }
  
  
  
  
  
  
 
/*function sortByName($a, $b) {
    $name_a = $a->properties['cmis:name'];
    $name_b = $b->properties['cmis:name'];
	
    if ($name_a == $name_b) {
        return 0;
    }
    return ($name_a < $name_b) ? -1 : 1;
 
}*/

function sortByName($a, $b) {
	$folder_a = $a->properties['cmis:baseTypeId'];
	$folder_b = $b->properties['cmis:baseTypeId'];
    $name_a = $a->properties['cmis:name'];
    $name_b = $b->properties['cmis:name'];
if ($folder_a == $folder_b) {	
    if ($name_a == $name_b) {
        return 0;
    }
    return ($name_a < $name_b) ? -1 : 1;
 }
 return ($folder_a < $folder_b) ? -1 : 1;
}




function sortByFolder($a, $b) {
    $name_a = $a->properties['cmis:baseTypeId'];
    $name_b = $b->properties['cmis:baseTypeId'];
	
    if ($name_a == $name_b) {
        return 0;
    }
    return ($name_a > $name_b) ? -1 : 1;
 
}

function contafigli($folderId) {
  $objs = $this->loader->listObjects($folderId);
   	 $NumObjs = 0;
	foreach($objs->objectList as $obj) {
	//conta quanti oggetti ci sono
	$NumObjs++;
	}
 return $NumObjs;
 }
 

  
  
 
 
  

  /**
  * @param string $objectId
  * @return string ObjectId de l'objet nouvellement cr
  **/
  public function addObject($objectId){
    return $this->loader->add($objectId);
  }
  
  
  public function newObject($result) {
    $obj = $this->objectManager->create('Tx_AtolCmisLibs_Object');
    $obj->setName($result->properties['cmis:name']);
    $obj->setId($result->id);
    $obj->setTypeId($result->properties['cmis:baseTypeId']);
    $obj->setType($result->properties['cmis:contentStreamMimeType']);
    $obj->setUrl($result->links['edit-media']);
    $obj = $this->processRenditions($obj, $result->renditions);
    $obj = $this->processProperties($obj, $result->properties);
    $obj = $this->processAspect($obj,$result->aspects);
    return $obj;
  }

  public function processRenditions($obj, $renditions) {
    if (is_array($renditions)) {
      foreach($renditions as $kind => $values) {
        $renditionObj = $this->objectManager->create('Tx_AtolCmisLibs_Rendition');
        $renditionObj->setKind($kind);
        foreach($values as $k => $v) {
          $setMethod = 'set'.ucfirst(preg_replace('/cmis:/', '', $k));
          if(method_exists($renditionObj, $setMethod)) {
            $renditionObj->$setMethod($v);
          }
        }
        $obj->addRendition($renditionObj);
      }
    }
    return $obj;
  }
  

  public function processProperties($obj, $properties) {
    foreach($properties as $propertyName => $propertyValue) {
      $propObj = $this->objectManager->create('Tx_AtolCmisLibs_Property');
      $propObj->setPropertyName($propertyName);
      $propObj->setPropertyValue($propertyValue);
      $obj->addProperty($propObj);
    }
    return $obj;
  }

  
  public function processAspect($obj, $aspects){
    if($aspects){
      $obj->setAppliedAspects($aspects['appliedAspects']);
	  
	  if (is_array($aspects['properties']))
		{
		  foreach($aspects['properties'] as $p){
			$apObj = $this->objectManager->create('Tx_AtolCmisLibs_AspectProperty');
			$apObj->setName($p['nodeName']);
			$apObj->setValue($p['nodeValue']);
			$apObj->setDisplayName($p['attributes']['displayName']);
			$apObj->setPropertyDefinitionId($p['attributes']['propertyDefinitionId']);
			$apObj->setQueryName($p['attributes']['queryName']);
			$obj->addAspectProperties($apObj);
		  }
		}
    }   
    return $obj;
  }
  


  public function getAddedObjects() {
    return $this->addedObjects;
  }
}
